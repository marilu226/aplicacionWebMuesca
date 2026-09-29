<?php
include("conexion.php");

// Manejo del Login de Administrador
if (isset($_POST['accion_admin']) && $_POST['accion_admin'] === 'login') {
    $correo = trim($_POST['admin_correo']);
    $clave = trim($_POST['admin_clave']);

    if ($correo === "muescaeventos@gmail.com" && $clave === "202026") {
        session_start();
        $_SESSION['admin'] = true;
    } else {
        echo "<script>alert('Credenciales incorrectas. Acceso denegado.'); window.location='formulario.php';</script>";
        exit;
    }
}

session_start();
$es_admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;

// Si se envió el formulario de alquiler de cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['accion_admin'])) {
    $nombre = $_POST['nombre_cliente'];
    $apellido = $_POST['apellido_cliente'];
    $telefono = $_POST['telefono_cliente'];
    $email = $_POST['email_cliente'];
    $direccion = $_POST['direccion_cliente'];
    $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : [];

    try {
        // 1. Guardar en la tabla cliente
        $sql = "INSERT INTO cliente (nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, direccion_cliente) VALUES (:nombre, :apellido, :telefono, :email, :direccion)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':telefono' => $telefono,
            ':email' => $email,
            ':direccion' => $direccion
        ]);
        $cliente_id = $conexion->lastInsertId();

        // Calcular total y unir servicios seleccionados
        $total = 0;
        $detalles_servicios = "";
        foreach ($servicios as $s) {
            $partes = explode(" - ", $s);
            $nombre_serv = $partes[0];
            $precio_serv = intval($partes[1]);
            $total += $precio_serv;
            $detalles_servicios .= $s . " | ";
        }

        // Redirigir a vista de factura generada del pedido
        echo "<script>window.location='procesar.php?factura=true&cliente=$nombre $apellido&tel=$telefono&servicios=" . urlencode($detalles_servicios) . "&total=$total';</script>";
        exit;

    } catch (PDOException $e) {
        die("Error al procesar el registro: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura y Panel - Muesca Eventos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>MUESCA EVENTOS</h1>
        <a href="formulario.php" class="btn-admin-nav">Regresar al Inicio</a>
    </header>

    <div class="container">
        <?php if (isset($_GET['factura'])): 
            $cliente = $_GET['cliente'];
            $tel = $_GET['tel'];
            $servicios = $_GET['servicios'];
            $total = $_GET['total'];
        ?>
            <!-- DETALLE DE EVENTO E IMPRESIÓN DE FACTURA -->
            <div id="printable-factura" style="background: white; padding: 20px; border: 2px solid var(--color-morado); border-radius: 8px;">
                <div style="display: flex; justify-content: space-between; border-bottom: 2px solid var(--color-amarillo); padding-bottom: 10px; margin-bottom: 15px;">
                    <div>
                        <h2>MUESCA EVENTOS C.A.</h2>
                        <p>RIF: J-20202600-9 | Barquisimeto, Lara</p>
                        <p>Teléfono: 0414-5012261[cite: 3]</p>
                    </div>
                    <div style="text-align: right;">
                        <h3 style="color: var(--color-morado);">FACTURA DE PEDIDO</h3>
                        <p>Fecha: <?php echo date("d/m/Y"); ?></p>
                    </div>
                </div>

                <p><strong>Cliente:</strong> <?php echo htmlspecialchars($cliente); ?></p>
                <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($tel); ?></p>

                <table>
                    <thead>
                        <tr>
                            <th>Concepto / Servicios Contratados</th>
                            <th style="text-align: right;">Subtotal (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($servicios); ?></td>
                            <td style="text-align: right;">$<?php echo htmlspecialchars($total); ?>.00</td>
                        </tr>
                    </tbody>
                </table>

                <div style="text-align: right; font-size: 1.3rem; margin-top: 20px;">
                    <strong>Total General: $<?php echo htmlspecialchars($total); ?> USD</strong>
                </div>
            </div>

            <div class="no-print" style="margin-top: 20px; display: flex; gap: 10px;">
                <button class="btn-accion" onclick="window.print()">🖨️ Imprimir Factura</button>
                <a href="formulario.php" class="btn-accion" style="text-align: center; text-decoration: none; background-color: #6c757d;">Hacer Otro Alquiler</a>
            </div>

        <?php elseif ($es_admin): ?>
            <!-- PANEL DE ADMINISTRADOR: FACTURAS DE TODOS LOS PEDIDOS -->
            <h3>Panel de Control - Facturas de Todos los Pedidos</h3>
            <p>Acceso exclusivo de administrador verificado para <strong>muescaeventos@gmail.com</strong>.</p>
            
            <table>
                <thead>
                    <tr>
                        <th>N° Pedido</th>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conexion->query("SELECT * FROM cliente ORDER BY cod_cliente DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>#00" . $row['cod_cliente'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombre_cliente'] . " " . $row['apellido_cliente']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['telefono_cliente']) . "</td>";
                        echo "<td><a href='formulario.php' class='btn-accion' style='padding: 5px 10px; font-size:0.85rem; text-decoration:none;'>Ver Detalles</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <br>
            <a href="formulario.php" class="btn-accion" style="display:inline-block; width:auto; text-decoration:none;">Cerrar Sesión / Volver</a>

        <?php else: ?>
            <p>Acceso no autorizado.</p>
            <a href="formulario.php">Volver</a>
        <?php endif; ?>
    </div>
</body>
</html>