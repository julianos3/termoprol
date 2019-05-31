function mascara() {
    var masks = ['(00) 00000-0000', '(00) 0000-00009'];
    $(".masked-phone").mask(masks[1], {
        onKeyPress: function (val, e, field, options) {
            field.mask(val.length > 14 ? masks[0] : masks[1], options);
        }
    });
    $(".masked-cep").mask("99999-999");
    $(".masked-cpf").mask("999.999.999-99");
    $(".masked-cnpj").mask("99.999.999/9999-99");
    $(".masked-validity").mask("99/99");
    $(".masked-date").mask("99/99/9999");
    $('.masked-money').mask('000.000.000.000.000,00', {reverse: true});
}
function scrollPage(x) {
    var newbox = $('#' + x);
    $('html, body').animate({scrollTop: newbox.offset().top - 0}, 600);
}
function addComponent(el) {
    var $clone = el.parents('nav').find('.main-component').children('li').clone(true);
    var $html = el.parents('nav').find('.main-component').html();

    var select1 = el.parents('nav').find('.main-component').find('.select-component').val();
    var select1_title = el.parents('nav').find('.main-component').find('.select-component option:selected').text();
    $($clone).find('.select-component').find('option').filter("option[value='"+select1+"']").attr('selected','selected');
    var select2 = el.parents('nav').find('.main-component').find('.select-defect').val();
    var select2_title = el.parents('nav').find('.main-component').find('.select-defect option:selected').text();
    $($clone).find('.select-defect').find('option').filter("option[value='"+select2+"']").attr('selected','selected');
    var number = el.parents('nav').find('.main-component').find('.number').text();
    var quantity = el.parents('nav').find('.main-component').find('.quantity').val();
    var archive = el.parents('nav').find('.main-component').find('.archive').val();
    // validação
    if(select1 == 0 || select2 == 0){
        alert('Preencha todos os campos');
        return false;
    }

    //adiciona nova listagem
    var $clone_result = $(".main-result-component li").clone(true);
    $($clone_result).find('.result-number').html(number);
    $($clone_result).find('.result-component').html(select1_title);
    $($clone_result).find('.result-defect').html(select2_title);
    $($clone_result).find('.result-quantity').html(quantity);
    $($clone_result).find('.result-archive').html(archive);

    var $index = parseInt($('.list-group-component ul').children('li').length) + 1;

    $clone.attr('id', 'id-'+$index);
    el.parents('nav').find('.main-component').html($html).find('.def-file p').text('Anexar Foto');

    $clone_result.attr('data-id',$index);
    $(".result-component ul ").append($clone_result)
    el.parents('nav').children('ul').append($clone);
    //alert($($clone).find('.number').html());
}
function removeComponent(el) {
    if(el.parents('.repeat-product').parent().hasClass('main-repeat-product')){
        el.parents('.repeat-product').html(el.parents('.repeat-product').html()).addClass('none');
    }else{
        el.parents('.repeat-product').remove();
    }
}

function addProduct(el) {
    var $html = $('.main-repeat-product').html();
    $('.bx-product').append($html);
    /*
    if($('.main-repeat-product .repeat-product').hasClass('none')){
        $('.main-repeat-product .repeat-product').removeClass('none');
    }else{
        $('.bx-product').append($html);
    }
    */
}

function menuResponsive() {
    $(".action-menu").click(function () {
        if($(".main-menu").hasClass('display-1024-none')){
            $(".main-menu").removeClass('display-1024-none');
            $('body').addClass('overflow-h');
        }else{
            $(".main-menu").addClass('display-1024-none');
            $('body').removeClass('overflow-h');
        }
    });
    $(window).resize(function () {
        if ($(window).innerWidth() > 1024 && $('body').hasClass('overflow-h')) {
            $(".action-menu").click();
            $(".main-menu ul li nav.opened").removeClass('opened');
        }
    });
    $('.close-menu').click(function () {
        $(".action-menu").click();
    });
    $('.close-submenu').click(function () {
        $(this).parents('.opened').removeClass('opened');
    });
}
function fix() {
    var h = parseFloat($('.top-page').innerHeight()) + parseFloat($('.false-header').innerHeight());
    h = h - 106;
    if($('.top-page').length < 1){
        h = 0;
    }
    var fix = $(".top-fix").offset().top;
    if (fix > h) {
        $('header').removeClass('absolute').addClass('fixed');
    } else {
        $('header').removeClass('fixed').addClass('absolute');
    }
};
$(document).ready(function () {
    menuResponsive();
    mascara();
    fix();
    $(window).resize(function () {
        fix();
    });
    $(window).scroll(function () {
        fix();
    });
    $(".menu-category ul li a").click(function(){
        var $this = $(this);
        $(".menu-category ul li a.active").removeClass('active');
        $this.addClass('active');
        $(".list-group-construction").removeClass('none');
        $(".list-group-construction > ul").addClass('none');
        $(".list-group-construction > ul").eq($this.parent().index()).removeClass('none');
    });
    $(document).on('change', 'input:file', function () {
        if ($(this).val() == '') {
            $(this).parent().find('p').text('Anexar Foto');
        } else {
            $(this).parent().find('p').text($(this).val());
        }
    });

    $(".click-and-scroll").on('click', function () {
        scrollPage($(this).data('anchor'));
        return false;
    });
});