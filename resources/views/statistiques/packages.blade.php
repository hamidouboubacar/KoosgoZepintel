@extends('layouts.template.app')

@section('title')
Packages
@endsection

@section('content')
<div class="container-fluid">
    <form action="" method="get">
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Evolution / Package</h5>
            <div class="form-row mt-2">
                <div class="col">
                    <label for="">Package</sup></label>
                    <select class="form-control select2" name="package_id" id="" required>
                        <option value="">---</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->nom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col">
                    <label for="">Année</label>
                    <select class="form-control" name="annee" id="" required>
                        <option value="">---</option>
                        @foreach($annees as $annee)
                            <option value="{{ $annee }}">{{ $annee }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="btn btn-success mt-2">Visualiser</button>
            
            @if($evolution)
                <div class="mt-4 chartjs-chart">
                    <canvas id="chart-chiffre-affaire" height="250" data-colors="#4a81d4,#fa5c7c,#4fc6e1,#ebeff2"> </canvas>
                </div>
            @endif
        </div>
    </form>
    
    @if($evolution)
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Variation des indicateurs de package ({{ $package_evolution->nom }} - année {{ $year }})</h5>
            <div class="table-responsive">
                <table id="myTable1" class="table dataTable table-centered table-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Mois</th>
                            <th>Nombre de client</th>
                            <th>Chiffre d'affaire</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>Mois</th>
                        <th>Nombre de client</th>
                        <th>Chiffre d'affaire</th>
                    </tfoot>
                    <tbody>
                        @if(isset($package_evolution)) @for($i = 0; $i < count($package_evolution['labels']); $i++)
                            <tr>
                                <td>{{ $package_evolution['labels'][$i] }}</td>
                                <td>{{ number_format($package_evolution['total_client'][$i],0,'.',' ') }}</td>
                                <td>{{ number_format($package_evolution['data'][$i],0,'.',' ') }} FCFA</td>
                            </tr>
                        @endfor @endif
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Packages</h5>
            <div class="table-responsive">
                <table id="myTable1" class="table dataTable table-centered table-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Package</th>
                            <th>Nombre de client</th>
                            <th>Nombre de facture</th>
                            <th>Chiffre d'affaire</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>Package</th>
                        <th>Nombre de client</th>
                        <th>Nombre de facture</th>
                        <th>Chiffre d'affaire</th>
                    </tfoot>
                    <tbody>
                        @for($i = 0; $i < count($variation_packages['labels']); $i++)
                            <tr>
                                <td>{{ $variation_packages['labels'][$i] }}</td>
                                <td>{{ number_format($variation_packages['total_client'][$i],0,'.',' ') }}</td>
                                <td>{{ number_format($variation_packages['total_facture'][$i],0,'.',' ') }}</td>
                                <td>{{ number_format($variation_packages['chiffre_affaire'][$i],0,'.',' ') ?? 0 }} FCFA</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <!-- end row -->

</div>
@endsection

@if($evolution)
    @push('js_files')
    <script>
        // Chiffre d'Affaire
        var ctxChiffreAffaire = document.getElementById('chart-chiffre-affaire').getContext('2d');
        const chartChiffreAffaire = new Chart(ctxChiffreAffaire, {
            type: 'line',
            data: {
                labels: @json($package_evolution['labels']),
                datasets: [{
                    label: '# Evolution Package ({{ $package_evolution->nom }} - {{ $year }})',
                    data: @json($package_evolution['data']),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
        });
    </script>
    @endpush
@endif