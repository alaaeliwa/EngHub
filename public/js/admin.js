// ═══════════════════════════════════════
// EngHub Admin Dashboard - Main Logic
// ═══════════════════════════════════════

// ── Data is injected from Blade Template ──
// usersData, coursesData, materialsData, workshopsData, departmentsData, commentsData

// ── State ──
let editingUserId = null;
let deletingItem = { type: null, id: null };

// ── Init ──
document.addEventListener("DOMContentLoaded", () => {
    setAdminDate();
    initTabs();
    initSidebar();
    initNotifications();
    renderOverview();
    // Tables are now rendered natively via Blade from the database:
    // renderUsers();
    // renderCourses();
    // renderMaterials();
    // renderWorkshops();
    // renderComments();
    // renderDepartments();
    initSearch();
});

// ── Date ──
function setAdminDate() {
    const d = new Date();
    const el = document.getElementById("adminDate");
    if (el)
        el.innerHTML = `<i class="fa-solid fa-calendar"></i> ${d.toLocaleDateString("en-US", { weekday: "long", year: "numeric", month: "long", day: "numeric" })}`;
}

// ── Tabs ──
function initTabs() {
    document.querySelectorAll(".admin-tab").forEach((tab) => {
        tab.addEventListener("click", () => {
            document
                .querySelectorAll(".admin-tab")
                .forEach((t) => t.classList.remove("active"));
            document
                .querySelectorAll(".tab-panel")
                .forEach((p) => p.classList.remove("active"));
            tab.classList.add("active");
            document
                .getElementById("panel-" + tab.dataset.tab)
                .classList.add("active");
        });
    });
}

// ── Notifications ──
function initNotifications() {
    const btn = document.getElementById("notificationBtn");
    const dropdown = document.getElementById("notificationDropdown");
    if (btn && dropdown) {
        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            dropdown.classList.toggle("active");
        });
        // Close when clicking outside
        document.addEventListener("click", (e) => {
            if (!dropdown.contains(e.target) && e.target !== btn) {
                dropdown.classList.remove("active");
            }
        });
        // Prevent closing when clicking inside the dropdown
        dropdown.addEventListener("click", (e) => {
            e.stopPropagation();
        });
    }
}

// ── Sidebar Mobile ──
function initSidebar() {
    const toggle = document.getElementById("sidebarToggle");
    const close = document.getElementById("sidebarClose");
    const sidebar = document.querySelector(".sidebar");
    if (toggle)
        toggle.addEventListener("click", () =>
            sidebar.classList.toggle("active"),
        );
    if (close)
        close.addEventListener("click", () =>
            sidebar.classList.remove("active"),
        );
}

// ── Toast ──
function showToast(msg, type = "success") {
    const c = document.getElementById("toastContainer");
    const icons = {
        success: "fa-circle-check",
        error: "fa-circle-xmark",
        info: "fa-circle-info",
    };
    const t = document.createElement("div");
    t.className = `toast ${type}`;
    t.innerHTML = `<i class="fa-solid ${icons[type]}"></i><span>${msg}</span>`;
    c.appendChild(t);
    setTimeout(() => {
        t.style.animation = "toastOut 0.4s forwards";
        setTimeout(() => t.remove(), 400);
    }, 3000);
}

// ── Modal ──
function openModal(id) {
    document.getElementById(id).classList.add("active");
}
function closeModal(id) {
    document.getElementById(id).classList.remove("active");
}
// Make closeModal globally available
window.closeModal = closeModal;

