@php
    $points = (new App\Plugins\Cms\ProductReview\Models\PluginModel)->getPointProduct($product->id);
    $pathPlugin = (new App\Plugins\Cms\ProductReview\AppConfig)->pathPlugin;
@endphp
<script>
   jQuery(document).ready(function($) {
      $('.review-star .radio-group .star-item').hover(function(){
      var index = $(this).index();
      $('.review-star .radio-group .star-item').each(function(i){
         if(i <= index)
            $(this).find('label').addClass('active');
         else
            $(this).find('label').removeClass('active');
      })
    },
    function(){
      if($(this).find('input:checked').length <= 0) {
         $('.review-star .radio-group .star-item label').removeClass('active');
      }
   });
   });
   /*==============review============*/
      var form_review = $('#form-review'),
         min_char = 80;
      if(form_review.length > 0){
         $('textarea[name="comment"]').on('input', function(){
            var count = $(this).val().length,
               min_char = $(this).attr('data');
            console.log(min_char);
            $('.count-comment span').text($(this).val().length);
            if(count < min_char)
               $('.count-comment span').addClass('error');
            else
               $('.count-comment span').removeClass('error');
         })
         $('#button-review').click(function(){
         $('#form-review').submit();
      });

      //**************image review*************/
      function readURL(input) {
         if (input.files) {
            var index = $(".list_picture_rate .view_thumbnail").length+1;
            var html = '<div class="view_thumbnail">',
               html1 = '</div>';
            
            $.each(input.files, function(i, item){
               var reader = new FileReader();
               console.log(reader);
               reader.onload = function(e) {
                  $('.list_picture_rate').append(html+'<button data="'+i+'" data-name="'+item['name']+'" type="button" class="btn remove-pic-rate btn-xs" title="Xóa"><i class="fa fa-times"></i></button></i>'+'<img class="img'+i+'" src="'+e.target.result+'" alt="your image" height="80"/>'+html1);
               }
               reader.readAsDataURL(item);
            });
         }
      }
      
      $(document).on('change', '#picture_rate', function() {
         console.log(name);
         readURL(this);
      });

      $(document).on('click', 'button.remove-pic-rate', function(){
         $(this).parent().remove();
      });
      //**************image review*************/

       form_review.validate({
           onfocusout: false,
           onkeyup: false,
           onclick: false,
           rules: {
             name: {
                   required: true,
               },
               phone: {
                   required: true,
               },
               comment: {
                   required: true,
                   minlength: min_char
               },
               point: {
                   required: true,
               },
               
           },
           messages: {
               "phone": {
                   required: "Vui lòng nhập số điện thoại.",
               },
                "name": {
                   required: "Vui lòng nhập Họ Tên",
               },
                "comment": {
                   required: "Vui lòng nhập Nội dung",
                   minlength: "Nội dung ít nhất "+ min_char +" ký tự",
               },
                "point": {
                   required: "Vui lòng chọn",
               },
           },
           errorElement: "span",
           errorPlacement: function errorPlacement(error, element) {
               error.addClass("invalid-feedback");
               element.closest(".form-group").append(error);
           },
           highlight: function highlight(element, errorClass, validClass) {
               $(element).addClass("is-invalid");
           },
           unhighlight: function unhighlight(element, errorClass, validClass) {
               $(element).removeClass("is-invalid");
           },
           submitHandler: function submitHandler(form) {
               form_review.find('.list-content-loading').show();

               var form_ = document.getElementById('form-review');
               var fdnew = new FormData(form_);

               const config = { headers: { 'Content-Type': 'multipart/form-data' } };
               axios.post(form_review.prop("action"), fdnew, config).then(res => {
                  if (res.data.error == 0) {
                      $('#reviewModal').modal('hide');
                      alertJs('success', res.data.msg);
                  } else {
                      $("#msg_div").removeClass("d-none");
                      alertJs('success', res.data.msg);
                  }
                  form_review.find('.list-content-loading').hide();
               });
           }
       });
     }
      /*==============end review============*/
</script>