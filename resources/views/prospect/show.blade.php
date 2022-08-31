@extends('layouts.template.app')

@section('title')
Prospects
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
                        <li class="breadcrumb-item active">Affichage prospect</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

     <!-- Start Content-->
     <div class="container-fluid">

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
                    @can('viewDocument', 'App\Models\Client')
                    <div class="button-list">
                        <a type="button" href="{{ route('document.create', ['client'=>$client->id, 'type' => 'Devis', 'redirect' => url()->current()]) }}" class="btn btn-primary waves-effect waves-light"><span class="btn-label"><i class="mdi mdi-plus"></i></span>Nouveau Devis</a>
                        <a href="{{ route('document.create', ['client'=>$client->id, 'type' => 'Facture', 'redirect' => url()->current()]) }}" type="button" class="btn btn-primary waves-effect waves-light"><span class="btn-label"><i class="mdi mdi-plus"></i></span>Nouvelle Facture</a>
                        {{-- <a href="{{route('paiements.client', ['client' => $client->id])}}" type="button"  class="btn btn-primary"><span class="btn-label"><i class="mdi mdi-plus"></i></span>Recouvrement</a> --}}
                    </div>
                    @endcan
                    <br>
                    
                    <ul class="nav nav-tabs nav-bordered">
                        
                        <li class="nav-item">
                            <a href="#facture" data-toggle="tab" aria-expanded="false" class="nav-link active ">
                                Facture
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#devis" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                Devis
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
                                            <th>Client</th>
                                            <th>TVA</th>
                                            <th>Montant TTC</th>
                                            <th>Montant HT</th>
                                            <th>Reste à payer</th>
                                            <th style="width: 85px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document_factures as $item)
                                        <tr>
                                            <td>{{ $item->numero ?? '---' }}</td>
                                            <td>{{ $item->date ?? '---' }}</td>
                                            <td>{{ $item->client->name ?? '---' }}</td>
                                            <td>{{number_format($item->tva,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->montantttc,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->montantht,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->reste_a_payer,0,'.',' ')}} F</td>
                                            <td class="">
                                                @can('viewDocument', 'App\Models\Client')
                                                <a href="{{ route('document.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                <a href="{{ route('document.edit', ['document' => $item, 'type' => 'Facture', 'redirect' => url()->current()]) }} " class="action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
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
                                            <th>Client</th>
                                            <th>TVA</th>
                                            <th>Montant TTC</th>
                                            <th>Montant HT</th>
                                            <th style="width: 85px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document_devis as $item)
                                            <tr>
                                                <td>{{ $item->numero ?? '---' }}</td>
                                                <td>{{ $item->date ?? '---' }}</td>
                                                <td>{{ $item->client->name ?? '---' }}</td>
                                                <td>{{number_format($item->tva,0,'.',' ')}} F</td>
                                                <td>{{number_format($item->montantttc,0,'.',' ')}} F</td>
                                                <td>{{number_format($item->montantht,0,'.',' ')}} F</td>
                                                <td class="">
                                                    @can('viewDocument', 'App\Models\Client')
                                                    <a href="{{ route('document.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                    <a href="{{ route('document.facturer', ['document'=> $item->id]) }}" title="Facturer"  class="action-icon text-info"> <i class="mdi mdi-credit-card"></i></a>
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
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container -->
    @include('packages.modals.modals')
    @endsection
    
    @push('js_files')
        <script src="{{ asset('assets/js/app/crud.js') }}"></script>
        <script src="{{ asset('assets/js/app/paiement.js') }}"></script>
    @endpush
