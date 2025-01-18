<script>
var strip_key = '<?php echo e(config('services.stripe')['key']); ?>';
jQuery(document).ready(function($) {
    $('input[name="delivery"]:checked').parent().find('.ship-content').show();

    delivery($('input[name="delivery"]:checked').val());

    $('input[name="payment_method"]:checked').parent().find('.payment-content').show();
    $('input[name="payment_method"]:checked').closest('.payment-item').find('.select-include').show();

    $('input[name="payment_method"]').change(function(){
        $('input[name="bank_code"]').prop('checked', false);
        // getShipping('form-checkout');
        $('.select-include').hide();
        $('.payment-content').removeClass('active');
        $(this).closest('.payment-item').find('.payment-content').addClass('active');
        $(this).closest('.payment-item').find('.select-include').show();

    });

    var cart_total_text_data = $('.cart_total_text').attr('data'),
            cart_total_text = '';
    $('input[name="delivery"]').on('change', function(){

        $('.ship-content').hide();
        $(this).parent().find('.ship-content').show();
        var val = $(this).val();
        
        if(cart_total_text == '')
            cart_total_text = $('.cart_total_text').text();
        
        delivery(val);
    });

    function delivery(val) {
        $('.delivery_content').hide();
        $('.'+ val + '_content').show();

        if(val == 'pick_up'){
            $('.shipping').hide();

            $('.cart_total_text').html(cart_total_text_data);

            $('.get_shipping_cost').hide();
            $('.shipping_cost').text(0);
        }
        else{
            $('.shipping').show();
            $('.cart_total_text').html(cart_total_text);
            $('.get_shipping_cost').show();
            $('.shipping_cost').text('Calculated at next step');
        }
    }

    
    $(document).on('change', '.shipping-list input', function(){
        var price = $(this).val();
        var total = $('input[name="cart_total"]').data('origin');

        $('.shipping_cost').text('$' + price);
        $('input[name="shipping_cost"]').val(price);

        total = parseFloat(total) + parseFloat(price);
        $('.cart_total').text( '$' + total );
        $('input[name="cart_total"]').val( total );
    });
});
</script><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/scripts.blade.php ENDPATH**/ ?>