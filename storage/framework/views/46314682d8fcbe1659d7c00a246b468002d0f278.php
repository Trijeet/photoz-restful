<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Account</div>

                <div class="card-body">
                    <p> Username : <?php echo e(Auth::user()->username); ?></p>
                    <p> Name : <?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></p>
                    <p> Email : <?php echo e(Auth::user()->email); ?></p>
                    <p> Gender : <?php echo e(Auth::user()->gender); ?></p>
                    <p> Profile Picture : </p><img src='/storage/profile_pictures/<?php echo e(Auth::user()->profile_pic); ?>'>
                    <p> Account Created : <?php echo e(Auth::user()->created_at); ?></p>
                    
                </div>
            </div>
        </div>
    </div>
    
    
    
    
</div>
<a href="/user/<?php echo e(Auth::user()->username); ?>/edit" class="btn btn-primary" class="row justify-content-left">Edit<a>
<?php echo e(Form::open(['action'=>['UsersController@destroy',Auth::user()->username],
                    'method'=>'delete',
                    'class'=>'pull-right'])); ?>

         <?php echo e(Form::submit('Delete',['class'=>'btn btn-danger'])); ?>

    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/pages/myaccount.blade.php ENDPATH**/ ?>