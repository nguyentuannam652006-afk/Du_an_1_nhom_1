<?php
ob_start();
?>

<div class="admin-guides">
    <h2>👨‍💼 Danh Sách Hướng Dẫn Viên</h2>
    <a href="<?php echo BASE_URL; ?>?act=admin-guide-create" class="btn btn-primary">➕ Tạo HDV Mới</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điện Thoại</th>
                <th>Chuyên Môn</th>
                <th>Kinh Nghiệm (năm)</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guides as $guide): ?>
                <tr>
                    <td><?php echo htmlspecialchars($guide->id); ?></td>
                    <td><?php echo htmlspecialchars($guide->name ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($guide->email ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($guide->phone ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($guide->specialization); ?></td>
                    <td><?php echo htmlspecialchars($guide->experience_years); ?></td>
                    <td>
                        <span class="badge bg-<?php echo $guide->status === 'san_sang' ? 'success' : 'warning'; ?>">
                            <?php echo htmlspecialchars($guide->status); ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>?act=admin-guide-edit&id=<?php echo $guide->id; ?>" class="btn btn-sm btn-warning">✏️ Sửa</a>
                        <a href="<?php echo BASE_URL; ?>?act=admin-guide-delete&id=<?php echo $guide->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn?');">🗑️ Xóa</a>
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
