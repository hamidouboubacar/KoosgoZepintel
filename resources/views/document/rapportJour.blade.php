@extends('layouts.template.app')

@section('title')
Rapport Journalier
@endsection
@section('content')

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
     <!-- Start Content-->
     <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <div class="card-box">
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
                                        @php
                                            echo empty($item->bonLivraison);
                                        @endphp
                                        <tr>
                                            <td>{{ $item->numero ?? '---' }}</td>
                                            <td>{{ $item->date ?? '---' }}</td>
                                            <td>{{ $item->client->name ?? '---' }}</td>
                                            <td>{{number_format($item->tva,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->montantttc,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->montantht,0,'.',' ')}} F</td>
                                            <td>{{number_format($item->reste_a_payer,0,'.',' ')}} F</td>
                                            <td class="">
                                                <a href="{{ route('document.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                <a href="{{ route('document.edit', ['document' => $item, 'type' => 'Facture', 'redirect' => url()->current()]) }} " class="action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                @if ($item->reste_a_payer==0)
                                                <a href="{{route('paiements.client', ['client' => $item->client->id])}}" title="Recouvrement" class="action-icon text-blue"> <i class="mdi mdi-receipt"></i></a>  
                                                    @if (!empty($item->bonLivraison[0]))
                                                    @else   
                                                    <a href="{{route('livraison.livraison', ['document' => $item->id])}}" title="Bon de livraison" class="action-icon text-normal"> <i class="mdi mdi-file"></i></a> 
                                                    @endif  
                                                @else
                                                <a href="{{ route('document.paiement', ['document'=> $item->id]) }}" class="action-icon text-blue"> <i class="mdi mdi-cash"></i></a>    
                                                @endif
                                                <a href="{{ route ('document.destroy', $item)}}" class="delete action-icon text-danger"> <i class="mdi mdi-delete"></i></a> 
                                                <a href="{{ route('exportDevis', ['document'=>$item->id, 'sans_signature' => 1]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>               
                                            </td>
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
                                                    <a href="{{ route('document.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                    <a href="{{ route('document.facturer', ['document'=> $item->id]) }}" title="Facturer"  class="action-icon text-info"> <i class="mdi mdi-credit-card"></i></a>
                                                    <a href="{{ route('document.edit', ['document' => $item, 'type' => 'Devis', 'redirect' => url()->current()]) }}" class="action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                    <a href="{{ route ('document.destroy', $item)}}" class="delete action-icon text-danger"> <i class="mdi mdi-delete"></i></a> 
                                                    <a href="{{ route('exportDevis', ['document'=>$item->id, 'sans_signature' => 1]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>               
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
