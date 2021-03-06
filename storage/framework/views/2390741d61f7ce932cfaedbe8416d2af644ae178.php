<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List of Users - </div>

                <div class="card-body">
                <?php if(count($users)>0): ?>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="well">
                                <h6><?php echo e($loop->iteration); ?>.  
                                    <a href="/user/<?php echo e($user->username); ?>"> <?php echo e($user->username); ?>

                                <a></h6>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($users->links()); ?>

                    <?php else: ?>
                        <p>No User found.</p>
                    <?php endif; ?>
                    

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz-restful\resources\views/pages/users.blade.php ENDPATH**/ ?>