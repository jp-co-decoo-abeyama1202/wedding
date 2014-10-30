@extends('layout')
{{-- Page content --}}
@section('style')
{{ HTML::style('assets/css/pages/dashboard.css'); }}
<style>
.shortcuts .shortcut {
    width: 80%;
    display: inline-block;
    padding: 12px 0;
    margin: 0 .9% 1em;
    vertical-align: top;
    text-decoration: none;
    background: #f9f6f1;
    border-radius: 5px;
}
</style>
@stop
@section('content')
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span2">
                    <div class="widget">
                        <div class="widget-header"><i class="icon-share"></i>
                            <h3>ログイン画面</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <div class="shortcuts">
                                <a href="https://wedding.gnavi.co.jp/shopadmin/" target="_blank" class="shortcut"><i class="shortcut-icon icon-share"></i><span class="shortcut-label">ぐるナビ</span> </a>
                                <a href="https://b.mwed.jp" target="_blank" class="shortcut"><i class="shortcut-icon icon-share"></i><span class="shortcut-label">みんなの</span> </a>
                                <a href="https://wedding.mynavi.jp/client/login/" target="_blank" class="shortcut"><i class="shortcut-icon icon-share"></i> <span class="shortcut-label">マイナビ</span> </a>
                                <a href="https://wplanet.weddingpark.net" target="_blank" class="shortcut"> <i class="shortcut-icon icon-share"></i><span class="shortcut-label">パーク</span> </a>
                                <a href="https://wedding.rakuten.co.jp/admin/" target="_blank" class="shortcut"><i class="shortcut-icon icon-share"></i><span class="shortcut-label">楽天</span> </a>
                                <a href="https://sugukon.com/admin/" target="_blank" class="shortcut"><i class="shortcut-icon icon-share"></i><span class="shortcut-label">すぐ婚</span> </a>
                                <a href="https://cszebra.zexy.net/id/login/?nw=on" target="_blank" class="shortcut"><i class="shortcut-icon icon-share"></i> <span class="shortcut-label">Zexy</span> </a>
                            </div><!-- /shortcuts --> 
                        </div><!-- /widget-content --> 
                    </div><!-- /widget -->
                </div><!-- /span2 -->
                <div class="span10">
                    <div class="widget widget-nopad">
                        <div class="widget-header"> <i class="icon-calendar"></i>
                            <h3> フェアカレンダー</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <div id='calendar'></div>
                        </div><!-- /widget-content --> 
                    </div><!-- /widget -->
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
@section('scripts')
{{ HTML::script('assets/js/full-calendar/fullcalendar.min.js')}}
<script>
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      // タイトルの書式
      titleFormat: {
        month: 'yyyy年M月',
        week: "yyyy年M月d日{ ～ }{[yyyy年]}{[M月]d日}",
        day: "yyyy年M月d日'('ddd')'"
      },
      // ボタン文字列
      buttonText: {
        prev:     '&lsaquo;', // <
        next:     '&rsaquo;', // >
        prevYear: '&laquo;',  // <<
        nextYear: '&raquo;',  // >>
        today:    '今日',
        month:    '月',
        week:     '週',
        day:      '日'
      },
      // 日付クリックイベント
      dayClick: function () {
        alert('日付クリックイベント');
      },
      // 月名称
      monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
      // 月略称
      monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
      // 曜日名称
      dayNames: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
      // 曜日略称
      dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],
      timeFormat: { // for event elements
        '': 'H:mm' // default
      },
      axisFormat: 'H:mm',
      selectable: false,
      // 選択時にプレースホルダーを描画
      selectHelper: true,
      editable: true,
      events: [
        @foreach($dates as $date)
        {
          title: "{{$date->fair->fair_name}}",
          start: new Date("{{date('Y-m-d',strtotime($date->fair_date))}} {{$date->fair->start_h}}:{{$date->fair->start_m}}"),
          end: new Date("{{date('Y-m-d',strtotime($date->fair_date))}} {{$date->fair->end_h}}:{{$date->fair->end_m}}"),
          allDay:false,
          url: "{{URL::to('fair/detail/'.$date->fair->id)}}"
        },
        @endforeach
      ]
    });
});
</script>
@stop
