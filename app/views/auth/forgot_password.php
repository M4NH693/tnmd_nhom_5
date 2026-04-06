<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1><i class="fas fa-key"></i> Quên mật khẩu</h1>
            <p class="subtitle">Xác minh danh tính để đặt lại mật khẩu</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $err): ?>
                        <div><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/forgot-password" novalidate>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email đã đăng ký</label>
                    <input type="email" id="email" name="email" class="form-control"
                           placeholder="example@email.com"
                           value="<?= htmlspecialchars($email ?? '') ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="full_name"><i class="fas fa-user"></i> Họ và tên</label>
                    <input type="text" id="full_name" name="full_name" class="form-control"
                           placeholder="Nhập đúng họ tên đã đăng ký"
                           value="<?= htmlspecialchars($full_name ?? '') ?>" required>
                </div>

                <div style="background: rgba(45,106,79,0.06); padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85em; color: var(--text-secondary);">
                    <i class="fas fa-info-circle" style="color: var(--primary);"></i>
                    Vui lòng nhập chính xác email và họ tên đã đăng ký để xác minh danh tính.
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-shield-alt"></i> Xác minh & Tiếp tục
                </button>
            </form>

            <div class="auth-footer">
                <a href="<?= BASE_URL ?>/login"><i class="fas fa-arrow-left"></i> Quay lại đăng nhập</a>
            </div>
        </div>
    </div>
</div>
