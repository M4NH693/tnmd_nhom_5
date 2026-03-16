<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/components.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/pages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <main style="margin-top:0;">
        <div class="auth-page" style="min-height:100vh;">
            <div class="auth-container" style="text-align:center;">
                <div style="font-size:6rem;margin-bottom:16px;">📖</div>
                <h1 style="font-family:var(--font-heading);font-size:4rem;color:var(--primary);margin-bottom:8px;">404</h1>
                <h2 style="font-family:var(--font-heading);font-size:1.5rem;margin-bottom:12px;">Trang không tồn tại</h2>
                <p style="color:var(--text-secondary);margin-bottom:30px;">
                    Xin lỗi, trang bạn đang tìm không tồn tại hoặc đã bị di chuyển.
                </p>
                <a href="<?= BASE_URL ?>/" class="btn btn-primary btn-lg">
                    <i class="fas fa-home"></i> Về trang chủ
                </a>
            </div>
        </div>
    </main>
</body>
</html>
