$(document).ready(function () {

    $('.btnEditLabel').bind('click', function () {
        var route = $(this).attr('data-route');
        $('.btnSalvarLegenda').attr("data-route", route);
    });

    $('.btnSalvarLegenda').live('click', function (e) {
        var route = $(this).attr("data-route");
        var label = $('#legenda-input').val();
        var id = $(this).attr('data-id');

        $.ajax({
            type: "POST",
            data: {
                label: label,
            },
            url: route,
            dataType: "html",
            success: function (result) {
                $('.legenda[data-id=' + id + ']').html(label);
                $(".modal-dismiss").click();
                e.stopImmediatePropagation();
            }
        });
        return false;
    });

    /*PRINCIPAL GALERIA*/
    $('.cover').live('click', function () {
        var route = $(this).attr("data-route");
        var id_album = $(this).attr("data-id-album")
        var foto_id = $(this).attr('data-id');;

        $('.cover').removeAttr("checked");
        $.ajax({
            type: "POST",
            data: {
                id_album: id_album,
            },
            url: route,
            dataType: "html",
            success: function (result) {
                $('.cover[data-id=' + foto_id + ']').attr("checked", "checked");
            }
        });
        return false;
    });

    /*ORDEM GALERIA*/
    $(".sortable").sortable({
        cursor: 'crosshair',
        helper: "clone",
        opacity: 0.6,
        update: function (event, ui) {
            var order = $(this).sortable('serialize');
            var route = $(this).attr('data-route');
            $.post(route, {
                item: order
            }, function (data) {
            });
        }
    });
});