<?php
    $currentRoute = Route::currentRouteName();
?>

<div class="sidebar-wrapper">
    <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation"
            data-accordion="false" id="navigation">
            <li class="nav-item">
                <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e($currentRoute == 'home' ? 'active' : ''); ?>">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('service.index')); ?>" class="nav-link <?php echo e($currentRoute == 'service.index' ? 'active' : ''); ?>">
                    <i class="nav-icon fa-solid fa-screwdriver-wrench"></i>
                    <p>
                        Services
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('service.provider')); ?>" class="nav-link <?php echo e($currentRoute == 'service.provider' ? 'active' : ''); ?>">
                    <i class="nav-icon fa-solid fa-gears"></i>
                    <p>
                        Service Provider
                    </p>
                </a>
            </li>

        </ul>
        <!--end::Sidebar Menu-->
    </nav>
</div>
<?php /**PATH D:\Rayhan\Development\Bkash-Portal\resources\views/layouts/_partials/sidebar.blade.php ENDPATH**/ ?>