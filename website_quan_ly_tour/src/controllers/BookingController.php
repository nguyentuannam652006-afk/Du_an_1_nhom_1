<?php

class BookingController
{
    // Form đặt tour
    public function create(): void
    {
        requireLogin();

        $schedule_id = $_GET['schedule_id'] ?? 0;
        $schedule = TourSchedule::getById($schedule_id);

        if (!$schedule) {
            header('Location: ' . BASE_URL . '?act=tours');
            exit;
        }

        $tour = Tour::getById($schedule->tour_id);

        view('bookings.create', [
            'title' => 'Đặt Tour - ' . $tour->name,
            'tour' => $tour,
            'schedule' => $schedule,
        ]);
    }

    // Lưu đặt tour
    public function store(): void
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=tours');
            exit;
        }

        $user = getCurrentUser();
        $schedule_id = $_POST['schedule_id'] ?? 0;
        $num_participants = $_POST['num_participants'] ?? 0;
        $notes = $_POST['notes'] ?? '';

        $schedule = TourSchedule::getById($schedule_id);
        $tour = Tour::getById($schedule->tour_id);

        $errors = [];

        if ($num_participants <= 0) $errors[] = 'Số lượng khách phải > 0';
        if ($num_participants > $schedule->available_seats) $errors[] = 'Không đủ chỗ trống';

        if (!empty($errors)) {
            view('bookings.create', [
                'title' => 'Đặt Tour - ' . $tour->name,
                'errors' => $errors,
                'tour' => $tour,
                'schedule' => $schedule,
                'form' => ['num_participants' => $num_participants, 'notes' => $notes],
            ]);
            return;
        }

        $total_price = $tour->price * $num_participants;

        $booking = new Booking([
            'user_id' => $user->id,
            'tour_schedule_id' => $schedule_id,
            'num_participants' => $num_participants,
            'total_price' => $total_price,
            'notes' => $notes,
            'status' => 'cho_xac_nhan'
        ]);

        if ($booking->create()) {
            // Cập nhật số chỗ trống
            $schedule->available_seats -= $num_participants;
            $schedule->update();

            header('Location: ' . BASE_URL . '?act=my-bookings');
        } else {
            $errors[] = 'Lỗi khi tạo đặt tour';
            view('bookings.create', [
                'title' => 'Đặt Tour - ' . $tour->name,
                'errors' => $errors,
                'tour' => $tour,
                'schedule' => $schedule,
                'form' => ['num_participants' => $num_participants, 'notes' => $notes],
            ]);
        }
        exit;
    }

    // Danh sách đặt tour của user
    public function myBookings(): void
    {
        requireLogin();

        $user = getCurrentUser();
        $bookings = Booking::getByUserId($user->id);

        view('bookings.my-bookings', [
            'title' => 'Đặt tour của tôi',
            'bookings' => $bookings,
        ]);
    }
}
