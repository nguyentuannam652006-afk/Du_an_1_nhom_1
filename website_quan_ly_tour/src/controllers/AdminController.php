<?php

class AdminController
{
    // === TOUR MANAGEMENT ===

    // Danh sách tour
    public function listTours(): void
    {
        requireAdmin();

        $tours = Tour::getAll();

        view('admin.tours.index', [
            'title' => 'Quản lý Tour - Admin',
            'tours' => $tours,
        ]);
    }

    // Form tạo tour mới
    public function createTour(): void
    {
        requireAdmin();

        view('admin.tours.create', [
            'title' => 'Tạo Tour Mới - Admin',
        ]);
    }

    // Lưu tour mới
    public function storeTour(): void
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin-tours');
            exit;
        }

        $errors = [];
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $destination = $_POST['destination'] ?? '';
        $duration = $_POST['duration'] ?? 0;
        $price = $_POST['price'] ?? 0;
        $max_participants = $_POST['max_participants'] ?? 30;

        // Validation
        if (empty($name)) $errors[] = 'Tên tour không được để trống';
        if (empty($destination)) $errors[] = 'Điểm đến không được để trống';
        if ($duration <= 0) $errors[] = 'Thời gian tour phải > 0';
        if ($price <= 0) $errors[] = 'Giá tour phải > 0';

        if (!empty($errors)) {
            view('admin.tours.create', [
                'title' => 'Tạo Tour Mới - Admin',
                'errors' => $errors,
                'form' => ['name' => $name, 'description' => $description, 'destination' => $destination, 'duration' => $duration, 'price' => $price, 'max_participants' => $max_participants],
            ]);
            return;
        }

        $tour = new Tour([
            'name' => $name,
            'description' => $description,
            'destination' => $destination,
            'duration' => $duration,
            'price' => $price,
            'max_participants' => $max_participants,
            'status' => 'dang_hoat_dong'
        ]);

        if ($tour->create()) {
            // Lấy ID tour vừa tạo để thêm chi tiết
            $tours = Tour::getAll();
            $lastTour = $tours[0] ?? null;

            header('Location: ' . BASE_URL . '?act=admin-tours');
        } else {
            $errors[] = 'Lỗi khi tạo tour';
            view('admin.tours.create', [
                'title' => 'Tạo Tour Mới - Admin',
                'errors' => $errors,
                'form' => ['name' => $name, 'description' => $description, 'destination' => $destination, 'duration' => $duration, 'price' => $price, 'max_participants' => $max_participants],
            ]);
        }
        exit;
    }

    // Form chỉnh sửa tour
    public function editTour(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;
        $tour = Tour::getById($id);

        if (!$tour) {
            header('Location: ' . BASE_URL . '?act=admin-tours');
            exit;
        }

        $details = TourDetail::getByTourId($id);

        view('admin.tours.edit', [
            'title' => 'Chỉnh sửa Tour - Admin',
            'tour' => $tour,
            'details' => $details,
        ]);
    }

    // Lưu chỉnh sửa tour
    public function updateTour(): void
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin-tours');
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $tour = Tour::getById($id);

        if (!$tour) {
            header('Location: ' . BASE_URL . '?act=admin-tours');
            exit;
        }

        $errors = [];
        $tour->name = $_POST['name'] ?? '';
        $tour->description = $_POST['description'] ?? '';
        $tour->destination = $_POST['destination'] ?? '';
        $tour->duration = $_POST['duration'] ?? 0;
        $tour->price = $_POST['price'] ?? 0;
        $tour->max_participants = $_POST['max_participants'] ?? 30;
        $tour->status = $_POST['status'] ?? 'dang_hoat_dong';

        // Validation
        if (empty($tour->name)) $errors[] = 'Tên tour không được để trống';
        if (empty($tour->destination)) $errors[] = 'Điểm đến không được để trống';
        if ($tour->duration <= 0) $errors[] = 'Thời gian tour phải > 0';
        if ($tour->price <= 0) $errors[] = 'Giá tour phải > 0';

        if (!empty($errors)) {
            view('admin.tours.edit', [
                'title' => 'Chỉnh sửa Tour - Admin',
                'errors' => $errors,
                'tour' => $tour,
            ]);
            return;
        }

        if ($tour->update()) {
            header('Location: ' . BASE_URL . '?act=admin-tours');
        } else {
            $errors[] = 'Lỗi khi cập nhật tour';
            view('admin.tours.edit', [
                'title' => 'Chỉnh sửa Tour - Admin',
                'errors' => $errors,
                'tour' => $tour,
            ]);
        }
        exit;
    }

    // Xóa tour
    public function deleteTour(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;

        if (Tour::delete($id)) {
            header('Location: ' . BASE_URL . '?act=admin-tours');
        } else {
            header('Location: ' . BASE_URL . '?act=admin-tours');
        }
        exit;
    }

    // === SCHEDULE MANAGEMENT ===

    // Danh sách lịch trình
    public function listSchedules(): void
    {
        requireAdmin();

        $schedules = TourSchedule::getAll();

        view('admin.schedules.index', [
            'title' => 'Quản lý Lịch trình - Admin',
            'schedules' => $schedules,
        ]);
    }

    // Form tạo lịch trình
    public function createSchedule(): void
    {
        requireAdmin();

        $tours = Tour::getAll();

        view('admin.schedules.create', [
            'title' => 'Tạo Lịch trình Mới - Admin',
            'tours' => $tours,
        ]);
    }

    // Lưu lịch trình mới
    public function storeSchedule(): void
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin-schedules');
            exit;
        }

        $errors = [];
        $tour_id = $_POST['tour_id'] ?? 0;
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';
        $available_seats = $_POST['available_seats'] ?? 0;

        if ($tour_id <= 0) $errors[] = 'Tour không hợp lệ';
        if (empty($start_date)) $errors[] = 'Ngày bắt đầu không được để trống';
        if (empty($end_date)) $errors[] = 'Ngày kết thúc không được để trống';
        if (strtotime($end_date) <= strtotime($start_date)) $errors[] = 'Ngày kết thúc phải sau ngày bắt đầu';
        if ($available_seats <= 0) $errors[] = 'Số chỗ phải > 0';

        if (!empty($errors)) {
            $tours = Tour::getAll();
            view('admin.schedules.create', [
                'title' => 'Tạo Lịch trình Mới - Admin',
                'errors' => $errors,
                'tours' => $tours,
                'form' => ['tour_id' => $tour_id, 'start_date' => $start_date, 'end_date' => $end_date, 'available_seats' => $available_seats],
            ]);
            return;
        }

        $schedule = new TourSchedule([
            'tour_id' => $tour_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'available_seats' => $available_seats,
            'status' => 'san_sang'
        ]);

        if ($schedule->create()) {
            header('Location: ' . BASE_URL . '?act=admin-schedules');
        } else {
            $errors[] = 'Lỗi khi tạo lịch trình';
            $tours = Tour::getAll();
            view('admin.schedules.create', [
                'title' => 'Tạo Lịch trình Mới - Admin',
                'errors' => $errors,
                'tours' => $tours,
            ]);
        }
        exit;
    }

    // Form chỉnh sửa lịch trình
    public function editSchedule(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;
        $schedule = TourSchedule::getById($id);

        if (!$schedule) {
            header('Location: ' . BASE_URL . '?act=admin-schedules');
            exit;
        }

        $tours = Tour::getAll();

        view('admin.schedules.edit', [
            'title' => 'Chỉnh sửa Lịch trình - Admin',
            'schedule' => $schedule,
            'tours' => $tours,
        ]);
    }

    // Lưu chỉnh sửa lịch trình
    public function updateSchedule(): void
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin-schedules');
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $schedule = TourSchedule::getById($id);

        if (!$schedule) {
            header('Location: ' . BASE_URL . '?act=admin-schedules');
            exit;
        }

        $errors = [];
        $schedule->start_date = $_POST['start_date'] ?? '';
        $schedule->end_date = $_POST['end_date'] ?? '';
        $schedule->available_seats = $_POST['available_seats'] ?? 0;
        $schedule->status = $_POST['status'] ?? 'san_sang';

        if (empty($schedule->start_date)) $errors[] = 'Ngày bắt đầu không được để trống';
        if (empty($schedule->end_date)) $errors[] = 'Ngày kết thúc không được để trống';
        if (strtotime($schedule->end_date) <= strtotime($schedule->start_date)) $errors[] = 'Ngày kết thúc phải sau ngày bắt đầu';
        if ($schedule->available_seats <= 0) $errors[] = 'Số chỗ phải > 0';

        if (!empty($errors)) {
            $tours = Tour::getAll();
            view('admin.schedules.edit', [
                'title' => 'Chỉnh sửa Lịch trình - Admin',
                'errors' => $errors,
                'schedule' => $schedule,
                'tours' => $tours,
            ]);
            return;
        }

        if ($schedule->update()) {
            header('Location: ' . BASE_URL . '?act=admin-schedules');
        } else {
            $errors[] = 'Lỗi khi cập nhật lịch trình';
            $tours = Tour::getAll();
            view('admin.schedules.edit', [
                'title' => 'Chỉnh sửa Lịch trình - Admin',
                'errors' => $errors,
                'schedule' => $schedule,
                'tours' => $tours,
            ]);
        }
        exit;
    }

    // Xóa lịch trình
    public function deleteSchedule(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;

        if (TourSchedule::delete($id)) {
            header('Location: ' . BASE_URL . '?act=admin-schedules');
        } else {
            header('Location: ' . BASE_URL . '?act=admin-schedules');
        }
        exit;
    }

    // === BOOKING MANAGEMENT ===

    // Danh sách đặt tour
    public function listBookings(): void
    {
        requireAdmin();

        $bookings = Booking::getAll();

        view('admin.bookings.index', [
            'title' => 'Quản lý Đặt tour - Admin',
            'bookings' => $bookings,
        ]);
    }

    // Chi tiết đặt tour
    public function bookingDetail(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;
        $booking = Booking::getById($id);

        if (!$booking) {
            header('Location: ' . BASE_URL . '?act=admin-bookings');
            exit;
        }

        view('admin.bookings.detail', [
            'title' => 'Chi tiết Đặt tour - Admin',
            'booking' => $booking,
        ]);
    }

    // Xác nhận đặt tour
    public function confirmBooking(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;
        $booking = Booking::getById($id);

        if ($booking) {
            $booking->confirm();
        }

        header('Location: ' . BASE_URL . '?act=admin-bookings');
        exit;
    }

    // Hủy đặt tour
    public function cancelBooking(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;
        $booking = Booking::getById($id);

        if ($booking) {
            $booking->cancel();
        }

        header('Location: ' . BASE_URL . '?act=admin-bookings');
        exit;
    }

    // === GUIDE MANAGEMENT ===

    // Danh sách hướng dẫn viên
    public function listGuides(): void
    {
        requireAdmin();

        $guides = TourGuide::getAll();

        view('admin.guides.index', [
            'title' => 'Quản lý Hướng dẫn viên - Admin',
            'guides' => $guides,
        ]);
    }

    // Form tạo hướng dẫn viên
    public function createGuide(): void
    {
        requireAdmin();

        $users = User::getByRole('huong_dan_vien');

        view('admin.guides.create', [
            'title' => 'Tạo Hướng dẫn viên - Admin',
            'users' => $users,
        ]);
    }

    // Lưu hướng dẫn viên mới
    public function storeGuide(): void
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin-guides');
            exit;
        }

        $errors = [];
        $user_id = $_POST['user_id'] ?? 0;
        $specialization = $_POST['specialization'] ?? '';
        $experience_years = $_POST['experience_years'] ?? 0;

        if ($user_id <= 0) $errors[] = 'Người dùng không hợp lệ';

        if (!empty($errors)) {
            $users = User::getByRole('huong_dan_vien');
            view('admin.guides.create', [
                'title' => 'Tạo Hướng dẫn viên - Admin',
                'errors' => $errors,
                'users' => $users,
            ]);
            return;
        }

        $guide = new TourGuide([
            'user_id' => $user_id,
            'specialization' => $specialization,
            'experience_years' => $experience_years,
            'status' => 'san_sang'
        ]);

        if ($guide->create()) {
            header('Location: ' . BASE_URL . '?act=admin-guides');
        } else {
            $errors[] = 'Lỗi khi tạo hướng dẫn viên';
            $users = User::getByRole('huong_dan_vien');
            view('admin.guides.create', [
                'title' => 'Tạo Hướng dẫn viên - Admin',
                'errors' => $errors,
                'users' => $users,
            ]);
        }
        exit;
    }

    // Form chỉnh sửa hướng dẫn viên
    public function editGuide(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;
        $guide = TourGuide::getById($id);

        if (!$guide) {
            header('Location: ' . BASE_URL . '?act=admin-guides');
            exit;
        }

        view('admin.guides.edit', [
            'title' => 'Chỉnh sửa Hướng dẫn viên - Admin',
            'guide' => $guide,
        ]);
    }

    // Lưu chỉnh sửa hướng dẫn viên
    public function updateGuide(): void
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?act=admin-guides');
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $guide = TourGuide::getById($id);

        if (!$guide) {
            header('Location: ' . BASE_URL . '?act=admin-guides');
            exit;
        }

        $guide->specialization = $_POST['specialization'] ?? '';
        $guide->experience_years = $_POST['experience_years'] ?? 0;
        $guide->status = $_POST['status'] ?? 'san_sang';
        $guide->available_from = $_POST['available_from'] ?? '';
        $guide->available_to = $_POST['available_to'] ?? '';

        if ($guide->update()) {
            header('Location: ' . BASE_URL . '?act=admin-guides');
        } else {
            $errors[] = 'Lỗi khi cập nhật hướng dẫn viên';
            view('admin.guides.edit', [
                'title' => 'Chỉnh sửa Hướng dẫn viên - Admin',
                'errors' => $errors,
                'guide' => $guide,
            ]);
        }
        exit;
    }

    // Xóa hướng dẫn viên
    public function deleteGuide(): void
    {
        requireAdmin();

        $id = $_GET['id'] ?? 0;

        if (TourGuide::delete($id)) {
            header('Location: ' . BASE_URL . '?act=admin-guides');
        } else {
            header('Location: ' . BASE_URL . '?act=admin-guides');
        }
        exit;
    }
}
