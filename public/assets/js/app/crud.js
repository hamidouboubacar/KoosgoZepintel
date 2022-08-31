$(".edit").click(function (e) {
    e.preventDefault();
    var _url = e.currentTarget.href;
    let _id = _url.toString().split("/");
    _id = _id[_id.length - 2];

    $.get(_url).done(function (data) {
        $('#formContent').html(data)
        _url = $('#formUpdate').attr("action").toString().split("/");
        _url.pop();
        _url = _url.join("/")
        _url = _url + '/'+_id;

        $('#formUpdate').attr("action",_url);
        $("#editType").modal("show")
        $(".contenu").summernote()
    }).fail(e => {
        console.log('Echec de la requete', e)
    })
})


$(".delete").click(e => {
    e.preventDefault();
    var _url = e.currentTarget.href;
    _url = _url.toString().split("/");
    let _id = _url[_url.length - 1];
    _url.pop();
    _url = _url.join("/");
    _url = _url + '/'+_id;
    $("#formDelete").attr("action", _url);
    $("#deleteModal").modal("show");
})

$('#btn-create').click(() => {
    $('.input-reset')
        .val('')
        .removeAttr('checked')
        .removeAttr('selected');  
})