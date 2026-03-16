<div class="page-header">
    <h1><i class="fas fa-book"></i> Quản lý sách</h1>
    <a href="<?= BASE_URL ?>/admin/books/add" class="admin-btn admin-btn-primary">
        <i class="fas fa-plus"></i> Thêm sách mới
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Danh sách sách (<?= $totalBooks ?>)</h3>
    </div>
    <div class="admin-card-body" style="padding:0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sách</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Đã bán</th>
                    <th>Đánh giá</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($books)): foreach ($books as $b): ?>
            <tr>
                <td>#<?= $b->book_id ?></td>
                <td style="max-width:250px;">
                    <strong style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <?= htmlspecialchars($b->title) ?>
                    </strong>
                    <small style="color:var(--admin-text-muted);"><?= htmlspecialchars($b->authors ?? '') ?></small>
                </td>
                <td style="color:var(--admin-danger);font-weight:600;"><?= number_format($b->price, 0, ',', '.') ?>₫</td>
                <td><?= $b->stock_quantity ?></td>
                <td><?= $b->total_sold ?></td>
                <td>⭐ <?= $b->avg_rating ?></td>
                <td>
                    <span class="admin-badge <?= $b->is_active ? 'badge-active' : 'badge-inactive' ?>">
                        <?= $b->is_active ? 'Active' : 'Hidden' ?>
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="<?= BASE_URL ?>/admin/books/edit/<?= $b->book_id ?>" class="admin-btn admin-btn-outline admin-btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/admin/books/delete/<?= $b->book_id ?>" class="admin-btn admin-btn-danger admin-btn-sm"
                           onclick="return confirm('Bạn có chắc muốn ẩn sách này?')">
                            <i class="fas fa-eye-slash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="8" class="admin-empty">Chưa có sách nào</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if (isset($totalPages) && $totalPages > 1): ?>
<div style="display:flex;justify-content:center;gap:6px;margin-top:20px;">
    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
        <a href="?page=<?= $p ?>" class="admin-btn <?= $p == $currentPage ? 'admin-btn-primary' : 'admin-btn-outline' ?> admin-btn-sm">
            <?= $p ?>
        </a>
    <?php endfor; ?>
</div>
<?php endif; ?>
