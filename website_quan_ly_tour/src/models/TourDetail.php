<?php

// Model TourDetail - Chi tiết lịch trình của tour
class TourDetail
{
    public $id;
    public $tour_id;
    public $day_number;
    public $activity;
    public $location;
    public $description;
    public $created_at;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Lấy chi tiết tour theo tour ID
    public static function getByTourId($tour_id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM tour_details WHERE tour_id = :tour_id ORDER BY day_number ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':tour_id' => $tour_id]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Tạo chi tiết tour mới
    public function create()
    {
        global $pdo;
        try {
            $sql = "INSERT INTO tour_details (tour_id, day_number, activity, location, description) 
                    VALUES (:tour_id, :day_number, :activity, :location, :description)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':tour_id' => $this->tour_id,
                ':day_number' => $this->day_number,
                ':activity' => $this->activity,
                ':location' => $this->location,
                ':description' => $this->description
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Cập nhật chi tiết tour
    public function update()
    {
        global $pdo;
        try {
            $sql = "UPDATE tour_details SET day_number = :day_number, activity = :activity, 
                    location = :location, description = :description WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id' => $this->id,
                ':day_number' => $this->day_number,
                ':activity' => $this->activity,
                ':location' => $this->location,
                ':description' => $this->description
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Xóa chi tiết tour
    public static function delete($id)
    {
        global $pdo;
        try {
            $sql = "DELETE FROM tour_details WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Xóa tất cả chi tiết tour theo tour ID
    public static function deleteByTourId($tour_id)
    {
        global $pdo;
        try {
            $sql = "DELETE FROM tour_details WHERE tour_id = :tour_id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':tour_id' => $tour_id]);
        } catch (Exception $e) {
            return false;
        }
    }
}
