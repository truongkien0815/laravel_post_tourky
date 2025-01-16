<div class="card">
    <div class="card-header">
        <h5>Nổi bật</h5>
    </div> <!-- /.card-header -->
    <div class="card-body">
        <label for="hot">
            <input type="checkbox" class="category_item_input" name="hot" value="1" id="hot" {{ isset($hot) && $hot==1?'checked':'' }} />
            Tin nổi bật
        </label>
        <br/>
        <label for="trend">
            <input type="checkbox" class="category_item_input" name="trend" value="1" id="trend" {{ isset($trend) && $trend==1?'checked':'' }} />
            Xu hướng
        </label>
    </div> <!-- /.card-body -->
</div><!-- /.card -->