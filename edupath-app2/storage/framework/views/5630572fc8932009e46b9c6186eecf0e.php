<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-semibold">Messages Inbox</h1>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-4 p-4 bg-green-50 text-green-800 border border-green-200 rounded-lg"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php if(!$msg->is_read): ?> bg-blue-50 <?php endif; ?>">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($msg->name); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($msg->email); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo e($msg->subject); ?></div>
                            <div class="text-xs text-gray-500 truncate max-w-md"><?php echo e(\Illuminate\Support\Str::limit($msg->message, 80)); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($msg->created_at->format('M d, Y h:i A')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <div class="inline-flex items-center gap-2">
                                <a href="<?php echo e(route('admin.messages.show', $msg)); ?>" class="px-3 py-1.5 text-xs bg-gray-800 text-white rounded hover:bg-gray-900">Open</a>
                                <form method="POST" action="<?php echo e(route('admin.messages.destroy', $msg)); ?>" onsubmit="return confirm('Delete this message?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="px-3 py-1.5 text-xs bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-sm text-gray-500">No messages yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($messages->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\edupath-app\edupath-app2\resources\views/admin/messages/index.blade.php ENDPATH**/ ?>