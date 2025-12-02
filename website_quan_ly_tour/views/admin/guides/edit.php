<?php
ob_start();
?>

<div class="admin-guide-edit">
    <h2>✏️ Chỉnh Sửa Hướng Dẫn Viên</h2>
    
    <form method="POST" action="<?php echo BASE_URL; ?>?act=admin-guide-update">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($guide->id); ?>">
        
        <div class="form-group">
            <label>Người Dùng: <strong><?php echo htmlspecialchars($guide->name); ?></strong></label>
        </div>

        <div class="form-group">
            <label for="specialization">Chuyên Môn</label>
            <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo htmlspecialchars($guide->specialization); ?>">
        </div>

        <div class="form-group">
            <label for="experience_years">Năm Kinh Nghiệm</label>
            <input type="number" class="form-control" id="experience_years" name="experience_years" min="0" value="<?php echo htmlspecialchars($guide->experience_years); ?>">
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="available_from">Sẵn Sàng Từ</label>
                <input type="date" class="form-control" id="available_from" name="available_from" value="<?php echo htmlspecialchars($guide->available_from); ?>">
            </div>

            <div class="form-group col-md-6">
                <label for="available_to">Sẵn Sàng Đến</label>
                <input type="date" class="form-control" id="available_to" name="available_to" value="<?php echo htmlspecialchars($guide->available_to); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="status">Trạng Thái</label>
            <select class="form-control" id="status" name="status">
                <option value="san_sang" <?php echo $guide->status === 'san_sang' ? 'selected' : ''; ?>>Sẵn Sàng</option>
                <option value="dang_hoat_dong" <?php echo $guide->status === 'dang_hoat_dong' ? 'selected' : ''; ?>>Đang Hoạt Động</option>
                <option value="nghi_phep" <?php echo $guide->status === 'nghi_phep' ? 'selected' : ''; ?>>Nghỉ Phép</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">💾 Cập Nhật</button>
            <a href="<?php echo BASE_URL; ?>?act=admin-guides" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['content' => $content, 'title' => $title]);
?>
