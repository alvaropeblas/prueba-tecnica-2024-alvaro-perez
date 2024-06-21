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
            language: 'es',
            style: 'background',
        });
        calendar.render();

        cargarDiasFestivos(calendar);

        // Función para cargar los días festivos 
        function cargarDiasFestivos(calendar) {
            $.ajax({
                url: '{{ route("diaFestivo.data") }}', // Ajusta la ruta según tu configuración
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                   

                    // Agregar cada día festivo al calendario
                    data.forEach(function (diaFestivo) {
                        console.log(diaFestivo)
                        calendar.addEvent({
                            startDate: new Date(diaFestivo.anyo, diaFestivo.mes - 1, diaFestivo.dia),
                            endDate: new Date(diaFestivo.anyo, diaFestivo.mes - 1, diaFestivo.dia),
                            title: diaFestivo.nombre,
                            color: diaFestivo.color,
                        });
                    });

                    // Renderizar el calendario después de agregar los eventos
                    calendar.render();
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener días festivos', error);
                    // Manejar el error si es necesario
                }
            });
        }


        function saveEvent() {
            var event = {
                id: $('#event-modal input[name="event-index"]').val(),
                name: $('#event-modal input[name="event-name"]').val(),
                location: $('#event-modal input[name="event-location"]').val(),
                startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
                endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate')
            }



            if (event.id) {
                for (var i in dataSource) {
                    if (dataSource[i].id == event.id) {
                        dataSource[i].name = event.name;
                        dataSource[i].location = event.location;
                        dataSource[i].startDate = event.startDate;
                        dataSource[i].endDate = event.endDate;
                    }
                }
            }
            else {
                var newId = 0;
                for (var i in dataSource) {
                    if (dataSource[i].id > newId) {
                        newId = dataSource[i].id;
                    }
                }

                newId++;
                event.id = newId;

                dataSource.push(event);
            }

            calendar.setDataSource(dataSource);
            $('#event-modal').modal('hide');
        }

        document.getElementById('diasFestivosLink').addEventListener('click', function (event) {
            event.preventDefault();
            $('#diasFestivosModal').modal('show');
        });
    });

</script>
@stop