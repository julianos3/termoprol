$(document).ready(function () {
    stateChangeCity();
    getAddrress();
    changeSelected();
    getSelectCategory();
    $("input.dinheiro").maskMoney({showSymbol: true, symbol: "R$ ", decimal: ",", thousands: "."});
});
function getSelectCategory() {
    $('#category').change(function () {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "http://www.agencias3.web2217.uni5.net/grupo-brava/admin/category/sub-category/getSelectCategory/" + id,
            data: {id: id},
            beforeSend: function () {
                $('#subcategory').html('<option value="">Carregando...</option>');
            },
            success: function (html) {
                $('#subcategory').html(html);
            }
        });
        return false;
    });
}

$('.optionBanner').change(function () {
    var type = $(this).val();
    if (type === 'image') {
        $('.showImage').fadeIn();
        $('.showImage input').prop('required', true);
        $('.showImage input.link_url').prop('required', false);
        $('.showVideo').hide();
        $('.showVideo input').prop('required', false);
    } else {
        $('.showVideo').fadeIn();
        $('.showVideo input').prop('required', true);
        $('.showImage').hide();
        $('.showImage input').prop('required', false);
    }
});

$('.optionCity').change(function () {
    var type = $(this).val();
    if (type === 'iframe' || type === 'link_url') {
        $('.showLink').fadeIn();
        $('.showLink input').prop('required', true);
    } else {
        $('.showLink').hide();
        $('.showLink input').prop('required', false);
    }
});


var timestamp = $('.auxGallery').attr('data-timestamp');
var token = $('.auxGallery').attr('data-token');
var token2 = $('.auxGallery').attr('data-token-2');
var uploadScript = $('.auxGallery').attr('data-uploadScript');

if (uploadScript) {
    $(function () {
        $('#file_upload').uploadifive({
            'auto': false,
            //'checkScript'      : 'check-exists.php',
            'buttonText': 'Clique para selecionar imagem',
            'formData': {
                'timestamp': timestamp,
                '_token': token,
                'token': token2
            },
            'queueID': 'queue',
            'uploadScript': uploadScript,
            'onQueueComplete': function () {
                location.reload();
            }
        });
    });
}


function changeSelected() {
    $('.changeSelected').change(function () {
        var vClass = $(this).attr('data-classe');
        var id = $(this).val();
        var route = $(this).attr('data-route');
        route = route.replace('/0', '/' + id);
        $.ajax({
            type: "GET",
            url: route,
            beforeSend: function () {
                $('.' + vClass).prev('span').find('p').html('Localizando...');
            },
            success: function (result) {
                $('.' + vClass).html(result);
            }
        });
        return false;
    });
}

function stateChangeCity() {
    $('.uf').change(function () {
        var id = $(this).val();
        var vClass = $(this).attr('data-classe');
        $.ajax({
            type: "GET",
            url: "/projetos/loja-desirius/admin/ajax/state/getCitiesSelect/" + id,
            beforeSend: function () {
                $('.' + vClass).prev('span').find('p').html('Localizando cidades...');
            },
            success: function (result) {
                $('.' + vClass).prev('span').find('p').html('CIDADE *');
                $('.' + vClass).html(result);
            }
        });
        return false;
    });
}

function getAddrress() {
    $('#zip_code').blur(function () {
        var zip_code = $('#zip_code').val();
        //zip_code = zip_code.replace(' ', '').replace('-', '');
        $('.address').fadeOut();
        $.ajax({
            url: '/projetos/loja-desirius/admin/ajax/getAddress/' + zip_code,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.address').fadeIn();
                if (data.sucesso == 1) {
                    $('#state_id option[value=' + data.state_id + ']').click();
                    $('#address').val(data.address);
                    $('#district').val(data.district);
                    $('#number').focus();

                    getSelectCities(data.state_id, data.city_id);
                    $('#state_id option[value=' + data.state_id + ']').attr("selected", "selected");
                } else {
                    alert('CEP não encontrado!');
                }
            }
        });
        return false;
    });
}

function getSelectCities(state_id, city_id) {
    if (state_id !== '') {
        $.ajax({
            url: '/projetos/loja-desirius/admin/ajax/citiesSelect/' + state_id + '/' + city_id,
            type: 'GET',
            dataType: 'html',
            success: function (result) {
                $('#city_id').html(result);
            }
        });
    }
    return false;
}