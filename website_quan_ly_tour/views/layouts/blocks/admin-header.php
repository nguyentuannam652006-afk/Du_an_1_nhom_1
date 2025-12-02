<?php
// Header block cho Admin
$user = getCurrentUser();
?>
<header class="admin-header">
    <div class="header-content">
        <div class="logo">
            <h1>📱 Quản Lý Tour</h1>
        </div>
        <div class="user-info">
            <span>👤 <?php echo htmlspecialchars($user->name); ?></span>
            <a href="<?php echo asset('../index.php?act=logout'); ?>" class="btn-logout">Đăng xuất</a>
        </div>
    </div>
</header>
