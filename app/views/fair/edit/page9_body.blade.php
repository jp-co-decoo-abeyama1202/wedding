<!-- 1.初期選択 -->
<tr>
    <th colspan="2"><h3>1.初期選択</h3></th>
</tr>
<tr>
    <th>使用サイト選択</th>
    <td>
        {{$fair->siteNames('<br/>')}}
    </td>
</tr>
<tr></tr>
<!-- 2.基本情報入力 -->
<tr>
    <th colspan="2"><h3>2.基本情報入力</h3></th>
</tr>
<tr>
    <th>フェア名称</th>
    <td>{{{$fair->fair_name}}}</td>
</tr>
<tr>
    <th>全体説明文</th>
    <td>{{{$fair->description}}}</td>
</tr>
<tr></tr>
<!-- 3.基本フェア構成作成 -->
<tr>
    <th colspan="2"><h3>3.基本フェア構成作成</h3></th>
</tr>
<tr>
    <th>合計所用時間</th>
    <td>{{$fair->shoyo_sum_h ? $fair->shoyo_sum_h.'時間' : ''}}{{$fair->shoyo_sum_m}}分</td>
</tr>
@foreach($fairContents as $content)
    <tr>
        <th>フェア内容{{$content->no}}</th>
        <td class='in-table'>
            <table class="table table-bordered">
                <tr>
                    <th>コンテンツ</th>
                    <td>{{$content->name}}</td>
                </tr>
                <tr>
                    <th>タイトル</th>
                    <td>{{{$content->title}}}</td>
                </tr>
                <tr>
                    <th>所用時間</th>
                    <td>{{$content->shoyo_h ? $content->shoyo_h.'時間':''}}{{$content->shoyo_m}}分</td>
                </tr>
                <tr>
                    <th>フェア内容説明文</th>
                    <td>{{{$content->description}}}</td>
                </tr>
                <tr>
                    <th>予約有無</th>
                    <td>{{FairContent::$reserveList[$content->reserve]}}</td>
                </tr>
                <tr>
                    <th>有料/無料</th>
                    <td>{{FairContent::$priceFlagList[$content->price_flg]}}</td>
                </tr>
                @if($content->price_flg == FairContent::PRICE_FLG_ON)
                <tr>
                    <th>料金</th>
                    <td>{{{$content->price}}}円/人</td>
                </tr>
                @endif
                <tr>
                    <th>個別フェア在庫数</th>
                    <td>{{{$content->stock}}}</td>
                </tr>
            </table>
        </td>
    </tr>
@endforeach
<tr>
    <th>部制選択</th>
    <td>{{$fair->tour_count}}部構成</td>
</tr>
@for($i=1;$i<=$fair->tour_count;++$i)
    <tr>
        <th>第{{$i}}部</th>
        <td>{{$fair->tourTime($i,'start')}}&nbsp;～&nbsp;{{$fair->tourTime($i,'end')}}</td>
    </tr>
@endfor
<tr></tr>
<!-- 4.画像選択 -->
<tr>
    <th colspan="2"><h3>4.画像選択</h3></th>
</tr>
@foreach(Site::$_site_names as $key => $name)
    @if($fair->isImage($key))
    <tr>
        <th>画像:{{$name}}</th>
        <td class='in-table'>
            <table>
                <tr>
                    <th>画像</th>
                    <td>{{HTML::image($fair->image($key)->getFilePath(true),'',array('style'=>'width:100px;height:100px;'))}}</td>
                </tr>
                @if(in_array($key,array(SiteGnavi::SITE_LOGIN_ID,SiteSugukon::SITE_LOGIN_ID)))
                <tr>
                    <th>画像説明</th>
                    <td>{{$fair->image_caption($key)}}</td>
                </tr>
                @endif
            </table>
        </td>
    </tr>
    @endif
@endforeach
<tr></tr>
<!-- 5.特典入力 -->
<tr>
    <th colspan="2"><h3>5.特典入力</h3></th>
</tr>
@if($fair->zexy_tokuten_flg == Fair::FLG_ON)
<tr>
    <th>ゼクシィ</th>
    <td class='in-table'>
        <table class='table table-bordered'>
            <tr>
                <th>特典</th>
                <td>あり</td>
            </tr>
            <tr>
                <th>特典内容説明</th>
                <td>{{{$fair->zexy_tokuten_description}}}</td>
            </tr>
            <tr>
                <th>備考</th>
                <td>{{{$fair->zexy_tokuten_remarks}}}</td>
            </tr>
            <tr>
                <th>期間</th>
                <td>{{{$fair->zexy_tokuten_period}}}</td>
            </tr>
        </table>
    </td>
</tr>
@endif
@if($fair->mwed_tokuten_flg == Fair::FLG_ON)
    <tr>
        <th>みんなの</th>
        <td class='in-table'>
            <table class='table table-bordered'>
                <tr>
                    <th>特典</th>
                    <td>あり</td>
                </tr>
                <tr>
                    <th>特典内容説明</th>
                    <td>{{{$fair->mwed_tokuten_description}}}</td>
                </tr>
            </table>
        </td>
    </tr>
