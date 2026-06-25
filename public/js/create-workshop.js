document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("createWorkshopForm");
    
    // Banner upload logic
    const bannerUpload = document.getElementById("bannerUpload");
    const bannerFile = document.getElementById("bannerFile");
    
    if (bannerUpload && bannerFile) {
        bannerUpload.addEventListener("click", () => {
            bannerFile.click();
        });
        
        bannerFile.addEventListener("change", (e) => {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    bannerUpload.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;" alt="Banner Preview">`;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Add drag and drop support
        bannerUpload.addEventListener('dragover', (e) => {
            e.preventDefault();
            bannerUpload.style.borderColor = 'var(--primary)';
        });
        bannerUpload.addEventListener('dragleave', (e) => {
            e.preventDefault();
            bannerUpload.style.borderColor = '#e2e8f0';
        });
        bannerUpload.addEventListener('drop', (e) => {
            e.preventDefault();
            bannerUpload.style.borderColor = '#e2e8f0';
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                bannerFile.files = e.dataTransfer.files;
                const event = new Event('change');
                bannerFile.dispatchEvent(event);
            }
        });
    }

    // PDF upload logic
    const pdfUpload = document.getElementById("pdfUpload");
    const pdfFile = document.getElementById("pdfFile");
    const pdfFileName = document.getElementById("pdfFileName");

    if (pdfUpload && pdfFile) {
        pdfUpload.addEventListener("click", () => {
            pdfFile.click();
        });

        pdfFile.addEventListener("change", (e) => {
            if (e.target.files && e.target.files[0]) {
                pdfFileName.textContent = e.target.files[0].name;
                pdfUpload.style.color = "var(--primary)";
            }
        });
    }

    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('title', document.getElementById("workshopTitle").value);
            formData.append('date', document.getElementById("workshopDate").value);
            formData.append('location', document.getElementById("workshopLocation").value);
            formData.append('category', document.getElementById("workshopCategory").value);
            formData.append('description', document.getElementById("workshopDescription").value);
            formData.append('time', document.getElementById("workshopTime").value);
            formData.append('duration', document.getElementById("workshopDuration").value);
            
            const typeRadio = document.querySelector('input[name="locationType"]:checked');
            if(typeRadio) formData.append('type', typeRadio.value);
            
            formData.append('instructor_name', document.getElementById("instructorName").value);
            
            const capacity = document.getElementById("workshopSeats")?.value;
            if(capacity) formData.append('capacity', capacity);
            
            if (bannerFile && bannerFile.files[0]) {
                formData.append('banner', bannerFile.files[0]);
            }
            
            if (pdfFile && pdfFile.files[0]) {
                formData.append('pdf_slides', pdfFile.files[0]);
            }

            const usefulLinks = document.getElementById("usefulLinks")?.value;
            if (usefulLinks) {
                formData.append('useful_links', usefulLinks);
            }

            const selectedDepts = Array.from(document.querySelectorAll('.ws_department_checkbox:checked')).map(cb => cb.value);
            selectedDepts.forEach((deptId, index) => {
                formData.append(`departments[${index}]`, deptId);
            });

            // Optional fields (for UI purposes)
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating...';
            submitBtn.disabled = true;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content 
                    || document.querySelector('input[name="_token"]')?.value;

                const response = await fetch('/create-workshop', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                    if (typeof showToast !== 'undefined') {
                        showToast("Workshop created successfully!", "success");
                    } else {
                        alert("Workshop created successfully!");
                    }
                    
                    // Redirect back or to workshops page
                    setTimeout(() => {
                        if (window.location.search.includes('admin=1')) {
                            window.location.href = '/admin';
                        } else {
                            window.location.href = '/workshops';
                        }
                    }, 1500);
                } else {
                    if (typeof showToast !== 'undefined') {
                        showToast("Failed to create workshop", "error");
                    } else {
                        alert("Failed to create workshop");
                    }
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error("Error creating workshop:", error);
                if (typeof showToast !== 'undefined') {
                    showToast("An error occurred", "error");
                } else {
                    alert("An error occurred");
                }
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});
