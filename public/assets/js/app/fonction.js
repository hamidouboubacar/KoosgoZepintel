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
        // console.log($('#formUpdate').attr("action").toString())
        _url = $('#formUpdate').attr("action").toString().split("/");
        _url.pop()
        _url = _url.join("/")
        _url = _url + '/'+_id;

        $('#formUpdate').attr("action",_url);
        $("#editType").modal("show")
    })
})
