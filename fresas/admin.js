// Objeto global para el panel de administración
const AdminPanel = {
    currentView: 'citas',
    currentPage: 1,
    itemsPerPage: 10,
    sortField: 'id',
    sortDirection: 'desc',
    
    init: function() {
        console.log('Datos cargados:', this.getData());
        this.renderView();
        this.attachEventListeners();
    },
    
    attachEventListeners: function() {
        // Cerrar modales al hacer click fuera
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        };
    },
    
    changeView: function(view) {
        this.currentView = view;
        this.currentPage = 1;
        this.sortField = 'id';
        this.sortDirection = 'desc';
        this.renderView();
        this.updateActiveButton(view);
    },
    
    updateActiveButton: function(view) {
        // Resetear todos los botones
        document.querySelectorAll('.view-btn').forEach(function(btn) {
            btn.classList.remove('bg-pink-500');
            btn.classList.add('bg-gray-400', 'hover:bg-gray-500');
        });
        
        // Activar el botón actual
        const activeBtn = document.getElementById('btn-' + view);
        if (activeBtn) {
            activeBtn.classList.remove('bg-gray-400', 'hover:bg-gray-500');
            activeBtn.classList.add('bg-pink-500');
        }
    },
    
    renderView: function() {
        const container = document.getElementById('admin-view-content');
        if (!container) return;
        
        let content = '';
        switch (this.currentView) {
            case 'citas':
                content = this.renderCitasView();
                break;
            case 'clientes':
                content = this.renderClientesView();
                break;
            case 'empleados':
                content = this.renderEmpleadosView();
                break;
            case 'servicios':
                content = this.renderServiciosView();
                break;
        }
        container.innerHTML = content;
    },
    
    getData: function() {
        return {
            citas: window.citasData || [],
            clientes: window.clientesData || [],
            empleados: window.empleadosData || [],
            servicios: window.serviciosData || []
        };
    },
    
    getSortedData: function() {
    const data = this.getData()[this.currentView] || [];
    const field = this.sortField;
    const direction = this.sortDirection;
    
    return data.sort(function(a, b) {
        let aVal = a[field] || '';
        let bVal = b[field] || '';
        
        // Para campos compuestos (mantener para otras vistas)
        if (field === 'nombre_completo') {
            aVal = (a.nombre || '') + ' ' + (a.apellidos || '');
            bVal = (b.nombre || '') + ' ' + (b.apellidos || '');
        } else if (field === 'cliente') {
            aVal = a.cliente || '';
            bVal = b.cliente || '';
        } else if (field === 'empleado') {
            aVal = a.empleado || '';
            bVal = b.empleado || '';
        } else if (field === 'fecha_hora') {
            // Ordenar por fecha y hora juntas
            aVal = (a.fecha || '') + ' ' + (a.hora || '');
            bVal = (b.fecha || '') + ' ' + (b.hora || '');
        }
        
        // Para números
        if (field === 'id' || field === 'precio') {
            aVal = parseFloat(aVal) || 0;
            bVal = parseFloat(bVal) || 0;
            return direction === 'asc' ? aVal - bVal : bVal - aVal;
        }
        
        // Para texto
        aVal = String(aVal).toLowerCase();
        bVal = String(bVal).toLowerCase();
        
        if (aVal < bVal) return direction === 'asc' ? -1 : 1;
        if (aVal > bVal) return direction === 'asc' ? 1 : -1;
        return 0;
    });
},
    
    getPaginatedData: function() {
        const sortedData = this.getSortedData();
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return sortedData.slice(start, end);
    },
    
    sort: function(field) {
        if (this.sortField === field) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortField = field;
            this.sortDirection = 'asc';
        }
        this.renderView();
    },
    
    changePage: function(page) {
        const totalItems = this.getSortedData().length;
        const totalPages = Math.ceil(totalItems / this.itemsPerPage);
        
        if (page >= 1 && page <= totalPages) {
            this.currentPage = page;
            this.renderView();
        }
    },
    
    renderPagination: function(totalItems) {
        if (totalItems <= this.itemsPerPage) return '';
        
        const totalPages = Math.ceil(totalItems / this.itemsPerPage);
        let pages = [];
        const maxVisiblePages = 5;
        
        let startPage = Math.max(1, this.currentPage - 2);
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            pages.push(i);
        }
        
        let paginationHTML = `
            <div class="pagination flex justify-center items-center mt-6 space-x-2">
                <button onclick="AdminPanel.changePage(${this.currentPage - 1})" 
                        ${this.currentPage === 1 ? 'disabled' : ''}
                        class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                    Anterior
                </button>
        `;
        
        if (startPage > 1) {
            paginationHTML += `<button onclick="AdminPanel.changePage(1)" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">1</button>`;
            if (startPage > 2) {
                paginationHTML += `<span class="px-2">...</span>`;
            }
        }
        
        pages.forEach(function(page) {
            const activeClass = page === AdminPanel.currentPage ? 'bg-pink-500 text-white' : 'bg-gray-200 hover:bg-gray-300';
            paginationHTML += `
                <button onclick="AdminPanel.changePage(${page})" class="px-3 py-1 rounded ${activeClass}">
                    ${page}
                </button>
            `;
        });
        
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHTML += `<span class="px-2">...</span>`;
            }
            paginationHTML += `<button onclick="AdminPanel.changePage(${totalPages})" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">${totalPages}</button>`;
        }
        
        paginationHTML += `
                <button onclick="AdminPanel.changePage(${this.currentPage + 1})" 
                        ${this.currentPage === totalPages ? 'disabled' : ''}
                        class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                    Siguiente
                </button>
                
                <span class="pagination-info text-sm text-gray-600 ml-4">
                    Página ${this.currentPage} de ${totalPages} (${totalItems} items)
                </span>
            </div>
        `;
        
        return paginationHTML;
    },
    
    renderCitasView: function() {
        const data = this.getPaginatedData();
        const totalItems = this.getSortedData().length;
        
        const rows = data.map(function(cita) {
            let serviciosHTML = 'No hay servicios';
            if (cita.servicios && cita.servicios.trim() !== '') {
                serviciosHTML = cita.servicios.split(', ').map(function(s) {
                    return `<span class="badge estado-en-proceso">${s}</span>`;
                }).join('');
            }
            
            // Combinar fecha y hora
            const fechaHora = cita.fecha + ' ' + cita.hora;
            
            return `
                <tr class="hover:bg-gray-50">
                    <td data-label="ID">${cita.id}</td>
                    <td data-label="Cliente">${cita.cliente || 'N/A'}</td>
                    <td data-label="Servicios">
                        <div class="max-w-xs">${serviciosHTML}</div>
                    </td>
                    <td data-label="Fecha/Hora">${fechaHora}</td>
                    <td data-label="Estado">
                        <span class="badge ${AdminPanel.getEstadoClass(cita.estado)}">
                            ${cita.estado || 'Pendiente'}
                        </span>
                    </td>
                    <td data-label="Empleado">${cita.empleado || 'No asignado'}</td>
                    <td data-label="Acciones" class="space-x-2">
                        <button class="btn-secondary text-xs" onclick="editarCita(${cita.id})">
                            Editar
                        </button>
                        <button class="btn-danger text-xs" onclick="eliminarCita(${cita.id})">
                            Eliminar
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
        
        return `
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Gestión de Citas</h3>
            <div class="table-container overflow-x-auto">
                <table class="responsive-table min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="sortable ${this.getSortClass('id')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('id')">ID</th>
                            <th class="sortable ${this.getSortClass('cliente')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('cliente')">Cliente</th>
                            <th class="px-4 py-2 text-left">Servicios</th>
                            <th class="sortable ${this.getSortClass('fecha_hora')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('fecha_hora')">Fecha/Hora</th>
                            <th class="sortable ${this.getSortClass('estado')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('estado')">Estado</th>
                            <th class="sortable ${this.getSortClass('empleado')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('empleado')">Empleado</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
            ${data.length === 0 ? '<p class="text-center text-gray-500 mt-4">No hay citas registradas.</p>' : ''}
            ${this.renderPagination(totalItems)}
        `;
    },
    
   renderClientesView: function() {  
    const data = this.getPaginatedData();
    const totalItems = this.getSortedData().length;
    
    const rows = data.map(function(cliente) {
        return `
            <tr class="hover:bg-gray-50">
                <td data-label="ID" class="px-4 py-2">${cliente.id}</td>
                <td data-label="Nombre" class="px-4 py-2">${cliente.nombre || 'N/A'}</td>
                <td data-label="Apellidos" class="px-4 py-2">${cliente.apellidos || 'N/A'}</td>
                <td data-label="Correo" class="px-4 py-2">${cliente.correo || 'N/A'}</td>
                <td data-label="Acciones" class="px-4 py-2 space-x-2">
                    <button class="btn-secondary text-xs" onclick="editarCliente(${cliente.id})">
                        Editar
                    </button>
                    <button class="btn-danger text-xs" onclick="eliminarCliente(${cliente.id})">
                        Eliminar
                    </button>
                </td>
            </tr>
        `;
    }).join('');
    
    return `
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Gestión de Clientes</h3>
        <button class="btn-success mb-4" onclick="agregarCliente()">Agregar Cliente</button>
        <div class="table-container overflow-x-auto">
            <table class="responsive-table min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="sortable ${this.getSortClass('id')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('id')">ID</th>
                        <th class="sortable ${this.getSortClass('nombre')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('nombre')">Nombre</th>
                        <th class="sortable ${this.getSortClass('apellidos')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('apellidos')">Apellidos</th>
                        <th class="sortable ${this.getSortClass('correo')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('correo')">Correo</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
        </div>
        ${data.length === 0 ? '<p class="text-center text-gray-500 mt-4">No hay clientes registrados.</p>' : ''}
        ${this.renderPagination(totalItems)}
    `;
},
    
   renderEmpleadosView: function() {
    const data = this.getPaginatedData();
    const totalItems = this.getSortedData().length;
    
    const rows = data.map(function(empleado) {
        return `
            <tr class="hover:bg-gray-50">
                <td data-label="ID" class="px-4 py-2">${empleado.id}</td>
                <td data-label="Nombre" class="px-4 py-2">${empleado.nombre || 'N/A'}</td>
                <td data-label="Apellidos" class="px-4 py-2">${empleado.apellidos || 'N/A'}</td>
                <td data-label="Correo" class="px-4 py-2">${empleado.correo || 'N/A'}</td>
                <td data-label="Especialidad" class="px-4 py-2">${empleado.especialidad || 'N/A'}</td>
                <td data-label="Acciones" class="px-4 py-2 space-x-2">
                    <button class="btn-secondary text-xs" onclick="editarEmpleado(${empleado.id})">
                        Editar
                    </button>
                    <button class="btn-danger text-xs" onclick="eliminarEmpleado(${empleado.id})">
                        Eliminar
                    </button>
                </td>
            </tr>
        `;
    }).join('');
    
    return `
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Gestión de Empleados</h3>
        <button class="btn-success mb-4" onclick="agregarEmpleado()">Agregar Empleado</button>
        <div class="table-container overflow-x-auto">
            <table class="responsive-table min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="sortable ${this.getSortClass('id')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('id')">ID</th>
                        <th class="sortable ${this.getSortClass('nombre')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('nombre')">Nombre</th>
                        <th class="sortable ${this.getSortClass('apellidos')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('apellidos')">Apellidos</th>
                        <th class="sortable ${this.getSortClass('correo')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('correo')">Correo</th>
                        <th class="sortable ${this.getSortClass('especialidad')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('especialidad')">Especialidad</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
        </div>
        ${data.length === 0 ? '<p class="text-center text-gray-500 mt-4">No hay empleados registrados.</p>' : ''}
        ${this.renderPagination(totalItems)}
    `;
},
    
    renderServiciosView: function() {
        const data = this.getPaginatedData();
        const totalItems = this.getSortedData().length;
        
        const rows = data.map(function(servicio) {
            return `
                <tr class="hover:bg-gray-50">
                    <td data-label="ID" class="px-4 py-2">${servicio.id}</td>
                    <td data-label="Nombre" class="px-4 py-2">${servicio.nombre}</td>
                    <td data-label="Descripción" class="px-4 py-2">${servicio.descripcion || 'Sin descripción'}</td>
                    <td data-label="Precio" class="px-4 py-2">$${parseFloat(servicio.precio).toFixed(2)}</td>
                    <td data-label="Acciones" class="px-4 py-2 space-x-2">
                        <button class="btn-secondary text-xs" onclick="editarServicio(${servicio.id})">
                            Editar
                        </button>
                        <button class="btn-danger text-xs" onclick="eliminarServicio(${servicio.id})">
                            Eliminar
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
        
        return `
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Gestión de Servicios</h3>
            <button class="btn-success mb-4" onclick="agregarServicio()">Agregar Servicio</button>
            <div class="table-container overflow-x-auto">
                <table class="responsive-table min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="sortable ${this.getSortClass('id')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('id')">ID</th>
                            <th class="sortable ${this.getSortClass('nombre')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('nombre')">Nombre</th>
                            <th class="sortable ${this.getSortClass('descripcion')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('descripcion')">Descripción</th>
                            <th class="sortable ${this.getSortClass('precio')} px-4 py-2 text-left cursor-pointer" onclick="AdminPanel.sort('precio')">Precio</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
            ${data.length === 0 ? '<p class="text-center text-gray-500 mt-4">No hay servicios registrados.</p>' : ''}
            ${this.renderPagination(totalItems)}
        `;
    },
    
    getSortClass: function(field) {
        if (this.sortField !== field) return '';
        return this.sortDirection === 'asc' ? 'sort-asc' : 'sort-desc';
    },
    
    getEstadoClass: function(estado) {
        const classes = {
            'Pendiente': 'estado-pendiente',
            'Confirmada': 'estado-confirmada',
            'En proceso': 'estado-en-proceso',
            'Completada': 'estado-completada',
            'Cancelada': 'estado-cancelada'
        };
        return classes[estado] || 'estado-pendiente';
    }
};

// ===== FUNCIONES DE ENCRIPTACIÓN =====
function encriptarPassword(password) {
    // Usar SHA-256 para encriptar
    if (typeof sha256 !== 'undefined') {
        return sha256(password);
    } else {
        // Fallback simple si no está cargada la librería
        console.warn('SHA-256 no disponible, usando encriptación básica');
        let hash = 0;
        for (let i = 0; i < password.length; i++) {
            const char = password.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash;
        }
        return Math.abs(hash).toString(16);
    }
}

// ===== FUNCIONES PARA CLIENTES =====
function configurarModalCliente(esEdicion = false) {
    const passwordField = document.getElementById('cliente_password_field');
    const passwordInput = document.getElementById('cliente_password');
    const passwordNote = document.getElementById('cliente_password_note');
    
    if (esEdicion) {
        // En edición: ocultar campo de contraseña
        passwordField.style.display = 'none';
        passwordInput.required = false;
        passwordInput.value = ''; // Limpiar campo
    } else {
        // En agregar: mostrar y hacer requerido
        passwordField.style.display = 'block';
        passwordInput.required = true;
        passwordNote.textContent = 'Mínimo 6 caracteres';
    }
}

function validarYEncriptarCliente() {
    const accion = document.getElementById('cliente_accion').value;
    const passwordInput = document.getElementById('cliente_password');
    const passwordHashInput = document.getElementById('cliente_password_hash');
    
    // Validar campos básicos
    if (!validarCliente()) {
        return false;
    }
    
    // Solo encriptar si es agregar O si se escribió nueva contraseña en edición
    if (accion === 'agregar') {
        if (!validarPassword(passwordInput)) {
            return false;
        }
        // Encriptar contraseña
        passwordHashInput.value = encriptarPassword(passwordInput.value);
    } else if (accion === 'editar' && passwordInput.value.trim() !== '') {
        if (!validarPassword(passwordInput)) {
            return false;
        }
        passwordHashInput.value = encriptarPassword(passwordInput.value);
    } else {
        // En edición sin cambiar contraseña, enviar vacío
        passwordHashInput.value = '';
    }
    
    return true;
}

function agregarCliente() {
    document.getElementById('clienteModalTitle').textContent = 'Agregar Cliente';
    document.getElementById('clienteForm').reset();
    document.getElementById('cliente_id').value = '';
    document.getElementById('cliente_accion').value = 'agregar';
    configurarModalCliente(false);
    document.getElementById('clienteModal').style.display = 'block';
}

function editarCliente(id) {
    const clientes = window.clientesData || [];
    const cliente = clientes.find(function(c) { return c.id == id; });
    if (!cliente) {
        alert('Cliente no encontrado');
        return;
    }

    document.getElementById('clienteModalTitle').textContent = 'Editar Cliente';
    document.getElementById('cliente_id').value = cliente.id;
    document.getElementById('cliente_nombre').value = cliente.nombre || '';
    document.getElementById('cliente_apellidos').value = cliente.apellidos || '';
    document.getElementById('cliente_correo').value = cliente.correo || '';
    document.getElementById('cliente_accion').value = 'editar';
    
    configurarModalCliente(true);
    document.getElementById('clienteModal').style.display = 'block';
}

function eliminarCliente(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'gestionar_cliente.php';
        
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'cliente_id';
        inputId.value = id;
        
        const inputAccion = document.createElement('input');
        inputAccion.type = 'hidden';
        inputAccion.name = 'accion';
        inputAccion.value = 'eliminar';
        
        form.appendChild(inputId);
        form.appendChild(inputAccion);
        document.body.appendChild(form);
        form.submit();
    }
}

// ===== FUNCIONES PARA EMPLEADOS =====
function configurarModalEmpleado(esEdicion = false) {
    const passwordField = document.getElementById('empleado_password_field');
    const passwordInput = document.getElementById('empleado_password');
    const passwordNote = document.getElementById('empleado_password_note');
    
    if (esEdicion) {
        // En edición: hacer opcional con nota
        passwordField.style.display = 'block';
        passwordInput.required = false;
        passwordNote.textContent = 'Dejar vacío para mantener la contraseña actual';
        passwordInput.value = ''; // Limpiar campo
    } else {
        // En agregar: requerido
        passwordField.style.display = 'block';
        passwordInput.required = true;
        passwordNote.textContent = 'Mínimo 6 caracteres';
    }
}

function validarYEncriptarEmpleado() {
    const accion = document.getElementById('empleado_accion').value;
    const passwordInput = document.getElementById('empleado_password');
    const passwordHashInput = document.getElementById('empleado_password_hash');
    
    // Validar campos básicos
    if (!validarEmpleado()) {
        return false;
    }
    
    // Encriptar lógica
    if (accion === 'agregar') {
        // En agregar, contraseña es obligatoria
        if (!validarPassword(passwordInput, 'emp')) {
            return false;
        }
        passwordHashInput.value = encriptarPassword(passwordInput.value);
    } else if (accion === 'editar' && passwordInput.value.trim() !== '') {
        // En edición solo si se escribió nueva contraseña
        if (!validarPassword(passwordInput, 'emp')) {
            return false;
        }
        passwordHashInput.value = encriptarPassword(passwordInput.value);
    } else {
        // En edición sin cambiar contraseña
        passwordHashInput.value = '';
    }
    
    return true;
}

function agregarEmpleado() {
    document.getElementById('empleadoModalTitle').textContent = 'Agregar Empleado';
    document.getElementById('empleadoForm').reset();
    document.getElementById('empleado_id').value = '';
    document.getElementById('empleado_accion').value = 'agregar';
    configurarModalEmpleado(false);
    document.getElementById('empleadoModal').style.display = 'block';
}

function editarEmpleado(id) {
    const empleados = window.empleadosData || [];
    const empleado = empleados.find(function(e) { return e.id == id; });
    if (!empleado) {
        alert('Empleado no encontrado');
        return;
    }

    document.getElementById('empleadoModalTitle').textContent = 'Editar Empleado';
    document.getElementById('empleado_id').value = empleado.id;
    document.getElementById('empleado_nombre').value = empleado.nombre || '';
    document.getElementById('empleado_apellidos').value = empleado.apellidos || '';
    document.getElementById('empleado_correo').value = empleado.correo || '';
    document.getElementById('empleado_especialidad').value = empleado.especialidad || '';
    document.getElementById('empleado_accion').value = 'editar';
    
    configurarModalEmpleado(true);
    document.getElementById('empleadoModal').style.display = 'block';
}

function eliminarEmpleado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este empleado?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'gestionar_empleado.php';
        
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'empleado_id';
        inputId.value = id;
        
        const inputAccion = document.createElement('input');
        inputAccion.type = 'hidden';
        inputAccion.name = 'accion';
        inputAccion.value = 'eliminar';
        
        form.appendChild(inputId);
        form.appendChild(inputAccion);
        document.body.appendChild(form);
        form.submit();
    }
}

// ===== FUNCIONES PARA SERVICIOS =====
function agregarServicio() {
    document.getElementById('servicioModalTitle').textContent = 'Agregar Servicio';
    document.getElementById('servicioForm').reset();
    document.getElementById('servicio_id').value = '';
    document.getElementById('servicio_accion').value = 'agregar';
    document.getElementById('servicioModal').style.display = 'block';
}

function editarServicio(id) {
    const servicios = window.serviciosData || [];
    const servicio = servicios.find(function(s) { return s.id == id; });
    if (!servicio) {
        alert('Servicio no encontrado');
        return;
    }

    document.getElementById('servicioModalTitle').textContent = 'Editar Servicio';
    document.getElementById('servicio_id').value = servicio.id;
    document.getElementById('servicio_nombre').value = servicio.nombre || '';
    document.getElementById('servicio_descripcion').value = servicio.descripcion || '';
    document.getElementById('servicio_precio').value = servicio.precio || '';
    document.getElementById('servicio_accion').value = 'editar';
    document.getElementById('servicioModal').style.display = 'block';
}

function eliminarServicio(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este servicio?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'gestionar_servicio.php';
        
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'servicio_id';
        inputId.value = id;
        
        const inputAccion = document.createElement('input');
        inputAccion.type = 'hidden';
        inputAccion.name = 'accion';
        inputAccion.value = 'eliminar';
        
        form.appendChild(inputId);
        form.appendChild(inputAccion);
        document.body.appendChild(form);
        form.submit();
    }
}

