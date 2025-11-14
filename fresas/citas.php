<?php
session_start();

include 'conexion.php';

// Variables para mensajes
$mensaje_exito = '';
$mensaje_error = '';

// Horarios disponibles según lo especificado
$horarios_disponibles = [
    'Lunes' => ['09:00', '10:00', '11:00', '16:00', '17:00', '18:00'],
    'Martes' => ['09:00', '10:00', '11:00', '16:00', '17:00', '18:00'],
    'Miércoles' => ['09:00', '10:00', '11:00'],
    'Viernes' => ['10:00', '11:00', '12:00', '13:00', '14:00'],
    'Sábado' => ['09:00', '10:00', '11:00', '12:00', '13:00'],
    'Domingo' => ['09:00', '10:00', '11:00', '12:00', '13:00']
];

// Verificar límite de citas por día
function verificarLimiteCitas($conn, $fecha) {
    $sql = "SELECT COUNT(*) as total FROM cita WHERE DATE(fecha) = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $fecha);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    return $row['total'] < 10; // Máximo 10 citas por día
}

// Verificar si el horario ya está ocupado
function verificarHorarioOcupado($conn, $fecha_hora) {
    $sql = "SELECT COUNT(*) as total FROM cita WHERE fecha = ? AND estado != 'Cancelada'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $fecha_hora);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    return $row['total'] > 0;
}

// Procesar el formulario de cita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agendar_cita'])) {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : [];
    
    // Validaciones
    if (empty($fecha) || empty($hora) || empty($servicios)) {
        $mensaje_error = 'Todos los campos son obligatorios.';
    } else {
        $fecha_hora = $fecha . ' ' . $hora . ':00';
        $dia_semana = date('l', strtotime($fecha));
        
        // Convertir día en español
        $dias_ingles_espanol = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        $dia_espanol = $dias_ingles_espanol[$dia_semana];
        
        // Verificar si el horario está disponible
        if (!in_array($hora, $horarios_disponibles[$dia_espanol])) {
            $mensaje_error = 'El horario seleccionado no está disponible para ' . $dia_espanol;
        } 
        // Verificar límite de citas
        elseif (!verificarLimiteCitas($conn, $fecha)) {
            $mensaje_error = 'Se ha alcanzado el límite máximo de 10 citas para este día.';
        } 
        // Verificar que no sea en la madrugada
        elseif ($hora < '06:00' || $hora > '23:59') {
            $mensaje_error = 'No se pueden agendar citas en la madrugada.';
        }
        // Verificar si el horario ya está ocupado
        elseif (verificarHorarioOcupado($conn, $fecha_hora)) {
            $mensaje_error = 'Este horario ya está ocupado. Por favor selecciona otro horario.';
        } else {
            // Insertar la cita
            $cliente_id = $_SESSION['user_id'];
            $sql_cita = "INSERT INTO cita (clienteID, fecha, estado) VALUES (?, ?, 'Pendiente')";
            $stmt_cita = mysqli_prepare($conn, $sql_cita);
            mysqli_stmt_bind_param($stmt_cita, "is", $cliente_id, $fecha_hora);
            
            if (mysqli_stmt_execute($stmt_cita)) {
                $cita_id = mysqli_insert_id($conn);
                
                // Insertar servicios seleccionados
                foreach ($servicios as $servicio_id) {
                    $sql_servicio = "INSERT INTO citaservicio (citaID, servicioID) VALUES (?, ?)";
                    $stmt_servicio = mysqli_prepare($conn, $sql_servicio);
                    mysqli_stmt_bind_param($stmt_servicio, "ii", $cita_id, $servicio_id);
                    mysqli_stmt_execute($stmt_servicio);
                    mysqli_stmt_close($stmt_servicio);
                }
                
                $mensaje_exito = 'Cita agendada exitosamente.';
            } else {
                $mensaje_error = 'Error al agendar la cita. Intenta nuevamente.';
            }
            mysqli_stmt_close($stmt_cita);
        }
    }
}

