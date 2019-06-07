<?php $__env->startSection('content'); ?>

    <div class="container">
    <h1>Register New User</h1>

    <?php echo e(Form::open(['action'=>'Api\PassportController@register',
                'method'=>'POST',
                'files'=>true,
                'enctype'=> "multipart/form-data"])); ?>

        <div class='.form-group'>
            <?php echo e(Form::label('username', 'Username', ['class'=>'control-label'])); ?>

            <?php echo e(Form::text('username', '', ['class'=>'form-control', 'placeholder'=>'Enter Username'])); ?>

        </div>
        <div class='form-group'>
            <?php echo e(Form::label('first_name', 'First Name')); ?>

            <?php echo e(Form::text('first_name', '', ['class'=>'form-control', 'placeholder'=>'Enter First Name'])); ?>

        </div>
        <div class='form-group'>
            <?php echo e(Form::label('last_name', 'Last Name')); ?>

            <?php echo e(Form::text('last_name', '', ['class'=>'form-control', 'placeholder'=>'Enter Last Name'])); ?>

        </div>
        <div class='form-group'>
            <?php echo e(Form::label('email', 'Email')); ?>

            <?php echo e(Form::text('email', '', ['class'=>'form-control', 'placeholder'=>'Enter Email'])); ?>

        </div>
        <div class='form-group'>
            <?php echo e(Form::label('gender', 'Gender')); ?>

            <?php echo e(Form::select('gender', ['1' => 'Male', '2'=>'Female', '3'=>'Other'])); ?>

        </div>
        <div class='form-group'>
            <?php echo e(Form::label('profile_picture', 'Profile Picture')); ?>

            <?php echo e(Form::file('profile_picture')); ?>

        </div>
        <div class='form-group'>
            <?php echo e(Form::label('password', 'Password')); ?>

            <?php echo e(Form::password('password',['class'=>'form-control'])); ?>

        </div>
        <div class='form-group'>
            <?php echo e(Form::label('password_confirmation', 'Confirm Password')); ?>

            <?php echo e(Form::password('password_confirmation',['class'=>'form-control'])); ?>

        </div>


            <?php echo e(Form::submit('Submit',['class'=>'btn btn-primary'])); ?>

    <?php echo e(Form::close()); ?>



</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/pages/register.blade.php ENDPATH**/ ?>