// ===== FUNCIONES PARA CITAS =====
async function cargarServiciosCita(citaId) {
    try {
        const response = await fetch('obtener_servicios_cita.php?cita_id=' + citaId);
        const serviciosCita = await response.json();
        
        const container = document.getElementById('servicios-container');
        container.innerHTML = '';
        
        const servicios = window.serviciosData || [];
        servicios.forEach(function(servicio) {
            const isSelected = serviciosCita.some(function(sc) { return sc.servicio_id == servicio.id; });
            const servicioItem = document.createElement('div');
            servicioItem.className = 'servicio-item flex items-center mb-2';
            servicioItem.innerHTML = `
                <input type="checkbox" name="servicios[]" value="${servicio.id}" 
                       ${isSelected ? 'checked' : ''} 
                       id="servicio-${servicio.id}" class="mr-2">
                <label for="servicio-${servicio.id}" class="text-sm">
                    ${servicio.nombre} - $${parseFloat(servicio.precio).toFixed(2)}
                </label>
            `;
            container.appendChild(servicioItem);
        });
    } catch (error) {
        console.error('Error al cargar servicios:', error);
        const container = document.getElementById('servicios-container');
        container.innerHTML = '<p class="text-red-500">Error al cargar servicios</p>';
    }
}

async function editarCita(citaId) {
    const citas = window.citasData || [];
    const cita = citas.find(function(c) { return c.id == citaId; });
    if (!cita) {
        alert('Cita no encontrada');
        return;
    }

    document.getElementById('edit_cita_id').value = cita.id;
    document.getElementById('edit_cliente').value = cita.cliente || '';
    
    document.getElementById('edit_fecha').value = cita.fecha || '';
    document.getElementById('edit_hora').value = cita.hora || '';
    
    document.getElementById('edit_estado').value = cita.estado || 'Pendiente';

    // Asignar el empleado
    const empleados = window.empleadosData || [];
    const empleadoSelect = document.getElementById('edit_empleado_id');
    const empleadoAsignado = empleados.find(function(e) { 
        const nombreCompleto = e.nombre + ' ' + (e.apellidos || '');
        return nombreCompleto === cita.empleado; 
    });
    if(empleadoAsignado) {
        empleadoSelect.value = empleadoAsignado.id;
    } else {
        empleadoSelect.value = ''; 
    }
    
    await cargarServiciosCita(citaId);
    
    document.getElementById('editCitaModal').style.display = 'block';
}

