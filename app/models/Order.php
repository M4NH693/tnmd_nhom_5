<?php
class Order extends Model {
    protected $table = 'orders';

    protected function getPrimaryKey() {
        return 'order_id';
    }

    public function getByUser($userId) {
        return $this->findAll('user_id = ?', [$userId], 'ordered_at DESC');
    }

    public function getOrderItems($orderId) {
        return $this->query(
            "SELECT oi.*, b.title, b.cover_image, b.slug
             FROM order_items oi
             JOIN books b ON b.book_id = oi.book_id
             WHERE oi.order_id = ?", [$orderId]
        );
    }

    public function createOrder($data, $items) {
        $this->db->beginTransaction();
        try {
            // Generate order code
            $data['order_code'] = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            
            $orderId = $this->insert($data);

            // Insert order items
            $stmt = $this->db->prepare(
                "INSERT INTO order_items (order_id, book_id, quantity, unit_price, total_price)
                 VALUES (?, ?, ?, ?, ?)"
            );

            foreach ($items as $item) {
                $stmt->execute([
                    $orderId,
                    $item['book_id'],
                    $item['quantity'],
                    $item['unit_price'],
                    $item['quantity'] * $item['unit_price']
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
