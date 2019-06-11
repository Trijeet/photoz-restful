<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Photo - <?php echo e($photo['photo']); ?></div>
                <div class='card-body'>
                    <img src='/storage/photos/<?php echo e($photo["photo"]); ?>'
                        height="256" width="256"> <br><br>
                    
                    Photos Description - <?php echo e($photo['photo_description']); ?> <br> <br>
                    Privacy - <?php echo e(['','Public','Link Accessible','Private'][$photo['privacy']]); ?> <br>
                    <br>
                    Created At - <?php echo e($photo['created_at']); ?> <br>
                    Last Modified At - <?php echo e($photo['updated_at']); ?> <br>
                </div>
                <br>
            </div>
            <div class='Buttons'>
            <br>
                <?php if(Auth::check() and $user_id === Auth::user()->id): ?>
                    <a href="/photos/<?php echo e($photo['id']); ?>/edit" class="btn btn-primary" class="row justify-content-left">Edit<a>
                    <br><br>
                    <?php echo e(Form::open(['action'=>['Web\PhotoController@delete',$photo['id']],
                                'method'=>'delete',
                                'class'=>'pull-right',
                                'onsubmit' => 'return ConfirmDelete()'])); ?>

                        <?php echo e(Form::submit('Delete',['class'=>'btn btn-danger pull-right'])); ?>

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
                <?php endif; ?>
            </div>
        </div> 
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/photo/photopage.blade.php ENDPATH**/ ?>