function eliminarCita(id) {
    if (confirm('¿Estás seguro de que quieres eliminar esta cita? Esto eliminará la cita y sus servicios asociados.')) {
        window.location.href = 'admin.php?eliminar_cita=' + id;
    }
}

// ===== FUNCIONES DE VALIDACIÓN =====
function validarCampo(input, tipo) {
    const errorId = `error_${input.id.replace('cliente_', '').replace('empleado_', '')}`;
    const errorElement = document.getElementById(errorId);
    const value = input.value.trim();
    
    // Remover espacios múltiples
    input.value = value.replace(/\s+/g, ' ');
    
    if (value === '') {
        mostrarError(errorElement, 'Este campo es obligatorio');
        return false;
    }
    
    if (tipo === 'nombre' || tipo === 'apellidos') {
        const regex = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/;
        if (!regex.test(value)) {
            mostrarError(errorElement, 'Solo se permiten letras y espacios');
            return false;
        }
    }
    
    if (input.minLength && value.length < input.minLength) {
        mostrarError(errorElement, `Mínimo ${input.minLength} caracteres`);
        return false;
    }
    
    if (input.maxLength && value.length > input.maxLength) {
        mostrarError(errorElement, `Máximo ${input.maxLength} caracteres`);
        return false;
    }
    
    ocultarError(errorElement);
    return true;
}

