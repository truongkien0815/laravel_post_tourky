function getShipping(id='form-checkout') 
	{
   $('.submit-checkout').attr('disabled', true);
   var form = document.getElementById(id),
       fdnew = new FormData(form);
   axios({
       method: 'post',
       url: '/ghn/shipping-fee-review',
       data: fdnew
   }).then(res => {
       if(res.data.view != '')
       {
           $('.cart_total_text').html(res.data.cart_total);
           $('#shipping_cost').val(res.data.shipping_fee);
           $('.shipping-select').remove();
           $('.shipping').append(res.data.view);
           $('.shipping').css({display:'flex'});
           $('.submit-checkout').attr('disabled', false);
       }

   }).catch(e => console.log(e));
}

function getShippingCart(cart_id) 
{
   
   axios({
       method: 'get',
       url: '/ghn/shipping-fee-review/' + cart_id,
   }).then(res => {
      if(res.data.total_fee)
      {
         $('input[name="shipping_cost"]').val(res.data.total_fee);
      }

   }).catch(e => console.log(e));
}