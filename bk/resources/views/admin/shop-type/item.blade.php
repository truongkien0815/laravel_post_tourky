@php
    $child = $child??0;
@endphp
<tr class="tr-item {{ $child?'item-level-1':'' }}">
    <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
    <td class="title">
        <a class="row-title" href="{{route('admin_type.edit', $data->id)}}">
            <b>{{$data->name}}</b>
            <br>
            <b style="color:#c76805;">{{$data->slug}}</b>                                
        </a>
    </td>
    <td class="text-center">
        {{ $data->status == 0 ? 'Draft' : 'Public' }}
    </td>
</tr>