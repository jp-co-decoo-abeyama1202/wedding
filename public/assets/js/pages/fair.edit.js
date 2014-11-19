/* 
 * fair/edit 用のJSまとめ。一部はURLの関係上viewの方に記載してるので注意。
 */
var page = 1;
var max_page = 9;
var min_page = 1;
var fairCnt = 1;
$(document).ready(function(){
    $("#button_confirm").click(function(){
        $('#edit_form').submit();
    });
    $("#button_reflection").click(function(){
        if(window.confirm('一度総合の内容を仮保存します。よろしいですか？')) {
            $('#only_total').val(true);
            $('#edit_form').submit();
        }
    });
    // 共通
    $('.counter').bind('keydown keyup keypress change',function(){
        var counterId = $(this).attr('id')+'_count';
        $('#'+counterId).html($(this).val().length);
        if($(this).val().length > $(this).attr('limit')) {
            $(this).addClass('has-error');
            $('#'+counterId).addClass('text-red');
        } else {
            $(this).removeClass('has-error');
            $('#'+counterId).removeClass('text-red');
        }
    });
    $('select.views').change(function(){
        view = $(this).attr('view');
        if($(this).val() == $(this).attr('view_value')) {
            $('#'+view).show();
        } else {
            $('#'+view).hide();
        }
    });
    $('input.views[type="checkbox"]').click(function(){
        view = $(this).attr('view');
        if ($(this).attr('readonly')) {
            return;
        }
        if ($(this).is(':checked')) {
            $('#'+view).show();
        } else {
            $('#'+view).hide();
        }
    });
    $('input.views[type="radio"]').click(function(){
        view = $(this).attr('view');
        viewList = $(this).attr('view_list');
        $('input.views[type="radio"][view_list="'+viewList+'"]').each(function(){
            $('#'+$(this).attr('view')).hide();
        });
        if ($(this).is(':checked')) {
            $('#'+view).show();
        }
    });
    //使用サイト選択
    $('.site_flg').click(function(){
        view = $(this).attr('view');
        if ($(this).is(':checked')) {
            $('#page_tab_'+view).removeClass('disabled');
            $('.'+view).show();
        } else {
            $('#page_tab_'+view).addClass('disabled')
            if($('#page_tab_'+view).hasClass('selected')) {
                $('#page_tab_total').click();
            }
            var flgList = ['gnavi','mwed','mynavi','park','rakuten','sugukon','zexy'];
            $('.'+view).hide();
            $('.'+view).map(function(){
                var target = $(this);
                flgList.map(function(key) {
                    var keyS = key + "s";
                    var keyFlg = 'flg_' + key;
                    if(keyS !== view && target.hasClass(keyS) && $('#'+keyFlg).is(':checked')) {
                        target.show();
                    }
                });
            });
        }
        //descriptionに入力可能な長さ&受付の設定
        var length = 500;
        $('#reserve_net').attr('onclick','').attr('readonly',false);
        $('#reserve_tel').attr('onclick','').attr('readonly',false);
        $('.site_flg:checked').map(function(){
            if($(this).attr('view') == 'zexys') {
                length = length < 100 ? length : 100;
                //電話受付必須
                $('#reserve_tel').attr('checked',true).attr('onclick','return false;').attr('readonly',true);
                $('#reserve_tels').show();
            }
            if($(this).attr('view') == 'parks') {
                length = length < 115 ? length : 115;
            }
            if($(this).attr('view') == 'rakutens') {
                length = length < 200 ? length : 200;
            }
            if($(this).attr('view') == 'gnavis') {
                length = length < 250 ? length : 250;
            }
            if($(this).attr('view') == 'sugukons') {
                length = length < 300 ? length : 300;
                //オンライン受付必須
                $('#reserve_net').attr('checked',true).attr('onclick','return false;').attr('readonly',true);
                $('#reserve_nets').show();
                //電話受付必須
                $('#reserve_tel').attr('checked',true).attr('onclick','return false;').attr('readonly',true);
                $('#reserve_tels').show();
            }
            if($(this).attr('view') == 'mweds') {
                length = length < 300 ? length : 300;
                //オンライン受付確定
                $('#reserve_net').attr('checked',true).attr('onclick','return false;').attr('readonly',true);
                $('#reserve_nets').show();
            }
        });
        $('#description').attr('limit',length);
        $('#description_max').html(length);
        $('#description').change();
    });
    //部制選択
    $('#tour_count').bind('change',function(){
        $('.tours').hide();
        var max = $(this).val();
        for(var i=1;i<=max;i++) {
            $('#tours_'+i).show();
        }
    });
    //画像選択
    $('.btn-imagemodal').click(function(){
        image_modal_search();
        $('#image_modal_target').val($(this).attr('target'));
    });
    //コンテンツ選択
    $('.btn-contentsmodal').click(function(){
        $('#contents_modal_target').val($(this).attr('target'));
    });
    //コンテンツクリア
    $('.btn-contents-clear').click(function(){
        var target = $(this).attr('target');
        if(!window.confirm('フェア内容'+target+'の内容を消去します。よろしいですか？')) {
            return;
        }
        $('#content_id_'+target).val('');
        $('#content_text_'+target).val('');
        $('#content_title_'+target).val('');
        $('#content_shoyo_h_'+target).val('');
        $('#content_shoyo_m_'+target).val('');
        $('#content_description_'+target).val('');
        $('#content_reserve_'+target).val(0);
        $('#content_price_flg_'+target).val(0);
        $('#content_price_'+target).val('');
        $('#content_stock_'+target).val('');
        $('#fair-contents-'+target).hide();
    });
    //所用時間の自動計算
    $('.shoyo_h,.shoyo_m').bind('change',function(){
        var time = 0;
        $('.shoyo_h').map(function() {
            if($(this).val()) {
                time += parseInt($(this).val()) * 60;
            }
        });
        $('.shoyo_m').map(function() {
            if($(this).val()) {
                time += parseInt($(this).val());
            }
        });
        var h = parseInt(time / 60);
        var m = time - (h*60);
        if(h > 23) {
            alert('所用時間の合計が23時間を超えました。23時間59分以内に調整してください。');
            return;
        }
        $('#shoyo_sum_h').val(h);
        $('#shoyo_sum_m').val(m);
    });
    
    //進むボタン
    $('.btn-next').click(function(){
        if(page === max_page||$(this).hasClass('disabled')) {
            return;
        }
        page_validate(true);
    });
    //戻るボタン
    $('.btn-prev').click(function(){
       if(page === min_page||$(this).hasClass('disabled')) { 
           return;
       }
       page--;
       page_move(page);
    });
    page_move(1);
});
//ページナビゲータから戻る
$(document).on('click','li.disabled.back',function(){
    move = $(this).attr('page');
    if(page <= move) {
        return;
    }
    page_move(move);
});
function page_move(movePage) {
    $('#fair-edit-error').hide();
    $('fieldset').hide();
    $('fieldset#page_'+movePage).show();
    page = movePage;
    $('ul#edit_status li').addClass('disabled');
    $('ul#edit_status li').removeClass('back');
    $('.btn-prev').removeClass('disabled');
    $('.btn-next').removeClass('disabled');
    $('ul#edit_status li:nth-child('+movePage+')').removeClass('disabled');
    if(page === min_page) {
        $('.btn-prev').addClass('disabled');
    }
    $('.saves').hide();
    if(page === max_page) {
        $('.btn-next').addClass('disabled');
        $('.saves').show();
    }
    for(var i=1;i<page;i++) {
        $('ul#edit_status li:nth-child('+i+')').addClass('back');
    }
    var p = $(".widget-content").offset().top;
    $('html,body').animate({ scrollTop: p }, 'fast');
}
function loading(on) {
    if(on) {
        $('.btn-next').addClass('disabled').button('loading');
    } else {
        $('.btn-next').removeClass('disabled').button('reset');
    }
}

