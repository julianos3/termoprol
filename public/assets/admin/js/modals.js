(function( $ ) {
    'use strict';
    $('.excluir').magnificPopup({
        type: 'inline',

        fixedContentPos: false,
        fixedBgPos: true,

        overflowY: 'auto',

        closeBtnInside: true,
        preloader: false,

        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
        modal: true
    });

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        e.stopImmediatePropagation();
    });

    $(document).on('click', '.excluir', function (e) {
        var route = $(this).attr('data-route');
        $('.btnConfirmarExcluir').prop("href", route);
    });

    $(document).on('click', '.formExcluir', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        var id = $(this).attr('data-id');
        $('#idexcluir').val(id);
        $('#fexcluir').submit();                

        new PNotify({
            title: 'Success!',
            text: 'Modal Confirm Message.',
            type: 'success'
        });
    });

    $(document).on('click', '.modal-form', function (e) {
        var id = $(this).attr('data-id');
        var legenda = $('.legenda[data-id='+id+']').html();
        $('#legenda-input').val('');
        $('.btnSalvarLegenda').attr("data-id",id);
        $('#legenda-input').val(legenda);
    });

    $('.modal-form').magnificPopup({
        type: 'inline',

        fixedContentPos: false,
        fixedBgPos: true,

        overflowY: 'auto',

        closeBtnInside: true,
        preloader: false,

        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
        modal: true
    });

}).apply( this, [ jQuery ]);