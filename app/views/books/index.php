<div class="books-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Trang chủ</a>
            <span class="separator">/</span>
            <span class="current"><?= isset($category) ? htmlspecialchars($category->category_name) : 'Tất cả sách' ?></span>
        </div>

        <div class="books-page-header">
            <h1><?= isset($category) ? htmlspecialchars($category->category_name) : 'Tất cả sách' ?></h1>
            <div class="sort-bar">
                <span>Sắp xếp:</span>
                <select id="sortSelect" onchange="window.location.href=this.value">
                    <option value="<?= BASE_URL ?>/books?sort=newest" <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                    <option value="<?= BASE_URL ?>/books?sort=popular" <?= ($sort ?? '') == 'popular' ? 'selected' : '' ?>>Bán chạy</option>
                    <option value="<?= BASE_URL ?>/books?sort=price_asc" <?= ($sort ?? '') == 'price_asc' ? 'selected' : '' ?>>Giá thấp → cao</option>
                    <option value="<?= BASE_URL ?>/books?sort=price_desc" <?= ($sort ?? '') == 'price_desc' ? 'selected' : '' ?>>Giá cao → thấp</option>
                    <option value="<?= BASE_URL ?>/books?sort=rating" <?= ($sort ?? '') == 'rating' ? 'selected' : '' ?>>Đánh giá cao</option>
                </select>
            </div>
        </div>

        <div class="books-layout">
            <?php if (!empty($categories)): ?>
            <aside class="sidebar">
                <div class="filter-box">
                    <h3>📂 Thể loại</h3>
                    <a href="<?= BASE_URL ?>/books" class="filter-item <?= !isset($category) ? 'active' : '' ?>">
                        <i class="fas fa-layer-group"></i> Tất cả
                    </a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?= BASE_URL ?>/category/<?= $cat->category_id ?>" 
                           class="filter-item <?= (isset($category) && $category->category_id == $cat->category_id) ? 'active' : '' ?>">
                            <i class="fas fa-chevron-right"></i> <?= htmlspecialchars($cat->category_name) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </aside>
            <?php endif; ?>

            <div>
                <?php if (!empty($books)): ?>
                    <div class="books-grid">
                        <?php foreach ($books as $book):
                            include APP_PATH . '/views/partials/book_card.php';
                        endforeach; ?>
                    </div>

                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="?page=<?= $currentPage - 1 ?>&sort=<?= $sort ?? '' ?>"><i class="fas fa-chevron-left"></i></a>
                        <?php endif; ?>
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <?php if ($p == $currentPage): ?>
                                <span class="active"><?= $p ?></span>
                            <?php else: ?>
                                <a href="?page=<?= $p ?>&sort=<?= $sort ?? '' ?>"><?= $p ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?page=<?= $currentPage + 1 ?>&sort=<?= $sort ?? '' ?>"><i class="fas fa-chevron-right"></i></a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📚</div>
                        <h3>Chưa có sách nào</h3>
                        <p>Danh mục này hiện chưa có sách. Hãy quay lại sau nhé!</p>
                        <a href="<?= BASE_URL ?>/books" class="btn btn-primary">Xem tất cả sách</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
