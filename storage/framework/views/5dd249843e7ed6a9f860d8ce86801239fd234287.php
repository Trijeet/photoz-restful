<?php $__env->startSection('content'); ?>

    <div class="container">
    <h1>Register New User</h1>

    <?php echo e(Form::open(['action'=>'Api\PassportController@login',
                'method'=>'POST'])); ?>

        <div class='.form-group'>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/pages/login.blade.php ENDPATH**/ ?>