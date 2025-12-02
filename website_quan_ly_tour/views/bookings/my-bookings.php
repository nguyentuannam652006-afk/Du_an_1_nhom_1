<?php
ob_start();
?>

<div class="my-bookings">
    <h2>🎫 Đặt Tour Của Tôi</h2>
    
    <?php if (empty($bookings)): ?>
        <div class="alert alert-info">
            Bạn chưa đặt tour nào. <a href="<?php echo BASE_URL; ?>?act=tours">Xem danh sách tour</a>
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tour</th>
                    <th>Ngày Bắt Đầu</th>
                    <th>Số Người</th>
                    <th>Tổng Tiền (VNĐ)</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): 
                    $schedule = TourSchedule::getById($booking->tour_schedule_id);
                    $tour = Tour::getById($schedule->tour_id);
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking->id); ?></td>
                        <td><?php echo htmlspecialchars($tour->name); ?></td>
                        <td><?php echo htmlspecialchars($schedule->start_date); ?></td>
                        <td><?php echo htmlspecialchars($booking->num_participants); ?></td>
                        <td><?php echo number_format($booking->total_price, 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo match($booking->status) { 'cho_xac_nhan' => 'warning', 'da_xac_nhan' => 'success', 'da_huy' => 'danger', 'hoan_thanh' => 'info', default => 'secondary' }; ?>">
                                <?php echo htmlspecialchars($booking->status); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($booking->created_at); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="actions">
        <a href="<?php echo BASE_URL; ?>?act=tours" class="btn btn-primary">🔍 Xem Thêm Tour</a>
        <a href="<?php echo BASE_URL; ?>?act=home" class="btn btn-secondary">🏠 Trang Chủ</a>
    </div>
</div>

<style>
.my-bookings {
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table thead {
    background-color: #f5f5f5;
}

.badge {
    padding: 5px 10px;
    border-radius: 4px;
    color: white;
    font-size: 12px;
}

.actions {
    margin-top: 20px;
}

.actions a {
    margin-right: 10px;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}
</style>

<?php
$content = ob_get_clean();
view('layouts.AuthLayout', ['content' => $content, 'title' => $title]);
?>
