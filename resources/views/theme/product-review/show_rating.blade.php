<div class="reviews">
   <div class="ratings">
      @for ($i = 1;  $i <= $point; $i++)
         <span class="fa fa-star checked"></span>
      @endfor
      @for ($k = 1;  $k <= (5 - $point); $k++)
         <span class="fa fa-star"></span>
      @endfor
   </div>
   <!-- <a href="javascript:;" class="total-review">({{ $rating_count ?? 0 }}) <span>Đánh giá</span></a> -->
   <span>({{ $rating_count ?? 0 }})</span>
   <a href="javascript:;" class="write_comment">Viết đánh giá</a>
</div>