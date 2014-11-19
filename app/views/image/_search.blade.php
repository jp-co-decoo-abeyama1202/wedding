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
$s_search = (object)Input::only('search_image_category_id','search_created_from_year','search_created_from_month','search_created_from_day','search_created_to_year','search_created_to_month','search_created_to_day','search_state','search_is_edit');
if(is_null($s_search->search_state)) {
    $s_search->search_state = array();
    foreach(Image::$stateList as $_state => $_view) {
        $s_search->search_state[] = $_state;
    }
}
if(is_null($s_search->search_is_edit)) {
    $s_search->search_is_edit = array();
    foreach(Image::$isEditList as $_edit => $_view) {
        $s_search->search_is_edit[] = $_edit;
    }
}
?>
{{Form::open(array('method'=>'post'))}}
<table class='table table-striped table-bordered' id='image_search_table'>
    <tr>
        <th colspan='2'><h3>画像絞り込み</h3></th>
    </tr>
    <tr>
        <th>カテゴリ</th>
        <td>
            {{Form::select('search_image_category_id',ImageCategory::getList(),$s_search->search_image_category_id,array('class'=>'w150','style'=>'margin-bottom:0px;'))}}
        </td>
    </tr>
    <tr>
        <th>登録日</th>
        <td>
            {{Form::select('search_created_from_year',$s_year,$s_search->search_created_from_year,array('class'=>'w80','style'=>'margin-bottom:0px;'))}}<span class='text-inline'>&nbsp;年</span>
            {{Form::select('search_created_from_month',$s_month,$s_search->search_created_from_month,array('class'=>'hhmm','style'=>'margin-bottom:0px;'))}}<span class='text-inline'>&nbsp;月</span>
            {{Form::select('search_created_from_day',$s_day,$s_search->search_created_from_day,array('class'=>'hhmm','style'=>'margin-bottom:0px;'))}}<span class='text-inline'>&nbsp;日</span>
            &nbsp;～&nbsp;
            {{Form::select('search_created_to_year',$s_year,$s_search->search_created_to_year,array('class'=>'w80','style'=>'margin-bottom:0px;'))}}<span class='text-inline'>&nbsp;年</span>
            {{Form::select('search_created_to_month',$s_month,$s_search->search_created_to_month,array('class'=>'hhmm','style'=>'margin-bottom:0px;'))}}<span class='text-inline'>&nbsp;月</span>
            {{Form::select('search_created_to_day',$s_day,$s_search->search_created_to_day,array('class'=>'hhmm','style'=>'margin-bottom:0px;'))}}<span class='text-inline'>&nbsp;日</span>
        </td>
    </tr>
    <tr>
        <th>登録別</th>
        <td>
            @foreach(Image::$stateList as $_state => $_view)
            <label class='checkbox inline'>{{Form::checkbox('search_state[]',$_state,$s_search->search_state&&in_array($_state,$s_search->search_state))}}{{$_view}}</label>
            @endforeach
        </td>
    </tr>
    <tr>
        <th>編集別</th>
        <td>
            @foreach(Image::$isEditList as $_edit => $_view)
            <label class='checkbox inline'>{{Form::checkbox('search_is_edit[]',$_edit,$s_search->search_is_edit&&in_array($_edit,$s_search->search_is_edit))}}{{$_view}}</label>
            @endforeach
        </td>
    </tr>
    <tr>
        <td style='text-align:center;border-bottom:1px solid #dddddd' colspan='2'>
            {{Form::button('絞り込み',array('class'=>'btn btn-primary','style'=>'width:200px;','onclick'=>'submit();'))}}
        </td>
    </tr>
</table>
{{Form::close()}}
