<?php
class Cart extends Model {
    protected $table = 'cart_items';

    protected function getPrimaryKey() {
        return 'cart_item_id';
    }

    public function getByUser($userId) {
        return $this->query(
            "SELECT ci.*, b.title, b.price, b.cover_image, b.stock_quantity, b.slug
             FROM cart_items ci
             JOIN books b ON b.book_id = ci.book_id
             WHERE ci.user_id = ?
             ORDER BY ci.added_at DESC", [$userId]
        );
    }

    public function addItem($userId, $bookId, $quantity = 1) {
        $existing = $this->queryOne(
            "SELECT * FROM cart_items WHERE user_id = ? AND book_id = ?",
            [$userId, $bookId]
        );

        if ($existing) {
            return $this->update($existing->cart_item_id, [
                'quantity' => $existing->quantity + $quantity
            ]);
        }

        return $this->insert([
            'user_id'  => $userId,
            'book_id'  => $bookId,
            'quantity' => $quantity,
        ]);
    }

    public function updateQuantity($cartItemId, $userId, $quantity) {
        $stmt = $this->db->prepare(
            "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ? AND user_id = ?"
        );
        return $stmt->execute([$quantity, $cartItemId, $userId]);
    }

    public function removeItem($cartItemId, $userId) {
        $stmt = $this->db->prepare(
            "DELETE FROM cart_items WHERE cart_item_id = ? AND user_id = ?"
        );
        return $stmt->execute([$cartItemId, $userId]);
    }

    public function clearCart($userId) {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    public function getCartCount($userId) {
        $result = $this->queryOne(
            "SELECT SUM(quantity) as total FROM cart_items WHERE user_id = ?", [$userId]
        );
        return $result->total ?? 0;
    }

    public function getBookStock($bookId) {
        $result = $this->queryOne(
            "SELECT stock_quantity FROM books WHERE book_id = ?", [$bookId]
        );
        return $result ? (int)$result->stock_quantity : 0;
    }

    public function getExistingQuantity($userId, $bookId) {
        $result = $this->queryOne(
            "SELECT quantity FROM cart_items WHERE user_id = ? AND book_id = ?",
            [$userId, $bookId]
        );
        return $result ? (int)$result->quantity : 0;
    }

    public function getCartTotal($userId) {
        $result = $this->queryOne(
            "SELECT SUM(ci.quantity * b.price) as total
             FROM cart_items ci
             JOIN books b ON b.book_id = ci.book_id
             WHERE ci.user_id = ?", [$userId]
        );
        return $result->total ?? 0;
    }
}
