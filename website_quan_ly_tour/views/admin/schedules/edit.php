<?php
ob_start();
?>

<div class="admin-schedule-edit">
    <h2>✏️ Chỉnh Sửa Lịch Trình</h2>
    
    <form method="POST" action="<?php echo BASE_URL; ?>?act=admin-schedule-update">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($schedule->id); ?>">
        
        <div class="form-group">
            <label>Tour: <strong><?php echo htmlspecialchars(Tour::getById($schedule->tour_id)->name); ?></strong></label>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="start_date">Ngày Bắt Đầu *</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($schedule->start_date); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="end_date">Ngày Kết Thúc *</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($schedule->end_date); ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="available_seats">Số Chỗ Trống *</label>
                <input type="number" class="form-control" id="available_seats" name="available_seats" value="<?php echo htmlspecialchars($schedule->available_seats); ?>" min="1" required>
            </div>

            <div class="form-group col-md-6">
                <label for="status">Trạng Thái</label>
                <select class="form-control" id="status" name="status">
                    <option value="san_sang" <?php echo $schedule->status === 'san_sang' ? 'selected' : ''; ?>>Sẵn Sàng</option>
                    <option value="dang_hoat_dong" <?php echo $schedule->status === 'dang_hoat_dong' ? 'selected' : ''; ?>>Đang Hoạt Động</option>
                    <option value="hoan_thanh" <?php echo $schedule->status === 'hoan_thanh' ? 'selected' : ''; ?>>Hoàn Thành</option>
                    <option value="da_huy" <?php echo $schedule->status === 'da_huy' ? 'selected' : ''; ?>>Đã Hủy</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">💾 Cập Nhật</button>
            <a href="<?php echo BASE_URL; ?>?act=admin-schedules" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['content' => $content, 'title' => $title]);
?>
