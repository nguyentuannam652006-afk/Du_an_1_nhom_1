<?php
ob_start();
?>

<div class="admin-tours">
    <h2>📋 Danh Sách Tour</h2>
    <a href="<?php echo BASE_URL; ?>?act=admin-tour-create" class="btn btn-primary">➕ Tạo Tour Mới</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên Tour</th>
                <th>Điểm Đến</th>
                <th>Thời Gian (ngày)</th>
                <th>Giá (VNĐ)</th>
                <th>Max Người</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tours as $tour): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tour->id); ?></td>
                    <td><?php echo htmlspecialchars($tour->name); ?></td>
                    <td><?php echo htmlspecialchars($tour->destination); ?></td>
                    <td><?php echo htmlspecialchars($tour->duration); ?></td>
                    <td><?php echo number_format($tour->price, 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($tour->max_participants); ?></td>
                    <td>
                        <span class="badge bg-<?php echo $tour->status === 'dang_hoat_dong' ? 'success' : 'danger'; ?>">
                            <?php echo htmlspecialchars($tour->status); ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>?act=admin-tour-edit&id=<?php echo $tour->id; ?>" class="btn btn-sm btn-warning">✏️ Sửa</a>
                        <a href="<?php echo BASE_URL; ?>?act=admin-tour-delete&id=<?php echo $tour->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn?');">🗑️ Xóa</a>
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
