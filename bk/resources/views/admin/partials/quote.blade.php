<div class="form-group">
    <label for="description">Trích dẫn</label>
    <textarea id="{{ $name ?? 'description' }}" name="{{ $name ?? 'description' }}" class="form-control">{!!$description!!}</textarea>
</div>
@push('scripts-footer')
    <script type="text/javascript">
        editorQuote('{{ $name??'content' }}');
    </script>
@endpush