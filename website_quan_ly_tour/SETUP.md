# 🌍 Website Quản Lý Tour Du Lịch

Một hệ thống quản lý tour du lịch hoàn chỉnh được xây dựng bằng PHP với kiến trúc MVC cơ bản.

## ✨ Tính Năng Chính

### 👨‍💼 Quản Trị Viên (Admin)
- ✅ **Quản lý Tour**
  - Xem danh sách tất cả tour
  - Tạo tour mới
  - Chỉnh sửa thông tin tour
  - Xóa tour
  - Quản lý chi tiết lịch trình từng ngày

- 📅 **Quản lý Lịch Trình**
  - Tạo lịch khởi hành cho tour
  - Cập nhật số chỗ trống
  - Thay đổi trạng thái lịch trình
  - Xóa lịch trình

- 💰 **Quản lý Đặt Tour**
  - Xem tất cả các đơn đặt tour
  - Xem chi tiết từng đơn đặt
  - Xác nhận đơn đặt
  - Hủy đơn đặt
  - Theo dõi trạng thái thanh toán

- 👨‍💼 **Quản lý Hướng Dẫn Viên**
  - Tạo hướng dẫn viên mới
  - Quản lý thông tin HDV
  - Xem lịch làm việc
  - Xem tour được phân công

### 🎫 Khách Hàng (Customer)
- 🔍 Xem danh sách tour du lịch
- 🔎 Tìm kiếm tour theo tên, điểm đến
- 👁️ Xem chi tiết tour
- 📅 Xem lịch khởi hành các tour
- 🎫 Đặt tour
- 📋 Xem danh sách các tour đã đặt
- 💬 Thêm ghi chú khi đặt tour

## 📁 Cấu Trúc Thư Mục

```
website_quan_ly_tour/
├── config/
│   └── config.php              # Cấu hình chung
├── src/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── AuthController.php
│   │   ├── TourController.php
│   │   ├── BookingController.php
│   │   └── AdminController.php
│   ├── models/
│   │   ├── User.php
│   │   ├── Tour.php
│   │   ├── TourSchedule.php
│   │   ├── Booking.php
│   │   ├── TourGuide.php
│   │   └── TourDetail.php
│   └── helpers/
│       ├── helpers.php         # Hàm tiện ích
│       └── database.php        # Kết nối database
├── views/
│   ├── layouts/
│   │   ├── AuthLayout.php
│   │   ├── AdminLayout.php
│   │   └── blocks/
│   │       ├── header.php
│   │       ├── footer.php
│   │       ├── aside.php
│   │       ├── admin-header.php
│   │       ├── admin-sidebar.php
│   │       └── admin-footer.php
│   ├── admin/
│   │   ├── tours/
│   │   ├── schedules/
│   │   ├── bookings/
│   │   └── guides/
│   ├── tours/
│   ├── bookings/
│   ├── auth/
│   ├── home.php
│   ├── welcome.php
│   └── not_found.php
├── public/
│   ├── css/
│   │   ├── auth.css
│   │   └── admin.css
│   ├── js/
│   │   └── login.js
│   └── images/
├── index.php                   # Entry point
├── database.sql               # File SQL khởi tạo database
├── README.md
└── .htaccess                  # URL rewriting
```

## 🚀 Cài Đặt & Chạy

### Yêu Cầu
- PHP 7.4+
- MySQL 5.7+
- Apache với mod_rewrite

### Bước 1: Clone/Copy Project
```bash
# Copy folder vào htdocs (Xampp) hoặc www (Laragon)
cd /path/to/laragon/www/Du_an_1_nhom_1/
```

### Bước 2: Tạo Database
1. Mở phpMyAdmin
2. Tạo database mới: `website_ql_tour`
3. Import file `database.sql` vào database này

Hoặc chạy lệnh SQL:
```bash
mysql -u root -p website_ql_tour < database.sql
```

### Bước 3: Cấu Hình
Sửa file `config/config.php` nếu cần:
- `host`: localhost (mặc định)
- `name`: website_ql_tour
- `user`: root
- `pass`: (trống nếu không có password)
- `BASE_URL`: Đường dẫn cơ sở của project

### Bước 4: Truy Cập
```
http://localhost/DU_AN_1_NHOM_1/website_quan_ly_tour/
```

## 👤 Tài Khoản Demo

### Admin
- **Email:** admin@tour.com
- **Password:** (password mặc định - xem database.sql)

### Hướng Dẫn Viên
- **Email:** huong.dv@tour.com
- **Email:** duc.dv@tour.com

### Khách Hàng
- **Email:** an.le@gmail.com
- **Email:** binh.pham@gmail.com

## 🔐 Tính Năng Bảo Mật

- ✅ Hash password với bcrypt
- ✅ Session-based authentication
- ✅ Prepared statements (PDO)
- ✅ Input validation
- ✅ Role-based access control (RBAC)
- ✅ CSRF protection (có thể thêm)

## 📊 Các Model & Database

### Users
- id, name, email, password, phone, address, role, status, created_at

### Tours
- id, name, description, destination, duration, price, max_participants, status

### TourSchedules
- id, tour_id, start_date, end_date, available_seats, status

### Bookings
- id, user_id, tour_schedule_id, num_participants, total_price, notes, status

### TourGuides
- id, user_id, specialization, experience_years, available_from, available_to, status

### TourDetails
- id, tour_id, day_number, activity, location, description

## 🛣️ Routing

### Public Routes
- `/` - Welcome page
- `?act=login` - Login page
- `?act=tours` - List tours
- `?act=tour-detail&id=X` - Tour detail

### Authenticated Routes
- `?act=home` - Home page
- `?act=my-bookings` - My bookings
- `?act=booking&schedule_id=X` - Booking form

### Admin Routes
- `?act=admin-tours` - Manage tours
- `?act=admin-schedules` - Manage schedules
- `?act=admin-bookings` - Manage bookings
- `?act=admin-guides` - Manage guides

## 🛠️ Công Nghệ Sử Dụng

- **Backend:** PHP 7.4+
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, Bootstrap 5
- **Frontend Extra:** Emoji icons
- **Architecture:** MVC Pattern

## 📝 Ghi Chú

- Output buffering được sử dụng để capture nội dung view
- Prepared statements bảo vệ chống SQL injection
- Session được sử dụng để quản lý user authentication
- Một model có thể có nhiều phương thức tĩnh để truy vấn dữ liệu

## 🎯 Các Bước Tiếp Theo (Future Features)

- [ ] Email notifications
- [ ] Payment gateway integration
- [ ] Review & Rating system
- [ ] Image upload for tours
- [ ] Advanced reporting
- [ ] API endpoints
- [ ] Real-time notifications
- [ ] Mobile app

## 📞 Support

Nếu gặp vấn đề, kiểm tra:
1. Database connection settings
2. File permissions (views folder)
3. Apache mod_rewrite enabled
4. PHP extensions installed

---

**Phiên bản:** 1.0  
**Ngày cập nhật:** Tháng 12, 2025  
**Tác giả:** Du_an_1_nhom_1
