<?php
ob_start();
?>

<div class="admin-schedule-create">
    <h2>➕ Tạo Lịch Trình Mới</h2>
    
    <form method="POST" action="<?php echo BASE_URL; ?>?act=admin-schedule-store">
        <div class="form-group">
            <label for="tour_id">Tour *</label>
            <select class="form-control" id="tour_id" name="tour_id" required>
                <option value="">-- Chọn Tour --</option>
                <?php foreach ($tours as $tour): ?>
                    <option value="<?php echo htmlspecialchars($tour->id); ?>" <?php echo (isset($form) && $form['tour_id'] == $tour->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tour->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="start_date">Ngày Bắt Đầu *</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($form['start_date'] ?? ''); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="end_date">Ngày Kết Thúc *</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($form['end_date'] ?? ''); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="available_seats">Số Chỗ Trống *</label>
            <input type="number" class="form-control" id="available_seats" name="available_seats" value="<?php echo htmlspecialchars($form['available_seats'] ?? ''); ?>" min="1" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">💾 Tạo Lịch Trình</button>
            <a href="<?php echo BASE_URL; ?>?act=admin-schedules" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['content' => $content, 'title' => $title]);
?>
