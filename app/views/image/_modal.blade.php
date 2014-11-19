<?php
$s_year = $s_month = $s_day = array(
    null => '--'
);
for($i=2014;$i<=date('Y');++$i) {
    $s_year[$i] = $i;
}
for($i=1;$i<=31;$i++) {
    if($i<=12) {
        $s_month[$i] = sprintf('%02d',$i);
    }
    $s_day[$i] = sprintf('%02d',$i);
}
$s_search = (object)Input::only('search_image_category_id','search_created_from_year','search_created_from_month','search_created_from_day','search_created_to_year','search_created_to_month','search_created_to_day');
?>
<div id="image_select_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="image_select_modal" aria-hidden="true" style='width: 70%;left: 17%;top: 20%;margin:0;'>
    {{Form::hidden('image_modal_target','all',array('id'=>'image_modal_target'))}}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="image_select_modal_label">画像選択</h3>
    </div>
    <div class="modal-body" id="image_modal_body">
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">キャンセル</button>
    </div>
</div>
@section('scripts')
@parent
<script>
$(document).on('click','.btn-image-modal-selected',function(){
    var target = $('#image_modal_target').val();
    if(!target) {
        return;
    }
    var id = $(this).attr('image_id');
    var src = $('#image_modal_path_'+id).attr('src');

    if(target === 'all') {
        $('.image_id').val(id);
        $('.image-body img').attr('src',src);
        $('.image_caption').val($('#image_modal_caption_'+id).html());
    } else {
        $('#image_id_'+target).val(id);
        $('#sample_image_'+target).attr('src',src);
        if($('#image_caption_'+target)) {
            $('#image_caption_'+target).val($('#image_modal_caption_'+id).html());
        }
    }
});
function image_modal_search(){
    var url = '{{URL::to('image/modal')}}';
    var data = {'_token':'{{csrf_token()}}'}
    $('#image_modal_form select').map(function() {
        data[$(this).attr('name')] = $(this).val();
    });
    $.post(
        url,
        data,
        function(data){
            $('#image_modal_body').html(data);
        },
        'html'
    );
}
</script>
@stop

