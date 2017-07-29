var MemedAPI = {
    api_url: 'http://api.desafio-memed.dev:8080',
    request: function(method, url, params, successCalback, errorCallback) {
        var requestUrl = this.api_url + url;
        jQuery.ajax({
            url: requestUrl,
            data: params,
            method: method,
        }).done(function (response) {
            if (typeof successCalback !== 'undefined') {
                successCalback(response.data);
            }
        }).fail(function () {
            if (typeof errorCalback !== 'undefined') {
                errorCalback(response.data);
            }
        });
    },
    get: function(url, params, callback){
        this.request('GET', url, params, callback);
    },
    put: function (url, params, sucessCallback, errorCallcback) {
        this.request('PUT', url, params,  sucessCallback, errorCallcback);
    }
};

var updateMedsTable = function (jsonMeds) {
    var template = jQuery('#linha-medicamento-template').html();
    Mustache.parse(template);
    for (var i in jsonMeds) {
        var templateRender = Mustache.render(
            template,
            {
                "nome": jsonMeds[i].nome,
                "ggrem": jsonMeds[i].ggrem,
                "slug": jsonMeds[i].slug,
                "atualizacao": jsonMeds[i].data_atualizacao,
                "criacao": jsonMeds[i].data_criacao
            }
        );
        jQuery('#medicamentos tbody').append(templateRender);
    }
    clickForMedsRow();
}

var openModal = function () {
    var nome, slug, ggrem, modal, historico;
    nome = jQuery(this).attr('data-nome');
    ggrem = jQuery(this).attr('data-ggrem');
    slug = jQuery(this).attr('data-slug');

    modal = jQuery('#form-medicamento-modal');
    modal.find('#nome').val(nome);
    modal.find('#ggrem').val(ggrem);
    modal.find('#slug').val(slug);

    MemedAPI.get('/medicaments/' + slug + '/historic', {},function (historico) {
        var template = jQuery('#linha-historico-medicamento-template').html();
        var listaHistorico = jQuery('#lista-historico');
        var templateRender;
        Mustache.parse(template);
        if (typeof historico == 'undefined') {
            return;
        }
        listaHistorico.html('');
        for (var i in historico) {
            var acao = historico[i].action;
            if (acao === 'update') {
                acao = 'modificou';
            }
            templateRender = Mustache.render(
                template,
                {
                    "usuario": historico[i].username,
                    "acao": acao,
                    "campo": historico[i].field,
                    "valor_anterior": historico[i].old_value,
                    "valor_novo": historico[i].new_value,
                    "data_atualizacao": historico[i].datetime
                }
            );
            listaHistorico.append(templateRender);
        }
    });


    modal.modal('show');
}

var updateMedicament = function () {
    var slug, nome, ggrem, modal;
    modal = jQuery('#form-medicamento-modal');
    nome = modal.find('#nome').val();
    ggrem = modal.find('#ggrem').val();
    slug = modal.find('#slug').val();

    var url = '/medicaments/' + slug;
    MemedAPI.put(url, {'nome': nome,  'ggrem': ggrem}, function () {
        modal.find('#feedback .sucesso').fadeToggle().delay(3000).fadeToggle();
    }, function () {
        modal.find('#feedback .erro').fadeToggle().delay(3000).fadeToggle();
    });
}

var clickForMedsRow = function () {
    jQuery('#medicamentos tbody tr').on('click', openModal);
}

jQuery(document).ready(function(){
    MemedAPI.get('/medicaments', {}, updateMedsTable);
    jQuery('#modal-action-button').click(updateMedicament);
});