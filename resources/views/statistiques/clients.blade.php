@extends('layouts.template.app')

@section('title')
Clients
@endsection

@section('content')
<div class="container-fluid">
    <form action="" method="get">
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Evolution / Client</h5>
            <div class="form-row mt-2">
                <div class="col">
                    <label for="">Clients</sup></label>
                    <select class="form-control select2" name="client_id" id="" required>
                        <option value="">---</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
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
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Variation des indicateurs de vente ({{ $client_evolution->name }} | année {{ $year }})</h5>
            <div class="table-responsive">
                <table id="" class="table dataTable table-centered table-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Mois</th>
                            <th>Chiffre A. HT</th>
                            <th>Chiffre A. TTC</th>
                            <th>Recouvré</th>
                            <th>TVA</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th>Mois</th>
                        <th>Chiffre A. HT</th>
                        <th>Chiffre A. TTC</th>
                        <th>Recouvré</th>
                        <th>TVA</th>
                    </tfoot>
                    <tbody>
                        @if(isset($client_evolution)) @for($i = 0; $i < 12; $i++)
                            <tr>
                                <td>{{ $client_evolution['labels'][$i] }}</td>
                                <td>{{ number_format($client_evolution_ht['data'][$i],0,'.',' ') }} FCFA</td>
                                <td>{{ number_format($client_evolution['data'][$i],0,'.',' ') }} FCFA</td>
                                <td>{{ number_format($client_evolution_recouvrement['data'][$i],0,'.',' ') }} FCFA</td>
                                <td>{{ number_format($client_evolution_tva['data'][$i],0,'.',' ') }} FCFA</td>
                            </tr>
                        @endfor @endif
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Clients essentiels (année {{ $year }})</h5>
            <div class="table-responsive">
                <table id="myTable1" class="table dataTable table-centered table-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Nombre facture</th>
                            <th>Total Fature HT</th>
                            <th>Total Fature TTC</th>
                            <th>Recouvré</th>
                            <th>TVA</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <th>Client</th>
                            <th>Nombre facture</th>
                            <th>Total Fature HT</th>
                            <th>Total Fature TTC</th>
                            <th>Recouvré</th>
                            <th>TVA</th>
                    </tfoot>
                    <tbody>
                        @foreach($variation_clients as $vc)
                            <tr>
                                <td>{{ $vc->client->name }}</td>
                                <td>{{ number_format($vc->total,0,'.',' ') }}</td>
                                <td>{{ number_format($vc->total_ht,0,'.',' ') ?? 0 }} FCFA</td>
                                <td>{{ number_format($vc->total_ttc,0,'.',' ') ?? 0 }} FCFA</td>
                                <td>{{ number_format($vc->total_versement,0,'.',' ') ?? 0 }} FCFA</td>
                                <td>{{ number_format($vc->total_tva,0,'.',' ') ?? 0 }} FCFA</td>
                            </tr>
                        @endforeach
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
                labels: @json($client_evolution['labels']),
                datasets: [{
                    label: '# Evolution Client ({{ $client_evolution->name }} - {{ $year }})',
                    data: @json($client_evolution['data']),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
        });

        $('.table').dataTable({
            "pageLength": 20,
            "ordering": false
        })
    </script>
    @endpush
@endif
