@extends('layout')
@section('style')
{{ HTML::style('assets/css/pages/fair.css?t=aaaaaaaas'); }}
<style>
.changes {
    text-align: center;	
}

.changes .change { 
    width: 60px;
    display: inline-block;
    padding: 12px 0;
    margin: 0 .9% 1em;
    vertical-align: top;
    text-decoration: none;
    background: #f9f6f1;
    border-radius: 5px;
}

.changes .change .change-icon {
    margin-top: .25em;
    margin-bottom: .25em;

    font-size: 32px;
    color: #545454;
}

.changes .change:hover {
    background: #00ba8b;
}

.changes .change:hover span{
    color: #fff;
}

.changes .change:hover .change-icon {
    color: #fff;
}

.changes .change-label {
    display: block;
    font-weight: 400;
    color: #545454;
}

.widget-header .header-titles {
    float:left;
}
.widget-header .header-buttons {
    float:right;
    margin-right:10px;
}
.clear {
    clear:both;
}
.form-horizontal {
    margin:20px;
}
.form-horizontal .controls {
    margin-left: 100px;
}
.form-horizontal .control-label {
    width: 85px;
}
.hhmm {
    width:50px;
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
                            <h3>切替</h3>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            <div class="changes">
                                <a class="change"><i class="change-icon icon-list-alt"></i><span class="change-label">総合</span> </a>
                                <a class="change"><i class="change-icon icon-list-alt"></i><span class="change-label">ぐるナビ</span> </a>
                                <a class="change"><i class="change-icon icon-bookmark"></i><span class="change-label">みんなの</span> </a>
                                <a class="change"><i class="change-icon icon-signal"></i> <span class="change-label">マイナビ</span> </a>
                                <a class="change"><i class="change-icon icon-comment"></i><span class="change-label">パーク</span> </a>
                                <a class="change"><i class="change-icon icon-user"></i><span class="change-label">楽天</span> </a>
                                <a class="change"><i class="change-icon icon-file"></i><span class="change-label">すぐ婚</span> </a>
                                <a class="change"><i class="change-icon icon-picture"></i> <span class="change-label">Zexy</span> </a>
                            </div><!-- /changes --> 
                        </div><!-- /widget-content --> 
                    </div><!-- /widget -->
                </div><!-- /span2 -->
                <div class="span10">
                    <div class="widget widget-nopad">
                        <div class="widget-header">
                            <div class="header-titles">
                                <i class="icon-calendar"></i>
                                <h3 id="page-title"> 総合</h3>
                            </div>
                            <div class="header-buttons">
                                <button class="btn btn-info">下書保存</button>
                                <button class="btn btn-info">保　　存</button>
                            </div>
                            <div class="clear"></div>
                        </div><!-- /widget-header -->
                        <div class="widget-content">
                            
                            <form action="" method="post" class="form-horizontal">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="fair_name">フェア名</label>
                                        <div class="controls">
                                            <input type="text" name="fair_name" id="fair_name" value="{{$fair->fair_name}}" maxlength="30"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">開催時間</label>
                                        <div class="controls">
                                            <select name="start_h" class="hhmm">
                                                @foreach(Fair::$hList as $value => $view)
                                                <option value="{{$value}}" 
                                                        @if ($fair->start_h==$value)
                                                            selected
                                                        @endif
                                                        >{{$view}}</option>
                                                @endforeach
                                            </select>
                                            &nbsp;:&nbsp;
                                            <select name="start_m" class="hhmm">
                                                @foreach(Fair::$mList as $value => $view)
                                                <option value="{{$value}}" 
                                                        @if ($fair->start_m==$value)
                                                            selected
                                                        @endif
                                                        >{{$view}}</option>
                                                @endforeach
                                            </select>
                                            &nbsp;～&nbsp;
                                            <select name="end_h" class="hhmm">
                                                @foreach(Fair::$hList as $value => $view)
                                                <option value="{{$value}}" 
                                                        @if ($fair->end_h==$value)
                                                            selected
                                                        @endif
                                                        >{{$view}}</option>
                                                @endforeach
                                            </select>
                                            &nbsp;:&nbsp;
                                            <select name="end_m" class="hhmm">
                                                @foreach(Fair::$mList as $value => $view)
                                                <option value="{{$value}}" 
                                                        @if ($fair->end_m==$value)
                                                            selected
                                                        @endif
                                                        >{{$view}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="description">フェア説明</label>
                                        <div class="controls">
                                            <textarea name="description" id="description">{{$fair->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="target">対象者</label>
                                        <div class="controls">
                                            <input type="text" name="target" id="target" value="{{$fair->target}}" maxlength="50"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="other_description">フェア説明</label>
                                        <div class="controls">
                                            <textarea name="other_description">{{$fair->other_description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <label class="radio inline" for="tour_or_pack">
                                                <input type="radio" name="tour_or_pack" value="{{Fair::TOUR_FLAG}}" {{$fair->tour_flg == Fair::FLG_ON ? 'checked' : ''}}>複数部制選択
                                            </label>
                                            <label class="radio inline" for="tour_or_pack">
                                                <input type="radio" name="tour_or_pack" value="{{Fair::PACK_FLAG}}" {{$fair->pack_flg == Fair::FLG_ON ? 'checked' : ''}}>まとめて予約
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div><!-- /widget-content --> 
                    </div><!-- /widget -->
                </div><!-- /span10 -->
            </div><!-- /row -->
        </div><!-- container -->
    </div><!-- /main-inner -->
</div><!-- /main -->
@stop
