<div class="books-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>/">Trang chủ</a>
            <span class="separator">/</span>
            <span class="current">Tìm kiếm: "<?= htmlspecialchars($keyword ?? '') ?>"</span>
        </div>

        <div class="books-page-header">
            <h1>Kết quả tìm kiếm</h1>
        </div>

        <div class="search-results-info">
            Tìm thấy <strong><?= $totalBooks ?? 0 ?></strong> kết quả cho "<strong><?= htmlspecialchars($keyword ?? '') ?></strong>"
        </div>

        <?php if (!empty($books)): ?>
            <div class="books-grid">
                <?php foreach ($books as $book):
                    include APP_PATH . '/views/partials/book_card.php';
                endforeach; ?>
            </div>

            <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="pagination">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <?php if ($p == $currentPage): ?>
                        <span class="active"><?= $p ?></span>
                    <?php else: ?>
                        <a href="?q=<?= urlencode($keyword) ?>&page=<?= $p ?>"><?= $p ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <h3>Không tìm thấy kết quả</h3>
                <p>Thử tìm với từ khóa khác hoặc duyệt theo thể loại.</p>
                <a href="<?= BASE_URL ?>/books" class="btn btn-primary">Xem tất cả sách</a>
            </div>
        <?php endif; ?>
    </div>
</div>
