@extends('layouts.template.app')

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-end my-2">
        <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#createUser">Ajouter</button> -->
        <a href="{{ route('articles.create') }}" class="btn btn-primary">Ajouter</a>
    </div>
    <table id="dataTable" class="table table-striped">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Nature</th>
                <th>Prix U.</th>
                <th>Disponible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr>

                    <td>{{ $article->id ?? '' }} </td>
                    <td>{{ $article->designation ?? ''}}</td>
                    <td>{{ $article->nature ?? ''}}</td>
                    <td>{{ $article->nature ?? ''}}</td>

                    <td class="">
                        <a href="{{ route('articles.edit', ['article' => $article->id]) }} " title="Modifier " class="edit"> <i class="fas fa-edit"></i></a>
                        &nbsp &nbsp &nbsp;
                            <a class="supprimer" href="{{ route ('articles.destroy',['article' =>$article->id])}} " title="Bloquer " style="color: red" class="mr-1"> <i class="fa fa-times" aria-hidden="true"></i></a>                </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('fonction.modals.modals')
</div>
@endsection
@push('js_files')
    <script src="{{ asset('assets/js/app/fonction.js') }}"></script>
@endpush

