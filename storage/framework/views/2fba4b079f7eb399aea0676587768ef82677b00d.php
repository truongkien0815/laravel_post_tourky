<script type="text/javascript">
	jQuery(function($){
		$('#seo_title').bind('input keyup keydown keypress', function(){
			var charCount1 = $(this).val().replace(/\s/g, '').length;
			$("#char_title").text(charCount1);
		});
		$('#seo_keyword').bind('input keyup keydown keypress', function(){
			var charCount2 = $(this).val().replace(/\s/g, '').length;
			$("#char_keyword").text(charCount2);
		});
		$('#seo_description').bind('input keyup keydown keypress', function(){
			var charCount3 = $(this).val().replace(/\s/g, '').length;
			$("#char_description").text(charCount3);
		});
	});
</script>
<!-- SEO Title-->
<div class="form-group">
	<label for="seo_title">SEO Title</label>
	<input type="text" id="seo_title" name="seo_title" class="form-control" value="<?php echo e($seo_title ?? ''); ?>">
	<div class="clear pd_lender" style="font-size:14px; color:#060;"><span id="char_title" style="color:#F00; font-weight:bold;"></span> character, Max <b>70</b> characters</div>
</div>

<!-- SEO Keyword-->
<div class="form-group">
	<label for="seo_keyword">SEO Keyword</label>
	<input type="text" id="seo_keyword" name="seo_keyword" class="form-control" value="<?php echo e($seo_keyword ?? ''); ?>">
	<div class="clear pd_lender" style="font-size:14px;color:#060;"><span id="char_keyword" style="color:#F00; font-weight:bold;"></span> character</div>
</div>

<!-- SEO Description-->
<div class="form-group">
	<label for="seo_description">SEO Description</label>
	<textarea id="seo_description" name="seo_description" class="form-control" rows="2"><?php echo e($seo_description ?? ''); ?></textarea>
	<div class="clear pd_lender"  style="font-size:14px;color:#060;"><span id="char_description" style="color:#F00; font-weight:bold;"></span> character, Max <b>150-160</b> characters</div>
</div><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/admin/form-seo/seo.blade.php ENDPATH**/ ?>