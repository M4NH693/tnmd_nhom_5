<?php
class AuthController extends Controller {

    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $agreeTerms = isset($_POST['agree_terms']);

            if (!$agreeTerms) {
                if ($isAjax) {
                    echo json_encode(['status' => 'error', 'message' => 'Bạn cần đồng ý với Điều khoản sử dụng để tiếp tục!']);
                    return;
                }
                $data = [
                    'pageTitle' => 'Đăng nhập - BookStore',
                    'error'     => 'Bạn cần đồng ý với Điều khoản sử dụng để tiếp tục!',
                    'email'     => $email,
                ];
                $this->view('auth/login', $data);
                return;
            }

            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);

            if ($user && $userModel->verifyPassword($password, $user->password_hash)) {
                $_SESSION['user_id']   = $user->user_id;
                $_SESSION['user_name'] = $user->full_name;
                $_SESSION['user_role'] = $user->role;
                $_SESSION['user_avatar'] = $user->avatar_url;
                if ($isAjax) {
                    echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công!', 'redirect' => BASE_URL . '/']);
                    return;
                }
                $this->setFlash('success', 'Đăng nhập thành công!');
                $this->redirect('');
                return;
            } else {
                if ($isAjax) {
                    echo json_encode(['status' => 'error', 'message' => 'Email hoặc mật khẩu không đúng.']);
                    return;
                }
                $data = [
                    'pageTitle' => 'Đăng nhập - BookStore',
                    'error'     => 'Email hoặc mật khẩu không đúng.',
                    'email'     => $email,
                ];
                $this->view('auth/login', $data);
                return;
            }
        }

        $this->view('auth/login', ['pageTitle' => 'Đăng nhập - BookStore']);
    }

    public function register() {
        if ($this->isLoggedIn()) {
            $this->redirect('');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            $fullName        = trim($_POST['full_name'] ?? '');
            $email           = trim($_POST['email'] ?? '');
            $phone           = trim($_POST['phone'] ?? '');
            $password        = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $agreeTerms = isset($_POST['agree_terms']);
            $errors = [];

            if (!$agreeTerms) $errors[] = 'Bạn cần đồng ý với Điều khoản sử dụng để tiếp tục!';

            if (empty($fullName)) $errors[] = 'Vui lòng nhập họ tên.';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
                $errors[] = 'Email không hợp lệ.';
            if (empty($phone) || !preg_match('/^[0-9]{10,11}$/', $phone))
                $errors[] = 'Số điện thoại không hợp lệ (cần 10-11 số).';
            if (strlen($password) < 6)
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            if ($password !== $confirmPassword)
                $errors[] = 'Mật khẩu xác nhận không khớp.';

            $userModel = $this->model('User');
            if ($userModel->findByEmail($email)) {
                $errors[] = 'Email này đã được sử dụng.';
            }

            if (empty($errors)) {
                $userId = $userModel->register($fullName, $email, $password, $phone);
                $_SESSION['user_id']   = $userId;
                $_SESSION['user_name'] = $fullName;
                $_SESSION['user_role'] = 'customer';
                if ($isAjax) {
                    echo json_encode(['status' => 'success', 'message' => 'Đăng ký thành công! Chào mừng bạn đến với BookStore.', 'redirect' => BASE_URL . '/']);
                    return;
                }
                $this->setFlash('success', 'Đăng ký thành công! Chào mừng bạn đến với BookStore.');
                $this->redirect('');
                return;
            }

            if ($isAjax) {
                echo json_encode(['status' => 'error', 'message' => implode('<br>', $errors)]);
                return;
            }

            $data = [
                'pageTitle' => 'Đăng ký - BookStore',
                'errors'    => $errors,
                'full_name' => $fullName,
                'email'     => $email,
                'phone'     => $phone,
            ];
            $this->view('auth/register', $data);
            return;
        }

        $this->view('auth/register', ['pageTitle' => 'Đăng ký - BookStore']);
    }

    public function forgotPassword() {
        if ($this->isLoggedIn()) {
            $this->redirect('');
            return;
        }

        $data = ['pageTitle' => 'Quên mật khẩu - BookStore'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $fullName = trim($_POST['full_name'] ?? '');

            $data['email']     = $email;
            $data['full_name'] = $fullName;

            // Validate đầu vào
            $errors = [];
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Vui lòng nhập email hợp lệ.';
            }
            if (empty($fullName)) {
                $errors[] = 'Vui lòng nhập họ tên.';
            }

            if (!empty($errors)) {
                $data['errors'] = $errors;
                $this->view('auth/forgot_password', $data);
                return;
            }

            // Kiểm tra email tồn tại
            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);

            if (!$user) {
                $data['errors'] = ['Email này không tồn tại trong hệ thống.'];
                $this->view('auth/forgot_password', $data);
                return;
            }

            // So khớp họ tên
            $nameMatch = mb_strtolower($fullName) === mb_strtolower($user->full_name);

            if (!$nameMatch) {
                $data['errors'] = ['Họ tên không khớp với tài khoản. Vui lòng kiểm tra lại.'];
                $this->view('auth/forgot_password', $data);
                return;
            }

            // Xác minh thành công → tạo token reset
            $token = bin2hex(random_bytes(32));
            $_SESSION['reset_token'] = $token;
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_expires'] = time() + 900; // 15 phút

            $this->redirect('reset-password?token=' . $token);
            return;
        }

        $this->view('auth/forgot_password', $data);
    }

    public function resetPassword() {
        if ($this->isLoggedIn()) {
            $this->redirect('');
            return;
        }

        $token = $_GET['token'] ?? ($_POST['token'] ?? '');
        $data = ['pageTitle' => 'Đặt lại mật khẩu - BookStore'];

        // Kiểm tra token hợp lệ
        if (empty($token) 
            || !isset($_SESSION['reset_token']) 
            || $token !== $_SESSION['reset_token']
            || time() > ($_SESSION['reset_expires'] ?? 0)) {
            $this->setFlash('error', 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn. Vui lòng thử lại.');
            $this->redirect('forgot-password');
            return;
        }

        $data['token'] = $token;
        $data['email'] = $_SESSION['reset_email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $errors = [];

            if (strlen($newPassword) < 6) {
                $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
            }
            if ($newPassword !== $confirmPassword) {
                $errors[] = 'Mật khẩu xác nhận không khớp.';
            }

            if (empty($errors)) {
                $userModel = $this->model('User');
                $user = $userModel->findByEmail($_SESSION['reset_email']);

                if ($user) {
                    $userModel->updatePassword($user->user_id, $newPassword);

                    // Xóa token reset
                    unset($_SESSION['reset_token'], $_SESSION['reset_email'], $_SESSION['reset_expires']);

                    $this->setFlash('success', 'Đặt lại mật khẩu thành công! Hãy đăng nhập với mật khẩu mới.');
                    $this->redirect('login');
                    return;
                } else {
                    $errors[] = 'Có lỗi xảy ra, vui lòng thử lại.';
                }
            }

            $data['errors'] = $errors;
        }

        $this->view('auth/reset_password', $data);
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "/login");
        exit;
    }
}
