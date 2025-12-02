<?php

// Model TourSchedule - Lịch trình của một tour
class TourSchedule
{
    public $id;
    public $tour_id;
    public $start_date;
    public $end_date;
    public $available_seats;
    public $status; // san_sang, dang_hoat_dong, hoan_thanh, da_huy
    public $created_at;
    public $updated_at;
    public $tour; // Dữ liệu tour liên quan

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Lấy tất cả lịch trình
    public static function getAll()
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM tour_schedules ORDER BY start_date DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy lịch trình theo ID
    public static function getById($id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM tour_schedules WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_CLASS, __CLASS__) ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Lấy lịch trình theo tour ID
    public static function getByTourId($tour_id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM tour_schedules WHERE tour_id = :tour_id ORDER BY start_date ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':tour_id' => $tour_id]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Tạo lịch trình mới
    public function create()
    {
        global $pdo;
        try {
            $sql = "INSERT INTO tour_schedules (tour_id, start_date, end_date, available_seats, status) 
                    VALUES (:tour_id, :start_date, :end_date, :available_seats, :status)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':tour_id' => $this->tour_id,
                ':start_date' => $this->start_date,
                ':end_date' => $this->end_date,
                ':available_seats' => $this->available_seats,
                ':status' => $this->status ?? 'san_sang'
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Cập nhật lịch trình
    public function update()
    {
        global $pdo;
        try {
            $sql = "UPDATE tour_schedules SET start_date = :start_date, end_date = :end_date, 
                    available_seats = :available_seats, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id' => $this->id,
                ':start_date' => $this->start_date,
                ':end_date' => $this->end_date,
                ':available_seats' => $this->available_seats,
                ':status' => $this->status
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Xóa lịch trình
    public static function delete($id)
    {
        global $pdo;
        try {
            $sql = "DELETE FROM tour_schedules WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Lấy tour thông tin
    public function getTour()
    {
        if (!isset($this->tour)) {
            require_once __DIR__ . '/Tour.php';
            $this->tour = Tour::getById($this->tour_id);
        }
        return $this->tour;
    }
}
