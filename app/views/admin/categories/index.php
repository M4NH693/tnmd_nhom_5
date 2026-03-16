<div class="page-header">
    <h1><i class="fas fa-folder"></i> Quản lý danh mục</h1>
    <a href="<?= BASE_URL ?>/admin/categories/add" class="admin-btn admin-btn-primary">
        <i class="fas fa-plus"></i> Thêm danh mục
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0;">
        <table class="admin-table">
            <thead><tr><th>ID</th><th>Tên danh mục</th><th>Slug</th><th>Số sách</th><th>Thao tác</th></tr></thead>
            <tbody>
            <?php if (!empty($categories)): foreach ($categories as $cat): ?>
            <tr>
                <td>#<?= $cat->category_id ?></td>
                <td><strong><?= htmlspecialchars($cat->category_name) ?></strong></td>
                <td style="color:var(--admin-text-muted);"><?= htmlspecialchars($cat->slug) ?></td>
                <td><span class="admin-badge badge-active"><?= $cat->book_count ?> sách</span></td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="<?= BASE_URL ?>/admin/categories/edit/<?= $cat->category_id ?>" class="admin-btn admin-btn-outline admin-btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/admin/categories/delete/<?= $cat->category_id ?>" class="admin-btn admin-btn-danger admin-btn-sm"
                           onclick="return confirm('Xóa danh mục này?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--admin-text-muted);">Chưa có danh mục nào</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
