@extends('layouts.template.app')

@section('title')
Résumés
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
 <form method="POST" action="{{ route('resume.search') }}" class="d-flex mb-3" id="form">
    @csrf
    <div class="form-group">
        <label for="date_debut">Date de début</label>
        <input type="date" name="date_debut" id="date_debut" value="{{ $debut ?? '' }}" class="form-control"
            placeholder="" aria-describedby="helpId" required>
    </div>
    <div class="form-group ml-2">
        <label for="date_fin">Date de fin</label>
        <input type="date" name="date_fin" value="{{ $fin ?? '' }}" id="date_fin" class="form-control"
            placeholder="" aria-describedby="helpId" required>
    </div>
    <div class="form-group ml-2 mt-3">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </div>
</form>
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
                                                <a href="{{ route('document.show', ['document'=> $document->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                <a href="{{ route('document.paiement', ['document'=> $document->id]) }}" class="action-icon text-blue"> <i class="mdi mdi-cash"></i></a>
                                                <a href="#" title="Envoyer par mail"  class="action-icon text-info"> <i class="mdi mdi-email"></i></a>
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
                                            <th>Client</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document_factures as $item)

                                        @foreach ($item->bonLivraison as $bon)
                                        <tr>
                                            <td>{{ $bon->numero_bl ?? '' }}</td>
                                            <td>{{ $item->numero ?? '' }} </td>
                                            <td>{{ $item->client->name ?? ''}}</td>
                                            <td class="">
                                                <a href="{{ route('bon.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                                <a href="#" title="Envoyer par mail"  class="action-icon text-info"> <i class="mdi mdi-email"></i></a>
                                                <a href="{{ route('exportBonlivraison', ['document'=>$item->id]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>      
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
                                            <th>Client</th>
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
                                            <td>{{ $bcc->client->name ?? '' }} </td>
                                            <td>{{ date('d-m-Y', strtotime($bcc->date)) ?? ''}}</td>
                                            <td> {{ date('d-m-Y', strtotime($bcc->echeance)) ?? ''}}</td>
                                            <td class="">
                                                <a href="{{ route('bonCommande.show',['bonCommande' => $bcc->id])}}" title="Voir" class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>                                     
                                                <a class="delete supprimer action-icon text-danger" href="{{ route ('bonCommande.supprimer',['bonCommande' => $bcc->id])}}" title="Supprimer"> <i class="mdi mdi-delete"></i></i></a>
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
