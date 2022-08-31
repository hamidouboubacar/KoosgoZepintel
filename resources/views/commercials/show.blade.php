@extends('layouts.template.app')

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="card-box">
        @include("commercials.modals.edit_planning_tache")
    </div>

    <div class="card-box">
        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Ajouter une tâche</h5>
        <form id="create-tache-form" action="">
            @csrf

            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label for="date">Tâche</label>
                        <input id="description" type="text" name="description" class="form-control"/>
                    </div>
                </div>
            </div>

            <input hidden name="planning_tache_id" type="text" value="{{ $item->id }}">
        </form>

        <button id="btn-ajouter-tache" class="btn btn-success">Ajouter</button>
    </div>

    <div class="card-box">
        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Liste des tâches</h5>
        @if(count($item->taches) > 0)
            @foreach($item->taches as $tache)
                <form id="form-{{ $tache->id }}" action="">
                    @csrf
                    <div class="form-group mt-3">
                        <div class="form-check">
                            <a style="margin-top: 1px; margin-right: 20px" href="#11" id="supprimer-{{ $tache->id }}" class="action-icon text-danger supprimer-tache" title="Supprimer la ligne du produit" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-trash-can"></i></a>
                            <input style="margin-top: 9px" @if($tache->etat) checked @endif class="form-check-input tache-check-box" type="checkbox" id="{{ $tache->id }}" >
                            <label id="label-{{ $tache->id }}" class="form-check-label" for="">
                                @if($tache->etat) 
                                    <strike>{{ $tache->description }}</strike> 
                                @else
                                    {{ $tache->description }}
                                @endif
                            </label>
                            <input hidden type="text" name="id" value="{{ $tache->id }}">
                            <input hidden type="text" id="description-{{ $tache->id }}" value="{{ $tache->description }}">
                        </div>
                    </div>
                </form>
            @endforeach
        @endif
        <div id="liste-tache"></div>
    </div>
</div>
@endsection
@push('js_files')
    <script src="{{ asset('assets/js/app/crud.js') }}"></script>
    <script>
        $('#date').flatpickr();
    </script>

    <script>
        function btnAjouterClick() {
            $("#btn-ajouter-tache").click(e => {
                e.preventDefault()
                var $inputs = $('#create-tache-form :input');

                var values = {};
                $inputs.each(function() {
                    values[this.name] = $(this).val();
                });
                
                $.post("{{ route('taches.store') }}", values)
                    .done(res => {
                        console.log(res)
                        $("#liste-tache").append(`
                            <form id="form-${res.tache.id}" action="">
                                <div class="form-group mt-3">
                                    <div class="form-check">
                                        <a style="margin-top: 1px; margin-right: 20px" href="#11" id="supprimer-${res.tache.id}" class="action-icon text-danger supprimer-tache" title="Supprimer la ligne du produit" data-plugin="tippy" data-tippy-animation="shift-away" data-tippy-inertia="true" data-tippy-duration="[600, 300]" data-tippy-arrow="true"> <i class="mdi mdi-trash-can"></i></a>
                                        <input style="margin-top: 9px" class="form-check-input tache-check-box" type="checkbox" id="${res.tache.id}" >
                                        <label id="label-${res.tache.id}" class="form-check-label" for="">${res.tache.description}</label>
                                        
                                        <input hidden type="text" name="id" value="${res.tache.id}">
                                        <input hidden type="text" id="description-${res.tache.id}" value="${res.tache.description}">
                                    </div>
                                </div>
                            </form>
                        `)
                        $("#description").val("")
                        tacheCheckBoxClick()
                        supprimerTacheClick()
                    })
            });
        }

        function tacheCheckBoxClick() {
            $(".tache-check-box").click(e => {
                console.log(e, e.currentTarget)
                var target = e.currentTarget
                var id = e.currentTarget.id
                var value = $(`#description-${id}`).val()

                var $inputs = $(`#form-${id} :input`);

                var values = {};
                $inputs.each(function() {
                    values[this.name] = $(this).val();
                });
                if($("#"+id).is(":checked")) values["etat"] = 1
                else values["etat"] = 0 

                console.log(id, values, $(target).is(":checked"))

                $.post("{{ route('taches.change_stat') }}", values)
                    .done(res => {
                        if($("#"+id).is(":checked")) $("#label-"+id).html(`<strike>${value}</strike>`)
                        else $("#label-"+id).html(`${value}`)
                    })
            })
        }
        
        function supprimerTacheClick() {
            $(".supprimer-tache").click(e => {
                var id = e.currentTarget.id.split('-')[1]
                $.post("{{ route('taches.supprimer') }}", {id: id})
                    .done(res => {
                        $("#form-"+id).remove()
                    })
            })
        }

        $(() => {
            btnAjouterClick()
            tacheCheckBoxClick()
            supprimerTacheClick()
        })
        
    </script>
@endpush

