<?php
ob_start();
?>

<div class="admin-bookings">
    <h2>💰 Danh Sách Đặt Tour</h2>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Khách Hàng</th>
                <th>Tour</th>
                <th>Số Người</th>
                <th>Tổng Tiền (VNĐ)</th>
                <th>Trạng Thái</th>
                <th>Ngày Đặt</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): 
                $user = User::getById($booking->user_id);
                $schedule = TourSchedule::getById($booking->tour_schedule_id);
                $tour = Tour::getById($schedule->tour_id);
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking->id); ?></td>
                    <td><?php echo htmlspecialchars($user->name ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($tour->name ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($booking->num_participants); ?></td>
                    <td><?php echo number_format($booking->total_price, 0, ',', '.'); ?></td>
                    <td>
                        <span class="badge bg-<?php echo match($booking->status) { 'cho_xac_nhan' => 'warning', 'da_xac_nhan' => 'success', 'da_huy' => 'danger', 'hoan_thanh' => 'info', default => 'secondary' }; ?>">
                            <?php echo htmlspecialchars($booking->status); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($booking->created_at); ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>?act=admin-booking-detail&id=<?php echo $booking->id; ?>" class="btn btn-sm btn-info">👁️ Chi Tiết</a>
                        <?php if ($booking->status === 'cho_xac_nhan'): ?>
                            <a href="<?php echo BASE_URL; ?>?act=admin-booking-confirm&id=<?php echo $booking->id; ?>" class="btn btn-sm btn-success">✅ Xác Nhận</a>
                        <?php endif; ?>
                        <?php if ($booking->status !== 'da_huy'): ?>
                            <a href="<?php echo BASE_URL; ?>?act=admin-booking-cancel&id=<?php echo $booking->id; ?>" class="btn btn-sm btn-danger">❌ Hủy</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['content' => $content, 'title' => $title]);
?>
