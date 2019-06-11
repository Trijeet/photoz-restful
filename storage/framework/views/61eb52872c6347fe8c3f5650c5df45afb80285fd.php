<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List of Users</div>
                <div class='card-body'>                    
                    <?php if(isset($users) and count($users)>0): ?>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <div>
                                <h6><?php echo e($loop->iteration); ?>.  
                                    <a href="/users/<?php echo e($user['username']); ?>"><?php echo e($user['username']); ?><a>
                                </h6>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        No Users to show.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/pages/users.blade.php ENDPATH**/ ?>