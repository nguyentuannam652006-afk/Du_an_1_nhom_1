<?php
ob_start();
?>

<div class="tour-detail">
    <h2><?php echo htmlspecialchars($tour->name); ?></h2>
    
    <div class="detail-info">
        <div class="info-box">
            <h3>Thông Tin Tour</h3>
            <p><strong>📍 Điểm Đến:</strong> <?php echo htmlspecialchars($tour->destination); ?></p>
            <p><strong>⏱️ Thời Gian:</strong> <?php echo htmlspecialchars($tour->duration); ?> ngày</p>
            <p><strong>💰 Giá:</strong> <?php echo number_format($tour->price, 0, ',', '.'); ?> VNĐ/người</p>
            <p><strong>👥 Số Người Tối Đa:</strong> <?php echo htmlspecialchars($tour->max_participants); ?></p>
            <p><strong>📝 Mô Tả:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($tour->description)); ?></p>
        </div>

        <?php if (!empty($details)): ?>
            <div class="info-box">
                <h3>📅 Chi Tiết Lịch Trình</h3>
                <ul>
                    <?php foreach ($details as $detail): ?>
                        <li>
                            <strong>Ngày <?php echo htmlspecialchars($detail->day_number); ?>:</strong> 
                            <?php echo htmlspecialchars($detail->activity); ?> 
                            @ <?php echo htmlspecialchars($detail->location); ?>
                            <p><?php echo htmlspecialchars($detail->description); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="info-box">
            <h3>📆 Lịch Khởi Hành</h3>
            <?php if (empty($schedules)): ?>
                <p class="alert alert-warning">Hiện không có lịch khởi hành nào</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ngày Bắt Đầu</th>
                            <th>Ngày Kết Thúc</th>
                            <th>Chỗ Trống</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedules as $schedule): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($schedule->start_date); ?></td>
                                <td><?php echo htmlspecialchars($schedule->end_date); ?></td>
                                <td><?php echo htmlspecialchars($schedule->available_seats); ?></td>
                                <td>
                                    <?php if (isLoggedIn() && $schedule->available_seats > 0): ?>
                                        <a href="<?php echo BASE_URL; ?>?act=booking&schedule_id=<?php echo $schedule->id; ?>" class="btn btn-primary btn-sm">🎫 Đặt Ngay</a>
                                    <?php elseif (!isLoggedIn()): ?>
                                        <a href="<?php echo BASE_URL; ?>?act=login&redirect=<?php echo urlencode(BASE_URL . '?act=booking&schedule_id=' . $schedule->id); ?>" class="btn btn-primary btn-sm">🎫 Đặt Ngay</a>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Hết Chỗ</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="actions">
        <a href="<?php echo BASE_URL; ?>?act=tours" class="btn btn-secondary">👈 Quay Lại</a>
    </div>
</div>

<style>
.tour-detail {
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.detail-info {
    margin: 20px 0;
}

.info-box {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    background: #f9f9f9;
}

.info-box h3 {
    margin-top: 0;
}

.info-box ul {
    padding-left: 20px;
}

.info-box li {
    margin-bottom: 10px;
}
</style>

<?php
$content = ob_get_clean();
view('layouts.AuthLayout', ['content' => $content, 'title' => $title]);
?>
