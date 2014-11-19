<?php
$contents_ = Content::all();
$contents = array();
$counts1 = array();
foreach($contents_ as $content) {
    $r1 = $content->rakuten_name_1;
    $r2 = $content->rakuten_name_2;
    if(!array_key_exists($r1,$contents)) {
        $contents[$r1] = array();
        $counts[$r1] = 0;
    }
    $counts[$r1]++;
    if($r2) {
        if(!array_key_exists($r2,$contents[$r1])) {
            $contents[$r1][$r2] = array();
        }
        $contents[$r1][$r2][] = $content;
    } else {
        $contents[$r1][] = $content;
    }
}
?>
<div id="contents_select_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="contents_select_modal" aria-hidden="true" style='width: 70%;left: 17%;top: 20%;margin:0;'>
    {{Form::hidden('contents_modal_target','all',array('id'=>'contents_modal_target'))}}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="contents_select_modal_label">コンテンツ選択</h3>
    </div>
    <div class="modal-body" id="contents_modal_body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>項目1</th>
                    <th>項目2</th>
                    <th>項目3</th>
                    <th>選択</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contents as $colum1Name => $cs2)
                <tr>
                    <td rowspan="{{$counts[$colum1Name]}}">{{$colum1Name}}</td>
                    @foreach($cs2 as $colum2Name => $cs3)
                        @if(is_int($colum2Name))
                            <td></td>
                            <td></td>
                            <td class="text-center-i">
                                {{Form::open(array('id'=>'contents-modal-selected-form-'.$cs3->id,'style'=>'margin:0'))}}
                                    {{Form::button('選択',array('class'=>'btn btn-info btn-contents-modal-selected','aria-hidden'=>'true','data-dismiss'=>'modal','contents_id'=>$cs3->id))}}
                                    {{Form::hidden('content_name',$cs3->getContentName())}}
                                {{Form::close()}}
                            </td>
                        @else
                            <td rowspan="{{count($cs3)}}">{{$colum2Name}}</td>
                            @foreach($cs3 as $content)
                            <td>{{$content->rakuten_name_3}}</td>
                            <td class="text-center-i">
                                {{Form::open(array('id'=>'contents-modal-selected-form-'.$content->id,'style'=>'margin:0'))}}
                                    {{Form::button('選択',array('class'=>'btn btn-info btn-contents-modal-selected','aria-hidden'=>'true','data-dismiss'=>'modal','contents_id'=>$content->id))}}
                                    {{Form::hidden('content_name',$content->getContentName())}}
                                {{Form::close()}}
                            </td>
                           </tr><tr>
                            @endforeach
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>項目1</th>
                    <th>項目2</th>
                    <th>項目3</th>
                    <th>選択</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">キャンセル</button>
    </div>
</div>
@section('scripts')
@parent
<script>
$(document).on('click','.btn-contents-modal-selected',function(){
    var target = $('#contents_modal_target').val();
    if(!target) {
        return;
    }
    var id = $(this).attr('contents_id');
    var text = $('#contents-modal-selected-form-'+id+' input[name="content_name"]').val();
    $('#content_id_'+target).val(id);
    $('#content_text_'+target).val(text);
    $('#fair-contents-'+target).show();
});
</script>
@stop