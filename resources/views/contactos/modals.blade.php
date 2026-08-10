<!-- Modal Crear Contacto -->
<div class="modal fade" id="modalCrearContacto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('contactos.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold text-dark">Registrar Nuevo Contacto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Nombre(s) *</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" class="form-control">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Apellido Materno</label>
                            <input type="text" name="apellido_materno" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Puesto *</label>
                            <select name="puesto_id" class="form-control select-search" required>
                                <option value="">Seleccione un puesto...</option>
                                @foreach($puestos as $puesto)
                                    <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Ente / Institución *</label>
                            <select name="ente_id" class="form-control select-search" required>
                                <option value="">Seleccione un ente...</option>
                                @foreach($entes as $ente)
                                    <option value="{{ $ente->id }}">{{ $ente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Sede (Opcional)</label>
                            <select name="sede_id" class="form-control select-search">
                                <option value="">Seleccione una sede...</option>
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label class="small font-weight-bold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Extensión</label>
                            <input type="text" name="extension" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Contacto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Contacto -->
<div class="modal fade" id="modalEditarContacto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <form id="formEditarContacto" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold text-dark">Editar Contacto y Asignación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Nombre(s) *</label>
                            <input type="text" id="edit_nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Apellido Paterno</label>
                            <input type="text" id="edit_apellido_paterno" name="apellido_paterno" class="form-control">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="small font-weight-bold">Apellido Materno</label>
                            <input type="text" id="edit_apellido_materno" name="apellido_materno" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Puesto *</label>
                            <select id="edit_puesto_id" name="puesto_id" class="form-control select-search" required>
                                <option value="">Seleccione un puesto...</option>
                                @foreach($puestos as $puesto)
                                    <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Ente / Institución *</label>
                            <select id="edit_ente_id" name="ente_id" class="form-control select-search" required>
                                <option value="">Seleccione un ente...</option>
                                @foreach($entes as $ente)
                                    <option value="{{ $ente->id }}">{{ $ente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Sede (Opcional)</label>
                            <select id="edit_sede_id" name="sede_id" class="form-control select-search">
                                <option value="">Seleccione una sede...</option>
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="small font-weight-bold">Correo Electrónico</label>
                            <input type="email" id="edit_correo" name="correo" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label class="small font-weight-bold">Teléfono</label>
                            <input type="text" id="edit_telefono" name="telefono" class="form-control">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="small font-weight-bold">Extensión</label>
                            <input type="text" id="edit_extension" name="extension" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nota / Observaciones -->
<div class="modal fade" id="modalNotaContacto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <form id="formNotaContacto" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold text-dark">Observaciones para: <span id="labelNombreNota" class="text-primary"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="small font-weight-bold">Notas de Vinculación / Riesgos</label>
                        <textarea id="nota_observaciones" name="observaciones" rows="4" class="form-control" placeholder="Escribe notas relevantes sobre este contacto..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm">Guardar Nota</button>
                </div>
            </form>
        </div>
    </div>
</div>