function validarEmail(input, prefijo = '') {
    const errorId = `error_${prefijo ? prefijo + '_' : ''}correo`;
    const errorElement = document.getElementById(errorId);
    const value = input.value.trim();
    
    if (value === '') {
        mostrarError(errorElement, 'El correo es obligatorio');
        return false;
    }
    
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(value)) {
        mostrarError(errorElement, 'Formato de correo inválido');
        return false;
    }
    
    ocultarError(errorElement);
    return true;
}

function validarPassword(input, prefijo = '') {
    const errorId = `error_${prefijo ? prefijo + '_' : ''}password`;
    const errorElement = document.getElementById(errorId);
    const value = input.value;
    
    if (input.required && value === '') {
        mostrarError(errorElement, 'La contraseña es obligatoria');
        return false;
    }
    
    if (value !== '' && value.length < 6) {
        mostrarError(errorElement, 'Mínimo 6 caracteres');
        return false;
    }
    
    ocultarError(errorElement);
    return true;
}

function mostrarError(elemento, mensaje) {
    if (elemento) {
        elemento.textContent = mensaje;
        elemento.classList.remove('hidden');
    }
}

function ocultarError(elemento) {
    if (elemento) {
        elemento.textContent = '';
        elemento.classList.add('hidden');
    }
}

