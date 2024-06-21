<!-- Modal Editar para Dias Festivos -->
<div class="modal fade" id="diasFestivosModalEditar" tabindex="-1" role="dialog" aria-labelledby="diasFestivosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="diasFestivosModalLabel">Editar Día Festivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editHolidayForm" action="{{ route('diaFestivo.update', ':id') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="idEditar">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreEditar">Nombre</label>
                        <input type="text" name="nombre" id="nombreEditar" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="colorEditar">Color</label>
                        <input type="color" name="color" id="colorEditar" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="diaEditar">Día</label>
                            <input type="number" name="dia" id="diaEditar" class="form-control" min="1" max="31" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="mesEditar">Mes</label>
                            <select name="mes" id="mesEditar" class="form-control" required>
                                <option value="">Seleccione...</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="anyoEditar">Año</label>
                            <input type="number" name="anyo" id="anyoEditar" class="form-control" min="{{ date('Y') }}" value="{{ date('Y') }}" {{ old('recurrente') ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="recurrenteEditar" id="recurrenteEditar" value="1">
                            <label class="form-check-label" for="recurrenteEditar">Recurrente</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
            <form id="deleteHolidayForm" action="{{ route('diaFestivo.delete', ':id') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="id" id="idEliminar">
                <button type="submit" id="eliminarDiaFestivo" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
