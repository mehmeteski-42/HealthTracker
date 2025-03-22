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
        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Login</a>
        <a href="<?php echo e(route('registerAccount')); ?>" class="btn btn-secondary">Register</a>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\HealthTracker\resources\views/welcome.blade.php ENDPATH**/ ?>