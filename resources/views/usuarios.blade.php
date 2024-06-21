@extends('adminlte::page')

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
            <!-- Botón para abrir el modal de añadir usuario -->
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
                <th data-field="actions" data-formatter="operateFormatter" data-events="operateEvents">Acciones</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal para añadir usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('usuarios.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Añadir Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Campos del formulario -->
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Nombre</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('adminlte_js')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.18.3/bootstrap-table.min.js"></script>
<script>
    function operateFormatter(value, row, index) {
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
        'click .edit': function (e, value, row, index) {
            // Editar usuario
            $('#editUserModal').modal('show');
            $('#edit_name').val(row.name);
            $('#edit_email').val(row.email);
            $('#editUserForm').attr('action', '{{ url("/usuarios") }}/' + row.id);
        },
        'click .remove': function (e, value, row, index) {
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
                        console.error('Error al eliminar usuario', error);
                        // Maneja el error de eliminación si es necesario
                    }
                });
            }
        }
    };

    $(document).ready(function () {
        $('#table').bootstrapTable();
    });
</script>
@endsection