// ═══ OVERVIEW ═══
function renderOverview() {
    // Activity Chart (Dynamic from DB)
    const chart = document.getElementById("activityChart");
    if (chart && typeof activityData !== "undefined") {
        // Reverse it so oldest is left, newest is right
        const data = [...activityData].reverse();
        const maxVal = Math.max(...data.map((d) => d.count), 5); // Minimum max is 5 for better scaling
        chart.innerHTML = data
            .map(
                (d, i) => `
      <div class="chart-bar-wrap" style="transition-delay: ${i * 0.1}s">
        <span class="chart-value">${d.count}</span>
        <div class="chart-bar" style="height:${(d.count / maxVal) * 180}px; background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 8px 8px 4px 4px; min-height: ${d.count > 0 ? '10px' : '0'};"></div>
        <span class="chart-label">${d.day}</span>
      </div>
    `,
            )
            .join("");
    }

    // Department Chart (Dynamic scaling)
    const dChart = document.getElementById("deptChart");
    const deptColors = ["#0284c7", "#16a34a", "#f1822d", "#db2777", "#8b5cf6", "#14b8a6"];
    if (dChart && typeof departmentsData !== "undefined") {
        const maxDept = Math.max(...departmentsData.map(d => d.students), 10); // Minimum max of 10
        dChart.innerHTML = departmentsData
            .map(
                (d, i) => `
      <div class="chart-bar-wrap" style="transition-delay: ${i * 0.15}s">
        <span class="chart-value">${d.students}</span>
        <div class="chart-bar" style="height:${(d.students / maxDept) * 180}px; background: ${deptColors[i % deptColors.length]}; border-radius: 8px 8px 4px 4px; min-height: ${d.students > 0 ? '10px' : '0'};"></div>
        <span class="chart-label">${d.name.split(" ")[0]}</span>
      </div>
    `,
            )
            .join("");
    }
}

// ═══ USERS TABLE NATIVE FILTERS ═══
function filterUsersTable() {
    const search =
        document.getElementById("searchUsers")?.value.toLowerCase() || "";
    const role = document.getElementById("filterRole")?.value || "all";
    const status = document.getElementById("filterStatus")?.value || "all";

    const rows = document.querySelectorAll('#usersBody tr[id^="user-row-"]');
    rows.forEach((row) => {
        const rowSearch = row.dataset.search || "";
        const rowRole = row.dataset.role || "";
        const rowStatus = row.dataset.status || "";

        let match = true;
        if (search && !rowSearch.includes(search)) match = false;
        if (role !== "all" && rowRole !== role) match = false;
        if (status !== "all" && rowStatus !== status) match = false;

        row.style.display = match ? "" : "none";
    });
}

// ═══ COURSES TABLE ═══
function renderCourses(filter = {}) {
    let data = [...coursesData];
    if (filter.status && filter.status !== "all")
        data = data.filter((c) => c.status === filter.status);
    if (filter.search)
        data = data.filter((c) =>
            c.title.toLowerCase().includes(filter.search),
        );

    const tbody = document.getElementById("coursesBody");
    if (!tbody) return;
    tbody.innerHTML =
        data.length === 0
            ? `<tr><td colspan="6" style="text-align:center; color:#64748b; padding:2rem;">No courses found. Click "Add Course" to get started.</td></tr>`
            : data
                  .map(
                      (c) => `
    <tr>
      <td><strong style="color:var(--primary-dark)">${c.title}</strong><br><small style="color:#64748b">${c.code || ""}</small></td>
      <td>${c.instructor || "—"}</td>
      <td><span class="badge" style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">Year ${c.year}</span></td>
      <td><span class="badge" style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;">Sem ${c.semester}</span></td>
      <td>${c.departments && c.departments.length ? c.departments.map(d => `<span class="badge" style="background:#f8fafc;color:#475569;border:1px solid #cbd5e1;margin-right:4px;">${d.name}</span>`).join('') : '—'}</td>
      <td><span class="badge badge-${c.status}">${capitalize(c.status)}</span></td>
      <td>
        <div class="action-btns">
          <button class="action-btn delete" title="Delete" onclick="confirmDelete('course',${c.id})"><i class="fa-solid fa-trash"></i></button>
        </div>
      </td>
    </tr>
  `,
                  )
                  .join("");
}

// ═══ COURSES TABLE NATIVE FILTERS ═══
function filterCoursesTable() {
    const search =
        document.getElementById("searchCourses")?.value.toLowerCase() || "";
    const status =
        document.getElementById("filterCourseStatus")?.value || "all";

    const rows = document.querySelectorAll(
        '#coursesBody tr[id^="course-row-"]',
    );
    rows.forEach((row) => {
        const rowSearch = row.dataset.search || "";
        const rowStatus = row.dataset.status || "";

        let match = true;
        if (search && !rowSearch.includes(search)) match = false;
        if (status !== "all" && rowStatus !== status) match = false;

        row.style.display = match ? "" : "none";
    });
}

