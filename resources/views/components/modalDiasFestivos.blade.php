<!-- Modal para Dias Festivos -->
<div class="modal fade" id="diasFestivosModal" tabindex="-1" role="dialog" aria-labelledby="diasFestivosModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="diasFestivosModalLabel">Añadir Día Festivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addHolidayForm" action="{{ route('diaFestivo.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="color" name="color" id="color" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="dia">Día</label>
                            <input type="number" name="dia" id="dia" class="form-control" min="1" max="31" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="mes">Mes</label>
                            <select name="mes" id="mes" class="form-control" required>
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
                            <label for="anyo">Año</label>
                            <input type="number" name="anyo" id="anyo" class="form-control" min="{{ date('Y') }}" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="recurrente" id="recurrente">
                            <label class="form-check-label" for="recurrente">
                                Recurrente
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Día Festivo</button>
                </div>
            </form>
        </div>
    </div>
</div>
