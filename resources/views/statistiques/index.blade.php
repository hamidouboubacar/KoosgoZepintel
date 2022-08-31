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
                    <h4 class="header-title">Evolution du chiffre d'affaires</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-chiffre-affaire" height="250" data-colors="#4a81d4,#fa5c7c,#4fc6e1,#ebeff2"> </canvas>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Chiffre d'affaire VS Montant recouvré</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-chiffre-affaire-vs-montant-recouvre" height="250" data-colors="#4a81d4,#fa5c7c,#4fc6e1,#ebeff2"> </canvas>
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
                    <h4 class="header-title">Montant recouvré</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-montant-recouvre" height="250" data-colors="#4a81d4,#fa5c7c,#4fc6e1,#ebeff2"> </canvas>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Créance client</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-creance-client" height="250"></canvas>
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
                    <h4 class="header-title">MRC (Packages)</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-mrc" height="250" data-colors="#4a81d4,#fa5c7c,#4fc6e1,#ebeff2"> </canvas>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">NRC (Frais d'installation)</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-nrc" height="250"></canvas>
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
                    <h4 class="header-title">MRC VS NRC</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-mrc-vs-nrc" height="250"></canvas>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Autre produit</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-produits" height="250" data-colors="#4a81d4,#fa5c7c,#4fc6e1,#ebeff2"> </canvas>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Répartition du type de package vendu</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-packages" height="250"></canvas>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Chiffre d'affaire par package</h4>

                    <div class="mt-4 chartjs-chart">
                        <canvas id="chart-chiffre-affaire-package" height="250"></canvas>
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
        // Générer couleur aléatoire
        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
         };

        // Chiffre d'Affaire
        var ctxChiffreAffaire = document.getElementById('chart-chiffre-affaire').getContext('2d');
        const chartChiffreAffaire = new Chart(ctxChiffreAffaire, {
            type: 'line',
            data: {
                labels: @json($data['chiffre_affaires']['labels']),
                datasets: [{
                    label: '# Chiffre d\'Affaire {{ $year }}',
                    data: @json($data['chiffre_affaires']['data']),
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

        // Répartition du type de package vendu
        var ctxPackage = document.getElementById('chart-packages').getContext('2d');
        colors = []
        for(var i = 0; i < @json($data['packages']['labels']).length; i++) colors.push(dynamicColors())
        const chartPackage = new Chart(ctxPackage, {
            type: 'pie',
            data: {
                labels: @json($data['packages']['labels']),
                datasets: [{
                    label: '# Répartition du type de package vendu',
                    data: @json($data['packages']['data']),
                    backgroundColor: colors
                    // borderColor: 'rgba(255, 99, 132, 1)',
                    // borderWidth: 1
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
        
        // Montant recouvre
        var ctxMontantRecouvre = document.getElementById('chart-montant-recouvre').getContext('2d');
        const chartMontantRecouvre = new Chart(ctxMontantRecouvre, {
            type: 'line',
            data: {
                labels: @json($data['paiements']['labels']),
                datasets: [{
                    label: '# Montant Recouvré {{ $year }}',
                    data: @json($data['paiements']['data']),
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
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
        
        // Creance client
        var ctxCreanceClient = document.getElementById('chart-creance-client').getContext('2d');
        const chartCreanceClient = new Chart(ctxCreanceClient, {
            type: 'line',
            data: {
                labels: @json($data['creance_clients']['labels']),
                datasets: [{
                    label: '# Créance client {{ $year }}',
                    data: @json($data['creance_clients']['data']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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

        // Chiffre d'affaire VS Montant recouvre
        var ctxChiffreAffaireVSMontantRecouvre = document.getElementById('chart-chiffre-affaire-vs-montant-recouvre').getContext('2d');
        const chartChiffreAffaireVSMontantRecouvre = new Chart(ctxChiffreAffaireVSMontantRecouvre, {
            type: 'line',
            data: {
                labels: @json($data['paiements']['labels']),
                datasets: [{
                    label: '# Chiffre d\'Affaire {{ $year }}',
                    data: @json($data['chiffre_affaires']['data']),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }, {
                    label: '# Montant Recouvré {{ $year }}',
                    data: @json($data['paiements']['data']),
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
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

        // Chiffre d'affaire par package
        var ctxChiffreAffairePackage = document.getElementById('chart-chiffre-affaire-package').getContext('2d');
        colors = []
        for(var i = 0; i < @json($data['packages']['labels']).length; i++) colors.push(dynamicColors())
        const chartChiffreAffairePackage = new Chart(ctxChiffreAffairePackage, {
            type: 'bar',
            data: {
                labels: @json($data['chiffre_affaire_packages']['labels']),
                datasets: [{
                    label: '# Chiffre d\'affaire par package',
                    data: @json($data['chiffre_affaire_packages']['data']),
                    backgroundColor: colors
                    // borderColor: 'rgba(255, 99, 132, 1)',
                    // borderWidth: 1
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

        // MRC
        var ctxMRC = document.getElementById('chart-mrc').getContext('2d');
        const chartMRC = new Chart(ctxMRC, {
            type: 'line',
            data: {
                labels: @json($data['document_packages']['labels']),
                datasets: [{
                    label: '# MRC {{ $year }}',
                    data: @json($data['document_packages']['data']),
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

        // NRC
        var ctxNRC = document.getElementById('chart-nrc').getContext('2d');
        const chartNRC = new Chart(ctxNRC, {
            type: 'line',
            data: {
                labels: @json($data['nrc']['labels']),
                datasets: [{
                    label: '# NRC {{ $year }}',
                    data: @json($data['nrc']['data']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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

        // MRC VS NRC
        var ctxMRCVSNRC = document.getElementById('chart-mrc-vs-nrc').getContext('2d');
        const chartMRCVSNRC = new Chart(ctxMRCVSNRC, {
            type: 'line',
            data: {
                labels: @json($data['nrc']['labels']),
                datasets: [{
                    label: '# MRC {{ $year }}',
                    data: @json($data['document_packages']['data']),
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }, {
                    label: '# NRC {{ $year }}',
                    data: @json($data['nrc']['data']),
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
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

        // Document produit
        var ctxAutreProduit = document.getElementById('chart-produits').getContext('2d');
        const chartAutreProduit = new Chart(ctxAutreProduit, {
            type: 'line',
            data: {
                labels: @json($data['document_produits']['labels']),
                datasets: [{
                    label: '# Autre Produit {{ $year }}',
                    data: @json($data['document_produits']['data']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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