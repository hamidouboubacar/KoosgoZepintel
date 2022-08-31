@extends('layouts.template.app')

@section('title')
Clients
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Clients</a></li>
                        <li class="breadcrumb-item active">Affichage client</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

     <!-- Start Content-->
     <div class="container-fluid">
        @can('viewDocument', 'App\Models\Client')
     <div class="row">
        <div class="col">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fe-bar-chart-line- font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">{{number_format($chiffres_affaire,0,'.',' ')}} F CFA</h3>
                                <p class="text-muted mb-1 text-truncate">CHIFFRE D'AFFAIRES</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                <i class="fe-bar-chart-line- font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">{{number_format($montant_recouvrer,0,'.',' ')}} F CFA</h3>
                                <p class="text-muted mb-1 text-truncate">MONTANT RECOUVRE</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                <i class="fe-bar-chart-line- font-22 avatar-title text-info"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">{{number_format($encours,0,'.',' ')}} F CFA</h3>
                                <p class="text-muted mb-1 text-truncate">ENCOURS CLIENT</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
     </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card-box">

                    <div class="media mb-5">
                        <img class="d-flex mr-3 rounded-circle avatar-lg" src="../assets/images/users/avatar.png" alt="Generic placeholder image">
                        <div class="media-body">
                            <h4 class="mt-0 mb-1">{{ $client->name}}</h4>
                            @if(isset($client->email))
                                <p class="text-muted"><i class="mdi mdi-email"></i> {{ $client->email }}</p>
                            @endif
                            @if(isset($client->phone))
                                <p class="text-muted"><i class="mdi mdi-phone"></i> {{ $client->phone }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="button-list">
                        <a type="button" href="{{ route('document.create', ['client'=>$client->id, 'type' => 'Devis', 'redirect' => url()->current()]) }}" class="btn btn-primary waves-effect waves-light"><span class="btn-label"><i class="mdi mdi-plus"></i></span>Nouveau Devis</a>
                        <a href="{{ route('document.create', ['client'=>$client->id, 'type' => 'Facture', 'redirect' => url()->current()]) }}" type="button" class="btn btn-primary waves-effect waves-light"><span class="btn-label"><i class="mdi mdi-plus"></i></span>Nouvelle Facture</a>
                        <a href="{{route('paiements.client', ['client' => $client->id])}}" type="button"  class="btn btn-primary"><span class="btn-label"><i class="mdi mdi-plus"></i></span>Recouvrement</a>
                    </div>
                    @endcan
                    <br>
                    
                    <ul class="nav nav-tabs nav-bordered">
                        
                        <li class="nav-item">
                            <a href="#facture" data-toggle="tab" aria-expanded="false" class="nav-link active ">
                                Facture
                            </a>
                        </li><li class="nav-item">
                            <a href="#factureAvoir" data-toggle="tab" aria-expanded="false" class="nav-link">
                                Facture Avoir
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#devis" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                Devis
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#impaye" data-toggle="tab" aria-expanded="false" class="nav-link">
                                Impayés
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#bl" data-toggle="tab" aria-expanded="false" class="nav-link">
                                BL
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#bc" data-toggle="tab" aria-expanded="false" class="nav-link">
                                BC
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="facture">
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="dataTable">
                                <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th>Date</th>
                                            <th>Période</th>
                                            <th>TVA</th>
                                            <th>Montant HT</th>
                                            <th>Montant TTC</th>
                                            <th>Reste à payer</th>
                                            <th style="width: 85px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document_factures as $item)
                                        @php
                                            echo empty($item->bonLivraison);
                                        @endphp
                                        <tr>
                                            <td>{{ $item->numero ?? '---' }}</td>
                                            <td>{{ $item->date ?? '---' }}</td>
                                            <td> {{ $item->perio ?? ''}}</td>
                                            <td>{{number_format($item->tva,0,'.',' ') ?? ''}} F</td>
                                            <td>{{number_format($item->montantht,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->montantttc,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->reste_a_payer,0,'.',' ')}} F</td>
                                            <td class="">
                                                @can('viewDocument', 'App\Models\Client')
                                                <a href="{{ route('document.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                <a href="{{ route('document.edit', ['document' => $item, 'type' => 'Facture', 'redirect' => url()->current()]) }}" title="Modifier" class="action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a data-documentid="{{ $item->id }} " data-email="{{ $item->client->email ?? '' }}" data-toggle="modal" data-target="#sendMailDocument" title="Envoyer par mail"  class="action-icon text-info"> <i class="mdi mdi-email"></i></a>
                                                @if ($item->reste_a_payer==0)
                                                <a href="{{route('paiements.client', ['client' => $client->id])}}" title="Recouvrement" class="action-icon text-blue"> <i class="mdi mdi-receipt"></i></a>  
                                                    @if (!empty($item->bonLivraison[0]))
                                                    @else   
                                                    <a href="{{route('livraison.livraison', ['document' => $item->id])}}" title="Bon de livraison" class="action-icon text-normal"> <i class="mdi mdi-file"></i></a> 
                                                    @endif  
                                                @else
                                                <a href="{{ route('document.paiement', ['document'=> $item->id]) }}" title="Payer" class="action-icon text-blue"> <i class="mdi mdi-cash"></i></a>    
                                                @endif
                                                <a href="{{ route ('document.destroy', $item)}}" title="Supprimer" class="delete action-icon text-danger"> <i class="mdi mdi-delete"></i></a> 
                                                <a href="{{ route('exportDevis', ['document'=>$item->id, 'sans_signature' => 1]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>               
                                          @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="factureAvoir">
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="dataTable">
                                <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th>Date</th>
                                            <th>Période</th>
                                            <th>TVA</th>
                                            <th>Montant HT</th>
                                            <th>Montant TTC</th>
                                            <th>Reste à payer</th>
                                            <th style="width: 85px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document_avoirs as $item)
                                        @php
                                            echo empty($item->bonLivraison);
                                        @endphp
                                        <tr>
                                            <td>{{ $item->numero ?? '---' }}</td>
                                            <td>{{ $item->date ?? '---' }}</td>
                                            <td> {{ $item->perio ?? ''}}</td>
                                            <td>{{number_format($item->tva,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->montantht,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->montantttc,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->reste_a_payer,0,'.',' ')}} F</td>
                                            <td class="">
                                                @can('viewDocument', 'App\Models\Client')
                                                <a href="{{ route('document.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                <a href="{{ route('document.edit', ['document' => $item, 'type' => 'Facture', 'redirect' => url()->current()]) }} " class="action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a data-documentid="{{ $item->id }} " data-email="{{ $item->client->email ?? '' }}" data-toggle="modal" data-target="#sendMailDocument" title="Envoyer par mail"  class="action-icon text-info"> <i class="mdi mdi-email"></i></a>
                                                @if ($item->reste_a_payer==0)
                                                <a href="{{route('paiements.client', ['client' => $client->id])}}" title="Recouvrement" class="action-icon text-blue"> <i class="mdi mdi-receipt"></i></a>  
                                                    @if (!empty($item->bonLivraison[0]))
                                                    @else   
                                                    <a href="{{route('livraison.livraison', ['document' => $item->id])}}" title="Bon de livraison" class="action-icon text-normal"> <i class="mdi mdi-file"></i></a> 
                                                    @endif  
                                                @else
                                                <a href="{{ route('document.paiement', ['document'=> $item->id]) }}" class="action-icon text-blue"> <i class="mdi mdi-cash"></i></a>    
                                                @endif
                                                <a href="{{ route ('document.destroy', $item)}}" class="delete action-icon text-danger"> <i class="mdi mdi-delete"></i></a> 
                                                <a href="{{ route('exportDevis', ['document'=>$item->id, 'sans_signature' => 1]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>               
                                            @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="devis">
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="dataTable1">
                                    <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th>Date</th>
                                            <th>TVA</th>
                                            <th>Montant HT</th>
                                            <th>Montant TTC</th>
                                            <th style="width: 85px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document_devis as $item)
                                            <tr>
                                                <td>{{ $item->numero ?? '---' }}</td>
                                                <td>{{ $item->date ?? '---' }}</td>
                                                <td>{{number_format($item->tva,0,'.',' ')}} F</td>
                                                <td>{{number_format($item->montantht,0,'.',' ')}} F</td>
                                                <td>{{number_format($item->montantttc,0,'.',' ')}} F</td>
                                                <td class="">
                                                    @can('viewDocument', 'App\Models\Client')
                                                    <a href="{{ route('document.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                    <a href="{{ route('document.facturer', ['document'=> $item->id]) }}" title="Facturer"  class="action-icon text-info"> <i class="mdi mdi-credit-card"></i></a>
                                                    <a data-documentid="{{ $item->id }} " data-email="{{ $item->client->email ?? '' }}" data-toggle="modal" data-target="#sendMailDocument" title="Envoyer par mail"  class="action-icon text-info"> <i class="mdi mdi-email"></i></a>
                                                    <a href="{{ route('document.edit', ['document' => $item, 'type' => 'Devis', 'redirect' => url()->current()]) }}" class="action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                    <a href="{{ route ('document.destroy', $item)}}" class="delete action-icon text-danger"> <i class="mdi mdi-delete"></i></a> 
                                                    <a href="{{ route('exportDevis', ['document'=>$item->id, 'sans_signature' => 1]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>               
                                               @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                         </div>
                        <div class="tab-pane" id="impaye">
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="dataTable3">
                                    <thead>
                                        <tr>
                                            <th>Numéro</th>
                                            <th>Date</th>
                                            <th>Montant TTC</th>
                                            <th>Reste à payer</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document_impayes as $document)
                                        <tr>
                                            <td>{{ $document->numero ?? '' }}</td>
                                            <td>{{ $document->date ?? '' }} </td>
                                            <td>{{number_format($document->montantttc,0,'.',' ')}} F</td>
                                            <td>{{number_format($document->reste_a_payer,0,'.',' ')}} F</td>
                                            
                                            <td class="">
                                                @can('viewDocument', 'App\Models\Client')
                                                <a href="{{ route('document.show', ['document'=> $document->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                <a href="{{ route('document.paiement', ['document'=> $document->id]) }}" class="action-icon text-blue"> <i class="mdi mdi-cash"></i></a>
                                                <a data-documentid="{{ $document->id }} " data-email="{{ $document->client->email ?? '' }}" data-toggle="modal" data-target="#sendMailDocument" title="Envoyer par mail"  class="action-icon text-info"> <i class="mdi mdi-email"></i></a>
                                            @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="bl">
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="dataTable4">
                                    <thead>
                                        <tr>
                                            <th>Numéro</th>
                                            <th>Référence facture</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document_factures as $item)

                                        @foreach ($item->bonLivraison as $bon)
                                        <tr>
                                            <td>{{ $bon->numero_bl ?? '' }}</td>
                                            <td>{{ $item->numero ?? '' }} </td>
                                            <td class="">
                                                @can('viewDocument', 'App\Models\Client')
                                                <a href="{{ route('bon.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                <a data-documentid="{{ $item->id }} " data-email="{{ $item->client->email ?? '' }}" data-toggle="modal" data-target="#sendMailBl" title="Envoyer par mail"  class="action-icon text-info"> <i class="mdi mdi-email"></i></a>
                                                <a href="{{ route('exportBonlivraison', ['document'=>$item->id]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>      
                                           @endcan
                                            </td>
                                        </tr>
                                            
                                        @endforeach
                                    
                                  
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="bc">
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="dataTable5">
                                    <thead>
                                        <tr>
                                            <th>Numéro</th>
                                            <th>Référence</th>
                                            <th>Date</th>
                                            <th>Echéance</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bonCommandes as $bcc)
                                        <tr>
                                            <td>{{ $bcc->id ?? '' }}</td>
                                            <td>{{ $bcc->reference ?? '' }} </td>
                                            <td>{{ date('d-m-Y', strtotime($bcc->date)) ?? ''}}</td>
                                            <td> {{ date('d-m-Y', strtotime($bcc->echeance)) ?? ''}}</td>
                                            <td class="">
                                                @can('viewDocument', 'App\Models\Client')
                                                <a href="{{ route('bonCommande.show',['bonCommande' => $bcc->id])}}" title="Voir" class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>                                     
                                                <a class="delete supprimer action-icon text-danger" href="{{ route ('bonCommande.supprimer',['bonCommande' => $bcc->id])}}" title="Supprimer"> <i class="mdi mdi-delete"></i></i></a>
                                            @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container -->
    @include('packages.modals.modals')
    @include('client.modals.mail')
    @include('client.modals.bonLivraison')
    @endsection
    
    @push('js_files')
        <script src="{{ asset('assets/js/app/crud.js') }}"></script>
        <script src="{{ asset('assets/js/app/paiement.js') }}"></script>
        <script src="{{ asset('assets/js/app/mail.js') }}"></script>
        <script>
            $('#contenu').summernote();
            $('.text-info').click(e => {
                var target = e.currentTarget
                console.log(target, $(target).data('email'), $(target).data('documentid'))
                $('#email1').val($(target).data('email'))
                $('#document_id').val($(target).data('documentid'))
            })
        </script>

<script>
    $('#contenu2').summernote();
    $('.text-info').click(e => {
        var target = e.currentTarget
        console.log(target, $(target).data('email'), $(target).data('documentid'))
        $('#email2').val($(target).data('email'))
        $('#document_id2').val($(target).data('documentid'))
    })
</script>
    @endpush
