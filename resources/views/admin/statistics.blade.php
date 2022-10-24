@extends('layouts.dashboard')

@section('content')
    <div class="heading">
        <h1>STATISTICS VIEW</h1>

        {{-- Chart Period List --}}
        <ul>
            <li class="period-list-item">2019</li>
            <li class="period-list-item">2020</li>
            <li class="period-list-item">2021</li>
            <li class="period-list-item">2022</li>
            <li class="period-list-item">TUTTI GLI ANNI</li>
        </ul>
    </div>

    {{-- Input hidden to pass $statisticsData to statistics.js --}}
    <input id="user-data" type="hidden" value="{{ json_encode($statisticsData) }}" >

    {{-- Chart Canvas --}}
    <canvas id="statistics-chart" width="400" height="400"></canvas>



@endsection