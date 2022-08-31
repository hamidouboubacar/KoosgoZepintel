@extends('layouts.template.app')

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Clients / Prospects</h4>
                    <div class="mt-4 chartjs-chart">
                        <canvas id="line-chart-example" height="250" data-colors="#1abc9c,#f1556c"></canvas>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Prospects contactés</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-propects-contactes" height="250" data-colors="#4a81d4,#e3eaef"></canvas>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Factures pro forma</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-facture-pro-format" height="250" class="mt-4" data-colors="#6658dd,#fa5c7c,#4fc6e1,#ebeff2"></canvas>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Factures</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-facture" height="250" data-colors="#6c757d,#1abc9c,#ebeff2"></canvas>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
</div>
@endsection

@push('js_files')
    <!-- <script src="{{ asset('assets/js/app/chartjs.init.js') }}"></script> -->
    <script>
        // Clients / Prospects
        var ctx = document.getElementById('line-chart-example').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($data['prospects']['labels']),
                datasets: [
                    {
                        label: '# Clients',
                        data: @json($data['clients']['data']),
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }, {
                        label: '# Prospects',
                        data: @json($data['prospects']['data']),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            }
        });

        // Prospects contacté
        var ctxProspectContactes = document.getElementById('chart-propects-contactes').getContext('2d');
        const chartProspectContactes = new Chart(ctxProspectContactes, {
            type: 'line',
            data: {
                labels: @json($data['prospects_contactes']['labels']),
                datasets: [
                    {
                        label: '# Prospects Contactés',
                        data: @json($data['clients_contactes']['data']),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '# Prospects Contactés',
                        data: @json($data['prospects_contactes']['data']),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Facture Pro Format
        var ctxFactureProFormat = document.getElementById('chart-facture-pro-format').getContext('2d');
        const chartFactureProFormat = new Chart(ctxFactureProFormat, {
            type: 'bar',
            data: {
                labels: @json($data['factureproformats']['labels']),
                datasets: [{
                    label: '# Factures Pro Format',
                    data: @json($data['factureproformats']['data']),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Facture
        var ctxFacture = document.getElementById('chart-facture').getContext('2d');
        const chartFacture = new Chart(ctxFacture, {
            type: 'bar',
            data: {
                labels: @json($data['factures']['labels']),
                datasets: [{
                    label: '# Factures',
                    data: @json($data['factures']['data']),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
@endpush