<?php
ob_start();
$user = User::getById($booking->user_id);
$schedule = TourSchedule::getById($booking->tour_schedule_id);
$tour = Tour::getById($schedule->tour_id);
?>

<div class="admin-booking-detail">
    <h2>👁️ Chi Tiết Đặt Tour</h2>
    
    <div class="info-box">
        <h3>Thông Tin Đặt Tour</h3>
        <p><strong>Mã Đặt Tour:</strong> #<?php echo htmlspecialchars($booking->id); ?></p>
        <p><strong>Trạng Thái:</strong> <span class="badge bg-<?php echo match($booking->status) { 'cho_xac_nhan' => 'warning', 'da_xac_nhan' => 'success', 'da_huy' => 'danger', 'hoan_thanh' => 'info', default => 'secondary' }; ?>"><?php echo htmlspecialchars($booking->status); ?></span></p>
        <p><strong>Ngày Đặt:</strong> <?php echo htmlspecialchars($booking->created_at); ?></p>
    </div>

    <div class="info-box">
        <h3>Thông Tin Khách Hàng</h3>
        <p><strong>Tên:</strong> <?php echo htmlspecialchars($user->name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
        <p><strong>Điện Thoại:</strong> <?php echo htmlspecialchars($user->phone); ?></p>
        <p><strong>Địa Chỉ:</strong> <?php echo htmlspecialchars($user->address); ?></p>
    </div>

    <div class="info-box">
        <h3>Thông Tin Tour</h3>
        <p><strong>Tên Tour:</strong> <?php echo htmlspecialchars($tour->name); ?></p>
        <p><strong>Điểm Đến:</strong> <?php echo htmlspecialchars($tour->destination); ?></p>
        <p><strong>Giá/Người:</strong> <?php echo number_format($tour->price, 0, ',', '.'); ?> VNĐ</p>
        <p><strong>Ngày Bắt Đầu:</strong> <?php echo htmlspecialchars($schedule->start_date); ?></p>
        <p><strong>Ngày Kết Thúc:</strong> <?php echo htmlspecialchars($schedule->end_date); ?></p>
    </div>

    <div class="info-box">
        <h3>Chi Tiết Đặt Phòng</h3>
        <p><strong>Số Người Tham Gia:</strong> <?php echo htmlspecialchars($booking->num_participants); ?></p>
        <p><strong>Tổng Tiền:</strong> <?php echo number_format($booking->total_price, 0, ',', '.'); ?> VNĐ</p>
        <?php if (!empty($booking->notes)): ?>
            <p><strong>Ghi Chú:</strong> <?php echo htmlspecialchars($booking->notes); ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <a href="<?php echo BASE_URL; ?>?act=admin-bookings" class="btn btn-secondary">👈 Quay Lại</a>
        <?php if ($booking->status === 'cho_xac_nhan'): ?>
            <a href="<?php echo BASE_URL; ?>?act=admin-booking-confirm&id=<?php echo $booking->id; ?>" class="btn btn-success">✅ Xác Nhận</a>
        <?php endif; ?>
        <?php if ($booking->status !== 'da_huy'): ?>
            <a href="<?php echo BASE_URL; ?>?act=admin-booking-cancel&id=<?php echo $booking->id; ?>" class="btn btn-danger">❌ Hủy</a>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['content' => $content, 'title' => $title]);
?>
