<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gradient-to-r from-blue-500 to-indigo-700 text-white font-sans antialiased">

<!-- Navigation Bar -->
<nav class="p-4 bg-white text-black shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-2xl font-bold">Health Care System</a>
        <div class="space-x-4">
            <a href="<?php echo e(route('login')); ?>" class="hover:text-blue-500 p-4">Login</a>
            <a href="<?php echo e(route('register')); ?>" class="hover:text-blue-500">Register</a>

        </div>
    </div>
</nav>

<!-- Welcome Section -->
<div class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-color: rgba(255,255,255,0.64);">
    <div class="bg-black bg-opacity-50 p-10 rounded-lg text-center">
        <img src="<?php echo e(asset('img/start.jfif')); ?>">
        <h1 class="text-4xl md:text-5xl font-semibold mb-4 text-black">Welcome to MyApp</h1>
        <p class="text-lg text-black mb-4">Your go-to platform for all things awesome!</p>

    </div>
</div>

<!-- Footer -->
<footer class="bg-black text-white py-4 text-center">
    <p>&copy; 2024 MyApp. All rights reserved.</p>
</footer>

</body>
</html>
<?php /**PATH C:\Users\MI\Desktop\cloud-healthcare-project-2\resources\views/welcome.blade.php ENDPATH**/ ?>