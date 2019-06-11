<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <?php if(isset($message)): ?>
                    <div class='alert alert-danger'>
                        <?php echo e($message); ?>

                    </div>                
                <?php endif; ?>
            <div class="card">
                <div class="card-header">Dashboard</div>
                
                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(isset($albums) and count($albums)>0): ?>
                        <?php $__currentLoopData = $albums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <h6><?php echo e($loop->iteration); ?>.  
                                <a href="/albums/<?php echo e($album['id']); ?>"><?php echo e($album['album_name']); ?><a>
                                </h6>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        No Albums to Show
                    <?php endif; ?>
                    
                </div>
            
            </div><a class="btn btn-primary" href="/albums/create">Create Album</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/home.blade.php ENDPATH**/ ?>