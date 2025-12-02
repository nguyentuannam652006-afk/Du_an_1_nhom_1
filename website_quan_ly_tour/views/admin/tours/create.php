<?php
ob_start();
?>

<div class="admin-tour-create">
    <h2>➕ Tạo Tour Mới</h2>
    
    <form method="POST" action="<?php echo BASE_URL; ?>?act=admin-tour-store">
        <div class="form-group">
            <label for="name">Tên Tour *</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($form['name'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($form['description'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="destination">Điểm Đến *</label>
            <input type="text" class="form-control" id="destination" name="destination" value="<?php echo htmlspecialchars($form['destination'] ?? ''); ?>" required>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="duration">Thời Gian (ngày) *</label>
                <input type="number" class="form-control" id="duration" name="duration" value="<?php echo htmlspecialchars($form['duration'] ?? ''); ?>" min="1" required>
            </div>

            <div class="form-group col-md-6">
                <label for="price">Giá (VNĐ) *</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($form['price'] ?? ''); ?>" min="1" required>
            </div>
        </div>

        <div class="form-group">
            <label for="max_participants">Số Người Tối Đa</label>
            <input type="number" class="form-control" id="max_participants" name="max_participants" value="<?php echo htmlspecialchars($form['max_participants'] ?? 30); ?>" min="1">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">💾 Tạo Tour</button>
            <a href="<?php echo BASE_URL; ?>?act=admin-tours" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['content' => $content, 'title' => $title]);
?>
