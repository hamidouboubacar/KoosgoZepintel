$(".imprimer-contrat").click(e => {
    e.preventDefault();
    var _url = e.currentTarget.href;
    _url = _url.toString().split("/");
    let _id = _url[_url.length - 1];
    _url.pop();
    _url = _url.join("/");
    _url = _url + '/'+_id;
    $("#formImpression").attr("action", _url);
    $("#imprimerContratModal").modal("show");
})

$('#impression-submit').click(() => {
    setTimeout(() => $('#impression-modal-dismiss').click(), 1500)
})