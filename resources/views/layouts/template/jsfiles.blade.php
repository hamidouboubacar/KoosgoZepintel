<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="{{ asset("assets/js/vendor.min.js") }}"></script>
<script src="{{ asset("js/pdfobject.min.js") }}"></script>
<script src="{{ asset("assets/libs/jquery-toast-plugin/jquery.toast.min.js") }}"></script>
<script src="{{ asset("assets/libs/pages/toastr.init.js") }}"></script>
<script src="{{ asset("assets/libs/flatpickr/flatpickr.min.js") }}"></script>
<script src="{{ asset("assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js") }}"></script>
<script src="{{ asset("assets/libs/clockpicker/bootstrap-clockpicker.min.js") }}"></script>
<script src="{{ asset("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
<script src="{{ asset("assets/libs/chart.js/Chart.bundle.min.js") }}"></script>
<script src="{{ asset("assets/libs/selectize/js/standalone/selectize.min.js") }}"></script>
<script src="{{ asset("assets/js/pages/dashboard-1.init.js") }}"></script>
<script src="{{ asset("assets/libs/tippy.js/tippy.all.min.js") }}"></script>
<script src="{{ asset("assets/js/app.min.js") }}"></script>
<script src="{{ asset("assets/js/bstable.js") }}"></script>
<script src="{{ asset("js/select2.min.js") }}"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    // Basic example
    var example1 = new BSTable("table1");
    example1.init();

    // Example with a add new row button & only some columns editable & removed actions column label
    var example2 = new BSTable("table2", {
        editableColumns:"0,1,2",
        $addButton: $('#table2-new-row-button'),
        onEdit:function() {
            console.log("EDITED");
        },
        advanced: {
            columnLabel: ''
        }
    });
    example2.init();

    // Example with dynamic table that requires BSTable refresh
    // TODO Create method to randomly seed a random amount of rows in the table
    var example3 = new BSTable("table3");
    example3.init();

    function dynamicTableValuesExample() {
        // Generate new values for the table and show how BSTable updates
        let names = ['Matt', 'John', 'Billy', 'Erica', 'Sammy', 'Tom', 'Tate', 'Emily', 'Mike', 'Bob'];
        let numberOfRows = Math.floor(Math.random() * 10);

        document.getElementById("table3-body").innerHTML = '';	// Clear current table
        for(let i = 0; i < numberOfRows; i++) {
            let randomNameIndex = Math.floor(Math.random() * 10);

            let row = document.createElement("tr");
            row.innerHTML = `<th scope="row">` + i + `</th><td>Value</td><td>` + names[randomNameIndex] + `</td><td>@twitter</td>`;
            document.getElementById("table3-body").append(row);
        }

        example3.refresh();
    }
    
    $(() => {
        $('.select2').select2({
            language: "fr"
        });
        $('.select2-selection').height('34')
        $('.select2-selection').css('border-color', '#C5C5C5')
        
        $("#dataTable tfoot th").each( function ( i ) {
            console.log(i)

            // var element = $("#myTable1 tfoot th:not(.no-filter)")
            // Pour enlever le filtre sur une colonne ajouter
            //class="no-filter" dans le th correspondant dans le tfoot

            if(!$("#dataTable tfoot th").eq(i).hasClass("no-filter")){
                
                var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $(this).empty() )
                    .on('change', function () {
                        table.column( i )
                            .search( $(this).val() )
                            .draw();
                    } );
            
                table.column( i ).data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );

            }
            

        } );

        $("table.num tbody tr").each( function(i){
            console.log($("table.num tbody tr:nth-child("+i+") td").first().val());
            
        });

        $(".dataTable tfoot th").each( function ( i ) {
            console.log(i)

            // var element = $("#myTable1 tfoot th:not(.no-filter)")
            // Pour enlever le filtre sur une colonne ajouter
            //class="no-filter" dans le th correspondant dans le tfoot

            if(!$(".dataTable tfoot th").eq(i).hasClass("no-filter")){
                
                var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $(this).empty() )
                    .on('change', function () {
                        table.column( i )
                            .search( $(this).val() )
                            .draw();
                    } );
            
                table.column( i ).data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );

            }
            

        } );
    });

</script>

@include('layouts.template.jsdise')

<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>
<script>
try {
fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
return true;
}).catch(function(e) {
var carbonScript = document.createElement("script");
carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
carbonScript.id = "_carbonads_js";
document.getElementById("carbon-block").appendChild(carbonScript);
});
} catch (error) {
console.log(error);
}
</script>


<script>
    if(document.getElementById('dataTable')){
        $(document).ready(function () {
            $('#dataTable, #dataTable1, #dataTable2, #dataTable3, #dataTable4, #dataTable5, #dataTable6').DataTable({
                ordering:false,
                language:{
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                },
            });
        });
    }

    $(() => {
        console.log("Document ready", $("#close-setting-theme"))
        $("#close-setting-theme").click();
        $.get("{{route('notifications.get')}}").done(data => {
            $("#notification-content").html(data.content)
            $("#icon-belt").append("<span class=badge badge-danger rounded-circle noti-icon-badge'>1</span>")
        })
    })


</script>
