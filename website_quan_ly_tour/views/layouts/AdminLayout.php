<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'Admin - Quản Lý Tour'); ?></title>
    <link rel="stylesheet" href="<?php echo asset('css/admin.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/auth.css'); ?>">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php block('admin-header'); ?>
        
        <div class="admin-main">
            <?php block('admin-sidebar'); ?>
            
            <main class="admin-content">
                <div class="content-wrapper">
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger">
                            <h4>❌ Lỗi:</h4>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($content)): ?>
                        <?php echo $content; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>

        <?php block('admin-footer'); ?>
    </div>
</body>
</html>

