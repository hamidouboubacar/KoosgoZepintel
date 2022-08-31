@extends('layouts.template.app')

@section('title')
    Paiements de {{$client->name}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                
                    <table id="dataTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Facture</th>
                                <th>Date de paiement</th>
                                <th>Période</th>
                                <th>Mode de règl.</th>
                                <th>Montant</th>
                                <th>Reste</th>
                                <th>Commercial</th>
                                <th style="width: 85px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $item)
                                @foreach ($item->paiements as $paiement )
                                
                                <tr>
                                    <td>{{ $item->numero  ?? '' }}</td>
                                    <td>{{ $paiement->date_paiement ?? '' }} </td>
                                    <td> {{ $item->periode ?? ''}}</td>
                                    <td> {{ $paiement->mode_paiement ?? ''}}</td>
                                    <td> {{number_format($paiement->montant_payer,0,'.',' ')}} F</td>
                                    <td> {{number_format($paiement->reste,0,'.',' ')}} F</td>
                                    <td> {{ $item->user->name ?? ''}}</td>
                                    <td class="">
                                        <a href="{{ route('exportRecu', ['paiement'=>$paiement->id]) }}" type="button" target="_blank" class="action-icon text-secondary" title="Imprimer"> <i class="mdi mdi-printer"></i></a>    
                                        <a data-paiementid="{{ $paiement->id }}" data-documentid="{{ $item->id }}" data-email="{{ $item->client->email ?? '' }}" data-toggle="modal" data-target="#sendMailPaiement" title="Envoyer par mail"  class="action-icon text-info"> <i class="mdi mdi-email"></i></a>
  
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
    
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
@include('paiement.modals.paiementMail')
<!-- end row -->
@endsection

@push('js_files')

<script>
$('#contenu2').summernote();
$('.text-info').click(e => {
var target = e.currentTarget
console.log(target, $(target).data('email'), $(target).data('documentid'))
$('#email2').val($(target).data('email'))
$('#document_id2').val($(target).data('documentid'))
$('#paiement_id').val($(target).data('paiementid'))
})
</script>
@endpush
