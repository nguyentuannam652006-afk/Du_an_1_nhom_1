<?php

// Model TourGuide - Hướng dẫn viên
class TourGuide
{
    public $id;
    public $user_id;
    public $specialization;
    public $experience_years;
    public $available_from;
    public $available_to;
    public $status; // san_sang, dang_hoat_dong, nghi_phep
    public $created_at;
    public $updated_at;
    public $user; // Dữ liệu user liên quan

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Lấy tất cả hướng dẫn viên
    public static function getAll()
    {
        global $pdo;
        try {
            $sql = "SELECT tg.*, u.name, u.email, u.phone FROM tour_guides tg 
                    JOIN users u ON tg.user_id = u.id 
                    ORDER BY tg.created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy hướng dẫn viên theo ID
    public static function getById($id)
    {
        global $pdo;
        try {
            $sql = "SELECT tg.*, u.name, u.email, u.phone FROM tour_guides tg 
                    JOIN users u ON tg.user_id = u.id 
                    WHERE tg.id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_CLASS, __CLASS__) ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Lấy hướng dẫn viên theo user ID
    public static function getByUserId($user_id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM tour_guides WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            return $stmt->fetch(PDO::FETCH_CLASS, __CLASS__) ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Tạo hướng dẫn viên mới
    public function create()
    {
        global $pdo;
        try {
            $sql = "INSERT INTO tour_guides (user_id, specialization, experience_years, available_from, available_to, status) 
                    VALUES (:user_id, :specialization, :experience_years, :available_from, :available_to, :status)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':user_id' => $this->user_id,
                ':specialization' => $this->specialization ?? '',
                ':experience_years' => $this->experience_years ?? 0,
                ':available_from' => $this->available_from ?? date('Y-m-d'),
                ':available_to' => $this->available_to ?? date('Y-m-d', strtotime('+1 year')),
                ':status' => $this->status ?? 'san_sang'
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Cập nhật hướng dẫn viên
    public function update()
    {
        global $pdo;
        try {
            $sql = "UPDATE tour_guides SET specialization = :specialization, experience_years = :experience_years, 
                    available_from = :available_from, available_to = :available_to, status = :status 
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id' => $this->id,
                ':specialization' => $this->specialization,
                ':experience_years' => $this->experience_years,
                ':available_from' => $this->available_from,
                ':available_to' => $this->available_to,
                ':status' => $this->status
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Xóa hướng dẫn viên
    public static function delete($id)
    {
        global $pdo;
        try {
            $sql = "DELETE FROM tour_guides WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Lấy hướng dẫn viên có sẵn trong khoảng ngày
    public static function getAvailable($from_date, $to_date)
    {
        global $pdo;
        try {
            $sql = "SELECT tg.*, u.name, u.email, u.phone FROM tour_guides tg 
                    JOIN users u ON tg.user_id = u.id 
                    WHERE tg.status = 'san_sang' 
                    AND tg.available_from <= :from_date 
                    AND tg.available_to >= :to_date
                    ORDER BY tg.specialization ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':from_date' => $from_date, ':to_date' => $to_date]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy hướng dẫn viên theo chuyên môn
    public static function getBySpecialization($specialization)
    {
        global $pdo;
        try {
            $sql = "SELECT tg.*, u.name, u.email, u.phone FROM tour_guides tg 
                    JOIN users u ON tg.user_id = u.id 
                    WHERE tg.specialization = :specialization AND tg.status = 'san_sang'
                    ORDER BY tg.created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':specialization' => $specialization]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy danh sách tour được phân công
    public function getAssignedTours()
    {
        global $pdo;
        try {
            $sql = "SELECT ts.*, t.name as tour_name FROM tour_guide_assignments tga
                    JOIN tour_schedules ts ON tga.tour_schedule_id = ts.id
                    JOIN tours t ON ts.tour_id = t.id
                    WHERE tga.guide_id = :guide_id
                    ORDER BY ts.start_date DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':guide_id' => $this->id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}
