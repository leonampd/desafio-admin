var MemedAPI = {
    api_url: 'http://api.desafio-memed.dev:8080',

    get: function(url, params, callback){
        var requestUrl = this.api_url + url;
        jQuery.ajax({
            url: requestUrl,
            data: params,
            method: 'GET'
        }).done(function (response) {
            callback(response.data);
        });
    }
}

var updateMedsTable = function (jsonMeds) {
    var template = jQuery('#linha-medicamento-template').html();
    Mustache.parse(template);
    for (var i in jsonMeds) {
        var templateRender = Mustache.render(
            template,
            {"nome": jsonMeds[i].nome, "ggrem": jsonMeds[i].ggrem}
        );
        jQuery('#medicamentos tbody').append(templateRender);
    }
    clickForMedsRow();
}

var openModal = function () {
    var nome, ggrem, modal;
    nome = jQuery(this).attr('data-nome');
    ggrem = jQuery(this).attr('data-ggrem');
    modal = jQuery('#form-medicamento-modal');
    modal.find('#nome').val(nome);
    modal.find('#ggrem').val(ggrem);
    modal.modal('show');
}

var clickForMedsRow = function () {
    jQuery('#medicamentos tbody tr').on('click', openModal);
}

jQuery(document).ready(function(){
    MemedAPI.get('/medicaments', {}, updateMedsTable);
});