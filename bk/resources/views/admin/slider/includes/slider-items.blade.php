
@foreach($sliders as $slider)
	<div class="slider-item slider-{{ $slider->id }} form-group row mb-2 pb-2 border-bottom">
		<input type="hidden" name="slider[]" value="{{ $slider->id }}">
		<div class="col-md-2 d-flex align-items-center">
			<div class="icon_change_postion mr-2"><i class="fa fa-sort"></i></div>
			<img src="{{ asset($slider->src) }}" alt="" style="height: 50px;">
		</div>
		<div class="col-md-3">
			{{ $slider->name }}
		</div>
		<div class="col-md-3">
			{{ $slider->link }}
		</div>
		<div class="col-md-2">
			@if($slider->type == 'mobile')
				<span class="badge badge-info">{{ $slider->type }}</span>
			@else
				<span class="badge badge-primary">{{ $slider->type }}</span>
			@endif
		</div>
		<div class="col-md-2 d-flex align-items-center">
			<button type="button" class="btn btn-sm btn-info edit-slider" data="{{ $slider->id }}" data-parent="{{ $slider->slider_id }}">Edit</button>
			<button type="button" class="btn btn-sm btn-danger delete-slider ml-2" data="{{ $slider->id }}">Delete</button>
		</div>
	</div>
@endforeach