// ═══ MATERIALS TABLE ═══
function renderMaterials(filter = {}) {
    let data = [...materialsData];
    if (filter.type && filter.type !== "all")
        data = data.filter((m) => m.type === filter.type);
    if (filter.search)
        data = data.filter((m) =>
            m.title.toLowerCase().includes(filter.search),
        );

    const typeIcons = {
        pdf: "fa-file-pdf",
        video: "fa-video",
        summary: "fa-file-lines",
        link: "fa-link",
    };
    const typeColors = {
        pdf: "#dc2626",
        video: "#0284c7",
        summary: "#16a34a",
        link: "#7c3aed",
    };

    const tbody = document.getElementById("materialsBody");
    if (!tbody) return;
    tbody.innerHTML = data
        .map(
            (m) => `
    <tr>
      <td><strong style="color:var(--primary-dark)">${m.title}</strong></td>
      <td><i class="fa-solid ${typeIcons[m.type]}" style="color:${typeColors[m.type]};margin-right:0.4rem"></i>${capitalize(m.type)}</td>
      <td>${m.uploader}</td>
      <td>${m.course}</td>
      <td>${m.date}</td>
      <td><span class="badge badge-${m.status}">${capitalize(m.status)}</span></td>
      <td>
        <div class="action-btns">
          <button class="action-btn view" title="Preview" onclick="window.open('/storage/' + '${m.file_path}', '_blank')"><i class="fa-solid fa-eye"></i></button>
          ${m.status === "pending" ? `<button class="action-btn approve" title="Approve" onclick="changeMaterialStatus(${m.id},'approved')"><i class="fa-solid fa-check"></i></button>` : ""}
          ${m.status === "pending" ? `<button class="action-btn ban" title="Reject" onclick="changeMaterialStatus(${m.id},'rejected')"><i class="fa-solid fa-xmark"></i></button>` : ""}
          <button class="action-btn delete" title="Delete" onclick="confirmDelete('material',${m.id})"><i class="fa-solid fa-trash"></i></button>
        </div>
      </td>
    </tr>
  `,
        )
        .join("");
}

// ═══ WORKSHOPS TABLE ═══
function renderWorkshops(filter = {}) {
    let data = [...workshopsData];
    if (filter.search)
        data = data.filter((w) =>
            w.title.toLowerCase().includes(filter.search),
        );

    const tbody = document.getElementById("workshopsBody");
    if (!tbody) return;
    tbody.innerHTML = data
        .map(
            (w) => `
    <tr>
      <td><strong style="color:var(--primary-dark)">${w.title}</strong></td>
      <td>${w.date}</td>
      <td>${w.location}</td>
      <td>${w.registered}</td>
      <td><span class="badge badge-${w.status}">${capitalize(w.status)}</span></td>
      <td>
        <div class="action-btns">
          ${w.status === "pending" ? `<button class="action-btn approve" title="Approve" onclick="changeWorkshopStatus(${w.id},'approved')"><i class="fa-solid fa-check"></i></button>` : ""}
          <button class="action-btn edit" title="Edit" onclick="showToast('Edit workshop feature coming soon','info')"><i class="fa-solid fa-pen"></i></button>
          <button class="action-btn delete" title="Delete" onclick="confirmDelete('workshop',${w.id})"><i class="fa-solid fa-trash"></i></button>
        </div>
      </td>
    </tr>
  `,
        )
        .join("");
}

