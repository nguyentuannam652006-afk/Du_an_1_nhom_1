<?php

// Model User đại diện cho thực thể người dùng trong hệ thống
class User
{
    // Các thuộc tính của User
    public $id;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $address;
    public $role;
    public $status;
    public $created_at;
    public $updated_at;

    // Constructor để khởi tạo thực thể User
    public function __construct($data = [])
    {
        // Nếu truyền vào mảng dữ liệu thì gán vào các thuộc tính
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
            // Giá trị mặc định
            if (!isset($this->role)) {
                $this->role = 'khach_hang';
            }
            if (!isset($this->status)) {
                $this->status = 1;
            }
        } else {
            // Nếu truyền vào string thì coi như tên (tương thích với code cũ)
            $this->name = $data;
        }
    }

    // Trả về tên người dùng để hiển thị
    public function getName()
    {
        return $this->name;
    }

    // Kiểm tra xem user có phải là admin không
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Kiểm tra xem user có phải là hướng dẫn viên không
    public function isGuide()
    {
        return $this->role === 'huong_dan_vien';
    }

    // Kiểm tra xem user có phải là khách hàng không
    public function isCustomer()
    {
        return $this->role === 'khach_hang';
    }

    // Lấy user theo ID
    public static function getById($id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_CLASS, __CLASS__) ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Lấy user theo email
    public static function getByEmail($email)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_CLASS, __CLASS__) ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Lấy tất cả user
    public static function getAll()
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM users ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy user theo role
    public static function getByRole($role)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM users WHERE role = :role ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':role' => $role]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Tạo user mới
    public function create()
    {
        global $pdo;
        try {
            $sql = "INSERT INTO users (name, email, password, phone, address, role, status) 
                    VALUES (:name, :email, :password, :phone, :address, :role, :status)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => $this->password,
                ':phone' => $this->phone ?? '',
                ':address' => $this->address ?? '',
                ':role' => $this->role ?? 'khach_hang',
                ':status' => $this->status ?? 1
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Cập nhật user
    public function update()
    {
        global $pdo;
        try {
            $sql = "UPDATE users SET name = :name, email = :email, phone = :phone, 
                    address = :address, role = :role, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id' => $this->id,
                ':name' => $this->name,
                ':email' => $this->email,
                ':phone' => $this->phone,
                ':address' => $this->address,
                ':role' => $this->role,
                ':status' => $this->status
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Xóa user
    public static function delete($id)
    {
        global $pdo;
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }
}
