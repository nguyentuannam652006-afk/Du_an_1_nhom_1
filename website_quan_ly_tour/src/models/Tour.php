<?php

// Model Tour - Đại diện cho một tour du lịch
class Tour
{
    public $id;
    public $name;
    public $description;
    public $destination;
    public $duration;
    public $price;
    public $max_participants;
    public $status; // dang_hoat_dong, tam_dung, da_huy
    public $created_at;
    public $updated_at;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Lấy tất cả tour
    public static function getAll()
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM tours ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy tour theo ID
    public static function getById($id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM tours WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_CLASS, __CLASS__);
            return $result ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Tạo tour mới
    public function create()
    {
        global $pdo;
        try {
            $sql = "INSERT INTO tours (name, description, destination, duration, price, max_participants, status) 
                    VALUES (:name, :description, :destination, :duration, :price, :max_participants, :status)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':name' => $this->name,
                ':description' => $this->description,
                ':destination' => $this->destination,
                ':duration' => $this->duration,
                ':price' => $this->price,
                ':max_participants' => $this->max_participants,
                ':status' => $this->status ?? 'dang_hoat_dong'
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Cập nhật tour
    public function update()
    {
        global $pdo;
        try {
            $sql = "UPDATE tours SET name = :name, description = :description, destination = :destination, 
                    duration = :duration, price = :price, max_participants = :max_participants, status = :status 
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id' => $this->id,
                ':name' => $this->name,
                ':description' => $this->description,
                ':destination' => $this->destination,
                ':duration' => $this->duration,
                ':price' => $this->price,
                ':max_participants' => $this->max_participants,
                ':status' => $this->status
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Xóa tour
    public static function delete($id)
    {
        global $pdo;
        try {
            $sql = "DELETE FROM tours WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Tìm kiếm tour
    public static function search($keyword, $destination = null)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM tours WHERE (name LIKE :keyword OR destination LIKE :keyword OR description LIKE :keyword)";
            $params = [':keyword' => '%' . $keyword . '%'];
            
            if ($destination) {
                $sql .= " AND destination = :destination";
                $params[':destination'] = $destination;
            }
            
            $sql .= " ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }
}
