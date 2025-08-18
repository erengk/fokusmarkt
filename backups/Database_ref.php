<?php
require_once __DIR__ . '/../config/database.php';

class Database {
    private static $instance = null;
    private $connection = null;
    
    private function __construct() {
        $this->connect();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function connect() {
        try {
            if (DB_TYPE === 'sqlite') {
                $this->connection = new PDO('sqlite:' . DB_PATH);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->exec('PRAGMA foreign_keys = ON');
            } else {
                $dsn = DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
                $this->connection = new PDO($dsn, DB_USER, DB_PASS);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log('Database query error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        
        return $this->connection->lastInsertId();
    }
    
    public function update($table, $data, $where, $whereParams = []) {
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setClause);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $params = array_merge($data, $whereParams);
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    public function commit() {
        return $this->connection->commit();
    }
    
    public function rollback() {
        return $this->connection->rollback();
    }
    
    // Initialize database with schema and seed data
    public function initialize() {
        try {
            // Check if database is already initialized
            $tables = $this->fetchAll("SELECT name FROM sqlite_master WHERE type='table' AND name='products'");
            
            if (empty($tables)) {
                // Create tables
                $schema = file_get_contents(__DIR__ . '/../database/schema.sql');
                $this->connection->exec($schema);
                
                // Insert seed data
                $seeds = file_get_contents(__DIR__ . '/../database/seeds.sql');
                $this->connection->exec($seeds);
                
                return true;
            }
            
            return false; // Database already exists
        } catch (Exception $e) {
            error_log('Database initialization error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    // Helper method for building WHERE clauses
    public function buildWhere($conditions) {
        $where = [];
        $params = [];
        
        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                $placeholders = [];
                foreach ($value as $i => $val) {
                    $placeholder = ":{$column}_{$i}";
                    $placeholders[] = $placeholder;
                    $params[$placeholder] = $val;
                }
                $where[] = "{$column} IN (" . implode(', ', $placeholders) . ")";
            } else {
                $placeholder = ":{$column}";
                $where[] = "{$column} = {$placeholder}";
                $params[$placeholder] = $value;
            }
        }
        
        return [
            'where' => implode(' AND ', $where),
            'params' => $params
        ];
    }
    
    // Helper method for pagination
    public function paginate($sql, $params = [], $page = 1, $perPage = 12) {
        $offset = ($page - 1) * $perPage;
        
        // Count total records
        $countSql = "SELECT COUNT(*) as total FROM ({$sql}) as subquery";
        $total = $this->fetchOne($countSql, $params)['total'];
        
        // Get paginated results
        $paginatedSql = $sql . " LIMIT {$perPage} OFFSET {$offset}";
        $results = $this->fetchAll($paginatedSql, $params);
        
        return [
            'data' => $results,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }
}
?>