// Validación completa de formularios
function validarCliente() {
    const nombre = document.getElementById('cliente_nombre');
    const apellidos = document.getElementById('cliente_apellidos');
    const correo = document.getElementById('cliente_correo');
    const accion = document.getElementById('cliente_accion').value;
    const password = document.getElementById('cliente_password');
    
    const val1 = validarCampo(nombre, 'nombre');
    const val2 = validarCampo(apellidos, 'apellidos');
    const val3 = validarEmail(correo);
    
    // Solo validar password si es agregar
    let val4 = true;
    if (accion === 'agregar') {
        val4 = validarPassword(password);
    }
    
    return val1 && val2 && val3 && val4;
}

function validarEmpleado() {
    const nombre = document.getElementById('empleado_nombre');
    const apellidos = document.getElementById('empleado_apellidos');
    const correo = document.getElementById('empleado_correo');
    const especialidad = document.getElementById('empleado_especialidad');
    const accion = document.getElementById('empleado_accion').value;
    const password = document.getElementById('empleado_password');
    
    const val1 = validarCampo(nombre, 'nombre');
    const val2 = validarCampo(apellidos, 'apellidos');
    const val3 = validarEmail(correo, 'emp');
    const val4 = validarCampo(especialidad, 'especialidad');
    
    // Solo validar password si es agregar
    let val5 = true;
    if (accion === 'agregar') {
        val5 = validarPassword(password, 'emp');
    }
    
    return val1 && val2 && val3 && val4 && val5;
}

function validarServicio() {
    const nombre = document.getElementById('servicio_nombre');
    const precio = document.getElementById('servicio_precio');
    
    const val1 = validarCampo(nombre, 'nombre');
    const val2 = validarPrecio(precio);
    
    return val1 && val2;
}

function validarPrecio(input) {
    const value = parseFloat(input.value);
    
    if (isNaN(value) || value <= 0) {
        alert('El precio debe ser mayor a 0');
        return false;
    }
    
    return true;
}

// ===== FUNCIONES PARA MODALES =====
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function changeAdminView(view) {
    AdminPanel.changeView(view);
}

// ===== INICIALIZACIÓN =====
document.addEventListener('DOMContentLoaded', function() {
    AdminPanel.init();
});