@if(!empty($data['category_id']))
    @php
        $category = \App\Model\Category::find($data['category_id']);
        if($category)
            $posts = (new \App\News)->setCategory($data['category_id'])->getList([
                'sort_order'    => 'created_at__desc',
                'limit' => $data['limit']??3
            ])

    @endphp
    @if(!empty($posts))
    <div class="news-block py-5">
        <div class="container">
            <div class="title-box">
                <div class="section-heading">
                    <h5>{{ $category->name }}</h5>
                </div>
                <a href="{{ route('news.single', $category->slug) }}">Xem thêm</a>
            </div>
            <div class="news-slider owl-carousel">
                @foreach($posts as $post)
                    @include($templatePath . '.news.includes.post-item', compact('post'))
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endif