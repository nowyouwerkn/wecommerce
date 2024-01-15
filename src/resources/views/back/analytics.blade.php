@extends('wecommerce::back.layouts.main')

@section('title')
    <div class="d-sm-flex align-items-center justify-content-between mg-lg-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="#">wcommerce</a></li>
                <li class="breadcrumb-item active" aria-current="page">Analítica</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Analítica</h4>
        </div>
    </div>
    <link href="{{ asset('lib/leaflet/leaflet.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card ht-lg-100p">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Ventas por Ubicación</h6>
                
                <div class="tx-13 d-flex align-items-center">
                    <span class="mg-r-5">País:</span> <span class="d-flex align-items-center link-03 lh-0">México</span>
                </div>
            </div>

            <div class="card-body pd-0">
                {{--  
                <div class="pd-y-25 pd-x-20">
                    <div id="map" class="ht-500"></div>
                </div>
                --}}
                <div class="table-responsive">
                    <table class="table table-borderless table-dashboard table-dashboard-one">
                    <thead>
                        <tr>
                        <th class="wd-40">Estado</th>
                        <th class="wd-25 text-right">Ordenes</th>
                        <th class="wd-35 text-right">Ingresos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="tx-medium">{{ $order->state }}</td>
                                <td class="text-right">{{ $order->qty }}</td>
                                <td class="text-right">${{ number_format($order->sales, 2) }} MXN</td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mg-b-0">Nube de Palabras</h6>
            </div>

            <div style="height: {{ $queries->count() * 50 }}px;">
                <canvas id="canvasWordCloud"></canvas>
            </div>

            <div class="card-body">
                <hr>
                <p>Estas han sido las palabras más buscadas en tu sitio web. Mientras más grande más veces ha sido repetida. Al poner el mouse sobre una palabra podrás saber la cantidad de veces que ha sido buscada.</p>
                <small class="text-muted">Rango de búsquedas: {{ Carbon\Carbon::now()->startOfYear()->translatedFormat('d M Y') }} hasta Hoy</small>
            </div>
            
        </div>       
    </div> 
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/chart.js@3"></script>
<script src="https://unpkg.com/chartjs-chart-wordcloud@3"></script>
<script>
    const words = [
        @php
            $index = 1;
        @endphp
        @foreach($queries as $query=>$count)
            { key: "{{ $query }}", value: {{ $count }} },
            @php
                $index++
            @endphp 
        @endforeach
    ];

    const chart = new Chart(document.getElementById("canvasWordCloud").getContext("2d"), {
    type: "wordCloud",
    data: {
        labels: words.map(d => d.key),
        datasets: [{
            label: "Veces buscado",
            data: words.map(d => d.value),
            size: words.map((d) => 10 + d.value * 2),
        }]
        },
        options: {
            title: {
                display: false,
                text: "Nube de Texto" 
            },

            plugins: {
                legend: {
                    display: false 
                } 
            },
        } 
    });
</script>

<script src="{{ asset('lib/leaflet/leaflet.js') }}"></script>

<script>
    var map = new L.Map("map", {center: [19.4326, -101.13], zoom: 4})
        .addLayer(new L.TileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"));
    
        
        $.getJSON("{{ asset('assets/js/states.geojson') }}",function(data){
         L.geoJson(data, {style: style}).addTo(map);
       });

       function style(feature) {
            return {
                fillColor: getColor(feature.properties.density),
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }

        function getColor(d) {
            return d > 1000 ? '#800026' :
                d > 500  ? '#BD0026' :
                d > 200  ? '#E31A1C' :
                d > 100  ? '#FC4E2A' :
                d > 50   ? '#FD8D3C' :
                d > 20   ? '#FEB24C' :
                d > 10   ? '#FED976' :
                            '#FFEDA0';
        }
</script>
@endpush