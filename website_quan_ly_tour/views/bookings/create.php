<?php
ob_start();
$user = getCurrentUser();
?>

<div class="booking-form">
    <h2>🎫 Đặt Tour: <?php echo htmlspecialchars($tour->name); ?></h2>
    
    <div class="tour-info">
        <h3>Thông Tin Tour</h3>
        <p><strong>Tên:</strong> <?php echo htmlspecialchars($tour->name); ?></p>
        <p><strong>Điểm Đến:</strong> <?php echo htmlspecialchars($tour->destination); ?></p>
        <p><strong>Ngày Khởi Hành:</strong> <?php echo htmlspecialchars($schedule->start_date); ?></p>
        <p><strong>Ngày Kết Thúc:</strong> <?php echo htmlspecialchars($schedule->end_date); ?></p>
        <p><strong>Giá/Người:</strong> <?php echo number_format($tour->price, 0, ',', '.'); ?> VNĐ</p>
        <p><strong>Chỗ Trống:</strong> <?php echo htmlspecialchars($schedule->available_seats); ?></p>
    </div>

    <form method="POST" action="<?php echo BASE_URL; ?>?act=booking-store">
        <input type="hidden" name="schedule_id" value="<?php echo htmlspecialchars($schedule->id); ?>">
        
        <div class="form-group">
            <label for="num_participants">Số Lượng Khách *</label>
            <input type="number" class="form-control" id="num_participants" name="num_participants" min="1" max="<?php echo htmlspecialchars($schedule->available_seats); ?>" required onchange="updateTotal()">
            <small>Tối đa: <?php echo htmlspecialchars($schedule->available_seats); ?> người</small>
        </div>

        <div class="form-group">
            <label for="notes">Ghi Chú (Tuỳ Chọn)</label>
            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Nhập yêu cầu hoặc ghi chú của bạn..."></textarea>
        </div>

        <div class="price-summary">
            <h4>Tóm Tắt Giá</h4>
            <p>Giá/Người: <strong><?php echo number_format($tour->price, 0, ',', '.'); ?></strong> VNĐ</p>
            <p>Số Người: <strong id="num">1</strong></p>
            <p><strong>Tổng Tiền: <span id="total"><?php echo number_format($tour->price, 0, ',', '.'); ?></span> VNĐ</strong></p>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success btn-lg">✅ Xác Nhận Đặt Tour</button>
            <a href="<?php echo BASE_URL; ?>?act=tour-detail&id=<?php echo $tour->id; ?>" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>
</div>

<script>
function updateTotal() {
    const price = <?php echo $tour->price; ?>;
    const num = document.getElementById('num_participants').value || 1;
    const total = price * num;
    document.getElementById('num').textContent = num;
    document.getElementById('total').textContent = new Intl.NumberFormat('vi-VN').format(total);
}
</script>

<style>
.booking-form {
    max-width: 700px;
    margin: 20px auto;
    padding: 20px;
}

.tour-info, .price-summary {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    background: #f9f9f9;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-group button {
    padding: 10px 20px;
    margin-right: 10px;
}
</style>

<?php
$content = ob_get_clean();
view('layouts.AuthLayout', ['content' => $content, 'title' => $title]);
?>