// ═══ COMMENTS TABLE ═══
function renderComments(filter = {}) {
    let data = [...commentsData];
    if (filter.type === "reported") data = data.filter((c) => c.reports > 0);
    if (filter.type === "spam") data = data.filter((c) => c.reports >= 5);

    const tbody = document.getElementById("commentsBody");
    if (!tbody) return;
    tbody.innerHTML = data
        .map(
            (c) => `
    <tr>
      <td><strong>${c.user}</strong></td>
      <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${c.comment}</td>
      <td>${c.on}</td>
      <td>${c.date}</td>
      <td>${c.reports > 0 ? `<span class="badge badge-${c.reports >= 5 ? "banned" : "pending"}">${c.reports} reports</span>` : '<span style="color:#94a3b8">None</span>'}</td>
      <td>
        <div class="action-btns">
          <button class="action-btn delete" title="Delete Comment" onclick="deleteComment(${c.id})"><i class="fa-solid fa-trash"></i></button>
          ${c.reports > 0 ? `<button class="action-btn ban" title="Ban User" onclick="showToast('User warned','info')"><i class="fa-solid fa-ban"></i></button>` : ""}
        </div>
      </td>
    </tr>`,
        )
        .join("");
}
// ═══ DEPARTMENTS TABLE ═══
function renderDepartments() {
    // Now rendered via Blade.
}

// ═══ MATERIALS TABLE NATIVE FILTERS ═══
function filterMaterialsTable() {
    const search =
        document.getElementById("searchMaterials")?.value.toLowerCase() || "";
    const type = document.getElementById("filterMaterialType")?.value || "all";

    const rows = document.querySelectorAll(
        '#materialsBody tr[id^="material-row-"]',
    );
    rows.forEach((row) => {
        const rowSearch = row.dataset.search || "";
        const rowType = row.dataset.type || "";

        let match = true;
        if (search && !rowSearch.includes(search)) match = false;
        if (type !== "all" && rowType !== type) match = false;

        row.style.display = match ? "" : "none";
    });
}

// ═══ WORKSHOPS TABLE ═══
function editUser(id) {
    const nameEl = document.getElementById(`user-name-${id}`);
    const emailEl = document.getElementById(`user-email-${id}`);
    const row = document.getElementById(`user-row-${id}`);
    if (!nameEl || !row) return;

    editingUserId = id;
    document.getElementById("editName").value = nameEl.innerText;
    document.getElementById("editEmail").value = emailEl.innerText;
    document.getElementById("editRole").value = row.dataset.role;
    document.getElementById("editStatus").value = row.dataset.status;
    openModal("editUserModal");
}

async function saveUser() {
    if (!editingUserId) return;
    const role = document.getElementById("editRole").value;
    const status = document.getElementById("editStatus").value;

    try {
        const res = await fetch(`/admin/users/${editingUserId}`, {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content ||
                    document.querySelector('input[name="_token"]')?.value,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ role, status }),
        });
        const json = await res.json();
        if (json.success) {
            showToast("User updated successfully", "success");

            // Update DOM
            const row = document.getElementById(`user-row-${editingUserId}`);
            const badgeRole = document.getElementById(
                `user-role-badge-${editingUserId}`,
            );
            const badgeStatus = document.getElementById(
                `user-status-badge-${editingUserId}`,
            );
            const banIcon = document.getElementById(
                `ban-icon-${editingUserId}`,
            );

            if (row) {
                row.dataset.role = role;
                row.dataset.status = status;
            }
            if (badgeRole) {
                badgeRole.className = `badge badge-${role}`;
                badgeRole.innerText = capitalize(role);
            }
            if (badgeStatus) {
                badgeStatus.className = `badge badge-${status}`;
                badgeStatus.innerText = capitalize(status);
            }
            if (banIcon) {
                banIcon.className = `fa-solid fa-${status === "banned" ? "lock-open" : "ban"}`;
            }

            closeModal("editUserModal");
        } else {
            showToast("Failed to update user", "error");
        }
    } catch (err) {
        showToast("Network error", "error");
    }
}

async function toggleBanUser(id) {
    try {
        const res = await fetch(`/admin/users/${id}/toggle-ban`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content ||
                    document.querySelector('input[name="_token"]')?.value,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });
        const json = await res.json();
        if (json.success) {
            const status = json.status;
            showToast(
                status === "banned"
                    ? "User has been banned"
                    : "User ban removed",
                status === "banned" ? "warning" : "success",
            );

            const row = document.getElementById(`user-row-${id}`);
            const badgeStatus = document.getElementById(
                `user-status-badge-${id}`,
            );
            const banIcon = document.getElementById(`ban-icon-${id}`);

            if (row) row.dataset.status = status;
            if (badgeStatus) {
                badgeStatus.className = `badge badge-${status}`;
                badgeStatus.innerText = capitalize(status);
            }
            if (banIcon) {
                banIcon.className = `fa-solid fa-${status === "banned" ? "lock-open" : "ban"}`;
            }
        } else {
            showToast("Failed to toggle ban", "error");
        }
    } catch (err) {
        showToast("Network error", "error");
    }
}