@endif
@if($fair->park_tokuten_flg == Fair::FLG_ON)
    <tr>
        <th>パーク</th>
        <td class='in-table'>
            <table class='table table-bordered'>
                <tr>
                    <th>特典</th>
                    <td>あり</td>
                </tr>
                <tr>
                    <th>特典内容説明</th>
                    <td>{{{$fair->park_tokuten_description}}}</td>
                </tr>
            </table>
        </td>
    </tr>
@endif
@if($fair->rakuten_tokuten_flg == Fair::FLG_ON)
    <tr>
        <th>楽天</th>
        <td class='in-table'>
            <table class='table table-bordered'>
                <tr>
                    <th>特典</th>
                    <td>あり</td>
                </tr>
            </table>
        </td>
    </tr>
@endif
@if($fair->mynavi_tokuten_flg == Fair::FLG_ON)
    <tr>
        <th>マイナビ</th>
        <td class='in-table'>
            <table class='table table-bordered'>
                <tr>
                    <th>特典</th>
                    <td>あり</td>
                </tr>
                <tr>
                    <th>特典内容説明</th>
                    <td>{{{$fair->mynavi_tokuten_description}}}</td>
                </tr>
            </table>
        </td>
    </tr>
@endif
@if($fair->gnavi_tokuten_flg == Fair::FLG_ON)
    <tr>
        <th>ぐるナビ</th>
        <td class='in-table'>
            <table class='table table-bordered'>
                <tr>
                    <th>特典</th>
                    <td>あり</td>
                </tr>
            </table>
        </td>
    </tr>
@endif
<tr></tr>
<!-- 6.契約期間及び受付方法 -->
<tr>
    <th colspan="2"><h3>6.契約期間及び受付方法</h3></th>
</tr>
@if($fair->flg_zexy == Fair::FLG_ON)
    <tr>
        <th>リアルタイム受付</th>
        <td>{{$fair->zexy_real_time_yoyaku_flg == Fair::FLG_ON ? '受付する' : '受付しない'}}</td>
    </tr>
    <tr>
        <th>予約切替</th>
        <td>{{FairZexy::$requestChangeConfigKbnList[$fair->zexy_request_change_config_kbn]}}</td>
    </tr>    
@endif
<tr>
    <th>オンライン受付</th>
    <td class='in-table'>
        <table>
            <tr>
                <th>設定</th>
                <td>{{$fair->reserve_net == Fair::FLG_ON ? 'する' : 'しない'}}</td>
            </tr>
            @if($fair->reserve_net == Fair::FLG_ON)
            <tr>
                <th>掲載期間</th>
                <td>{{Fair::$reserveDayList[$fair->reserve_net_day]}}まで</td>
            </tr>
            <tr>
                <th>受付時間</th>
                <td>{{Fair::$reserveTimeList[$fair->reserve_net_time]}}まで</td>
            </tr>
            @endif
        </table>
    </td>
</tr>
<tr>
    <th>電話受付</th>
    <td class='in-table'>
        <table>
            <tr>
                <th>設定</th>
                <td>{{$fair->reserve_tel == Fair::FLG_ON ? 'する' : 'しない'}}</td>
            </tr>
            @if($fair->reserve_tel == Fair::FLG_ON)
            <tr>
                <th>掲載期間</th>
                <td>{{Fair::$reserveDayList[$fair->reserve_tel_day]}}まで</td>
            </tr>
            <tr>
                <th>受付時間</th>
                <td>{{Fair::$reserveTimeList[$fair->reserve_tel_time]}}まで</td>
            </tr>
            @endif
        </table>
    </td>
</tr>
<tr>
    <th>優先度</th>
    <td>{{Fair::$reserveList[$fair->reserve]}}</td>
</tr>
<tr></tr>
<!-- 7.アクセスデータ -->
<tr>
    <th colspan="2"><h3>7.アクセスデータ</h3></th>
</tr>
<tr>
    <th>開催会場</th>
    <td>{{Fair::$hollList[$fair->holl_id]}}</td>
</tr>
<tr>
    <th>所在地</th>
    <td>{{{$fair->address}}}</td>
</tr>
<tr>
    <th>所在地備考</th>
    <td>{{{$fair->address_note}}}</td>
</tr>
<tr>
    <th>駐車場</th>
    <td>{{{$fair->parking}}}</td>
</tr>
<tr>
    <th>電話番号1</th>
    <td class='in-table'>
        <table>
            <tr>
                <td colspan='2'>
                    {{{$fair->tel1_1}}}-{{{$fair->tel1_2}}}-{{{$fair->tel1_3}}}
                </td>
            </tr>
            <tr>
                <th>種別</th>
                <td>{{Fair::$telSyubetsuList[$fair->tel1_syubetsu]}}</td>
            </tr>
            <tr>
                <th>担当窓口</th>
                <td>{{$fair->tel1_tanto}}</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <th>電話番号2</th>
    <td class='in-table'>
        <table>
            <tr>
                <td colspan='2'>
                    @if($fair->tel2_1)
                    {{{$fair->tel1_1}}}-{{{$fair->tel1_2}}}-{{{$fair->tel1_3}}}
                    @else
                    なし
                    @endif
                </td>
            </tr>
            @if($fair->tel2_1)
            <tr>
                <th>種別</th>
                <td>{{Fair::$telSyubetsuList[$fair->tel2_syubetsu]}}</td>
            </tr>
            <tr>
                <th>担当窓口</th>
                <td>{{$fair->tel2_tanto}}</td>
            </tr>
            @endif
        </table>
    </td>
