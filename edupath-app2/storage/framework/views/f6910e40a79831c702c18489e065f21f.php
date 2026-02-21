<div class="form-header">
    <div class="header-left">
        <div class="blue-line-top"></div>
        <div class="university-name-line1">DAVAO ORIENTAL</div>
        <div class="university-name-line2">STATE UNIVERSITY</div>
        <div class="university-tagline">A University of excellence, innovation, and inclusion</div>
        <div class="blue-line-bottom"></div>
    </div>
    <div class="logo-container">
        <?php
            $logoPath = null;
            $candidates = [
                'images/dorsu-logo.png.png',
                'images/dorsu-logo.png', 
                'images/dorsu-logo.PNG', 
                'images/dorsu-logo.webp', 
                'images/dorsu-logo.jpg', 
                'images/dorsu-logo.jpeg',
                'dorsu-logo.png.png',
                'dorsu-logo.png'
            ];
            foreach ($candidates as $c) {
                if (file_exists(public_path($c))) {
                    $logoPath = asset($c);
                    break;
                }
            }
            if (!$logoPath && is_dir(public_path('images'))) {
                $any = glob(public_path('images/*.{png,PNG,webp,jpg,jpeg,JPG,JPEG,gif}'), GLOB_BRACE);
                if (!empty($any)) {
                    $logoPath = asset('images/' . basename($any[0]));
                }
            }
        ?>
        <?php if($logoPath): ?>
            <img src="<?php echo e($logoPath); ?>" alt="DOrSU Logo" style="width: 100%; height: 100%; object-fit: contain;">
        <?php else: ?>
            <div style="font-size: 9px; text-align: center; padding: 5px; color: #003366; font-weight: bold;">DOrSU<br/>LOGO</div>
        <?php endif; ?>
    </div>
    <div class="doc-control">
        <div class="doc-control-header">Document Code No.</div>
        <div class="doc-control-code">FM-DOrSU-ODI-05</div>
        <table class="doc-control-table">
            <tr class="doc-control-header-row">
                <td>Issue Status</td>
                <td>Rev No.</td>
                <td>Effective Date</td>
                <td>Page No.</td>
            </tr>
            <tr class="doc-control-value-row">
                <td>01</td>
                <td>00</td>
                <td>07.22.2022</td>
                <td><?php echo e($pageNo ?? '1 of 2'); ?></td>
            </tr>
        </table>
    </div>
</div>
<?php /**PATH C:\Users\Admin\edupath-app\edupath-app2\resources\views/admin/enrollment_requests/_spf_header.blade.php ENDPATH**/ ?>