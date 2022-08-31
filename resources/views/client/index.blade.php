@extends('layouts.template.app')

@section('title')
    Clients
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                
                    @can('create', 'App\Models\Client')
                    <div class="row mb-2">
                        <div class="col-sm">
                            <div class="d-flex justify-content-end my-2">
                                <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#createUser"><i class="mdi mdi-plus-circle me-1"></i> Ajouter Client</button>
                            </div>   
                        </div>
                    </div>
                    @endcan
                    <table id="myTable1" class="table table-striped" data-client="{{ App\Models\Client::where('type', 'Client')->count() + 1 }}"
                    data-prospect="{{ App\Models\Client::where('type', 'Prospect')->count() + 1 }}"
                    >
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Nom & Prénom</th>
                                <th>Contact</th>
                                <th>Ville</th>
                                <th>Commercial</th>
                                <th style="width: 85px;">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Code</th>
                                <th>Nom & Prénom</th>
                                <th>Contact</th>
                                <th>Ville</th>
                                <th>Commercial</th>
                                <th style="width: 85px;">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($clients as $us)
                                <tr>
                                    <td>{{ $us->code_client ?? '' }}</td>
                                    <td>{!! $us->name ?? '' !!} </td>
                                    <td> {{ $us->telephone ?? ''}}</td>
                                    <td> {{ $us->ville ?? ''}}</td>
                                    <td> {{ $us->user->name ?? ''}}</td>
                                    <td class="">
                                            <a href="{{ route('client.show', ['client'=>$us->id]) }}" title="Voir"  class="action-icon text-secondary" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-eye"></i></a>
                                        @can('update', $us)
                                            <a href="{{ route('client.edit', ['client'=> $us->id]) }}" title="Modifier le client" class="edit action-icon text-primary" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-square-edit-outline"></i></a>
                                        @endcan
                                        @can('delete', $us)
                                            <a class="delete supprimer action-icon text-danger" href="{{ route ('client.supprimer',['client' => $us->id])}} " title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @include('client.modals.modals')
                </div>
    
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->
@endsection

@push('js_files')
    <script src="{{ asset('assets/js/app/client.js') }}"></script>
    <script>
        $(".numero_paiement").change(e => {
            console.log("change")
            $.post($("#numero-change-url").val(), {
                id: e.currentTarget.id,
                telephone: e.currentTarget.value
            });
        })

        $('#btn-ajouter-numero-paiement').click(e => {
            console.log('click')
            e.preventDefault()
            var values = $('#numero_paiement_ajout').val();

            if(values == "") {
                $.toast({
                    text: `
                        <i class="mdi mdi-block-helper mr-2"></i> Veuillez saisir un numero s'il vous plaît
                    `,
                    textColor: '#fff',
                    bgColor: '#dc3545'
                })
                return "";
            }
            
            $("#btn-ajouter-numero-paiement").html(`
                <span class="spinner-grow spinner-grow-sm mr-1" role="status" aria-hidden="true"></span> 
                Enregistrement...                        
            `)
            $.post($("#numero-add-url").val(), {
                "telephone": values,
                "client_id": $("#client_id").val()
            }).done(data => {
                $("#btn-ajouter-numero-paiement").html('Ajouter')
                $("#numero-box").append(`
                    <div class="form-row" id="numero-paiement-${data.id}">
                        <div class="col">
                            <div class="form-group">
                                <label for="telephone">Numéro de paiement <a class="action-icon text-danger numero-delete" href="#d-${data.id}" title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></a></label>
                                <input type="text" id="${data.id}" class="numero_paiement form-control" placeholder="+226 xx xx xx" value="${values}" />
                            </div>
                        </div>
                    </div>
                `)
                $('#numero_paiement_ajout').val("")
                $.toast({
                    text: `
                        <i class="mdi mdi-check-all mr-2"></i> Enregistrement effectué avec succès
                    `,
                    textColor: '#fff',
                    bgColor: '#198754'
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
            .fail(err => {
                $("#btn-ajouter-numero-paiement").html('Ajouter')
                $.toast({
                    text: `
                        <i class="mdi mdi-block-helper mr-2"></i> Echec de l'enregistrement
                    `,
                    textColor: '#fff',
                    bgColor: '#dc3545'
                })
            })
        })
    </script>
@endpush
