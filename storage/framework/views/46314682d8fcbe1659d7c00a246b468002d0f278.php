<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Account</div>
                <div class='card-body'>
                    <img src='/storage/profile_pictures/<?php echo e($data["profile_picture"]); ?>'
                        height="256" width="256"> <br><br>
                    
                    Username - <?php echo e($data['username']); ?> <br>
                    Name - <?php echo e($data['first_name']); ?> <?php echo e($data['last_name']); ?><br>
                    Email - <?php echo e($data['email']); ?> <br>
                    Gender - <?php echo e(['','Male','Female','Other'][$data['gender']]); ?> <br>
                    <br>
                    Created At - <?php echo e($data['created_at']); ?> <br>
                    Last Modified At - <?php echo e($data['updated_at']); ?> <br>
                </div>
            </div>
            <a href="/users/<?php echo e(Auth::user()->username); ?>/edit" class="btn btn-primary" class="row justify-content-left">Edit<a>
            <br>
            <?php echo e(Form::open(['action'=>['Web\UserController@delete',Auth::user()->username],
                        'method'=>'delete',
                        'class'=>'pull-right',
                        'onsubmit' => 'return ConfirmDelete()'])); ?>

                <?php echo e(Form::submit('Delete',['class'=>'btn btn-danger'])); ?>

            <?php echo e(Form::close()); ?>

            <script>
                function ConfirmDelete()
                {
                var x = confirm("Are you sure you want to delete your account?");
                if (x)
                    return true;
                else
                    return false;
                }
            </script>
        </div> 
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/pages/myaccount.blade.php ENDPATH**/ ?>