document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("editWorkshopForm");
    const workshopId = document.querySelector('meta[name="workshop-id"]')?.content;
    
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
            formData.append('_method', 'PUT');
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

            // Optional fields (for UI purposes)
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content 
                    || document.querySelector('input[name="_token"]')?.value;

                const response = await fetch(`/admin/workshops/${workshopId}`, {
                    method: 'POST', // using POST with _method=PUT to support FormData files in Laravel
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                if (data.success) {
                    if (typeof showToast !== 'undefined') {
                        showToast(window.translations?.toast_ws_updated || "Workshop updated successfully!", "success");
                    }
                    
                    setTimeout(() => {
                        window.location.href = '/admin';
                    }, 1500);
                } else {
                    if (typeof showToast !== 'undefined') {
                        showToast(window.translations?.toast_ws_update_fail || "Failed to update workshop", "error");
                    } else {
                        console.error("Failed to update workshop", data);
                    }
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error("Error updating workshop:", error);
                if (typeof showToast !== 'undefined') {
                    showToast(window.translations?.toast_error_occurred || "An error occurred", "error");
                }
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});
