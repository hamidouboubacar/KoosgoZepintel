<script>

                $(document).ready( function () {
                    
                    table = $('#myTablecode').DataTable({
                        language:{
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                        },
                        'columnDefs': [ 
                            { orderable: false, targets: [0] },
                            {
                                'targets': "_all",
                                'render': function(data, type, full, meta){
                                    if(type === 'display'){
                                        data = strtrunc(data, 50);  //limite le nombre de caractère dans les datatable avec des pointillée
                                    }
                                    
                                    return data;
                                }
                            }],
                    });
                    /*$('#myTablecode').on('order.dt search.dt',function() {
                        console.log('bien')
                        
                        table
                            .on( 'preDraw', function () {
                                
                            } )
                            .on( 'draw.dt', function () {
                                $('#myTablecode tbody').find('tr').each(function(i){
                                    console.log(i)
                                    $(this).children('td:first').text(i+1)
                                    console.log($(this).children('td:first').text())
                                    console.log($(this).next().length)
                                    if($(this).next().length == 0) { //TODO: Too loop
                                        return false;
                                    }
                                })
                            });
                        
                    })*/


                    $('#myTable').DataTable({
                        order:[],
                        language:{
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                        },
                    });

                    $('#myTable2').DataTable({
                        searching:false,
                        language:{
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                        },
                    });

                    $('.myTable2').DataTable({
                        searching:false,
                        language:{
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                        },
                    });
                    
                    $('#myTable3, #myTable4, #myTable5').DataTable({
                        searching:false,
                        language:{
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                        },
                    });

                    var table = $('#myTable1').DataTable({
                        "order": [],
                        language:{
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json", 
                        },
                        
                        
                    });

                    $('.myTable1').DataTable({
                        "order": [],
                        language:{
                            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json", 
                        },
                        
                        
                    });

                    $("#myTable1 tfoot th").each( function ( i ) {
                        console.log(i)

                        // var element = $("#myTable1 tfoot th:not(.no-filter)")
                        // Pour enlever le filtre sur une colonne ajouter
                        //class="no-filter" dans le th correspondant dans le tfoot

                        if(!$("#myTable1 tfoot th").eq(i).hasClass("no-filter")){
                            
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

                    $(".myTable1 tfoot th").each( function ( i ) {
                        console.log(i)

                        // var element = $("#myTable1 tfoot th:not(.no-filter)")
                        // Pour enlever le filtre sur une colonne ajouter
                        //class="no-filter" dans le th correspondant dans le tfoot

                        if(!$(".myTable1 tfoot th").eq(i).hasClass("no-filter")){
                            
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

                   function enableOrNot(elmt){
                       //Bloquer ou autorise la suppersion d'un elmt 
                       $(elmt).on('click', function (e) {
                        if(!confirm("Confirmer pour activer/désactiver")){
                            e.preventDefault();
                        }
                    })
                   }
                });
        </script>