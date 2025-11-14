<!-- Modal Editar Cita -->
 
<div id="editCitaModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editCitaModal')">&times;</span>
        <h3 class="text-xl font-semibold mb-4">Editar Cita</h3>
        <form id="editCitaForm" method="POST" action="actualizar_cita.php">
            <input type="hidden" id="edit_cita_id" name="cita_id">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Cliente:</label>
                <input type="text" id="edit_cliente" name="cliente" class="w-full p-2 border border-gray-300 rounded" readonly>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Servicios:</label>
                <div class="servicios-container" id="servicios-container">
                    <!-- Los servicios se cargan dinámicamente -->
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Fecha:</label>
                <input type="date" id="edit_fecha" name="fecha" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Hora:</label>
                <input type="time" id="edit_hora" name="hora" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Estado:</label>
                <select id="edit_estado" name="estado" class="w-full p-2 border border-gray-300 rounded" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Completada">Completada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Empleado:</label>
                <select id="edit_empleado_id" name="empleado_id" class="w-full p-2 border border-gray-300 rounded">
                    <option value="">Seleccionar empleado</option>
                    <?php foreach ($empleados as $emp): ?>
                        <option value="<?php echo $emp['id']; ?>"><?php echo htmlspecialchars($emp['nombre'] . ' ' . $emp['apellidos']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" class="btn-secondary" onclick="closeModal('editCitaModal')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Cliente -->
<!-- Modal Cliente -->
<div id="clienteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('clienteModal')">&times;</span>
        <h3 class="text-xl font-semibold mb-4" id="clienteModalTitle">Agregar Cliente</h3>
        <form id="clienteForm" method="POST" action="gestionar_cliente.php" onsubmit="return validarYEncriptarCliente()">
            <input type="hidden" id="cliente_id" name="cliente_id">
            <input type="hidden" id="cliente_accion" name="accion" value="agregar">
            <input type="hidden" id="cliente_password_hash" name="password_hash">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nombre: <span class="text-red-500">*</span></label>
                <input type="text" id="cliente_nombre" name="nombre" class="w-full p-2 border border-gray-300 rounded" required 
                       minlength="2" maxlength="50" pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                       oninput="validarCampo(this, 'nombre')">
                <span class="text-red-500 text-sm hidden" id="error_nombre"></span>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Apellidos: <span class="text-red-500">*</span></label>
                <input type="text" id="cliente_apellidos" name="apellidos" class="w-full p-2 border border-gray-300 rounded" required
                       minlength="2" maxlength="80" pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                       oninput="validarCampo(this, 'apellidos')">
                <span class="text-red-500 text-sm hidden" id="error_apellidos"></span>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Correo: <span class="text-red-500">*</span></label>
                <input type="email" id="cliente_correo" name="correo" class="w-full p-2 border border-gray-300 rounded" required
                       oninput="validarEmail(this)">
                <span class="text-red-500 text-sm hidden" id="error_correo"></span>
            </div>
            
            <!-- Campo de contraseña solo para AGREGAR -->
            <div class="mb-4" id="cliente_password_field">
                <label class="block text-gray-700 mb-2">Contraseña: <span class="text-red-500">*</span></label>
                <input type="password" id="cliente_password" class="w-full p-2 border border-gray-300 rounded" required
                       minlength="6" oninput="validarPassword(this)">
                <span class="text-red-500 text-sm hidden" id="error_password"></span>
                <p class="text-sm text-gray-500 mt-1" id="cliente_password_note">Mínimo 6 caracteres</p>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" class="btn-secondary" onclick="closeModal('clienteModal')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Empleado -->
<!-- Modal Empleado -->
<div id="empleadoModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('empleadoModal')">&times;</span>
        <h3 class="text-xl font-semibold mb-4" id="empleadoModalTitle">Agregar Empleado</h3>
        <form id="empleadoForm" method="POST" action="gestionar_empleado.php" onsubmit="return validarYEncriptarEmpleado()">
            <input type="hidden" id="empleado_id" name="empleado_id">
            <input type="hidden" id="empleado_accion" name="accion" value="agregar">
            <input type="hidden" id="empleado_password_hash" name="password_hash">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nombre: <span class="text-red-500">*</span></label>
                <input type="text" id="empleado_nombre" name="nombre" class="w-full p-2 border border-gray-300 rounded" required
                       minlength="2" maxlength="50" pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                       oninput="validarCampo(this, 'nombre')">
                <span class="text-red-500 text-sm hidden" id="error_emp_nombre"></span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Apellidos: <span class="text-red-500">*</span></label>
                <input type="text" id="empleado_apellidos" name="apellidos" class="w-full p-2 border border-gray-300 rounded" required
                       minlength="2" maxlength="80" pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+"
                       oninput="validarCampo(this, 'apellidos')">
                <span class="text-red-500 text-sm hidden" id="error_emp_apellidos"></span>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Correo: <span class="text-red-500">*</span></label>
                <input type="email" id="empleado_correo" name="correo" class="w-full p-2 border border-gray-300 rounded" required
                       oninput="validarEmail(this, 'emp')">
                <span class="text-red-500 text-sm hidden" id="error_emp_correo"></span>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Especialidad: <span class="text-red-500">*</span></label>
                <input type="text" id="empleado_especialidad" name="especialidad" class="w-full p-2 border border-gray-300 rounded" required
                       minlength="3" maxlength="100"
                       oninput="validarCampo(this, 'especialidad')">
                <span class="text-red-500 text-sm hidden" id="error_especialidad"></span>
            </div>
            
            <!-- Campo de contraseña solo para AGREGAR -->
            <div class="mb-4" id="empleado_password_field">
                <label class="block text-gray-700 mb-2">Contraseña: <span class="text-red-500">*</span></label>
                <input type="password" id="empleado_password" class="w-full p-2 border border-gray-300 rounded"
                       minlength="6" oninput="validarPassword(this, 'emp')">
                <span class="text-red-500 text-sm hidden" id="error_emp_password"></span>
                <p class="text-sm text-gray-500 mt-1" id="empleado_password_note">Mínimo 6 caracteres</p>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" class="btn-secondary" onclick="closeModal('empleadoModal')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Servicio -->
<div id="servicioModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('servicioModal')">&times;</span>
        <h3 class="text-xl font-semibold mb-4" id="servicioModalTitle">Agregar Servicio</h3>
        <form id="servicioForm" method="POST" action="gestionar_servicio.php">
            <input type="hidden" id="servicio_id" name="servicio_id">
            <input type="hidden" id="servicio_accion" name="accion" value="agregar">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nombre:</label>
                <input type="text" id="servicio_nombre" name="nombre" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Descripción:</label>
                <textarea id="servicio_descripcion" name="descripcion" class="w-full p-2 border border-gray-300 rounded"></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Precio:</label>
                <input type="number" id="servicio_precio" name="precio" step="0.01" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" class="btn-secondary" onclick="closeModal('servicioModal')">Cancelar</button>
                <button type="submit" class="btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>