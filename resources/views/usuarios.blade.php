@extends('adminlte::page')

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
@section('css')
<style>
    .loading-wrap {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                Añadir Usuario
            </button>
        </div>
    </div>
    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
        data-url="{{ route('usuarios.data') }}" class="table table-bordered">
        <thead>
            <tr>
                <th data-field="name">Nombre</th>
                <th data-field="email">Email</th>
                <th data-field="actions" data-formatter="botonesAcciones" data-events="operateEvents">Acciones</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal para añadir usuario -->
@include('components.modalAñadirUsuario')

<!-- Modal para editar usuario -->
@include('components.modalEditarUsuario')

<!-- Modal para Dias Festivos -->
@include('components.modalDiasFestivos')

@endsection

@section('adminlte_js')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/bootstrap-table.min.js"></script>

<script>
     function botonesAcciones(value, row, index) {
        return [
            '<a class="edit btn btn-warning btn-sm" title="Editar">',
            '<i class="fas fa-edit"></i>',
            '</a>  ',
            '<a class="remove btn btn-danger btn-sm" title="Eliminar">',
            '<i class="fas fa-trash"></i>',
            '</a>'
        ].join('');
    }

    var operateEvents = {
        'click .edit': function (row) {
            // Editar usuario
            $('#editUserModal').modal('show');
            $('#edit_name').val(row.name);
            $('#edit_email').val(row.email);
            $('#editUserForm').attr('action', '{{ url("/usuarios") }}/' + row.id);
        },
        'click .remove': function (row) {
            // Eliminar usuario
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                $.ajax({
                    url: '{{ url('/usuarios') }}/' + row.id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function (response) {
                        alert('Usuario eliminado correctamente');
                        // Recargar la tabla para reflejar los cambios
                        $('#table').bootstrapTable('refresh');
                    },
                    error: function (xhr, status, error) {
                        alert('Error al eliminar usuario');

                    }
                });
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        $('#table').bootstrapTable();
    });
</script>
@endsection