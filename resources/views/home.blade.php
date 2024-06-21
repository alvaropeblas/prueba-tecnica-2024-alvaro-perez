@extends('adminlte::page')

@section('title', 'Dashboard')

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Dias Festivos -->
@include('components.modalDiasFestivos')

@stop

@section('css')
<style>
    .months-container {
        height: 100vh;
        width: 100%;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 10px;
    }

    .calendar-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    table {
        width: 100%;
        margin-bottom: 2.5%;
        margin-top: 1.5%;
    }
</style>
@stop

@section('js')
<script src="https://unpkg.com/js-year-calendar@latest/dist/js-year-calendar.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendar = new Calendar('#calendar', {
            minDate: new Date(),
            language: 'es',
            style: 'background',
        });
        calendar.render();

        
        document.getElementById('diasFestivosLink').addEventListener('click', function (event) {
            event.preventDefault();
            $('#diasFestivosModal').modal('show'); 
        });
    });

</script>
@stop