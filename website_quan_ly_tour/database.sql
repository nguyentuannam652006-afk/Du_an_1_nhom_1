-- Database: website_ql_tour
-- Tạo cơ sở dữ liệu
CREATE DATABASE IF NOT EXISTS website_ql_tour1;
USE website_ql_tour1;

-- ===================================
-- 1. BẢNG USERS (Người dùng: Admin, Hướng dẫn viên, Khách hàng)
-- ===================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('admin', 'huong_dan_vien', 'khach_hang') DEFAULT 'khach_hang',
    status TINYINT DEFAULT 1, -- 1: hoạt động, 0: khóa
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- 2. BẢNG TOURS (Tour du lịch)
-- ===================================
CREATE TABLE IF NOT EXISTS tours (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    description LONGTEXT,
    destination VARCHAR(100) NOT NULL,
    duration INT NOT NULL, -- số ngày
    price DECIMAL(10, 2) NOT NULL,
    max_participants INT NOT NULL DEFAULT 30,
    status ENUM('dang_hoat_dong', 'tam_dung', 'da_huy') DEFAULT 'dang_hoat_dong',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_destination (destination),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- 3. BẢNG TOUR_SCHEDULES (Lịch trình tour)
-- ===================================
CREATE TABLE IF NOT EXISTS tour_schedules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tour_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    available_seats INT NOT NULL,
    status ENUM('san_sang', 'dang_hoat_dong', 'hoan_thanh', 'da_huy') DEFAULT 'san_sang',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
    INDEX idx_tour_id (tour_id),
    INDEX idx_start_date (start_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- 4. BẢNG TOUR_GUIDES (Hướng dẫn viên)
-- ===================================
CREATE TABLE IF NOT EXISTS tour_guides (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    specialization VARCHAR(100), -- chuyên môn (ví dụ: miền Bắc, miền Nam)
    experience_years INT DEFAULT 0,
    available_from DATE,
    available_to DATE,
    status ENUM('san_sang', 'dang_hoat_dong', 'nghi_phep') DEFAULT 'san_sang',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_guide (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- 5. BẢNG TOUR_GUIDE_ASSIGNMENTS (Phân công hướng dẫn viên cho tour)
-- ===================================
CREATE TABLE IF NOT EXISTS tour_guide_assignments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tour_schedule_id INT NOT NULL,
    guide_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_schedule_id) REFERENCES tour_schedules(id) ON DELETE CASCADE,
    FOREIGN KEY (guide_id) REFERENCES tour_guides(id) ON DELETE CASCADE,
    UNIQUE KEY unique_assignment (tour_schedule_id, guide_id),
    INDEX idx_guide_id (guide_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- 6. BẢNG BOOKINGS (Đặt tour)
-- ===================================
CREATE TABLE IF NOT EXISTS bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    tour_schedule_id INT NOT NULL,
    num_participants INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    notes TEXT,
    status ENUM('cho_xac_nhan', 'da_xac_nhan', 'da_huy', 'hoan_thanh') DEFAULT 'cho_xac_nhan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tour_schedule_id) REFERENCES tour_schedules(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_tour_schedule_id (tour_schedule_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- 7. BẢNG TOUR_DETAILS (Chi tiết lịch trình từng ngày của tour)
-- ===================================
CREATE TABLE IF NOT EXISTS tour_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tour_id INT NOT NULL,
    day_number INT NOT NULL,
    activity VARCHAR(255),
    location VARCHAR(100),
    description LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE CASCADE,
    INDEX idx_tour_id (tour_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- DATA MẪU
-- ===================================

-- Thêm user admin
INSERT INTO users (name, email, password, phone, address, role, status) VALUES
('Admin System', 'admin@tour.com', '$2y$10$U1Z8X7Y9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8', '0123456789', 'Hà Nội', 'admin', 1);

-- Thêm hướng dẫn viên
INSERT INTO users (name, email, password, phone, address, role, status) VALUES
('Nguyễn Thị Hương', 'huong.dv@tour.com', '$2y$10$U1Z8X7Y9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8', '0987654321', 'Hà Nội', 'huong_dan_vien', 1),
('Trần Minh Đức', 'duc.dv@tour.com', '$2y$10$U1Z8X7Y9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8', '0987654322', 'TP. Hồ Chí Minh', 'huong_dan_vien', 1);

-- Thêm khách hàng
INSERT INTO users (name, email, password, phone, address, role, status) VALUES
('Lê Văn An', 'an.le@gmail.com', '$2y$10$U1Z8X7Y9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8', '0912345678', 'Hà Nội', 'khach_hang', 1),
('Phạm Thị Bình', 'binh.pham@gmail.com', '$2y$10$U1Z8X7Y9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8X9W2Q3E4R5T6Y7Z8', '0912345679', 'Đà Nẵng', 'khach_hang', 1);

-- Thêm hướng dẫn viên info
INSERT INTO tour_guides (user_id, specialization, experience_years, available_from, available_to, status) VALUES
(2, 'Miền Bắc', 5, '2025-01-01', '2025-12-31', 'san_sang'),
(3, 'Miền Nam', 3, '2025-01-01', '2025-12-31', 'san_sang');

-- Thêm tour
INSERT INTO tours (name, description, destination, duration, price, max_participants, status) VALUES
('Tour Hà Nội - Sapa 3 ngày 2 đêm', 
 'Khám phá vẻ đẹp của Sapa với cảnh sắc thiên nhiên tuyệt vời, những cánh đồng lúa bậc thang, và cuộc sống của các dân tộc thiểu số. Ăn cơm lẩu ở Sapa, tham quan thị trấn Sapa, đi bộ theo các con đường mòn đẹp nhất.', 
 'Sapa', 3, 5000000, 25, 'dang_hoat_dong'),

('Tour Hạ Long Bay 2 ngày 1 đêm',
 'Thưởng thức vẻ đẹp kỳ vĩ của Vịnh Hạ Long - Di sản Thế giới. Tham quan các động nổi tiếng, bơi lội và thư giãn trên du thuyền 5 sao.',
 'Quảng Ninh', 2, 3500000, 30, 'dang_hoat_dong'),

('Tour Phú Quốc 4 ngày 3 đêm',
 'Khám phá hòn đảo thiên đường với biển xanh, cát trắng, những resort sang trọng và đặc sản nổi tiếng của Phú Quốc.',
 'Kiên Giang', 4, 7000000, 20, 'dang_hoat_dong');

-- Thêm lịch trình tour
INSERT INTO tour_schedules (tour_id, start_date, end_date, available_seats, status) VALUES
(1, '2025-12-20', '2025-12-22', 25, 'san_sang'),
(1, '2025-12-27', '2025-12-29', 25, 'san_sang'),
(2, '2025-12-15', '2025-12-16', 30, 'san_sang'),
(2, '2025-12-22', '2025-12-23', 30, 'san_sang'),
(3, '2025-12-18', '2025-12-21', 20, 'san_sang');

-- Thêm chi tiết tour Sapa
INSERT INTO tour_details (tour_id, day_number, activity, location, description) VALUES
(1, 1, 'Khởi hành từ Hà Nội', 'Hà Nội', 'Đón khách từ trung tâm Hà Nội, lên xe khởi hành về Sapa'),
(1, 1, 'Thị trấn Sapa', 'Sapa', 'Tham quan thị trấn Sapa về đêm, mua sắm ở chợ Sapa'),
(1, 2, 'Đi bộ xuyên Sapa', 'Sapa', 'Đi bộ qua các con đường mòn đẹp, ngắm cảnh đồng lúa bậc thang'),
(1, 2, 'Ăn cơm lẩu', 'Sapa', 'Ăn cơm lẩu nổi tiếng tại nhà hàng địa phương'),
(1, 3, 'Tây Bắc Sapa', 'Sapa', 'Thăm làng dân tộc Mường Hoa, gặp gỡ các dân tộc thiểu số'),
(1, 3, 'Quay về Hà Nội', 'Hà Nội', 'Trở về Hà Nội, kết thúc tour');

-- Thêm chi tiết tour Hạ Long
INSERT INTO tour_details (tour_id, day_number, activity, location, description) VALUES
(2, 1, 'Khởi hành từ Hà Nội', 'Hà Nội', 'Đón khách, lên xe khởi hành về Hạ Long'),
(2, 1, 'Tham quan động', 'Hạ Long', 'Lên du thuyền, tham quan các động nổi tiếng như Hang Đầu Gỗ'),
(2, 1, 'Ăn tối trên du thuyền', 'Hạ Long', 'Thưởng thức hải sản tươi sống trên du thuyền'),
(2, 2, 'Bơi lội', 'Hạ Long', 'Bơi lội và thư giãn tại các bãi biển đẹp của Vịnh Hạ Long'),
(2, 2, 'Quay về Hà Nội', 'Hà Nội', 'Trở về Hà Nội, kết thúc tour');

-- Phân công hướng dẫn viên
INSERT INTO tour_guide_assignments (tour_schedule_id, guide_id) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 2);
