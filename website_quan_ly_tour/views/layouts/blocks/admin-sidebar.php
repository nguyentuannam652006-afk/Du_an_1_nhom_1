<?php
// Sidebar/Aside cho Admin
$user = getCurrentUser();
$role = $user->role;
?>
<aside class="admin-sidebar">
    <nav class="admin-nav">
        <ul>
            <?php if ($user->isAdmin()): ?>
                <li><a href="<?php echo BASE_URL; ?>?act=home">🏠 Trang chủ</a></li>
                
                <li class="nav-section">
                    <strong>☀️ Quản Lý Tour</strong>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>?act=admin-tours">📋 Danh sách Tour</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?act=admin-tour-create">➕ Tạo Tour</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?act=admin-schedules">📅 Lịch Trình</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?act=admin-schedule-create">➕ Tạo Lịch Trình</a></li>
                    </ul>
                </li>

                <li class="nav-section">
                    <strong>💰 Quản Lý Đặt Tour</strong>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>?act=admin-bookings">📋 Danh sách Đặt tour</a></li>
                    </ul>
                </li>

                <li class="nav-section">
                    <strong>👨‍💼 Quản Lý HDV</strong>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>?act=admin-guides">📋 Danh sách HDV</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?act=admin-guide-create">➕ Tạo HDV</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</aside>
