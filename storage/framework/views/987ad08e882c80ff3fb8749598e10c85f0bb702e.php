<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Albums</div>

                <div class="card-body">
                    <?php if(count($albums)>0): ?>
                        <?php $__currentLoopData = $albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="well">
                                <h4><?php echo e($album->album_name); ?></h4>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($albums->links()); ?>

                    <?php else: ?>
                        <p>No Albums Created.</p>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="album/create">Create Album</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/pages/dash.blade.php ENDPATH**/ ?>