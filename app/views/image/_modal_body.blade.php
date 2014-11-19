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
<form id="image_modal_form" action="#">
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
        <td style='text-align:center;border-bottom:1px solid #dddddd' colspan='2'>
            {{Form::button('絞り込み',array('class'=>'btn btn-primary','style'=>'width:200px;','onclick'=>'image_modal_search();'))}}
        </td>
    </tr>
</table>
</form>
<table class='table table-bordered' style='margin-top:10px;border-top:1px solid #dddddd;'>
    @foreach(Image::ofModal()->get() as $image)
    <tr class='tr-title'>
        <th colspan='7'>
            #{{$image->id}}&nbsp;{{$image->title}}
        </th>
    </tr>
    <tr>
        <td rowspan='3' style='text-align:center;width:160px;'>{{HTML::image($image->getFilePath(true),$image->title,array('style'=>'width:150px;height:150px;','id'=>'image_modal_path_'.$image->id))}}</td>
        <th>キャプション</th>
        <td colspan='7' id='image_modal_caption_{{$image->id}}'>{{{$image->caption}}}</td>
    </tr>
    <tr>
        <th>画像カテゴリ</th>
        <td>{{{$image->category->name or '選択無し'}}}</td>
        <th>登録日</th>
        <td>{{date('Y/m/d',strtotime($image->created_at))}}</td>
        <th>更新日</th>
        <td>{{date('Y/m/d',strtotime($image->updated_at))}}</td>
    </tr>
    <tr>
        <td colspan='7' class='text-center-i' id='image_modal_selected_{{$image->id}}'>
            {{Form::button('この画像を選択',array('class'=>'btn btn-info btn-image-modal-selected','aria-hidden'=>'true','data-dismiss'=>'modal','image_id'=>$image->id))}}
        </td>
    </tr>
    @endforeach
</table>
