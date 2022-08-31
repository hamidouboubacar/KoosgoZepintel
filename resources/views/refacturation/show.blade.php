@extends('layouts.template.app')

@section('title')
Détails refacturation
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm">
                               @if ($documents[0]->etat == 3)
                                <div style="float:left;">
                                    <a  class="btn btn-blue validation" href="{{route('refacturation.validation', ['refacturation'=> $id]) }}">Validation</a>
                                  </div>
                               @else

                                <div class="d-flex justify-content-end my-2">
                                    <button data-refacturationid="{{ $id }}" class="btn btn-primary text" data-toggle="modal" data-target="#sendMailRefacturations">E-mail groupés</button>
                                </div>
                               @endif
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="myTable1">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Reference</th>
                                            <th>Date</th>
                                            <th>Période</th>
                                            <th>Client</th>
                                            <th>TVA</th>
                                            <th>Montant TTC</th>
                                            <th>Montant HT</th>
                                            <th style="width: 85px;">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Reference</th>
                                        <th>Date</th>
                                        <th>Période</th>
                                        <th>Client</th>
                                        <th>TVA</th>
                                        <th>Montant TTC</th>
                                        <th>Montant HT</th>
                                        <th style="width: 85px;">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($documents as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{ $item->numero ?? '---' }}</td>
                                        <td>{{ $item->date ?? '---' }}</td>
                                        <td> {{ $item->periode ?? ''}}</td>
                                        <td>{{ $item->client->name ?? '---' }}</td>
                                        <td>{{number_format($item->tva,0,'.',' ') ?? ''}} F</td>
                                        <td>{{number_format($item->montantttc,0,'.',' ')}} F</td>
                                        <td>{{number_format($item->montantht,0,'.',' ')}} F</td>
                                        <td class="">
                                            <a href="{{ route('document.show', ['document'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                            <a href="{{ route('document.edit', ['document' => $item, 'type' => 'Facture', 'redirect' => url()->current()]) }} " class="action-icon text-primary"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a class="delete supprimer action-icon text-danger" href="{{route('supprimer',['refacturation'=> $id, 'document'=>$item->id])}} " title="Supprimer" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-delete"></i></i></a>
                                            <a href="{{ route('exportDevis', ['document'=>$item->id, 'sans_signature' => 1]) }}" type="button" target="_blank" class="action-icon text-warning" title="Imprimer"> <i class="mdi mdi-file"></i></a>               
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        @include('refacturation.modals.email')
    </div>
@endsection

@push('js_files')
<script>
    $('#date').flatpickr({
    defaultDate: 'today'
});
</script>
<script>
    $('#contenu').summernote();
       $('.text').click(e => {
        var target = e.currentTarget
        console.log(target, $(target).data('email'), $(target).data('documentid'))
        $('#refacturation_id').val($(target).data('refacturationid'))
    })
</script>
<script>
    $('.validation').on('click', function (e) {
        if (!confirm("Voulez-vous valider cette refacturation ?")){
            e.preventDefault();
        }
    })
</script>
@endpush
