function choixclient(){
	var type=document.getElementById('type').value;
        const num_client = document.getElementById('dataTable').getAttribute('data-client')
        const num_prospect = document.getElementById('dataTable').getAttribute('data-prospect')
        if(type=='Client'){
            document.getElementById('code_client').value='CL'+num_client;
        }else if(type=='Prospect'){
            document.getElementById('code_client').value='PRT'+num_prospect;
        }
}

$('#name').keyup(function (e) {
    let _code = $("#name").val().toString().trim().replaceAll(" ", "_").toLowerCase();
    $('#code').val(_code);
})
$('#name1').keyup(function (e) {
    let _code = $("#name1").val().toString().trim().replaceAll(" ", "_").toLowerCase();
    $('#code1').val(_code);
})

$(".edit").click(function (e) {
    e.preventDefault();
    var _url = e.currentTarget.href;
    let _id = _url.toString().split("/");
    _id = _id[_id.length - 2];

    $.get(_url).done(function (data) {
        $("#name1").val(data.name);
        $("#code1").val(data.code);
        $("#telephone1").val(data.telephone);
        $("#adresse1").val(data.adresse);
        $("#type1").val(data.type);
        $("#user_id1").val(data.user_id);
        $("#ifu1").val(data.ifu);
        $("#rccm1").val(data.rccm);
        $("#ville1").val(data.ville);
        $("#pays1").val(data.pays);
        $("#email1").val(data.email);
        $("#numero_paiement1").val(data.numero_paiement);
        // console.log($('#formUpdate').attr("action").toString())
        _url = $('#formUpdate').attr("action").toString().split("/");
        _url.pop()
        _url = _url.join("/")
        _url = _url + '/'+_id;

        $('#formUpdate').attr("action",_url);
        $("#editType").modal("show")
        $("#client_id").val(_id)
        console.log( $("#client_id"), $("#client_id").val(_id), _id)
    })

    $.post($("#numero-liste-url").val(), {
        client_id: _id
    }).done(function (data) {
        $.each(data, (k, v) => {
            $("#numero-box").append(`
                <div class="form-row" id="numero-paiement-${v.id}">
                    <div class="col">
                        <div class="form-group">
                            <label for="telephone">Numéro de paiement <a class="action-icon text-danger numero-delete" href="#d-${v.id}" title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></a></label>
                            <input type="text" id="${v.id}" class="numero_paiement form-control" placeholder="+226 xx xx xx" value="${v.telephone}" />
                        </div>
                    </div>
                </div>
            `)
        })

        $(".numero_paiement").change(e => {
            console.log("change")
            $.post($("#numero-change-url").val(), {
                id: e.currentTarget.id,
                telephone: e.currentTarget.value
            });
        })

        $(".numero-delete").click(e => {
            let id = e.currentTarget.href.split('-')[1]
            $.post($("#numero-delete-url").val(), {
                id: id
            }).done(data => {
                $.toast({
                    text: `
                        <i class="mdi mdi-check-all mr-2"></i> Suppression effectuée avec succès
                    `,
                    textColor: '#fff',
                    bgColor: '#198754'
                })
                $("#numero-paiement-"+id).remove()
            }).fail(err => {
                $.toast({
                    text: `
                        <i class="mdi mdi-block-helper mr-2"></i> Echec de la suppression
                    `,
                    textColor: '#fff',
                    bgColor: '#dc3545'
                })
            });
        })
    })
})

