<?php

// Model Booking - Đặt tour
class Booking
{
    public $id;
    public $user_id;
    public $tour_schedule_id;
    public $num_participants;
    public $total_price;
    public $notes;
    public $status; // cho_xac_nhan, da_xac_nhan, da_huy, hoan_thanh
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

    // Lấy tất cả booking
    public static function getAll()
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM bookings ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Lấy booking theo ID
    public static function getById($id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM bookings WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_CLASS, __CLASS__) ?: null;
        } catch (Exception $e) {
            return null;
        }
    }

    // Lấy booking theo user ID
    public static function getByUserId($user_id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM bookings WHERE user_id = :user_id ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Tạo booking mới
    public function create()
    {
        global $pdo;
        try {
            $sql = "INSERT INTO bookings (user_id, tour_schedule_id, num_participants, total_price, notes, status) 
                    VALUES (:user_id, :tour_schedule_id, :num_participants, :total_price, :notes, :status)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':user_id' => $this->user_id,
                ':tour_schedule_id' => $this->tour_schedule_id,
                ':num_participants' => $this->num_participants,
                ':total_price' => $this->total_price,
                ':notes' => $this->notes ?? '',
                ':status' => $this->status ?? 'cho_xac_nhan'
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Cập nhật booking
    public function update()
    {
        global $pdo;
        try {
            $sql = "UPDATE bookings SET num_participants = :num_participants, total_price = :total_price, 
                    notes = :notes, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id' => $this->id,
                ':num_participants' => $this->num_participants,
                ':total_price' => $this->total_price,
                ':notes' => $this->notes,
                ':status' => $this->status
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Hủy booking
    public function cancel()
    {
        $this->status = 'da_huy';
        return $this->update();
    }

    // Xác nhận booking
    public function confirm()
    {
        $this->status = 'da_xac_nhan';
        return $this->update();
    }

    // Xóa booking
    public static function delete($id)
    {
        global $pdo;
        try {
            $sql = "DELETE FROM bookings WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Lấy tất cả booking cho một lịch trình
    public static function getByScheduleId($schedule_id)
    {
        global $pdo;
        try {
            $sql = "SELECT * FROM bookings WHERE tour_schedule_id = :schedule_id AND status != 'da_huy' ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':schedule_id' => $schedule_id]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            return [];
        }
    }

    // Tính tổng số người tham gia cho một lịch trình
    public static function countParticipants($schedule_id)
    {
        global $pdo;
        try {
            $sql = "SELECT SUM(num_participants) as total FROM bookings 
                    WHERE tour_schedule_id = :schedule_id AND status != 'da_huy'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':schedule_id' => $schedule_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}
