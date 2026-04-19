export function initProduct() {
    // Keep empty for now if no dom-ready init needed, but good to have
}

export function changeQty(delta) {
    const input = document.getElementById('qtyInput');
    if (!input) return;
    let val = parseInt(input.value) + delta;
    const min = parseInt(input.min) || 1;
    // Provide a large fallback if data-stock is empty (should not happen typically)
    const max = parseInt(input.dataset.stock) || 9999;
    
    if (val < min) val = min;
    if (val > max) {
        // We still clamp when using the + button to prevent infinite clicking
        val = max;
        // Show stock exceeded warning
        if (typeof window.showStockWarning === 'function') {
            window.showStockWarning(max);
        }
    }
    input.value = val;
}

// Show stock exceeded warning modal/toast
window.showStockWarning = function(stockQty) {
    // Remove existing modal if any
    const existing = document.getElementById('stockWarningModal');
    if (existing) existing.remove();

    const modal = document.createElement('div');
    modal.id = 'stockWarningModal';
    modal.style.cssText = `
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); display: flex; align-items: center;
        justify-content: center; z-index: 10000; animation: fadeIn 0.3s ease;
    `;
    modal.innerHTML = `
        <div style="
            background: var(--bg-primary, #fff); border-radius: 16px; padding: 32px;
            max-width: 460px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center; animation: slideUp 0.3s ease; position: relative;
        ">
            <button onclick="this.closest('#stockWarningModal').remove()" style="
                position: absolute; top: 12px; right: 16px; background: none; border: none; font-size: 1.8rem; 
                cursor: pointer; color: #999; transition: color 0.2s; padding: 0; line-height: 1;
            " onmouseover="this.style.color='#ff4757'" onmouseout="this.style.color='#999'">&times;</button>
            <div style="font-size: 3rem; margin-bottom: 12px;">⚠️</div>
            <h3 style="margin-bottom: 12px; color: var(--text-primary, #333); font-size: 1.2rem;">
                Đơn đặt hàng vượt quá số lượng trong kho
            </h3>
            <p style="color: var(--text-secondary, #666); margin-bottom: 0; line-height: 1.6;">
                nếu bạn vẫn muốn đặt thì hãy liên hệ với gmail: book4u
            </p>
        </div>
    `;

    // Close on backdrop click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) modal.remove();
    });

    document.body.appendChild(modal);
};

// Expose changeQty globally for onclick handlers
window.changeQty = changeQty;
