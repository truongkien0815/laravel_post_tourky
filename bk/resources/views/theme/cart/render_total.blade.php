@if (!empty($dataTotal) && count($dataTotal))
<div id="showTotal">
   @foreach ($dataTotal as $key => $element)
        @if ($element['code']=='total')
        <div class="showTotal mb-3 pb-3 into-money">
            <div class="title">{!! $element['title'] !!}:</div>
            <div class="price {{ $element['code'] }}" id="{{ $element['code'] }}">
                {!! $element['text'] !!}
            </div>
        </div>
        @elseif($element['value'] !=0)
            <div class="showTotal mb-1">
                <div class="title">{!! $element['title'] !!}
                    @if ($element['code']=='discount')
                    <span style="cursor: pointer;" class="text-danger" id="removeCoupon" title="Remove coupon"><i class="fa fa fa-times"></i></span>
                    @endif
                </div>
                <div class="price" id="{{ $element['code'] }}">
                    {!! $element['text'] !!}
                </div>
            </div>
        @endif
   @endforeach
</div>
@endif