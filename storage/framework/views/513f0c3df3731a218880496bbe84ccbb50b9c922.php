<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Loggin</div>
                <?php if(isset($error) and count($error)>0): ?>
                    <?php $__currentLoopData = $error; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k =>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class='alert alert-danger'>
                            <?php echo e($v[0]); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                    
                <?php endif; ?>
                <div class="card-body">
                <?php echo e(Form::open(['action'=>'Web\UserController@logg',
                        'method'=>'POST'])); ?>

                <div class='form-group'>
                    <?php echo e(Form::label('username', 'Username', ['class'=>'control-label'])); ?>

                    <?php echo e(Form::text('username', '', ['class'=>'form-control', 'placeholder'=>'Enter Username'])); ?>

                </div>
                <div class='form-group'>
                    <?php echo e(Form::label('password', 'Password')); ?>

                    <?php echo e(Form::password('password',['class'=>'form-control'])); ?>

                </div>

                    <?php echo e(Form::submit('Submit',['class'=>'btn btn-primary'])); ?>

                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/logg.blade.php ENDPATH**/ ?>