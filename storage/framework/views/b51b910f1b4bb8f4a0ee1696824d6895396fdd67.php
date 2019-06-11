<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User - <?php echo e($user['username']); ?></div>
                <div class='card-body'>
                    <img src='/storage/profile_pictures/<?php echo e($user["profile_picture"]); ?>'
                        height="256" width="256"> <br><br>
                    
                    Name - <?php echo e($user['first_name']); ?> <?php echo e($user['last_name']); ?><br>
                    Email - <?php echo e($user['email']); ?> <br>
                    Gender - <?php echo e(['','Male','Female','Other'][$user['gender']]); ?> <br>
                    <br>
                    Created At - <?php echo e($user['created_at']); ?> <br>
                    Last Modified At - <?php echo e($user['updated_at']); ?> <br>
                </div>
                <br>
                <div class="card-header">Albums</div>
                <div class='card-body'>
                    <?php if(isset($albums) and count($albums)>0): ?>
                        <?php $__currentLoopData = $albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($album); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        No albums to show.
                    <?php endif; ?>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/pages/userpage.blade.php ENDPATH**/ ?>