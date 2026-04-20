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
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($isAjax) {
            if (!$this->isLoggedIn()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để tiếp tục.', 'redirect' => BASE_URL . '/login']);
                exit;
            }
        } else {
            $this->requireLogin();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookId   = (int)($_POST['book_id'] ?? 0);
            $quantity = max(1, (int)($_POST['quantity'] ?? 1));

            $cartModel = $this->model('Cart');

            // --- Stock quantity validation ---
            $stockQuantity = $cartModel->getBookStock($bookId);
            $existingQty = $cartModel->getExistingQuantity($_SESSION['user_id'], $bookId);
            $totalRequested = $existingQty + $quantity;

            if ($totalRequested > $stockQuantity) {
                $errorMsg = "Đơn đặt hàng vượt quá số lượng trong kho, nếu bạn vẫn muốn đặt thì hãy liên hệ với gmail: book4u@gmail.com";
                
                if ($isAjax) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false, 
                        'message' => $errorMsg,
                        'stock_exceeded' => true,
                        'stock_quantity' => $stockQuantity,
                        'existing_qty' => $existingQty
                    ]);
                    exit;
                }

                $this->setFlash('error', $errorMsg);
                $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL;
                header("Location: $referer");
                exit;
            }
            // --- End stock validation ---

            $cartModel->addItem($_SESSION['user_id'], $bookId, $quantity);
            
            if ($isAjax) {
                $cartCount = $cartModel->getCartCount($_SESSION['user_id']);
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Đã thêm sách vào giỏ hàng!', 'cartCount' => $cartCount]);
                exit;
            }

            $this->setFlash('success', 'Đã thêm sách vào giỏ hàng!');
        }

        // Redirect back
        if (!$isAjax) {
            $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL;
            header("Location: $referer");
            exit;
        }
    }

    public function update() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = (int)($_POST['cart_item_id'] ?? 0);
            $quantity   = max(1, (int)($_POST['quantity'] ?? 1));

            $cartModel = $this->model('Cart');

            // Get the book_id from the cart item to check stock
            $cartItem = $cartModel->queryOne(
                "SELECT book_id FROM cart_items WHERE cart_item_id = ? AND user_id = ?",
                [$cartItemId, $_SESSION['user_id']]
            );

            if ($cartItem) {
                $stockQuantity = $cartModel->getBookStock($cartItem->book_id);

                if ($quantity > $stockQuantity) {
                    $this->setFlash('error', "Đơn đặt hàng vượt quá số lượng trong kho, nếu bạn vẫn muốn đặt thì hãy liên hệ với gmail: book4u@gmail.com");
                    $this->redirect('cart');
                    return;
                }

                $cartModel->updateQuantity($cartItemId, $_SESSION['user_id'], $quantity);
            }
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
