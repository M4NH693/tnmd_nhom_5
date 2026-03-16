<?php $isEdit = isset($book); ?>
<div class="page-header">
    <h1><i class="fas fa-<?= $isEdit ? 'edit' : 'plus' ?>"></i> <?= $isEdit ? 'Sửa sách' : 'Thêm sách mới' ?></h1>
    <a href="<?= BASE_URL ?>/admin/books" class="admin-btn admin-btn-outline"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>

<div class="admin-card">
    <div class="admin-card-body">
        <form method="POST" action="<?= BASE_URL ?>/admin/books/<?= $isEdit ? 'edit/' . $book->book_id : 'add' ?>">
            <div class="admin-form-group">
                <label for="title">Tên sách *</label>
                <input type="text" name="title" id="title" class="admin-form-control"
                       value="<?= htmlspecialchars($isEdit ? $book->title : '') ?>" required>
            </div>

            <div class="form-row">
                <div class="admin-form-group">
                    <label for="category_id">Thể loại</label>
                    <select name="category_id" id="category_id" class="admin-form-control">
                        <option value="">-- Chọn thể loại --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat->category_id ?>" <?= ($isEdit && $book->category_id == $cat->category_id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat->category_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="admin-form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" name="isbn" id="isbn" class="admin-form-control"
                           value="<?= htmlspecialchars($isEdit ? ($book->isbn ?? '') : '') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="admin-form-group">
                    <label for="price">Giá bán (₫) *</label>
                    <input type="number" name="price" id="price" class="admin-form-control" min="0" step="1000"
                           value="<?= $isEdit ? $book->price : '' ?>" required>
                </div>
                <div class="admin-form-group">
                    <label for="stock_quantity">Số lượng tồn kho *</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" class="admin-form-control" min="0"
                           value="<?= $isEdit ? $book->stock_quantity : '0' ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="admin-form-group">
                    <label for="publication_year">Năm xuất bản</label>
                    <input type="number" name="publication_year" id="publication_year" class="admin-form-control"
                           value="<?= $isEdit ? ($book->publication_year ?? '') : '' ?>">
                </div>
                <div class="admin-form-group">
                    <label for="pages">Số trang</label>
                    <input type="number" name="pages" id="pages" class="admin-form-control"
                           value="<?= $isEdit ? ($book->pages ?? '') : '' ?>">
                </div>
            </div>

            <div class="admin-form-group">
                <label for="language">Ngôn ngữ</label>
                <input type="text" name="language" id="language" class="admin-form-control"
                       value="<?= htmlspecialchars($isEdit ? ($book->language ?? 'Tiếng Việt') : 'Tiếng Việt') ?>">
            </div>

            <div class="admin-form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="admin-form-control" rows="5"><?= htmlspecialchars($isEdit ? ($book->description ?? '') : '') ?></textarea>
            </div>

            <div style="display:flex;gap:12px;margin-top:24px;">
                <button type="submit" class="admin-btn admin-btn-primary admin-btn-lg">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Cập nhật' : 'Thêm sách' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/books" class="admin-btn admin-btn-outline admin-btn-lg">Hủy</a>
            </div>
        </form>
    </div>
</div>
