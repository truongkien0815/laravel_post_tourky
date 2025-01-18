<?php extract($data); ?>



<?php $__env->startSection('seo'); ?>

<?php $__env->startSection('content'); ?>
 


<?php echo $__env->make($templatePath .'.product.product-discover', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make($templatePath .'.product.product-button-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- ***** List Product Starts ***** -->

            <?php echo $__env->make($templatePath .'.product.includes.product-list', ['products' => $products], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
<!-- ***** List Product Ends ***** -->

<!-- ***** Archive Starts ***** -->
<?php echo $__env->make($templateFile .'.blocks.archive', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- ***** Archive Ends ***** -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        jQuery(document).ready(function($) {
            $('.productFilterForm select').on('change', function(){
                $('.product-list-content .lds-ellipsis').show();
                getProductList();
            });

            $('.filter-reset').click(function(){
                // window.location.href = '<?php echo e(url()->current()); ?>'
                $('#productFilterForm select').val('');

                window.history.pushState('', '', '<?php echo e(url()->current()); ?>');
                getProductList();
            })

            function getProductList() {
                var form = document.getElementById('productFilterForm'),
                    fdnew = new FormData(form);
                axios({
                    method: "post",
                    url: $('#productFilterForm').prop("action"),
                    data: fdnew,
                })
                .then((res) => {
                    if (!res.data.error && res.data.view !='') {
                        $('.list-group-product').remove();
                        $('.product-list-content').append(res.data.view);
                    }
                    if(res.data.url)
                    {
                        window.history.pushState('', '', res.data.url);
                    }
                    $('.product-list-content .lds-ellipsis').hide();
                })
                .catch((e) => console.log(e));
            }

        });
    </script>   
<?php $__env->stopPush(); ?>
<?php echo $__env->make($templatePath .'.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/theme/product/product-category.blade.php ENDPATH**/ ?>