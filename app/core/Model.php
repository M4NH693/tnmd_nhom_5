<?php
/**
 * Base Model Class
 */
class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll($conditions = '', $params = [], $orderBy = '', $limit = '') {
        $sql = "SELECT * FROM {$this->table}";
        if ($conditions) $sql .= " WHERE $conditions";
        if ($orderBy)    $sql .= " ORDER BY $orderBy";
        if ($limit)      $sql .= " LIMIT $limit";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE " . $this->getPrimaryKey() . " = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function count($conditions = '', $params = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if ($conditions) $sql .= " WHERE $conditions";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()->total;
    }

    public function insert($data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($fields) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $stmt = $this->db->prepare("UPDATE {$this->table} SET $set WHERE " . $this->getPrimaryKey() . " = ?");
        $values = array_values($data);
        $values[] = $id;
        return $stmt->execute($values);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE " . $this->getPrimaryKey() . " = ?");
        return $stmt->execute([$id]);
    }

    protected function getPrimaryKey() {
        return rtrim($this->table, 's') . '_id';
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function queryOne($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
}
