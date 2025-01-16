@php
    if(isset($slider))
        extract($slider->toArray());

    $type = $type??'';
@endphp

<form id="form-editSlider" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{ $id??0 }}">
    <input type="hidden" name="slider_id" value="{{ $parent??0 }}">
    <div class="form-group">
        <label for="name">Tên</label>
        <input type="text" class="form-control" id="name"  name="name" value="{{ $name??'' }}">
    </div>
    <div class="form-group">
        <label for="link">Link</label>
        <input type="text" class="form-control" name="link" value="{{ $link??'' }}">
    </div>
    <div class="form-group">
        <label for="order">Device</label>
        <select name="type" class="form-control">
            <option value="desktop">Desktop</option>
            <option value="mobile" {{ $type=='mobile'?'selected' : '' }}>Mobile</option>
        </select>
    </div>
    <div class="form-group">
        <label for="order">STT</label>
        <input id="order" type="text" name="order" class="form-control" value="{{ $order??'' }}">
    </div>
    <div class="form-group">
        <div class="inserIMG">
            <input type="hidden" name="src" id="src-img" value="{{ $src ?? '' }}">
            @if(isset($src) && $src!='')
                <img src="{{ asset($slider->src) }}" id="show-img" class="show-img src-img ckfinder-popup" data-show="show-img" data="src-img" width="200" onerror="this.onerror=null;this.src='{{ asset('assets/images/placeholder.png') }}';">
            @else
                <img src="{{ asset('assets/images/placeholder.png') }}" id="show-img" class="show-img src-img ckfinder-popup" data-show="show-img" data="src-img" width="200">
            @endif
            <span class="remove-icon" data-img="{{ asset('assets/images/placeholder.png') }}">X</span>
        </div>
    </div>
    <div class="form-group">
        <textarea name="description" id="description" class="form-control">{!! $description??'' !!}</textarea>
    </div>
</form>