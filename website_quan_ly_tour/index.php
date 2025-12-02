<?php

// Nạp cấu hình chung của ứng dụng
$config = require __DIR__ . '/config/config.php';

// Nạp các file chứa hàm trợ giúp
require_once __DIR__ . '/src/helpers/helpers.php'; // Helper chứa các hàm trợ giúp (hàm xử lý view, block, asset, session, ...)
require_once __DIR__ . '/src/helpers/database.php'; // Helper kết nối database(kết nối với cơ sở dữ liệu)

// Nạp các file chứa model
require_once __DIR__ . '/src/models/User.php';
require_once __DIR__ . '/src/models/Tour.php';
require_once __DIR__ . '/src/models/TourSchedule.php';
require_once __DIR__ . '/src/models/Booking.php';
require_once __DIR__ . '/src/models/TourGuide.php';
require_once __DIR__ . '/src/models/TourDetail.php';

// Nạp các file chứa controller
require_once __DIR__ . '/src/controllers/HomeController.php';
require_once __DIR__ . '/src/controllers/AuthController.php';
require_once __DIR__ . '/src/controllers/TourController.php';
require_once __DIR__ . '/src/controllers/BookingController.php';
require_once __DIR__ . '/src/controllers/AdminController.php';

// Khởi tạo các controller
$homeController = new HomeController();
$authController = new AuthController();
$tourController = new TourController();
$bookingController = new BookingController();
$adminController = new AdminController();

// Xác định route dựa trên tham số act (mặc định là trang chủ '/')
$act = $_GET['act'] ?? '/';

// Match đảm bảo chỉ một action tương ứng được gọi
match ($act) {
    // Trang welcome (cho người chưa đăng nhập) - mặc định khi truy cập '/'
    '/', 'welcome' => $homeController->welcome(),

    // Trang home (cho người đã đăng nhập)
    'home' => $homeController->home(),

    // Đường dẫn đăng nhập, đăng xuất
    'login' => $authController->login(),
    'check-login' => $authController->checkLogin(),
    'logout' => $authController->logout(),

    // Quản lý tour - Admin
    'admin-tours' => $adminController->listTours(),
    'admin-tour-create' => $adminController->createTour(),
    'admin-tour-store' => $adminController->storeTour(),
    'admin-tour-edit' => $adminController->editTour(),
    'admin-tour-update' => $adminController->updateTour(),
    'admin-tour-delete' => $adminController->deleteTour(),

    // Quản lý lịch trình - Admin
    'admin-schedules' => $adminController->listSchedules(),
    'admin-schedule-create' => $adminController->createSchedule(),
    'admin-schedule-store' => $adminController->storeSchedule(),
    'admin-schedule-edit' => $adminController->editSchedule(),
    'admin-schedule-update' => $adminController->updateSchedule(),
    'admin-schedule-delete' => $adminController->deleteSchedule(),

    // Quản lý đặt tour - Admin
    'admin-bookings' => $adminController->listBookings(),
    'admin-booking-detail' => $adminController->bookingDetail(),
    'admin-booking-confirm' => $adminController->confirmBooking(),
    'admin-booking-cancel' => $adminController->cancelBooking(),

    // Quản lý hướng dẫn viên - Admin
    'admin-guides' => $adminController->listGuides(),
    'admin-guide-create' => $adminController->createGuide(),
    'admin-guide-store' => $adminController->storeGuide(),
    'admin-guide-edit' => $adminController->editGuide(),
    'admin-guide-update' => $adminController->updateGuide(),
    'admin-guide-delete' => $adminController->deleteGuide(),

    // Đặt tour - Customer
    'tours' => $tourController->listTours(),
    'tour-detail' => $tourController->detail(),
    'booking' => $bookingController->create(),
    'booking-store' => $bookingController->store(),
    'my-bookings' => $bookingController->myBookings(),

    // Đường dẫn không tồn tại
    default => $homeController->notFound(),
};
