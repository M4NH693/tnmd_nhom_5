<?php
class Category extends Model {
    protected $table = 'categories';

    protected function getPrimaryKey() {
        return 'category_id';
    }

    public function getActive() {
        return $this->findAll('is_active = 1 AND parent_id IS NULL', [], 'category_name ASC');
    }

    public function getAllActive() {
        return $this->findAll('is_active = 1', [], 'category_name ASC');
    }

    public function getWithBookCount() {
        return $this->query(
            "SELECT c.*, COUNT(b.book_id) as book_count
             FROM categories c
             LEFT JOIN books b ON b.category_id = c.category_id AND b.is_active = 1
             WHERE c.is_active = 1 AND c.parent_id IS NULL
             GROUP BY c.category_id
             ORDER BY c.category_name ASC"
        );
    }
}
