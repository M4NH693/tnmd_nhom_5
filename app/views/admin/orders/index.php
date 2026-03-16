<?php
$stMap = ['pending'=>'badge-pending','confirmed'=>'badge-confirmed','shipping'=>'badge-shipping','delivered'=>'badge-delivered','cancelled'=>'badge-cancelled','returned'=>'badge-cancelled'];
$stLabel = ['pending'=>'Chờ xác nhận','confirmed'=>'Đã xác nhận','shipping'=>'Đang giao','delivered'=>'Đã giao','cancelled'=>'Đã hủy','returned'=>'Đã trả'];
$statuses = [''=>'Tất cả','pending'=>'Chờ xác nhận','confirmed'=>'Đã xác nhận','shipping'=>'Đang giao','delivered'=>'Đã giao','cancelled'=>'Đã hủy'];
?>
<div class="page-header">
    <h1><i class="fas fa-shopping-bag"></i> Quản lý đơn hàng</h1>
</div>

<div class="status-filters">
    <?php foreach ($statuses as $val => $label): ?>
        <a href="<?= BASE_URL ?>/admin/orders<?= $val ? '?status='.$val : '' ?>" 
           class="status-filter <?= ($currentStatus ?? '') === $val ? 'active' : '' ?>"><?= $label ?></a>
    <?php endforeach; ?>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0;">
        <table class="admin-table">
            <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Email</th><th>Tổng tiền</th><th>Thanh toán</th><th>Trạng thái</th><th>Ngày</th><th>Thao tác</th></tr></thead>
            <tbody>
            <?php if (!empty($orders)): foreach ($orders as $o): ?>
            <tr>
                <td><strong style="color:var(--admin-primary);"><?= $o->order_code ?></strong></td>
                <td><?= htmlspecialchars($o->full_name) ?></td>
                <td style="color:var(--admin-text-muted);font-size:0.85rem;"><?= $o->email ?></td>
                <td style="font-weight:700;color:var(--admin-danger);"><?= number_format($o->total_amount, 0, ',', '.') ?>₫</td>
                <td><span class="admin-badge <?= $o->payment_status === 'paid' ? 'badge-delivered' : 'badge-pending' ?>">
                    <?= $o->payment_status === 'paid' ? 'Đã TT' : ($o->payment_status === 'refunded' ? 'Hoàn tiền' : 'Chưa TT') ?>
                </span></td>
                <td><span class="admin-badge <?= $stMap[$o->order_status] ?? '' ?>"><?= $stLabel[$o->order_status] ?? $o->order_status ?></span></td>
                <td style="color:var(--admin-text-muted);font-size:0.85rem;"><?= date('d/m/Y H:i', strtotime($o->ordered_at)) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/admin/orders/detail/<?= $o->order_id ?>" class="admin-btn admin-btn-outline admin-btn-sm">
                        <i class="fas fa-eye"></i> Chi tiết
                    </a>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="8" style="text-align:center;padding:40px;color:var(--admin-text-muted);">Không có đơn hàng nào</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
