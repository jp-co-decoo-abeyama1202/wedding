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
                        <div class="widget-header"> <i class="icon-bookmark"></i>
                            <h3>ログイン状況</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <div class="shortcuts">
                                <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-list-alt"></i><span class="shortcut-label">ぐるナビ</span> </a>
                                <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-bookmark"></i><span class="shortcut-label">みんなの</span> </a>
                                <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-signal"></i> <span class="shortcut-label">マイナビ</span> </a>
                                <a href="javascript:;" class="shortcut"> <i class="shortcut-icon icon-comment"></i><span class="shortcut-label">パーク</span> </a>
                                <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-user"></i><span class="shortcut-label">楽天</span> </a>
                                <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-file"></i><span class="shortcut-label">すぐ婚</span> </a>
                                <a href="javascript:;" class="shortcut"><i class="shortcut-icon icon-picture"></i> <span class="shortcut-label">Zexy</span> </a>
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
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
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
      // 月名称
      monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
      // 月略称
      monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
      // 曜日名称
      dayNames: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
      // 曜日略称
      dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],
      selectable: false,
      selectHelper: false,
      select: function(start, end, allDay) {
        var title = prompt('Event Title:');
        if (title) {
          calendar.fullCalendar('renderEvent',
            {
              title: title,
              start: start,
              end: end,
              allDay: allDay
            },
            false // make the event "stick"
          );
        }
        calendar.fullCalendar('unselect');
      },
      editable: true,
      events: [
        {
          title: 'フェア1',
          start: new Date(y, m, 1)
        },
        {
          title: 'フェア2',
          start: new Date(y, m, d+5),
          end: new Date(y, m, d+7)
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: new Date(y, m, d-3, 16, 0),
          allDay: false
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: new Date(y, m, d+4, 16, 0),
          allDay: false
        },
        {
          title: 'Meeting',
          start: new Date(y, m, d, 10, 30),
          allDay: false
        },
        {
          title: 'Lunch',
          start: new Date(y, m, d, 12, 0),
          end: new Date(y, m, d, 14, 0),
          allDay: false
        },
        {
          title: 'Birthday Party',
          start: new Date(y, m, d+1, 19, 0),
          end: new Date(y, m, d+1, 22, 30),
          allDay: false
        },
        {
          title: 'EGrappler.com',
          start: new Date(y, m, 28),
          end: new Date(y, m, 29),
          url: 'http://EGrappler.com/'
        }
      ]
    });
});
</script>
@stop
