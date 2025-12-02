<?php
ob_start();
?>

<div class="tours-list">
    <h2>🌍 Danh Sách Tour Du Lịch</h2>
    
    <div class="filters">
        <form method="GET" action="<?php echo BASE_URL; ?>?act=tours" class="form-inline">
            <div class="form-group">
                <input type="hidden" name="act" value="tours">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm tour..." value="<?php echo htmlspecialchars($keyword); ?>">
            </div>
            <div class="form-group">
                <input type="text" name="destination" class="form-control" placeholder="Điểm đến..." value="<?php echo htmlspecialchars($destination); ?>">
            </div>
            <button type="submit" class="btn btn-primary">🔍 Tìm Kiếm</button>
        </form>
    </div>

    <?php if (empty($tours)): ?>
        <div class="alert alert-info">Không tìm thấy tour nào phù hợp</div>
    <?php else: ?>
        <div class="tours-grid">
            <?php foreach ($tours as $tour): ?>
                <div class="tour-card">
                    <h3><?php echo htmlspecialchars($tour->name); ?></h3>
                    <p><strong>📍 Điểm Đến:</strong> <?php echo htmlspecialchars($tour->destination); ?></p>
                    <p><strong>⏱️ Thời Gian:</strong> <?php echo htmlspecialchars($tour->duration); ?> ngày</p>
                    <p><strong>💰 Giá:</strong> <?php echo number_format($tour->price, 0, ',', '.'); ?> VNĐ/người</p>
                    <p><strong>👥 Max:</strong> <?php echo htmlspecialchars($tour->max_participants); ?> người</p>
                    <p class="description"><?php echo substr(htmlspecialchars($tour->description), 0, 100); ?>...</p>
                    <a href="<?php echo BASE_URL; ?>?act=tour-detail&id=<?php echo $tour->id; ?>" class="btn btn-primary">👁️ Xem Chi Tiết</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.tours-list {
    padding: 20px;
}

.filters {
    margin-bottom: 20px;
}

.filters form {
    display: flex;
    gap: 10px;
}

.tours-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.tour-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.tour-card h3 {
    margin-top: 0;
}

.description {
    color: #666;
    font-size: 14px;
}
</style>

<?php
$content = ob_get_clean();
view('layouts.AuthLayout', ['content' => $content, 'title' => $title]);
?>
