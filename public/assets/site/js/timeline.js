
var itens_page = 5;

itens_page = itensPerPage();
setTimeout(function(){ timeline($('.timeline'), itens_page) }, 1000);

$(window).resize(function(){
    itens_page = itensPerPage();
    setTimeout(function(){ timeline($('.timeline'), itens_page) }, 100);
});
function itensPerPage() {
    $('.timeline ul > div').css('margin-left', 0).attr('data-w', 0);
    itens_page = 5;
    if($('body').width() < 1024){ itens_page = 3; }
    if($('body').width() < 800){ itens_page = 1; }
    return itens_page;
}
function timeline(el, itens_page) {

    var qtd_li = el.find('li').length;
    var width_el = el.innerWidth();
    var width_li = width_el / itens_page;
    el.find('li').innerWidth(width_li);
    var li = el.find('ul').children('div').html();
    var width_carrossel = width_li * qtd_li;
    el.find('ul').children('div').innerWidth(width_carrossel);
    adjustHeight(el);
}
function adjustHeight(el){
        var element = el.find('li');
        var finalHeight = 0;
        $.each(element,function(i,compare){
            if($(compare).find('div.content-timeline').height() > finalHeight){
                finalHeight = parseFloat($(compare).find('div.content-timeline').innerHeight());
            }
        });
        $.each(element,function(i,change){
            $(this).height(finalHeight);
            if($(this).hasClass('li-2')){
                $(this).css('margin-top', finalHeight);
            }
        });
    }
function actionTimeline(action){
    var margin_left = $('.timeline ul > div').attr('data-w');
    var width_li = $('.timeline ul li').innerWidth();
    var new_margin_left = 0;
    var limit = $('.timeline ul > div').innerWidth() - parseFloat(width_li * itens_page);
    if(action == 'next') {
        new_margin_left = parseFloat(margin_left) + width_li;
        if(new_margin_left >= limit){
            return false;
        }
        $('.timeline ul > div').css('margin-left', '-' + new_margin_left + 'px').attr('data-w', new_margin_left);
    }else{
        new_margin_left = parseFloat(margin_left) - width_li;
        if(new_margin_left <= 0){
            new_margin_left = 0;
        }
        $('.timeline ul > div').css('margin-left', '-' + new_margin_left + 'px').attr('data-w', new_margin_left);
    }
}