// Insertar servicios si no existen
$servicios_base = [
    ['Depilación y Epilación', 350.00],
    ['Peluquería', 250.00],
    ['Maquillaje Artístico', 400.00],
    ['Manicura y Pedicura', 200.00],
    ['Masajes Relajantes y Terapéuticos', 450.00],
    ['Tratamientos Faciales Avanzados', 500.00]
];

foreach ($servicios_base as $servicio) {
    $sql_check = "SELECT servicioID FROM servicio WHERE nombre = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $servicio[0]);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    
    if (mysqli_num_rows($result_check) == 0) {
        $sql_insert = "INSERT INTO servicio (nombre, precio, descripcion) VALUES (?, ?, 1)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "sd", $servicio[0], $servicio[1]);
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_stmt_close($stmt_check);
}

// Obtener servicios disponibles
$servicios = [];
$sql_servicios = "SELECT servicioID, nombre, precio FROM servicio WHERE descripcion = 1 ORDER BY nombre";
$result_servicios = mysqli_query($conn, $sql_servicios);
if ($result_servicios && mysqli_num_rows($result_servicios) > 0) {
    while ($servicio = mysqli_fetch_assoc($result_servicios)) {
        $servicios[] = $servicio;
    }
}

// Obtener citas del cliente
$citas_cliente = [];
$sql_citas = "SELECT 
                c.citaID, 
                c.fecha, 
                c.estado,
                GROUP_CONCAT(s.nombre SEPARATOR ', ') as servicios
              FROM cita c 
              LEFT JOIN citaservicio cs ON c.citaID = cs.citaID 
              LEFT JOIN servicio s ON cs.servicioID = s.servicioID 
              WHERE c.clienteID = ?
              GROUP BY c.citaID
              ORDER BY c.fecha DESC";
$stmt_citas = mysqli_prepare($conn, $sql_citas);
mysqli_stmt_bind_param($stmt_citas, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt_citas);
$result_citas = mysqli_stmt_get_result($stmt_citas);

if ($result_citas && mysqli_num_rows($result_citas) > 0) {
    while ($cita = mysqli_fetch_assoc($result_citas)) {
        $citas_cliente[] = $cita;
    }
}
mysqli_stmt_close($stmt_citas);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita - Fresitaslab</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #E91E63 0%, #C2185B 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(225, 29, 99, 0.3);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .servicios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .servicio-item {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .servicio-item:hover {
            border-color: #E91E63;
            background-color: #f8f9fa;
        }
        
        .servicio-item.selected {
            border-color: #E91E63;
            background-color: #fff5f7;
        }
        
        .servicio-item input[type="checkbox"] {
            margin-right: 10px;
        }
        
        .horario-btn {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            padding: 10px 15px;
            margin: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .horario-btn:hover {
            border-color: #E91E63;
        }
        
        .horario-btn.selected {
            background: #E91E63;
            color: white;
            border-color: #E91E63;
        }
        
        .horario-btn.disabled {
            background: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
            opacity: 0.5;
        }
        
        .horario-btn.ocupado {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
            cursor: not-allowed;
        }
        
        .estado-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .estado-pendiente { background: #fff3cd; color: #856404; }
        .estado-confirmada { background: #d1ecf1; color: #0c5460; }
        .estado-completada { background: #d4edda; color: #155724; }
        .estado-cancelada { background: #f8d7da; color: #721c24; }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        
        .servicio-icon {
            font-size: 24px;
            margin-bottom: 10px;
            color: #E91E63;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <div class="container-custom">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Agendar Cita</h1>
        <p class="text-gray-600 mb-6">Selecciona los servicios, fecha y horario para tu cita</p>
        
        <!-- Mensajes -->
        <?php if ($mensaje_exito): ?>
            <div class="alert alert-success"><?php echo $mensaje_exito; ?></div>
        <?php endif; ?>
        
        <?php if ($mensaje_error): ?>
            <div class="alert alert-danger"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Formulario de Cita -->
            <div class="card">
                <h2 class="text-xl font-semibold mb-4">Nueva Cita</h2>
                <form method="POST" id="citaForm">
                    <!-- Selección de Servicios -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-3">Servicios:</label>
                        <div class="servicios-grid">
                            <?php foreach ($servicios as $servicio): ?>
                                <div class="servicio-item" onclick="toggleServicio(<?php echo $servicio['servicioID']; ?>)">
                                    <input type="checkbox" 
                                           name="servicios[]" 
                                           value="<?php echo $servicio['servicioID']; ?>" 
                                           id="servicio-<?php echo $servicio['servicioID']; ?>"
                                           class="hidden">
                                    <label for="servicio-<?php echo $servicio['servicioID']; ?>" class="cursor-pointer">
                                        <div class="servicio-icon">
                                            <?php 
                                            $iconos = [
                                                'Depilación y Epilación' => 'fas fa-spa',
                                                'Peluquería' => 'fas fa-cut',
                                                'Maquillaje Artístico' => 'fas fa-palette',
                                                'Manicura y Pedicura' => 'fas fa-hand-sparkles',
                                                'Masajes Relajantes y Terapéuticos' => 'fas fa-hands',
                                                'Tratamientos Faciales Avanzados' => 'fas fa-star'
                                            ];
                                            $icono = $iconos[$servicio['nombre']] ?? 'fas fa-spa';
                                            ?>
                                            <i class="<?php echo $icono; ?>"></i>
                                        </div>
                                        <strong class="block mb-1"><?php echo htmlspecialchars($servicio['nombre']); ?></strong>
                                        <small class="text-gray-600 block">
                                            $<?php echo number_format($servicio['precio'], 2); ?> 
                                        </small>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Selección de Fecha -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-3">Fecha:</label>
                        <input type="date" 
                               name="fecha" 
                               id="fecha" 
                               class="w-full p-3 border border-gray-300 rounded-lg"
                               min="<?php echo date('Y-m-d'); ?>"
                               required
                               onchange="cargarHorarios()">
                    </div>
                    
                    <!-- Selección de Horario -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-3">Horario:</label>
                        <div id="horarios-container" class="flex flex-wrap">
                            <p class="text-gray-500">Selecciona una fecha para ver los horarios disponibles</p>
                        </div>
                    </div>
                    
                    <button type="submit" name="agendar_cita" class="btn-primary w-full">
                        <i class="fas fa-calendar-plus mr-2"></i>Agendar Cita
                    </button>
                </form>
            </div>
            
            <!-- Mis Citas -->
            <div class="card">
                <h2 class="text-xl font-semibold mb-4">Mis Citas</h2>
                
                <?php if (empty($citas_cliente)): ?>
                    <p class="text-gray-500 text-center py-8">No tienes citas agendadas</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($citas_cliente as $cita): ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <strong class="text-lg">
                                            <?php echo date('d/m/Y', strtotime($cita['fecha'])); ?>
                                        </strong>
                                        <span class="text-gray-600 ml-2">
                                            <?php echo date('H:i', strtotime($cita['fecha'])); ?>
                                        </span>
                                    </div>
                                    <span class="estado-badge estado-<?php echo strtolower($cita['estado']); ?>">
                                        <?php echo $cita['estado']; ?>
                                    </span>
                                </div>
                                
                                <p class="text-gray-700 mb-2">
                                    <strong>Servicios:</strong> 
                                    <?php echo $cita['servicios'] ?: 'No especificados'; ?>
                                </p>
                                
                                <div class="flex space-x-2 mt-3">
                                    <?php if ($cita['estado'] === 'Pendiente'): ?>
                                        <button class="btn-danger text-sm" 
                                                onclick="cancelarCita(<?php echo $cita['citaID']; ?>)">
                                            <i class="fas fa-times mr-1"></i>Cancelar
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Horarios de la Estética -->
        <div class="card mt-6">
            <h2 class="text-xl font-semibold mb-4">Horarios de la Estética</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                <?php foreach ($horarios_disponibles as $dia => $horarios): ?>
                    <div class="text-center">
                        <strong class="block mb-2 text-gray-700"><?php echo $dia; ?></strong>
                        <?php if (empty($horarios)): ?>
                            <span class="text-red-500 text-sm">Cerrado</span>
                        <?php else: ?>
                            <?php foreach ($horarios as $hora): ?>
                                <span class="block text-sm text-green-600 mb-1"><?php echo $hora; ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Toggle selección de servicios
        function toggleServicio(servicioId) {
            const checkbox = document.getElementById('servicio-' + servicioId);
            const item = checkbox.parentElement.parentElement;
            
            checkbox.checked = !checkbox.checked;
            if (checkbox.checked) {
                item.classList.add('selected');
            } else {
                item.classList.remove('selected');
            }
        }
        
        // Cargar horarios disponibles según la fecha seleccionada
        async function cargarHorarios() {
            const fechaInput = document.getElementById('fecha');
            const fecha = fechaInput.value;
            const container = document.getElementById('horarios-container');
            
            if (!fecha) {
                container.innerHTML = '<p class="text-gray-500">Selecciona una fecha</p>';
                return;
            }
            
            // Mostrar loading
            container.innerHTML = '<p class="text-gray-500">Cargando horarios disponibles...</p>';
            
            try {
                const response = await fetch(`obtener_horarios_disponibles.php?fecha=${fecha}`);
                const data = await response.json();
                
                if (data.horarios && data.horarios.length > 0) {
                    container.innerHTML = '';
                    data.horarios.forEach(horario => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = `horario-btn ${horario.ocupado ? 'ocupado' : ''}`;
                        button.textContent = horario.hora;
                        button.onclick = () => seleccionarHorario(horario.hora, button);
                        
                        if (!horario.ocupado) {
                            button.addEventListener('click', function() {
                                seleccionarHorario(horario.hora, button);
                            });
                        }
                        
                        container.appendChild(button);
                    });
                } else {
                    container.innerHTML = '<p class="text-red-500">No hay horarios disponibles para esta fecha</p>';
                }
            } catch (error) {
                container.innerHTML = '<p class="text-red-500">Error al cargar horarios</p>';
                console.error('Error:', error);
            }
        }
        
        // Seleccionar horario
        function seleccionarHorario(hora, elemento) {
            // Remover selección anterior
            document.querySelectorAll('.horario-btn').forEach(btn => {
                if (!btn.classList.contains('ocupado') && !btn.classList.contains('disabled')) {
                    btn.classList.remove('selected');
                }
            });
            
            // Seleccionar nuevo horario
            elemento.classList.add('selected');
            
            // Crear input hidden para el horario seleccionado
            let horaInput = document.querySelector('input[name="hora"]');
            if (!horaInput) {
                horaInput = document.createElement('input');
                horaInput.type = 'hidden';
                horaInput.name = 'hora';
                document.getElementById('citaForm').appendChild(horaInput);
            }
            horaInput.value = hora;
        }
        
        // Cancelar cita
        function cancelarCita(citaId) {
            if (confirm('¿Estás seguro de que quieres cancelar esta cita?')) {
                window.location.href = `cancelar_cita.php?id=${citaId}`;
            }
        }
        
        // Validar formulario antes de enviar
        document.getElementById('citaForm').addEventListener('submit', function(e) {
            const serviciosSeleccionados = document.querySelectorAll('input[name="servicios[]"]:checked').length;
            const fechaSeleccionada = document.getElementById('fecha').value;
            const horaSeleccionada = document.querySelector('input[name="hora"]');
            
            if (serviciosSeleccionados === 0) {
                e.preventDefault();
                alert('Por favor selecciona al menos un servicio.');
                return;
            }
            
            if (!fechaSeleccionada) {
                e.preventDefault();
                alert('Por favor selecciona una fecha.');
                return;
            }
            
            if (!horaSeleccionada || !horaSeleccionada.value) {
                e.preventDefault();
                alert('Por favor selecciona un horario.');
                return;
            }
        });
    </script>
</body>
</html>