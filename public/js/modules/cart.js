export function initCart() {
    // Intercept form submissions ending with /cart/add
    const cartForms = document.querySelectorAll('form[action$="/cart/add"]');
    cartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent page reload
            
            // --- Frontend stock validation before AJAX ---
            const qtyInput = this.querySelector('input[name="quantity"]');
            const quantity = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
            const maxStock = qtyInput ? parseInt(qtyInput.dataset.stock) || parseInt(qtyInput.max) || 0 : 0;

            if (maxStock > 0 && quantity > maxStock) {
                if (typeof window.showStockWarning === 'function') {
                    window.showStockWarning(maxStock);
                }
                // allow the field to remain as is, return directly to prevent form submit
                return;
            }
            // --- End frontend validation ---

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            if(!submitBtn) return;
            const originalHtml = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            if(submitBtn.innerHTML.includes('<i')) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            } else {
                submitBtn.innerHTML = '...';
            }

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                
                if (data.success) {
                    const badge = document.getElementById('cartBadge');
                    if (badge) {
                        badge.textContent = data.cartCount;
                        
                        // Optional animations
                        badge.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            badge.style.transform = 'scale(1)';
                        }, 200);
                    }
                    if(typeof window.showToast === 'function') {
                        window.showToast(data.message, 'success');
                    }
                } else {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data.stock_exceeded && typeof window.showStockWarning === 'function') {
                        window.showStockWarning(data.stock_quantity);
                    } else {
                        if(typeof window.showToast === 'function') {
                            window.showToast(data.message, 'error');
                        }
                    }
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                if(typeof window.showToast === 'function') {
                    window.showToast('Đã xảy ra lỗi, vui lòng thử lại', 'error');
                }
            });
        });
    });
}
