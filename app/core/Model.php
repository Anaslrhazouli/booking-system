<?php

class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

       // Add new method for executing queries that don't return results
    protected function execute($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    public function insert($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    public function findOne($conditions) {
    // Get the columns from the conditions
    $columns = array_keys($conditions);
    
    // Build the WHERE clause
    $whereClause = implode(' AND ', array_map(fn($col) => "$col = :$col", $columns));
    
    // Prepare the SQL statement
    $sql = "SELECT * FROM {$this->table} WHERE $whereClause LIMIT 1";
    

    $stmt = $this->db->prepare($sql);
    
    // Execute the query with the conditions
    $stmt->execute($conditions);
    
    // Fetch the result as an associative array
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function findAll($conditions = []) {
        $whereClause = '';
        if (!empty($conditions)) {
            $columns = array_keys($conditions);
            $whereClause = 'WHERE ' . implode(' AND ', array_map(fn($col) => "$col = :$col", $columns));
        }
        $sql = "SELECT * FROM {$this->table} $whereClause";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update($data, $where) {
    $setParts = [];
    $values = [];
    
    // Build SET clause
    foreach ($data as $column => $value) {
        $setParts[] = "`$column` = ?";
        $values[] = $value;
    }
    
    // Build WHERE clause
    $whereParts = [];
    foreach ($where as $column => $value) {
        $whereParts[] = "`$column` = ?";
        $values[] = $value;
    }
    
    $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts) . 
           " WHERE " . implode(' AND ', $whereParts);
    
    return $this->db->prepare($sql)->execute($values);
}
    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
