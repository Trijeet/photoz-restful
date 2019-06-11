<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit User Details</div>
                <?php if(isset($error) and count($error)>0): ?>
                    <?php $__currentLoopData = $error; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k =>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class='alert alert-danger'>
                            <?php echo e($v[0]); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                    
                <?php endif; ?>
                <div class="card-body">
                <?php echo e(Form::open(['action'=>['UserController@edit',Auth::user()->username],
                        'method'=>'PUT',
                        'files'=>true,
                        'enctype'=> "multipart/form-data"])); ?>

                
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
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/pages/edituser.blade.php ENDPATH**/ ?>