</tr>
<tr>
    <th>問合せ</th>
    <td class='in-table'>
        <table>
            <tr>
                <th>受付時間</th>
                <td>{{$fair->inquery_time}}</td>
            </tr>
            <tr>
                <th>問合せ担当者</th>
                <td>{{$fair->inquery_support_name}}</td>
            </tr>
        </table>
    </td>
</tr>
<tr></tr>
<!-- 8.個別設定項目 -->
<tr>
    <th colspan="2"><h3>8.個別設定項目</h3></th>
</tr>
@if($fair->flg_zexy == Fair::FLG_ON || $fair->flg_mynavi)
<tr>
    <th>共通</th>
    <td class='in-table'>
        <table class='table table-bordered'>
            <tr>
                <th>対象者</th>
                <td>{{{$fair->target_note}}}
            </tr>
            <tr>
                <th>その他</th>
                <td>{{{$fair->etc_note}}}
            </tr>
        </table>
    </td>
</tr>
@endif
@if($fair->flg_zexy == Fair::FLG_ON)
<tr>
    <th>ゼクシィ</th>
    <td class='in-table'>
        <table class='table table-bordered'>
            <tr>
                <th>フェアの分類</th>
                <td>{{$fair->zexy_secret_flg == Fair::FLG_ON ? 'シークレットフェア' : 'ノーマルフェア'}}</td>
            </tr>
            <tr>
                <th>代表フェアに</th>
                <td>{{$fair->zexy_head_fair_flg == Fair::FLG_ON ? 'する' : 'しない'}}
            </tr>
            <tr>
                <th>質問項目</th>
                <td>{{{$fair->zexy_free_config_question}}}</td>
            </tr>
            <tr>
                <th>必須回答に</th>
                <td>{{$fair->zexy_free_config_answer_must_flg == Fair::FLG_ON ? 'する' : 'しない'}}</td>
            </tr>
            <tr>
                <th>まとめて予約受付に</th>
                <td>{{$fair->zexy_packs == Fair::FLG_ON ? 'する' : 'しない'}}</td>
            </tr>
            @if($fair->zexy_packs == Fair::FLG_ON)
            <tr>
                <th>予約区分</th>
                <td>{{FairZexy::$packYoyakuKbnList[$fair->zexy_pack_yoyaku_kbn]}}</td>
            </tr>
            <tr>
                <th>単位</th>
                <td>{{FairZexy::$packYoyakuUnitKbnList[$fair->zexy_pack_yoyaku_unit_kbn]}}</td>
            </tr>
            <tr>
                <th>zebra予約受付</th>
                <td>{{{$fair->zexy_pack_yoyaku_uketsuke_cnt}}}</td>
            </tr>
            @endif
        </table>
    </td>
</tr>
@endif
@if($fair->flg_sugukon == Fair::FLG_ON)
<tr>
    <th>すぐ婚</th>
    <td class='in-table'>
        <table class='table table-bordered'>
            <tr>
                <th>オススメフェアとして登録</th>
                <td>{{$fair->sugukon_is_recommend == Fair::FLG_ON ? 'する' : 'しない'}}</td>
            </tr>
        </table>
    </td>
</tr>
@endif
@if($fair->flg_gnavi == Fair::FLG_ON)
<tr>
    <th>ぐるナビ</th>
    <td class='in-table'>
        <table class='table table-bordered'>
            <tr>
                <th>検索キーワード設定</th>
                <td>{{{$fair->gnavi_freeword_search}}}</td>
            </tr>
            <tr>
                <th>キャッチコピー</th>
                <td>{{{$fair->gnavi_fair_catch}}}</td>
            </tr>
            <tr>
                <th>ココに注目</th>
                <td>{{{$fair->gnavi_fair_point}}}</td>
            </tr>
            <tr>
                <th>ぐるナビ限定</th>
                <td>{{$fair->gnavi_gnavi_limit_flg == Fair::FLG_ON ? 'ON' : 'OFF'}}</td>
            </tr>
            <tr>
                <th>おひとり様参加OK</th>
                <td>{{$fair->gnavi_just_one_ok_flg == Fair::FLG_ON ? 'ON' : 'OFF'}}</td>
            </tr>
            <tr>
                <th>見積書のご案内</th>
                <td>{{$fair->gnavi_estimate_bid_flg == Fair::FLG_ON ? 'ON' : 'OFF'}}</td>
            </tr>
            <tr>
                <th>定員</th>
                <td>{{{$fair->gnavi_customer_count ? $fair->gnavi_customer_count.'人' : '指定なし'}}}</td>
            </tr>
        </table>
    </td>
</tr>
@endif