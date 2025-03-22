<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body>
    
    <div class="container text-center mt-5">
        <h1>Welcome to HealthTracker</h1>
        <p>Your health, our priority.</p>
        <?php if(Auth::check()): ?>
            <p>Hoş geldin, <strong><?php echo e(Auth::user()->name); ?></strong>!</p>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-danger">Çıkış Yap</button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('loginAccount')); ?>" class="btn btn-primary">Login</a>
            <a href="<?php echo e(route('registerAccount')); ?>" class="btn btn-secondary">Register</a>
        <?php endif; ?>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\HealthTracker\resources\views/welcome.blade.php ENDPATH**/ ?>