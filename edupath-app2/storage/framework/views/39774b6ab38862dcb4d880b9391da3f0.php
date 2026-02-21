<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <?php
            $candidates = [
                'images/dorsu-logo.png','images/dorsu-logo.webp','images/dorsu-logo.jpg',
                'dorsu-logo.png','dorsu-logo.webp','dorsu-logo.jpg','logo.png','logo.jpg'
            ];
            $bgLogo = null;
            foreach ($candidates as $c) { if (file_exists(public_path($c))) { $bgLogo = asset($c); break; } }
            if (!$bgLogo && is_dir(public_path('images'))) {
                $any = glob(public_path('images/*.{png,PNG,webp,jpg,jpeg,JPG,JPEG,gif}'), GLOB_BRACE);
                if (!empty($any)) { $bgLogo = asset('images/'.basename($any[0])); }
            }
        ?>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative bg-gradient-to-br from-blue-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900"
             <?php if(empty($noBgImage) && $bgLogo): ?> style="background-image:url('<?php echo e($bgLogo); ?>'); background-size:cover; background-position:center;" <?php endif; ?>>
            <?php if(empty($noBgImage) && $bgLogo): ?>
                <div class="absolute inset-0 bg-white/80 dark:bg-black/70 backdrop-blur-sm"></div>
            <?php endif; ?>

            <?php if(empty($hideHeader)): ?>
            <div class="relative z-10 flex flex-col items-center mb-8">
                <a href="/" class="transform transition-transform hover:scale-105">
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-lg">
                        <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'w-16 h-16 mx-auto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 mx-auto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
                    </div>
                </a>
                <div class="mt-4 text-center">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Baganga Campus</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Education Management System</p>
                </div>
            </div>
            <?php endif; ?>

            <div class="relative z-10 <?php echo e($cardClass ?? 'w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-700'); ?>">
                <?php echo e($slot); ?>

            </div>

            <?php if(empty($hideFooter)): ?>
            <div class="relative z-10 mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
                <p>&copy; <?php echo e(date('Y')); ?> Baganga Campus. All rights reserved.</p>
            </div>
            <?php endif; ?>
        </div>
    </body>
</html>
<?php /**PATH C:\Users\Admin\edupath-app\edupath-app2\resources\views/layouts/guest.blade.php ENDPATH**/ ?>