async function deleteUser(id) {
    if (!confirm("Are you sure you want to permanently delete this user?"))
        return;
    try {
        const res = await fetch(`/admin/users/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content ||
                    document.querySelector('input[name="_token"]')?.value,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });
        const json = await res.json();
        if (json.success) {
            showToast("User deleted successfully", "success");
            const row = document.getElementById(`user-row-${id}`);
            if (row) row.remove();
        } else {
            showToast("Failed to delete user", "error");
        }
    } catch (err) {
        showToast("Network error", "error");
    }
}

// ═══ STATUS CHANGES ═══
async function changeCourseStatus(id, status) {
    try {
        const res = await fetch(`/admin/courses/${id}/status`, {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content ||
                    document.querySelector('input[name="_token"]')?.value,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ status }),
        });
        const json = await res.json();
        if (json.success) {
            showToast(
                `Course ${status} successfully`,
                status === "approved" ? "success" : "error",
            );

            const row = document.getElementById(`course-row-${id}`);
            const badge = document.getElementById(`course-status-badge-${id}`);
            const actions = document.getElementById(`course-actions-${id}`);

            if (row) row.dataset.status = status;
            if (badge) {
                badge.className = `badge badge-${status}`;
                badge.innerText = capitalize(status);
            }
            if (actions) {
                // Remove approve/reject buttons since it is no longer pending
                actions.innerHTML = `<button class="action-btn delete" title="Delete" onclick="deleteCourse(${id})"><i class="fa-solid fa-trash"></i></button>`;
            }
        } else {
            showToast("Failed to change status", "error");
        }
    } catch (err) {
        showToast("Network error", "error");
    }
}

async function changeMaterialStatus(id, status) {
    try {
        const res = await fetch(`/admin/materials/${id}/status`, {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content ||
                    document.querySelector('input[name="_token"]')?.value,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({ status }),
        });
        const json = await res.json();
        if (json.success) {
            showToast(
                `Material ${status} successfully`,
                status === "approved" ? "success" : "error",
            );

            const row = document.getElementById(`material-row-${id}`);
            const badge = document.getElementById(
                `material-status-badge-${id}`,
            );
            const actions = document.getElementById(`material-actions-${id}`);

            if (row) row.dataset.status = status;
            if (badge) {
                badge.className = `badge badge-${status}`;
                badge.innerText = capitalize(status);
            }
            if (actions) {
                const viewBtn = actions.querySelector(".view");
                const deleteBtn = actions.querySelector(".delete");
                actions.innerHTML = "";
                if (viewBtn) actions.appendChild(viewBtn);
                if (deleteBtn) actions.appendChild(deleteBtn);
            }
        } else {
            showToast("Failed to change status", "error");
        }
    } catch (err) {
        showToast("Network error", "error");
    }
}

function changeWorkshopStatus(id, status) {
    const w = workshopsData.find((w) => w.id === id);
    if (!w) return;
    w.status = status;
    renderWorkshops();
    showToast(`Workshop "${w.title}" ${status}`);
}

async function deleteMaterial(id) {
    if (!confirm("Are you sure you want to permanently delete this material?"))
        return;
    try {
        const res = await fetch(`/admin/materials/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content ||
                    document.querySelector('input[name="_token"]')?.value,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });
        const json = await res.json();
        if (json.success) {
            showToast("Material deleted successfully", "success");
            const row = document.getElementById(`material-row-${id}`);
            if (row) row.remove();
        } else {
            showToast("Failed to delete material", "error");
        }
    } catch (err) {
        showToast("Network error", "error");
    }
}

