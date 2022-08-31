@extends('layouts.template.app')

@section('title')
    Refacturation
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm">
                                @can('create', 'App\Models\Refacturation')
                                <div class="d-flex justify-content-end my-2">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#createRefacturation"><i class="mdi mdi-plus-circle me-1"></i> Nouvel refacturation</button>
                                </div>
                                @endcan
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="myTable1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Libellé</th>
                                        <th>Date</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Libellé</th>
                                        <th>Date</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($refacturations as $item)
                                    <tr>
                                        <td>{{ $item->id ?? '' }}</td>
                                        <td>{{'Refacturations de '.date('M-Y', strtotime($item->created_at))}}</td>
                                        <td> {{ date('d-M-Y', strtotime($item->created_at)) ?? ''}}</td>
                                        <td class="">
                                            <a href="{{ route('refacturation.show', ['refacturation'=> $item->id]) }}" title="Voir"  class="action-icon text-secondary"> <i class="mdi mdi-eye"></i></a>
                                         
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
        @include('refacturation.modals.edit')
    </div>
@endsection

@push('js_files')
<script src="{{ asset('assets/js/app/refacturation.js') }}"></script>
<script>
    $('#date').flatpickr({
    defaultDate: 'today'
});
</script>
<script>
    function tousClients() {
      var check = document.getElementById("myCheck").checked;
      let displayDiv = document.getElementById("displayDiv");
      let select_id = document.getElementById("select_id");
      let option = document.getElementsByClassName("option");
      if(check == true){
          var length = document.getElementsByClassName("option").length
          for(i=0; i<length; i++){
            option[i].selected = true
          }
          displayDiv.style = 'display'
          select_id.style.display = 'none'
      }else{
        displayDiv.style.display = 'none'
        select_id.style = 'display'
      }
      
    }
    </script>
@endpush
