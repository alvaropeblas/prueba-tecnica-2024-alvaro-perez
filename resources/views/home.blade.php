@extends('adminlte::page')

@section('title', 'Dashboard')

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/app.css'])
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
@include('components.modalEditarDiaFestivo')

@stop



@section('js')
<script src="https://unpkg.com/js-year-calendar@latest/dist/js-year-calendar.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    let tooltip = null;
    
    document.addEventListener('DOMContentLoaded', function () {
        var calendar = new Calendar('#calendar', {
            style: 'background',
            
            clickDay: function (e) {

                var dayEvents = e.events[0];
                
                if (dayEvents != null) {

                    document.getElementById('nombreEditar').value = dayEvents.title;
                    document.getElementById('colorEditar').value = dayEvents.color;
                    document.getElementById('diaEditar').value = dayEvents.startDate.getDate();
                    document.getElementById('mesEditar').value = dayEvents.startDate.getMonth() + 1;
                    document.getElementById('anyoEditar').value = dayEvents.startDate.getFullYear();
                    if (dayEvents.recurrente == 1) {
                        document.getElementById('recurrenteEditar').checked = true;
                        document.getElementById('anyoEditar').disabled = true;
                    } else {
                        document.getElementById('recurrenteEditar').checked = false;
                        document.getElementById('anyoEditar').disabled = false;
                    }
                    // Configuro la acción del formulario para enviar el ID del día festivo
                    var form = document.getElementById('editHolidayForm');
                    form.action = '{{ route("diaFestivo.update", ":id") }}'.replace(':id', dayEvents.id);
                    var form = document.getElementById('deleteHolidayForm');
                    form.action = '{{ route("diaFestivo.delete", ":id") }}'.replace(':id', dayEvents.id);
                    $('#diasFestivosModalEditar').modal('show');
                } else {
                    var selectedDate = e.date;
                    document.getElementById('dia').value = selectedDate.getDate();
                    document.getElementById('mes').value = selectedDate.getMonth() + 1;
                    document.getElementById('anyo').value = selectedDate.getFullYear();

                    $('#diasFestivosModal').modal('show');
                }


            },
            mouseOnDay: function (e) {
                if (e.events.length > 0) {
                    var content = '';

                    for (var i in e.events) {
                        content += '<div class="event-tooltip-content">'
                            + '<div class="event-name">' + e.events[i].title + '</div>'
                            + '<div class="event-details">' + e.events[i].startDate + '</div>'
                            + '</div>';
                    }


                    $(e.element).popover({
                        title: 'Dia Festivo',
                        content: content,
                        trigger: 'hover',
                        placement: 'right',
                        html: true
                    });
                    $(e.element).popover('show');
                }
            },
            mouseOutDay: function () {

                $('.popover').popover('hide');
            }

        });


        calendar.render();

        cargarDiasFestivos(calendar);

        // Función para cargar los días festivos
        function cargarDiasFestivos(calendar) {
            $.ajax({
                url: '{{ route("diaFestivo.data") }}',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    data.forEach(function (diaFestivo) {
                        if (diaFestivo.recurrente == 1) {
                            var fechaActual = new Date();
                            var añoActual = fechaActual.getFullYear();

                            // Agrega eventos para el año actual, año anterior y año siguiente
                            calendar.addEvent({
                                startDate: new Date(añoActual, diaFestivo.mes - 1, diaFestivo.dia),
                                endDate: new Date(añoActual, diaFestivo.mes - 1, diaFestivo.dia),
                                title: diaFestivo.nombre,
                                color: diaFestivo.color,
                                id: diaFestivo.id,
                            });

                            calendar.addEvent({
                                startDate: new Date(añoActual - 1, diaFestivo.mes - 1, diaFestivo.dia),
                                endDate: new Date(añoActual - 1, diaFestivo.mes - 1, diaFestivo.dia),
                                title: diaFestivo.nombre,
                                color: diaFestivo.color,
                                id: diaFestivo.id,
                            });

                            calendar.addEvent({
                                startDate: new Date(añoActual + 1, diaFestivo.mes - 1, diaFestivo.dia),
                                endDate: new Date(añoActual + 1, diaFestivo.mes - 1, diaFestivo.dia),
                                title: diaFestivo.nombre,
                                color: diaFestivo.color,
                                id: diaFestivo.id,
                            });
                        } else {
                            // Agregar evento para el año específico no recurrente
                            calendar.addEvent({
                                startDate: new Date(diaFestivo.anyo, diaFestivo.mes - 1, diaFestivo.dia),
                                endDate: new Date(diaFestivo.anyo, diaFestivo.mes - 1, diaFestivo.dia),
                                title: diaFestivo.nombre,
                                color: diaFestivo.color,
                                id: diaFestivo.id,
                            });
                        }
                    });
                    calendar.render();
                },
                error: function (error) {
                    alert('Error al obtener días festivos');
                }
            });
        }


        // Evento para mostrar el modal de días festivos
        document.getElementById('diasFestivosLink').addEventListener('click', function (event) {
            event.preventDefault();
            $('#diasFestivosModal').modal('show');
        });
    });

</script>
@stop