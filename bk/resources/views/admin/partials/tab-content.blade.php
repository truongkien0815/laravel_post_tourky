<div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
    <div class="form-group">
        <label for="post_title">Tiêu đề</label>
        <input type="text" class="form-control title_slugify" id="post_title" name="name" placeholder="Tiêu đề" value="{{ $name??'' }}">
    </div>
    <div class="form-group">
        <label for="post_slug">Slug</label>
        <input type="text" class="form-control slug_slugify" id="post_slug" name="slug" placeholder="Slug" value="{{ $slug??'' }}">
        @isset($id)
        <p>
            <b style="color: #0000cc;">Demo Link:</b> 
            <u><i><a  style="color: #F00;" href="{{ url($page_url_home??'javascript:;') }}" target="_blank">{{ url($page_url_home??'') }}</a></i></u>
        </p>
        @endisset
    </div>
    @if($description_show)
    <div class="form-group">
        <label for="post_description">Trích dẫn</label>
        <textarea id="post_description" name="description">{!! $description??'' !!}</textarea>
    </div>
    @endif
    @if($content_show)
    <div class="form-group">
        <label for="post_content">Nội dung</label>
        <textarea id="post_content" name="content">{!! $content??'' !!}</textarea>
    </div>
    @endif
</div>
<div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
    <div class="form-group">
        <label for="post_title_en">Title</label>
        <input type="text" class="form-control" id="post_title_en" name="name_en" placeholder="Title" value="{{$name_en??''}}">
    </div>
    <div class="form-group">
        <label for="post_description_en">Description</label>
        <textarea id="post_description_en" name="description_en">{!! $description_en??'' !!}</textarea>
    </div>
    @if($content_show)
    <div class="form-group">
        <label for="post_content_en">Content</label>
        <textarea id="post_content_en" name="content_en">{!! $content_en??'' !!}</textarea>
    </div>
    @endif
</div>