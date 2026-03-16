<?php
$stLabel = ['pending'=>'Chờ xác nhận','confirmed'=>'Đã xác nhận','shipping'=>'Đang giao','delivered'=>'Đã giao','cancelled'=>'Đã hủy','returned'=>'Đã trả'];
$stMap = ['pending'=>'badge-pending','confirmed'=>'badge-confirmed','shipping'=>'badge-shipping','delivered'=>'badge-delivered','cancelled'=>'badge-cancelled','returned'=>'badge-cancelled'];
$pmLabel = ['cod'=>'COD','bank_transfer'=>'Chuyển khoản','e_wallet'=>'Ví điện tử','credit_card'=>'Thẻ tín dụng'];
?>
<div class="page-header">
    <h1><i class="fas fa-file-invoice"></i> Đơn hàng #<?= $order->order_code ?></h1>
    <a href="<?= BASE_URL ?>/admin/orders" class="admin-btn admin-btn-outline"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>

<div class="order-detail-grid">
    <div class="admin-card">
        <div class="admin-card-header"><h3><i class="fas fa-user"></i> Thông tin khách hàng</h3></div>
        <div class="admin-card-body">
            <div class="detail-row"><span class="detail-label">Họ tên</span><span class="detail-value"><?= htmlspecialchars($order->full_name) ?></span></div>
            <div class="detail-row"><span class="detail-label">Email</span><span class="detail-value"><?= $order->email ?></span></div>
            <div class="detail-row"><span class="detail-label">Người nhận</span><span class="detail-value"><?= htmlspecialchars($order->receiver_name) ?></span></div>
            <div class="detail-row"><span class="detail-label">SĐT</span><span class="detail-value"><?= $order->receiver_phone ?></span></div>
            <div class="detail-row"><span class="detail-label">Địa chỉ</span><span class="detail-value"><?= htmlspecialchars($order->shipping_address) ?></span></div>
        </div>
    </div>
    <div class="admin-card">
        <div class="admin-card-header"><h3><i class="fas fa-info-circle"></i> Thông tin đơn hàng</h3></div>
        <div class="admin-card-body">
            <div class="detail-row"><span class="detail-label">Trạng thái</span><span class="admin-badge <?= $stMap[$order->order_status] ?? '' ?>"><?= $stLabel[$order->order_status] ?? $order->order_status ?></span></div>
            <div class="detail-row"><span class="detail-label">Thanh toán</span><span class="detail-value"><?= $pmLabel[$order->payment_method] ?? $order->payment_method ?></span></div>
            <div class="detail-row"><span class="detail-label">Tạm tính</span><span class="detail-value"><?= number_format($order->subtotal, 0, ',', '.') ?>₫</span></div>
            <div class="detail-row"><span class="detail-label">Phí ship</span><span class="detail-value"><?= number_format($order->shipping_fee, 0, ',', '.') ?>₫</span></div>
            <div class="detail-row"><span class="detail-label">Tổng cộng</span><span class="detail-value" style="color:var(--admin-danger);font-size:1.2rem;"><?= number_format($order->total_amount, 0, ',', '.') ?>₫</span></div>
            <div class="detail-row"><span class="detail-label">Ngày đặt</span><span class="detail-value"><?= date('d/m/Y H:i', strtotime($order->ordered_at)) ?></span></div>
            <?php if ($order->note): ?>
            <div class="detail-row"><span class="detail-label">Ghi chú</span><span class="detail-value"><?= htmlspecialchars($order->note) ?></span></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Update Status -->
<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-card-header"><h3><i class="fas fa-sync-alt"></i> Cập nhật trạng thái</h3></div>
    <div class="admin-card-body">
        <form method="POST" action="<?= BASE_URL ?>/admin/orders/update-status/<?= $order->order_id ?>" style="display:flex;gap:12px;align-items:flex-end;">
            <div class="admin-form-group" style="margin-bottom:0;flex:1;max-width:300px;">
                <label>Trạng thái mới</label>
                <select name="order_status" class="admin-form-control">
                    <?php foreach ($stLabel as $val => $label): ?>
                        <option value="<?= $val ?>" <?= $order->order_status === $val ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-check"></i> Cập nhật</button>
        </form>
    </div>
</div>

<!-- Order Items -->
<div class="admin-card">
    <div class="admin-card-header"><h3><i class="fas fa-list"></i> Sản phẩm (<?= count($items) ?>)</h3></div>
    <div class="admin-card-body" style="padding:0;">
        <table class="admin-table">
            <thead><tr><th>Sách</th><th>Đơn giá</th><th>SL</th><th>Thành tiền</th></tr></thead>
            <tbody>
            <?php foreach ($items as $it): ?>
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:40px;height:52px;background:#F0F0F0;border-radius:4px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">📚</div>
                        <strong><?= htmlspecialchars($it->title) ?></strong>
                    </div>
                </td>
                <td><?= number_format($it->unit_price, 0, ',', '.') ?>₫</td>
                <td><?= $it->quantity ?></td>
                <td style="font-weight:700;color:var(--admin-danger);"><?= number_format($it->total_price, 0, ',', '.') ?>₫</td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
