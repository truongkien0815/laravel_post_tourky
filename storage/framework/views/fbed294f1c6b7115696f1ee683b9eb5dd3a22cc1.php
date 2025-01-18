<?php
  $variables = \App\ShopVariable::where('status', 1)->orderByDesc('created_at')->limit(20)->get();
  $types = (new \App\Model\ShopType)->where('status', 1)->limit(20)->get();
?>



<?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/product-filter-form.blade.php ENDPATH**/ ?>