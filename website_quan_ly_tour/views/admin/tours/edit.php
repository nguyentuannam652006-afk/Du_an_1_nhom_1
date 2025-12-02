<?php
ob_start();
?>

<div class="admin-tour-edit">
    <h2>✏️ Chỉnh Sửa Tour</h2>
    
    <form method="POST" action="<?php echo BASE_URL; ?>?act=admin-tour-update">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($tour->id); ?>">
        
        <div class="form-group">
            <label for="name">Tên Tour *</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($tour->name); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($tour->description); ?></textarea>
        </div>

        <div class="form-group">
            <label for="destination">Điểm Đến *</label>
            <input type="text" class="form-control" id="destination" name="destination" value="<?php echo htmlspecialchars($tour->destination); ?>" required>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="duration">Thời Gian (ngày) *</label>
                <input type="number" class="form-control" id="duration" name="duration" value="<?php echo htmlspecialchars($tour->duration); ?>" min="1" required>
            </div>

            <div class="form-group col-md-6">
                <label for="price">Giá (VNĐ) *</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($tour->price); ?>" min="1" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="max_participants">Số Người Tối Đa</label>
                <input type="number" class="form-control" id="max_participants" name="max_participants" value="<?php echo htmlspecialchars($tour->max_participants); ?>" min="1">
            </div>

            <div class="form-group col-md-6">
                <label for="status">Trạng Thái</label>
                <select class="form-control" id="status" name="status">
                    <option value="dang_hoat_dong" <?php echo $tour->status === 'dang_hoat_dong' ? 'selected' : ''; ?>>Đang Hoạt Động</option>
                    <option value="tam_dung" <?php echo $tour->status === 'tam_dung' ? 'selected' : ''; ?>>Tạm Dừng</option>
                    <option value="da_huy" <?php echo $tour->status === 'da_huy' ? 'selected' : ''; ?>>Đã Hủy</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">💾 Cập Nhật</button>
            <a href="<?php echo BASE_URL; ?>?act=admin-tours" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>

    <?php if (!empty($details)): ?>
        <hr>
        <h3>📅 Chi Tiết Lịch Trình</h3>
        <ul>
            <?php foreach ($details as $detail): ?>
                <li><strong>Ngày <?php echo htmlspecialchars($detail->day_number); ?>:</strong> <?php echo htmlspecialchars($detail->activity); ?> - <?php echo htmlspecialchars($detail->location); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['content' => $content, 'title' => $title]);
?>
