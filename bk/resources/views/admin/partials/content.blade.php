<div class="form-group">
    <label for="{{ $name??'content' }}">{{ $label??'Nội dung' }}</label>
    <textarea id="{{ $name??'content' }}" name="{{ $name??'content' }}" rows="10" class="form-control">{!!$content??''!!}</textarea>
</div>
@push('scripts-footer')
<script type="text/javascript">
    editor('{{ $name??'content' }}');
</script>
@endpush
