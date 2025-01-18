<?php $__env->startSection('seo'); ?>
  <?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $id = empty($id) ? 0 : $id;
?>
<section class="content">
    <div class="container-fluid pt-3">
<div class="row">

  <div class="col-md-6">

    <div class="card">
      <div class="card-header with-border">
        <h3 class="card-title">
          <h3>
            <a class="btn btn-warning btn-flat menu-sort-save" title="Save"><i class="fa fa-save"></i><span class="hidden-xs">&nbsp;Save</span></a>
          </h3>
        </h3>
      </div>

<div class="card-body p-0">
  <div class="box-body table-responsive">
  <div class="dd" id="menu-sort">
      <ol class="dd-list">
<?php
  $menus = \App\Model\AdminMenu::getListAll()->groupBy('parent_id');
  //dd($menus);
?>

        <?php $__currentLoopData = $menus[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level0): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($level0->type ==1): ?>
            <li class="dd-item " data-id="<?php echo e($level0->id); ?>">
                <div class="dd-handle header-fix  <?php echo e(($level0->id == $id)? 'active-item' : ''); ?>">
                  <?php echo __($level0->title); ?>

                  <span class="float-right dd-nodrag">
                      <a href="<?php echo e(route('admin_menu.edit',['id'=>$level0->id])); ?>"><i class="fa fa-edit"></i></a>
                      &nbsp; 
                      <a data-id="<?php echo e($level0->id); ?>" class="remove_menu"><i class="fa fa-trash"></i></a>
                  </span>
                </div>
            </li>
          <?php elseif($level0->uri): ?>
            <li class="dd-item" data-id="<?php echo e($level0->id); ?>">
                <div class="dd-handle <?php echo e(($level0->id == $id)? 'active-item' : ''); ?>">
                  <i class="<?php echo e($level0->icon); ?>"></i> <?php echo __($level0->title); ?>

                  <span class="float-right dd-nodrag">
                      <a href="<?php echo e(route('admin_menu.edit',['id'=>$level0->id])); ?>"><i class="fa fa-edit fa-edit"></i></a>
                      &nbsp; 
                      <a data-id="<?php echo e($level0->id); ?>" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                  </span>
                </div>
            </li>
          <?php else: ?>
            <li class="dd-item " data-id="<?php echo e($level0->id); ?>">
              <div class="dd-handle <?php echo e(($level0->id == $id)? 'active-item' : ''); ?>">
                <i class="<?php echo e($level0->icon); ?>"></i> <?php echo __($level0->title); ?>

                  <span class="float-right dd-nodrag">
                      <a href="<?php echo e(route('admin_menu.edit',['id'=>$level0->id])); ?>"><i class="fa fa-edit fa-edit"></i></a>
                      &nbsp; 
                      <a data-id="<?php echo e($level0->id); ?>" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                  </span>
              </div>
    
            <?php if(isset($menus[$level0->id]) && count($menus[$level0->id])): ?>
              <ol class="dd-list">
                <?php $__currentLoopData = $menus[$level0->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($level1->uri): ?>
                    <li class="dd-item" data-id="<?php echo e($level1->id); ?>">
                        <div class="dd-handle <?php echo e(($level1->id == $id)? 'active-item' : ''); ?>">
                          <i class="<?php echo e($level1->icon); ?>"></i> <?php echo __($level1->title); ?>

                          <span class="float-right dd-nodrag">
                              <a href="<?php echo e(route('admin_menu.edit',['id'=>$level1->id])); ?>"><i class="fa fa-edit fa-edit"></i></a>
                              &nbsp; 
                              <a data-id="<?php echo e($level1->id); ?>" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                          </span>
                        </div>
                    </li>
                  <?php else: ?>
                  <li class="dd-item" data-id="<?php echo e($level1->id); ?>">
                    <div class="dd-handle <?php echo e(($level1->id == $id)? 'active-item' : ''); ?>">
                      <i class="<?php echo e($level1->icon); ?>"></i> <?php echo __($level1->title); ?>

                      <span class="float-right dd-nodrag">
                          <a href="<?php echo e(route('admin_menu.edit',['id'=>$level1->id])); ?>"><i class="fa fa-edit fa-edit"></i></a>
                          &nbsp; 
                          <a data-id="<?php echo e($level1->id); ?>" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                      </span>
                    </div>
            
                        <?php if(isset($menus[$level1->id]) && count($menus[$level1->id])): ?>
                          <ol class="dd-list dd-collapsed">
                            <?php $__currentLoopData = $menus[$level1->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if($level2->uri): ?>
                                <li class="dd-item" data-id="<?php echo e($level2->id); ?>">
                                    <div class="dd-handle <?php echo e(($level2->id == $id)? 'active-item' : ''); ?>">
                                      <i class="<?php echo e($level2->icon); ?>"></i> <?php echo __($level2->title); ?>

                                      <span class="float-right dd-nodrag">
                                          <a href="<?php echo e(route('admin_menu.edit',['id'=>$level2->id])); ?>"><i class="fa fa-edit fa-edit"></i></a>
                                          &nbsp; 
                                          <a data-id="<?php echo e($level2->id); ?>" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                                      </span>
                                    </div>
                                </li>
                              <?php else: ?>
                              <li class="dd-item" data-id="<?php echo e($level2->id); ?>">
                                <div class="dd-handle <?php echo e(($level2->id == $id)? 'active-item' : ''); ?>">
                                  <i class="<?php echo e($level2->icon); ?>"></i> <?php echo __($level2->title); ?>

                                  <span class="float-right dd-nodrag">
                                      <a href="<?php echo e(route('admin_menu.edit',['id'=>$level2->id])); ?>"><i class="fa fa-edit fa-edit"></i></a>
                                      &nbsp; 
                                      <a data-id="<?php echo e($level2->id); ?>" class="remove_menu"><i class="fa fa-trash fa-edit"></i></a>
                                  </span>
                                </li>
                              <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </ol>
                        <?php endif; ?>
                        
                    </li>
                  <?php endif; ?>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ol>
            <?php endif; ?>
              
            </li>
          <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      
      
    </ol>
</div>

      </div>
    </div>
    </div>
  </div>

  <div class="col-md-6">

    <div class="card">   
              <div class="card-header with-border">
                <h3><?php echo $title_head; ?></h3>
                <?php if($layout == 'edit'): ?>
                <div class="card-tools">
                    <div class="btn-group float-right" style="margin-right: 5px">
                        <a href="<?php echo e(route('admin_menu.index')); ?>" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> <?php echo e(__('admin.back_list')); ?></span></a>
                    </div>
                </div>
                <?php endif; ?>
              </div>
   
                <form action="<?php echo e($url_action); ?>" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">

                    <div class="card-body">

                      <div class="form-group row <?php echo e($errors->has('parent_id') ? ' text-red' : ''); ?>">
                        <label for="parent_id" class="col-sm-2 col-form-label">Parent</label>
                        <div class="col-sm-10 ">
                          <select class="form-control parent mb-3" name="parent_id" >
                            <option value=""></option>
                            <option value="0" <?php echo e((old('parent',$menu['parent']??'') ==0) ? 'selected':''); ?>>== ROOT ==</option>
                            <?php $__currentLoopData = $treeMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k); ?>" <?php echo e((old('parent',$menu['parent_id']??'') ==$k) ? 'selected':''); ?>><?php echo $v; ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
            
                          <?php if($errors->has('parent_id')): ?>
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> <?php echo e($errors->first('parent_id')); ?>

                          </span>
                          <?php endif; ?>
            
                        </div>
                      </div>

                      <div class="form-group row <?php echo e($errors->has('title') ? ' text-red' : ''); ?>">
                        <label for="title" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10 ">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            </div>
                            <input type="text" id="title" name="title" value="<?php echo old()?old('title'):$menu['title']??''; ?>" class="form-control title <?php echo e($errors->has('title') ? ' is-invalid' : ''); ?>">
                          </div>
            
                          <?php if($errors->has('title')): ?>
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> <?php echo e($errors->first('title')); ?>

                          </span>
                          <?php endif; ?>
            
                        </div>
                      </div>

                      <div class="form-group row <?php echo e($errors->has('icon') ? ' text-red' : ''); ?>">
                        <label for="icon" class="col-sm-2 col-form-label">Icon</label>
                        <div class="col-sm-10 ">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="fas fa-pencil-alt"></i>
                              </span>
                            </div>
                            <input required="1" style="width: 140px" type="text" id="icon" name="icon" value="<?php echo old()?old('icon'):$menu['icon']??'fas fa-bars'; ?>" class="form-control icon <?php echo e($errors->has('icon') ? ' is-invalid' : ''); ?> " placeholder="Input Icon">
                          </div>
                          
            
                          <?php if($errors->has('icon')): ?>
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> <?php echo e($errors->first('icon')); ?>

                          </span>
                          <?php endif; ?>
            
                        </div>
                      </div>

                      <div class="form-group row <?php echo e($errors->has('uri') ? ' text-red' : ''); ?>">
                        <label for="uri" class="col-sm-2 col-form-label">Url</label>
                        <div class="col-sm-10 ">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            </div>
                            <input type="text" id="uri" name="uri" value="<?php echo old()?old('uri'):$menu['uri']??''; ?>" class="form-control uri <?php echo e($errors->has('uri') ? ' is-invalid' : ''); ?>" placeholder="Input uri">
                          </div>
            
                          <?php if($errors->has('uri')): ?>
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> <?php echo e($errors->first('uri')); ?>

                          </span>
                          <?php endif; ?>
            
                        </div>
                      </div>

                      <div class="form-group row <?php echo e($errors->has('sort') ? ' text-red' : ''); ?>">
                        <label for="sort" class="col-sm-2 col-form-label">Sort</label>
                        <div class="col-sm-10 ">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                            </div>
                            <input type="number" style="width: 100px;" id="sort" name="sort" value="<?php echo old()?old('sort'):$menu['sort']??''; ?>" class="form-control sort <?php echo e($errors->has('sort') ? ' is-invalid' : ''); ?>" placeholder="Input sort">
                          </div>
            
                          <?php if($errors->has('sort')): ?>
                          <span class="text-sm">
                            <i class="fa fa-info-circle"></i> <?php echo e($errors->first('sort')); ?>

                          </span>
                          <?php endif; ?>
            
                        </div>
                      </div>

                      <div class="form-group row <?php echo e($errors->has('sort') ? ' text-red' : ''); ?>">
                        <label for="sort" class="col-sm-2 col-form-label">Ẩn menu</label>
                        <div class="col-sm-10 ">
                          <div class="custom-control custom-checkbox">
                            <?php
                              $hidden = $menu['hidden'] ?? 0;
                            ?>
                            <input type="checkbox" name="hidden" class="custom-control-input" id="customCheck_show" value="1" <?php echo e($hidden == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label" for="customCheck_show">Ẩn menu</label>
                          </div>
          
            
                        </div>
                      </div>

                    </div>

                    <!-- /.card-body -->

                    <div class="card-footer row">
                            <?php echo csrf_field(); ?>
                        <div class="col-md-2">
                        </div>

                        <div class="col-md-8">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                            <div class="btn-group float-left">
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-footer -->

                      </form>

    </div>
  </div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('styles'); ?>
<!-- Ediable -->
<link rel="stylesheet" href="<?php echo e(asset('assets/plugin/sweetalert2/sweetalert2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/plugin/nestable/jquery.nestable.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/plugin/iconpicker/fontawesome-iconpicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Ediable -->

<script src="<?php echo e(asset('assets/plugin/sweetalert2/sweetalert2.all.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugin/nestable/jquery.nestable.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugin/iconpicker/fontawesome-iconpicker.min.js')); ?>"></script>

<script type="text/javascript">
$('.remove_menu').click(function(event) {
  var id = $(this).data('id');
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  })

  swalWithBootstrapButtons.fire({
    title: '<?php echo e(__('action.delete_confirm')); ?>',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '<?php echo e(__('action.confirm_yes')); ?>',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '<?php echo e(__('action.confirm_no')); ?>',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '<?php echo e($urlDeleteItem ?? ''); ?>',
                data: {
                  id:id,
                    _token: '<?php echo e(csrf_token()); ?>',
                },
                success: function (data) {
                    if(data.error == 1){
                      alertMsg('error', 'Cancelled', data.msg);
                      return;
                    }else{
                      alertMsg('success', 'Success');
                      window.location.replace('<?php echo e(route('admin_menu.index')); ?>');
                    }

                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '<?php echo e(__('action.delete_confirm_deleted_msg')); ?>', '<?php echo e(__('action.delete_confirm_deleted')); ?>');
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })

});


$('#menu-sort').nestable();
$('.menu-sort-save').click(function () {
    $('#loading').show();
    var serialize = $('#menu-sort').nestable('serialize');
    var menu = JSON.stringify(serialize);
    $.ajax({
      url: '<?php echo e(route('admin_menu.update_sort')); ?>',
      type: 'POST',
      dataType: 'json',
      data: {
        _token: '<?php echo e(csrf_token()); ?>',
        menu: menu
      },
    })
    .done(function(data) {
      $('#loading').hide();
      if(data.error == 0){
        location.reload();
      }else{
        alertMsg('error', data.msg, 'Cancelled');
      }
      //console.log(data);
    });
});


$(document).ready(function() {
    $('.active-item').parents('li').removeClass('dd-collapsed');
      //icon picker
    $('.icon').iconpicker({placement:'bottomLeft', animation: false});
});

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/admin/menu-admin.blade.php ENDPATH**/ ?>