<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1>Đăng nhập</h1>
            <p class="subtitle">Chào mừng bạn trở lại BookStore</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/login">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                           placeholder="example@email.com"
                           value="<?= htmlspecialchars($email ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="form-control"
                           placeholder="Nhập mật khẩu" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>

            <div class="auth-footer">
                Chưa có tài khoản? <a href="<?= BASE_URL ?>/register">Đăng ký ngay</a>
            </div>
        </div>
    </div>
</div>
