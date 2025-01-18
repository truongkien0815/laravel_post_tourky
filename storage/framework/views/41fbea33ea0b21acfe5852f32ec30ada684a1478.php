<?php $__env->startSection('seo'); ?>
<?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="bg-white p-3">
         <?php if(!$order): ?>
         <div class="text-danger">
            <?php echo e(sc_language_render('front.data_notfound')); ?>

         </div>
         <?php else: ?>
         <div class="row" id="order-body">
            <div class="col-sm-6">
               <table class="table table-bordered">
                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.first_name')); ?>:</td><td><a href="#" class="updateInfoRequired" data-name="first_name" data-type="text" data-pk="<?php echo e($order->id); ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.first_name')); ?>" ><?php echo $order->first_name; ?></a></td>
                  </tr>

                  <?php if(sc_config_admin('customer_lastname')): ?>
                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.last_name')); ?>:</td><td><a href="#" class="updateInfoRequired" data-name="last_name" data-type="text" data-pk="<?php echo e($order->id); ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.last_name')); ?>" ><?php echo $order->last_name; ?></a></td>
                  </tr>
                  <?php endif; ?>

                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.phone')); ?>:</td>
                     <td>
                        <a href="#" class="updateInfoRequired" data-name="phone" data-type="text" data-pk="<?php echo e($order->id); ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.phone')); ?>" ><?php echo $order->phone; ?></a>
                     </td>
                  </tr>

                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.email')); ?>:</td><td><?php echo empty($order->email)?'N/A':$order->email; ?></td>
                  </tr>

                  <?php if(sc_config_admin('customer_company')): ?>
                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.company')); ?>:</td><td><a href="#" class="updateInfoRequired" data-name="company" data-type="text" data-pk="<?php echo e($order->id); ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.company')); ?>" ><?php echo $order->company; ?></a></td>
                  </tr>
                  <?php endif; ?>

                  <?php if(sc_config_admin('customer_postcode')): ?>
                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.postcode')); ?>:</td><td><a href="#" class="updateInfoRequired" data-name="postcode" data-type="text" data-pk="<?php echo e($order->id); ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.postcode')); ?>" ><?php echo $order->postcode; ?></a></td>
                  </tr>
                  <?php endif; ?>


                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.address1')); ?>:</td>
                     <td>
                        <a href="#" class="updateLocation" data-name="address1" data-type="select" 
                           data-source ="<?php echo e(json_encode($provinces)); ?>" 
                           data-pk="<?php echo e($order->id); ?>" 
                           data-value="<?php echo $order->address1; ?>" 
                           data-url="<?php echo e(route("admin_order.update")); ?>" 
                           data-title="<?php echo e($order->address1); ?>">
                           <?php echo e($order->address1); ?>

                        </a>
                     </td>
                  </tr>

                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.address2')); ?>:</td>
                     <td>
                        <a href="#" class="updateLocation district_change" data-name="address2" data-type="select" 
                           data-source ="<?php echo e(json_encode($districts)); ?>" 
                           data-pk="<?php echo e($order->id); ?>" 
                           data-value="<?php echo $order->address2; ?>" 
                           data-url="<?php echo e(route("admin_order.update")); ?>" 
                           data-title="<?php echo e($order->address2); ?>">
                           <?php echo e($order->address2??'Chọn Quận/huyện'); ?>

                        </a>
                     </td>
                  </tr>
                  <tr>
                     <td class="td-title"><?php echo e(sc_language_render('order.address3')); ?>:</td>
                     <td>
                        <a href="#" class="updateInfoRequired" data-name="address3" data-type="text" data-pk="<?php echo e($order->id); ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.address3')); ?>" ><?php echo $order->address3; ?></a>
                     </td>
                  </tr>
               </table>
            </div>
            <div class="col-sm-6">
               <table  class="table table-bordered">
                  <tr>
                     <td  class="td-title"><?php echo e(sc_language_render('order.order_status')); ?>:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="status" data-type="select" data-source ="<?php echo e(json_encode($statusOrder)); ?>"  data-pk="<?php echo e($order->id); ?>" data-value="<?php echo $order->status; ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.order_status')); ?>"><?php echo e($statusOrder[$order->status] ?? $order->status); ?></a>
                     </td>
                  </tr>
                  <tr>
                     <td><?php echo e(sc_language_render('order.shipping_status')); ?>:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="shipping_status" data-type="select" data-source ="<?php echo e(json_encode($statusShipping)); ?>"  data-pk="<?php echo e($order->id); ?>" data-value="<?php echo $order->shipping_status; ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.shipping_status')); ?>"><?php echo e($statusShipping[$order->shipping_status]??$order->shipping_status); ?></a>
                     </td>
                  </tr>
                  <tr>
                     <td><?php echo e(sc_language_render('order.payment_status')); ?>:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="payment_status" data-type="select" data-source ="<?php echo e(json_encode($statusPayment)); ?>"  data-pk="<?php echo e($order->id); ?>" data-value="<?php echo $order->payment_status; ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.payment_status')); ?>"><?php echo e($statusPayment[$order->payment_status]??$order->payment_status); ?></a>
                     </td>
                  </tr>
                  <?php if($order->getShippingOrder): ?>
                  <tr>
                     <td><?php echo e(sc_language_render('order.shipping_method')); ?>:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="shipping_method" data-type="select" data-source ="<?php echo e(json_encode($shippingMethod)); ?>"  data-pk="<?php echo e($order->id); ?>" data-value="<?php echo $order->shipping_method; ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.shipping_method')); ?>"><?php echo e($order->getShippingOrder->name); ?></a>
                     </td>
                  </tr>
                  <?php endif; ?>
                  <tr>
                     <td><?php echo e(sc_language_render('order.payment_method')); ?>:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="payment_method" data-type="select" data-source ="<?php echo e(json_encode($paymentMethod)); ?>"  data-pk="<?php echo e($order->id); ?>" data-value="<?php echo $order->payment_method; ?>" data-url="<?php echo e(route("admin_order.update")); ?>" data-title="<?php echo e(sc_language_render('order.payment_method')); ?>"><?php echo e($order->getPaymentMethodOrder->name??''); ?></a>
                     </td>
                  </tr>
                  <tr>
                     <td><?php echo e(sc_language_render('order.domain')); ?>:</td>
                     <td><?php echo e($order->domain); ?></td></tr>
                  <tr>
                     <td></i> <?php echo e(sc_language_render('admin.created_at')); ?>:</td>
                     <td><?php echo e($order->created_at); ?></td></tr>
               </table>
               </div>
            </div>

                    <div class="row">
                       <div class="col-sm-12">
                          <div class="box collapsed-box">
                             <div class="table-responsive">
                                <table class="table table-bordered">
                                   <thead>
                                      <tr>
                                         <th><?php echo e(sc_language_render('product.name')); ?></th>
                                         <th><?php echo e(sc_language_render('product.sku')); ?></th>
                                         <th class="product_price"><?php echo e(sc_language_render('product.price')); ?></th>
                                         <th class="product_qty"><?php echo e(sc_language_render('product.quantity')); ?></th>
                                         <th class="product_total"><?php echo e(sc_language_render('order.totals.sub_total')); ?></th>
                                         <th class="product_tax"><?php echo e(sc_language_render('product.tax')); ?></th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                         <td><?php echo e($item->name); ?>

                                            
                                         </td>
                                         <td><?php echo e($item->sku); ?></td>
                                         <td class="product_price"><?php echo e($item->price); ?></td>
                                         <td class="product_qty">x  <?php echo e($item->qty); ?></td>
                                         <td class="product_total item_id_<?php echo e($item->id); ?>"><?php echo e(sc_currency_render_symbol($item->total_price,$order->currency)); ?></td>
                                         <td class="product_tax"><?php echo e($item->tax); ?></td>
                                      </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   </tbody>
                                </table>
                             </div>
                          </div>
                       </div>
                    </div>
                    <?php
                    $dataTotal = \App\Model\ShopOrderTotal::where('order_id',$order->id)->get();
                    ?>
                    <div class="row">
                       <div class="col-md-12">
                          <div class="box collapsed-box">
                             <table   class="table table-bordered">

                                <?php $__currentLoopData = $dataTotal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <?php if($element['value'] != 0): ?>
                                      <?php if($element['code'] =='subtotal'): ?>
                                         <tr>
                                            <td  class="td-title-normal"><?php echo $element['title']; ?>:</td>
                                            <td style="text-align:right" class="data-<?php echo e($element['code']); ?>"><?php echo e(sc_currency_format($element['value'])); ?></td>
                                         </tr>
                                      <?php endif; ?>
                                      <?php if($element['code'] =='tax'): ?>
                                      <tr>
                                         <td  class="td-title-normal"><?php echo $element['title']; ?>:</td>
                                         <td style="text-align:right" class="data-<?php echo e($element['code']); ?>"><?php echo e(sc_currency_format($element['value'])); ?></td>
                                      </tr>
                                      <?php endif; ?>
                                      <?php if($element['code'] =='shipping'): ?>
                                      <tr>
                                         <td><?php echo $element['title']; ?>:</td>
                                         <td style="text-align:right"><?php echo e(sc_currency_format($element['value'])); ?></td>
                                      </tr>
                                      <?php endif; ?>
                                      <?php if($element['code'] =='discount'): ?>
                                      <tr>
                                         <td><?php echo htmlspecialchars_decode($element['title']); ?>(-):</td>
                                         <td style="text-align:right"><?php echo e(sc_currency_format($element['value'])); ?></td>
                                      </tr>
                                      <?php endif; ?>
                                      <?php if($element['code'] =='total'): ?>
                                      <tr style="background:#f5f3f3;font-weight: bold;">
                                         <td><?php echo $element['title']; ?>:</td>
                                         <td style="text-align:right" class="data-<?php echo e($element['code']); ?>"><?php echo e(sc_currency_format($element['value'])); ?></td>
                                      </tr>
                                      <?php endif; ?>
                                      <?php if($element['code'] =='received'): ?>
                                      <tr>
                                         <td><?php echo $element['title']; ?>(-):</td>
                                         <td style="text-align:right"><?php echo e(sc_currency_format($element['value'])); ?></td>
                                      </tr>
                                      <?php endif; ?>
                                   <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr class="data-balance">
                                   <td><?php echo e(sc_language_render('order.totals.balance')); ?>:</td>
                                   <td style="text-align:right"><?php echo e(sc_currency_format($order->balance)); ?></td>
                                </tr>
                             </table>
                          </div>
                       </div>
                    </div>
                    <?php endif; ?>
                </div>
   </div> <!-- /.container-fluid -->
