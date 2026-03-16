<?php
class CartController extends Controller {

    public function index() {
        $this->requireLogin();
        $cartModel = $this->model('Cart');

        $data = [
            'pageTitle'  => 'Giỏ hàng - BookStore',
            'cartItems'  => $cartModel->getByUser($_SESSION['user_id']),
            'cartTotal'  => $cartModel->getCartTotal($_SESSION['user_id']),
        ];

        $this->view('cart/index', $data);
    }

    public function add() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookId   = (int)($_POST['book_id'] ?? 0);
            $quantity = max(1, (int)($_POST['quantity'] ?? 1));

            $cartModel = $this->model('Cart');
            $cartModel->addItem($_SESSION['user_id'], $bookId, $quantity);
            $this->setFlash('success', 'Đã thêm sách vào giỏ hàng!');
        }

        // Redirect back
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL;
        header("Location: $referer");
        exit;
    }

    public function update() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = (int)($_POST['cart_item_id'] ?? 0);
            $quantity   = max(1, (int)($_POST['quantity'] ?? 1));

            $cartModel = $this->model('Cart');
            $cartModel->updateQuantity($cartItemId, $_SESSION['user_id'], $quantity);
        }

        $this->redirect('cart');
    }

    public function remove() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = (int)($_POST['cart_item_id'] ?? 0);

            $cartModel = $this->model('Cart');
            $cartModel->removeItem($cartItemId, $_SESSION['user_id']);
            $this->setFlash('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        }

        $this->redirect('cart');
    }
}
