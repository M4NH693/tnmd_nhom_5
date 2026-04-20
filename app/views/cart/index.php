<div class="cart-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Trang chủ</a>
            <span class="separator">/</span>
            <span class="current">Giỏ hàng</span>
        </div>

        <h1>🛒 Giỏ hàng của bạn</h1>

        <?php if (!empty($cartItems)): ?>
        <div class="cart-layout">
            <div class="cart-items">
                <?php foreach ($cartItems as $item):
                    $itemTotal = $item->price * $item->quantity;
                ?>
                <div class="cart-item">
                    <div class="cart-item-image">
                        <?php if (!empty($item->cover_image)): ?>
                            <img src="<?= BASE_URL . (strpos($item->cover_image, '/') === 0 ? $item->cover_image : '/images/books/' . $item->cover_image) ?>" alt="">
                        <?php else: ?>
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#f0e6d3,#e8d5b7);display:flex;align-items:center;justify-content:center;font-size:2rem;">📚</div>
                        <?php endif; ?>
                    </div>

                    <div class="cart-item-info">
                        <h3><a href="<?= BASE_URL ?>/book/<?= $item->book_id ?>"><?= htmlspecialchars($item->title) ?></a></h3>
                        <div class="cart-item-price"><?= number_format($item->price, 0, ',', '.') ?>₫</div>
                        <form action="<?= BASE_URL ?>/cart/update" method="POST" style="margin-top:8px; display:flex; gap:8px; align-items:center;" class="cart-update-form">
                            <input type="hidden" name="cart_item_id" value="<?= $item->cart_item_id ?>">
                            <div class="quantity-selector" style="transform:scale(0.85); transform-origin:left;">
                                <button type="button" class="qty-decrease" data-stock="<?= $item->stock_quantity ?>">−</button>
                                <input type="number" name="quantity" value="<?= $item->quantity ?>" min="1" max="<?= $item->stock_quantity ?>" data-stock="<?= $item->stock_quantity ?>" class="cart-qty-input">
                                <button type="button" class="qty-increase" data-stock="<?= $item->stock_quantity ?>">+</button>
                            </div>
                            <span class="stock-info" style="font-size: 0.75rem; color: var(--text-secondary, #888);">
                                (Kho: <?= $item->stock_quantity ?>)
                            </span>
                        </form>
                    </div>

                    <div class="cart-item-total"><?= number_format($itemTotal, 0, ',', '.') ?>₫</div>

                    <form action="<?= BASE_URL ?>/cart/remove" method="POST">
                        <input type="hidden" name="cart_item_id" value="<?= $item->cart_item_id ?>">
                        <button type="submit" class="btn btn-sm btn-danger" style="border-radius:50%;width:36px;height:36px;padding:0;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <h3>Tóm tắt đơn hàng</h3>
                <div class="cart-summary-row">
                    <span>Tạm tính</span>
                    <span><?= number_format($cartTotal, 0, ',', '.') ?>₫</span>
                </div>
                <?php 
                    $shippingFeeDisplay = $cartTotal >= 300000 ? 0 : 30000;
                ?>
                <div class="cart-summary-row">
                    <span>Phí vận chuyển</span>
                    <span><?= $shippingFeeDisplay == 0 ? 'Miễn phí' : number_format($shippingFeeDisplay, 0, ',', '.') . '₫' ?></span>
                </div>
                <div class="cart-summary-row total">
                    <span>Tổng cộng</span>
                    <span class="text-error"><?= number_format($cartTotal + $shippingFeeDisplay, 0, ',', '.') ?>₫</span>
                </div>
                <a href="<?= BASE_URL ?>/checkout" class="btn btn-primary btn-lg">
                    <i class="fas fa-credit-card"></i> Thanh toán
                </a>
                <a href="<?= BASE_URL ?>/books" class="btn btn-secondary" style="margin-top:10px;">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">🛒</div>
            <h3>Giỏ hàng trống</h3>
            <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
            <a href="<?= BASE_URL ?>/books" class="btn btn-primary btn-lg">Mua sắm ngay</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity decrease buttons
    document.querySelectorAll('.qty-decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            const input = form.querySelector('.cart-qty-input');
            let val = parseInt(input.value) - 1;
            if (val < 1) val = 1;
            input.value = val;
            form.submit();
        });
    });

    // Handle quantity increase buttons
    document.querySelectorAll('.qty-increase').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            const input = form.querySelector('.cart-qty-input');
            const stock = parseInt(this.dataset.stock) || 999;
            let val = parseInt(input.value) + 1;
            
            if (val > stock) {
                val = stock;
                if (typeof window.showStockWarning === 'function') {
                    window.showStockWarning(stock);
                }
                return;
            }
            input.value = val;
            form.submit();
        });
    });

    // Handle manual input change
    document.querySelectorAll('.cart-qty-input').forEach(input => {
        input.addEventListener('change', function() {
            const stock = parseInt(this.dataset.stock) || 999;
            let val = parseInt(this.value);
            
            if (val < 1) {
                this.value = 1;
            } else if (val > stock) {
                this.value = stock;
                if (typeof window.showStockWarning === 'function') {
                    window.showStockWarning(stock);
                }
                return;
            }
            this.closest('form').submit();
        });
    });
});
</script>

