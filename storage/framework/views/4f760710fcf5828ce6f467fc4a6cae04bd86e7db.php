<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Album : <?php echo e($album_name); ?></div>
                <?php if(isset($error) and count($error)>0): ?>
                    <?php $__currentLoopData = $error; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k =>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class='alert alert-danger'>
                            <?php echo e($v[0]); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                    
                <?php endif; ?>
                <div class="card-body">
                <?php echo e(Form::open(['action'=>['Web\AlbumController@edit',$album_id],
                        'method'=>'PUT',
                        'files'=>true,
                        'enctype'=> "multipart/form-data"])); ?>

                
                <div class='form-group'>
                    <?php echo e(Form::label('album_name', 'Album Name')); ?>

                    <?php echo e(Form::text('album_name', '', ['class'=>'form-control', 'placeholder'=>'Enter Album Name'])); ?>

                </div>
                <div class='form-group'>
                    <?php echo e(Form::label('album_description', 'Album Description')); ?>

                    <?php echo e(Form::text('album_description', '', ['class'=>'form-control', 'placeholder'=>'Enter Album Description'])); ?>

                </div>
                <div class='form-group'>
                    <?php echo e(Form::label('privacy', 'Privacy')); ?>

                    <?php echo e(Form::select('privacy', ['1' => 'Public', '2'=>'Link Accessible', '3'=>'Private'])); ?>

                </div>
                <div class='form-group'>
                    <?php echo e(Form::label('cover_picture', 'Cover Picture')); ?>

                    <?php echo e(Form::file('cover_picture')); ?>

                </div>
                    <?php echo e(Form::submit('Submit',['class'=>'btn btn-primary'])); ?>

                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\photoz\resources\views/album/editalbum.blade.php ENDPATH**/ ?>