<?php
ob_start();
?>

<div class="admin-schedules">
    <h2>📅 Danh Sách Lịch Trình</h2>
    <a href="<?php echo BASE_URL; ?>?act=admin-schedule-create" class="btn btn-primary">➕ Tạo Lịch Trình</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tour</th>
                <th>Ngày Bắt Đầu</th>
                <th>Ngày Kết Thúc</th>
                <th>Chỗ Trống</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($schedules as $schedule): 
                $tour = Tour::getById($schedule->tour_id);
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($schedule->id); ?></td>
                    <td><?php echo htmlspecialchars($tour->name ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($schedule->start_date); ?></td>
                    <td><?php echo htmlspecialchars($schedule->end_date); ?></td>
                    <td><?php echo htmlspecialchars($schedule->available_seats); ?></td>
                    <td>
                        <span class="badge bg-info"><?php echo htmlspecialchars($schedule->status); ?></span>
                    </td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>?act=admin-schedule-edit&id=<?php echo $schedule->id; ?>" class="btn btn-sm btn-warning">✏️ Sửa</a>
                        <a href="<?php echo BASE_URL; ?>?act=admin-schedule-delete&id=<?php echo $schedule->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn?');">🗑️ Xóa</a>
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
