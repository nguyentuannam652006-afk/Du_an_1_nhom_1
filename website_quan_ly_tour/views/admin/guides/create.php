<?php
ob_start();
?>

<div class="admin-guide-create">
    <h2>➕ Tạo Hướng Dẫn Viên Mới</h2>
    
    <form method="POST" action="<?php echo BASE_URL; ?>?act=admin-guide-store">
        <div class="form-group">
            <label for="user_id">Chọn Người Dùng *</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">-- Chọn Người Dùng --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user->id); ?>">
                        <?php echo htmlspecialchars($user->name); ?> (<?php echo htmlspecialchars($user->email); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="specialization">Chuyên Môn</label>
            <input type="text" class="form-control" id="specialization" name="specialization" placeholder="VD: Miền Bắc, Miền Nam...">
        </div>

        <div class="form-group">
            <label for="experience_years">Năm Kinh Nghiệm</label>
            <input type="number" class="form-control" id="experience_years" name="experience_years" min="0" value="0">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">💾 Tạo HDV</button>
            <a href="<?php echo BASE_URL; ?>?act=admin-guides" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
view('layouts.AdminLayout', ['content' => $content, 'title' => $title]);
?>