async function deleteCourse(id) {
    if (!confirm("Are you sure you want to permanently delete this course?"))
        return;
    try {
        const res = await fetch(`/admin/courses/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content ||
                    document.querySelector('input[name="_token"]')?.value,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });
        const json = await res.json();
        if (json.success) {
            showToast("Course deleted successfully", "success");
            const row = document.getElementById(`course-row-${id}`);
            if (row) row.remove();
        } else {
            showToast("Failed to delete course", "error");
        }
    } catch (err) {
        showToast("Network error", "error");
    }
}

// ═══ DELETE ═══
function confirmDelete(type, id) {
    deletingItem = { type, id };
    const names = {
        user: usersData.find((u) => u.id === id)?.name,
        course: coursesData.find((c) => c.id === id)?.title,
        material: materialsData.find((m) => m.id === id)?.title,
        workshop: workshopsData.find((w) => w.id === id)?.title,
        department: departmentsData.find((d) => d.id === id)?.name,
    };
    document.getElementById("deleteMsg").textContent =
        `Are you sure you want to delete "${names[type] || "this item"}"? This action cannot be undone.`;
    openModal("deleteModal");
}

document.getElementById("confirmDeleteBtn")?.addEventListener("click", () => {
    const { type, id } = deletingItem;
    const arrays = {
        user: usersData,
        course: coursesData,
        material: materialsData,
        workshop: workshopsData,
        department: departmentsData,
    };
    const arr = arrays[type];
    const idx = arr?.findIndex((i) => i.id === id);
    if (idx > -1) arr.splice(idx, 1);

    closeModal("deleteModal");
    showToast(`${capitalize(type)} deleted successfully`, "error");

    if (type === "user") renderUsers();
    else if (type === "course") renderCourses();
    else if (type === "material") renderMaterials();
    else if (type === "workshop") renderWorkshops();
    else if (type === "department") renderDepartments();
});

function deleteComment(id) {
    const idx = commentsData.findIndex((c) => c.id === id);
    if (idx > -1) commentsData.splice(idx, 1);
    renderComments();
    showToast("Comment deleted", "error");
}

function deleteCommentDB(id, btn) {
    if (!confirm('Are you sure you want to delete this comment?')) return;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value;
    
    fetch(`/admin/comments/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Comment deleted successfully', 'success');
            btn.closest('tr').remove();
            
            // Check if table is empty to show "No comments" message
            const tbody = document.getElementById('commentsBodyNative');
            if(tbody && tbody.children.length === 0) {
                 tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#64748b;">No comments found.</td></tr>';
            }
        } else {
            showToast('Failed to delete comment', 'error');
        }
    }).catch(err => {
        showToast('Network error', 'error');
    });
}


// ═══ SEARCH & FILTERS ═══
function initSearch() {
    // Users Table
    document
        .getElementById("searchUsers")
        ?.addEventListener("input", filterUsersTable);
    document
        .getElementById("filterRole")
        ?.addEventListener("change", filterUsersTable);
    document
        .getElementById("filterStatus")
        ?.addEventListener("change", filterUsersTable);

    document
        .getElementById("searchCourses")
        ?.addEventListener("input", filterCoursesTable);
    document
        .getElementById("filterCourseStatus")
        ?.addEventListener("change", filterCoursesTable);

    document
        .getElementById("searchMaterials")
        ?.addEventListener("input", filterMaterialsTable);
    document
        .getElementById("filterMaterialType")
        ?.addEventListener("change", filterMaterialsTable);

    // Add Workshop button
    document.getElementById("addWorkshopBtn")?.addEventListener("click", () => {
        window.location.href = '/create-workshop?admin=1';
    });

    // Add Department button
    document.getElementById("addDeptBtn")?.addEventListener("click", () => {
        openModal("addDeptModal");
    });
}