</section>
<script>
   $(function () {
    editorQuote('admin_note');
   })
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
   <link rel="stylesheet" href="<?php echo e(asset('assets/plugin/bootstrap-editable.css')); ?>">
   <style type="text/css" media="screen">
      .shipping_log .active{
         color: #2784f7;
      }
   </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<!-- Ediable -->
<script src="<?php echo e(asset('assets/plugin/bootstrap-editable.min.js')); ?>"></script>

<script src="<?php echo e(asset('/js/ghn.js?ver='. time())); ?>"></script>
<script>
   jQuery(document).ready(function($) {
      const showLoading = function() {
         Swal.fire({
            title: 'Đang xử lý',
             allowEscapeKey: false,
             allowOutsideClick: false,
             timer: 15000,
             didOpen: () => {
               swal.showLoading();
             }
         })
         .then(
          () => {},
          (dismiss) => {
            if (dismiss === 'timer') {
              console.log('closed by timer!!!!');
              swal({ 
                title: 'Finished!',
                type: 'success',
                timer: 2000,
                showConfirmButton: false
              })
            }
          }
         )
      };
      $('#shipping_create_order').click(function(event) {
         Swal.fire({
            title: "TẠO ĐƠN VẬN CHUYỂN GHN",
            text: 'Bạn có chắc tạo đơn vận chuyển với đơn vị vận chuyển GHN',
            showCancelButton: true,
            confirmButtonText: 'Xác nhận',
            imageUrl: '<?php echo e(asset("assets/images/ghn-icon.png")); ?>',
            imageHeight: 50
         }).then((result) => {
            
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
               showLoading();
               var form = document.getElementById('frm-order-detail'),
                   fdnew = new FormData(form);
               axios({
                   method: 'post',
                   url: '<?php echo e(route("ghn.create_order")); ?>',
                   data: fdnew
               }).then(res => {
                  if(res.data.error==0)
                  {
                     $('#shipping_create_order').remove();
                     Swal.fire('Tạo đơn hàng thành công', '', 'success');
                  }
                  else
                     Swal.fire(res.data.message, '', 'error');
   
               }).catch(e => console.log(e));
   
            }
         })
      });
   
      //shipping 
      $('select[name="shipping_company"]').change(function(){
         var cart_id = $('input[name="cart_id"]').val(),
            company = $(this).val();

         $('#shipping_create_order').hide();
         if(company == 'ghn')
         {
            $('#shipping_create_order').show();
            getShippingCart(cart_id);
         }
      });
      //shipping 

      $.fn.editable.defaults.params = function (params) {
        params._token = "<?php echo e(csrf_token()); ?>";
        return params;
      };
      $('.updateLocation').editable({
         validate: function(value) {
            if (value == '') {
               return 'Not empty';
            }
         },
         success: function(response) {
            if(response.error ==0){
                if(response.data)
                {
                  if(typeof(response.data.districts) != 'undefined')
                  {
                     $('.district_change').editable('setValue', null).editable("option", "source", JSON.stringify(response.data.districts));
                     $('.district_change').editable("enable");
                  }
                  if(typeof(response.data.wards) != 'undefined')
                  {
                     $('.ward_change').editable('setValue', null).editable("option", "source", JSON.stringify(response.data.wards));
                     $('.ward_change').editable("enable");
                  }
               }
               alertJs('success', response.msg);
            } else {
               alertJs('error', response.msg);
            }
         }
      });

      $('.updateStatus').editable({
         validate: function(value) {
            if (value == '') {
               return '<?php echo e(sc_language_render('admin.not_empty')); ?>';
            }
         },
         success: function(response) {
            if(response.error ==0){
               alertJs('success', response.msg);
            } else {
               alertJs('error', response.msg);
            }
         }
      });

      $('.updateInfoRequired').editable({
         validate: function(value) {
            if (value == '') {
                return 'Not empty';
            }
         },
         success: function(response,newValue) {
            console.log(response.msg);
            if(response.error == 0){
               alertJs('success', response.msg);
            } else {
               alertJs('error', response.msg);
            }
         }
      });
   });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/orders/single.blade.php ENDPATH**/ ?>