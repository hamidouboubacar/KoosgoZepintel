@extends('layouts.template.app')

@section('title')
Ventes
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fe-bar-chart-line- font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span class="toLocalString" data-plugin="">{{ number_format($chiffre_affaires_total,0,'.',' ') }}</span> F CFA</h3>
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
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                <i class="fe-bar-chart-line- font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="">{{ number_format($nombre_facture_total,0,'.',' ') }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">NOMBRE DE FACTURE</p>
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
                        <div class="col-6">
                            <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                <i class="fe-bar-chart-line- font-22 avatar-title text-info"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="">{{ number_format($en_cours_total,0,'.',' ') }}</span> F CFA</h3>
                                <p class="text-muted mb-1 text-truncate">TOTAL ENCOURS</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>

    <form action="" method="get">
        <div class="card-box">
            <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Comparaison</h5>
            <div class="form-row mt-2">
                <div class="col">
                    <label for="">Année</sup></label>
                    <select class="form-control" name="annee1" id="" required>
                        <option value="">---</option>
                        @foreach($annees as $annee)
                            <option value="{{ $annee }}">{{ $annee }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col">
                    <label for="">Année</label>
                    <select class="form-control" name="annee2" id="" required>
                        <option value="">---</option>
                        @foreach($annees as $annee)
                            <option value="{{ $annee }}">{{ $annee }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="btn btn-success mt-2">Comparer</button>
        </div>
    </form>

    <div class="card-box">
        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Graphe</h5>

        <form action="" method="get">
            <div class="form-row mt-2">
                <div class="col-4">
                    <label for="">Année</sup></label>
                    <select class="form-control" name="annee1" id="" required>
                        <option value="">---</option>
                        @foreach($annees as $annee)
                            <option value="{{ $annee }}">{{ $annee }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <button class="btn btn-success mt-2">Changer</button>
        </form>
        
        <div class="mt-4 chartjs-chart">
            <canvas id="chart-chiffre-affaire" height="250" data-colors="#4a81d4,#fa5c7c,#4fc6e1,#ebeff2"> </canvas>
        </div>
        
    </div>

    <div class="card-box">
        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Variations des indicateurs de vente (année {{ $year }})</h5>
        <div class="table-responsive">
            <table id="" class="table dataTable table-centered table-nowrap table-striped">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Chiffre A. HT</th>
                        <th>Chiffre A. TTC</th>
                        <th>Recouvré</th>
                        <!-- <th>Taux de recouvrement</th> -->
                    </tr>
                </thead>
                <tfoot>
                    <th>Mois</th>
                    <th>Chiffre A. HT</th>
                    <th>Chiffre A. TTC</th>
                    <th>Recouvré</th>
                    <!-- <th>Taux de recouvrement</th> -->
                </tfoot>
                <tbody>
                    @if(isset($chiffre_affaires)) @for($i = 0; $i < 12; $i++)
                        <tr>
                            <td>{{ $chiffre_affaires['labels'][$i] }}</td>
                            <td>{{ number_format($chiffre_affaires_ht['data'][$i],0,'.',' ') }}</td>
                            <td>{{ number_format($chiffre_affaires_ttc['data'][$i],0,'.',' ') }}</td>
                            <td>{{ number_format($chiffre_affaires_recouvrement['data'][$i],0,'.',' ') }}</td>
                            <!-- @if($total_versement == 0)
                                <td> 0 %</td>
                            @else
                                <td>{{ ($chiffre_affaires_recouvrement['data'][$i] / $total_versement) * 100 }} %</td>
                            @endif -->
                        </tr>
                    @endfor @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- end row -->
</div>
@endsection

@push('js_files')
<script>
    // Chiffre d'Affaire
    var ctxChiffreAffaire = document.getElementById('chart-chiffre-affaire').getContext('2d');
    const chartChiffreAffaire = new Chart(ctxChiffreAffaire, {
        type: 'line',
        data: {
            labels: @json($chiffre_affaires['labels']),
            datasets: [{
                label: '# Chiffre d\'Affaire {{ $year }}',
                data: @json($chiffre_affaires['data']),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }, @if($comparaison)
            {
                label: '# Chiffre d\'Affaire {{ $annee2 }}',
                data: @json($chiffre_affaires2['data']),
                backgroundColor: 'rgba(153, 102, 86, 0.2)',
                borderColor: 'rgba(153, 102, 86, 1)',
                borderWidth: 1
            }     
            @endif]
        },
    });

    $('.table').dataTable({
        "pageLength": 20,
        "ordering": false
    })
</script>
@endpush