// ═══ WORKSHOPS ACTIONS ═══
function saveWorkshop() {
    const titleInput = document.getElementById("newWorkshopTitle");
    const dateInput = document.getElementById("newWorkshopDate");
    const locationInput = document.getElementById("newWorkshopLocation");

    if (!titleInput.value.trim() || !dateInput.value || !locationInput.value.trim()) return;

    const d = new Date(dateInput.value);
    const formattedDate = d.toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" });

    const newId = workshopsData.length ? Math.max(...workshopsData.map((w) => w.id)) + 1 : 1;
    const newWorkshop = { id: newId, title: titleInput.value.trim(), date: formattedDate, location: locationInput.value.trim(), registered: 0, status: "approved" };

    workshopsData.push(newWorkshop);
    renderWorkshops();
    closeModal("addWorkshopModal");
    showToast(`Workshop "${newWorkshop.title}" added successfully`);
    titleInput.value = ""; dateInput.value = ""; locationInput.value = "";
}

function changeWorkshopStatus(id, status) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    fetch(`/admin/workshops/${id}/status`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ status })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(`Workshop ${status === 'approved' ? 'approved' : 'rejected'} successfully`, 'success');
            // Refresh the row
            const row = document.querySelector(`button[onclick*="changeWorkshopStatus(${id},"]`)?.closest('tr');
            if (row) {
                const badge = row.querySelector('.badge');
                if (badge) { badge.className = `badge badge-${status}`; badge.textContent = status.charAt(0).toUpperCase() + status.slice(1); }
                const actionBtns = row.querySelector('.action-btns');
                if (actionBtns) {
                    const approveBtn = actionBtns.querySelector('.approve');
                    const rejectBtn = actionBtns.querySelector('.ban');
                    if (approveBtn) approveBtn.remove();
                    if (rejectBtn) rejectBtn.remove();
                }
            }
        } else showToast('Failed to update status', 'error');
    });
}

function deleteWorkshop(id) {
    if (!confirm('Are you sure you want to delete this workshop?')) return;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    fetch(`/admin/workshops/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Workshop deleted!', 'success');
            document.querySelector(`button[onclick="deleteWorkshop(${id})"]`)?.closest('tr')?.remove();
        } else showToast('Failed to delete workshop', 'error');
    });
}

// ═══ DEPARTMENTS ACTIONS ═══
function saveDepartment() {
    const nameInput = document.getElementById("newDeptName");
    const yearsInput = document.getElementById("newDeptYears");

    if (!nameInput.value.trim()) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const btn = document.querySelector('#addDeptModal button[type="submit"]');

    fetch('/admin/departments', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ name: nameInput.value.trim(), years: yearsInput.value })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const newDept = data.department;
            showToast(`Department "${newDept.name}" added successfully`, 'success');
            setTimeout(() => window.location.reload(), 1000); 
        } else {
            showToast('Failed to add department', 'error');
        }
    }).catch(err => {
        showToast('Network error', 'error');
    });
}

function editDepartment(id, name, years) {
    document.getElementById("editDeptId").value = id;
    document.getElementById("editDeptName").value = name;
    document.getElementById("editDeptYears").value = years;
    openModal("editDeptModal");
}

function submitEditDepartment() {
    const id = document.getElementById("editDeptId").value;
    const name = document.getElementById("editDeptName").value;
    const years = document.getElementById("editDeptYears").value;

    if (!name.trim()) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    fetch(`/admin/departments/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ name: name.trim(), years: years })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Department updated successfully', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showToast('Failed to update department', 'error');
        }
    }).catch(err => {
        showToast('Network error', 'error');
    });
}

function deleteDepartment(id) {
    if (!confirm('Are you sure you want to delete this department?')) return;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    fetch(`/admin/departments/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Department deleted successfully', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showToast('Failed to delete department', 'error');
        }
    }).catch(err => {
        showToast('Network error', 'error');
    });
}

// ═══ Utility ═══
function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// Make functions globally available for onclick handlers
window.editUser = editUser;
window.toggleBan = toggleBan;
window.confirmDelete = confirmDelete;
window.changeCourseStatus = changeCourseStatus;
window.changeMaterialStatus = changeMaterialStatus;
window.changeWorkshopStatus = changeWorkshopStatus;
window.deleteComment = deleteComment;
window.deleteCommentDB = deleteCommentDB;
window.showToast = showToast;
window.saveDepartment = saveDepartment;
window.saveWorkshop = saveWorkshop;
window.editDepartment = editDepartment;
window.submitEditDepartment = submitEditDepartment;
window.deleteDepartment = deleteDepartment;
