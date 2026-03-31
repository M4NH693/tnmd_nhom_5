<?php $isEdit = isset($category); ?>
<div class="page-header">
    <h1><i class="fas fa-<?= $isEdit ? 'edit' : 'plus' ?>"></i> <?= $isEdit ? 'Sửa danh mục' : 'Thêm danh mục' ?></h1>
    <a href="<?= BASE_URL ?>/admin/categories" class="admin-btn admin-btn-outline"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>

<div class="admin-card" style="max-width:600px;">
    <div class="admin-card-body">
        <form method="POST" action="<?= BASE_URL ?>/admin/categories/<?= $isEdit ? 'edit/' . $category->category_id : 'add' ?>" enctype="multipart/form-data">
            <div class="admin-form-group">
                <label for="category_name">Tên danh mục *</label>
                <input type="text" name="category_name" id="category_name" class="admin-form-control"
                       value="<?= htmlspecialchars($isEdit ? $category->category_name : '') ?>" required>
            </div>
            
            <div class="admin-form-group">
                <label for="image">Ảnh minh họa (Bỏ trống nếu không đổi)</label>
                <input type="file" name="image" id="image" class="admin-form-control" accept="image/*">
                <?php if ($isEdit && !empty($category->image)): ?>
                    <div style="margin-top: 10px;">
                        <img src="<?= BASE_URL . $category->image ?>" alt="Category Image" style="max-height: 100px; border-radius: 4px; border: 1px solid #ddd;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="admin-form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="admin-form-control" rows="3"><?= htmlspecialchars($isEdit ? ($category->description ?? '') : '') ?></textarea>
            </div>
            <div style="display:flex;gap:12px;margin-top:20px;">
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-lg">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Cập nhật' : 'Thêm' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/categories" class="admin-btn admin-btn-outline admin-btn-lg">Hủy</a>
            </div>
        </form>
    </div>
</div>
