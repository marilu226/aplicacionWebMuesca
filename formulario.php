<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muesca Eventos - Inicio y Alquiler</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <!-- Header Principal -->
    <header>
        <h1>MUESCA EVENTOS</h1>
        <!-- Botón superior para Admin -->
        <button class="btn-admin-nav" onclick="toggleModalLogin()">👤 Usuario / Admin</button>
    </header>

    <div class="container">
        <!-- Página Principal / Bienvenida y Descripción -->
        <div class="hero-bienvenida">
            <h2>¡Bienvenidos a Muesca Eventos!</h2>
            <p>
                Llevamos la energía, confianza, alegría y profesionalismo a cada celebración y empresa[cite: 3]. 
                Nos especializamos en experiencias recreativas, dinámicas de integración, fiestas infantiles inmersivas, 
                atracciones inflables, juegos tipo feria, gastronomía y entretenimiento de alto nivel para garantizar momentos inolvidables[cite: 3].
            </p>
            <!-- Botón en el medio para comenzar a alquilar -->
            <a href="#seccion-alquiler" class="btn-alquilar-centro">¡Alquilar Ahora!</a>
        </div>

        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #ccc;">

        <!-- Formulario de Alquiler y Selección Múltiple de Servicios -->
        <div id="seccion-alquiler">
            <h3>Formulario de Alquiler y Registro de Cliente</h3>
            <form action="procesar.php" method="POST">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label for="nombre_cliente">Nombre del Cliente:</label>
                        <input type="text" id="nombre_cliente" name="nombre_cliente" maxlength="15" required placeholder="Ej. María">
                    </div>
                    <div>
                        <label for="apellido_cliente">Apellido del Cliente:</label>
                        <input type="text" id="apellido_cliente" name="apellido_cliente" maxlength="15" required placeholder="Ej. Molina">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label for="telefono_cliente">Teléfono:</label>
                        <input type="number" id="telefono_cliente" name="telefono_cliente" required placeholder="04145012261">
                    </div>
                    <div>
                        <label for="email_cliente">Correo Electrónico:</label>
                        <input type="email" id="email_cliente" name="email_cliente" maxlength="25" required placeholder="correo@domain.com">
                    </div>
                </div>

                <label for="direccion_cliente">Dirección:</label>
                <input type="text" id="direccion_cliente" name="direccion_cliente" maxlength="40" required placeholder="Barquisimeto, Lara">

                <!-- Catálogo de Servicios con precios y selección múltiple -->
                <label>Selecciona los Servicios del Catálogo (Múltiple):</label>
                <div class="servicios-catalogo-box">
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Promo Animación - 190"> Promo Animación (1 Animador, 2 Recreadores, Sonido Básico)</label><span>$190[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Temática Pool Party - 290"> Temática Pool Party</label><span>$290[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Temática FarmKids - 290"> Temática FarmKids (Granjeros)</label><span>$290[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Temática Sports Muesca - 290"> Temática Sports Muesca</label><span>$290[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Temática Painters - 290"> Temática Painters</label><span>$290[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Temática Nerf - 340"> Temática Nerf Muesca</label><span>$340[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Castillo Inflable 3x3 - 40"> Castillo Inflable 3x3 mts</label><span>$40[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Cancha de Fútbol Inflable - 50"> Cancha de Fútbol Inflable</label><span>$50[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Zona Gamer - 110"> Zona Gamer (Consolas)</label><span>$110[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Zona Arcade - 120"> Zona Arcade (Hall of Games)</label><span>$120[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Juegos Tipo Feria - 50"> Juegos Tipo Feria (Tiro al blanco)</label><span>$50[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Estación Perros Calientes - 90"> Estación Perros Calientes Sencillos</label><span>$90[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Estación Hamburguesas - 170"> Estación Hamburguesas Sencillas</label><span>$170[cite: 3]</span></div>
                    <div class="servicio-item-check"><label><input type="checkbox" name="servicios[]" value="Promo Snacks - 120"> Promo Snacks (Cotufas, Raspados, Obleas)</label><span>$120[cite: 3]</span></div>
                </div>

                <button type="submit">Procesar Alquiler y Registrar Cliente</button>
            </form>
        </div>
    </div>

    <!-- Modal Oculto para Login de Administrador -->
    <div id="modal-login" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
        <div style="background: white; padding: 2rem; border-radius: 8px; width: 350px; border-top: 5px solid var(--color-morado);">
            <h3>Acceso Administrador</h3>
            <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">Solo el administrador autorizado puede ver las facturas de todos los pedidos.</p>
            <form action="procesar.php" method="POST">
                <input type="hidden" name="accion_admin" value="login">
                <label>Correo:</label>
                <input type="email" name="admin_correo" required placeholder="muescaeventos@gmail.com">
                <label>Clave:</label>
                <input type="password" name="admin_clave" required placeholder="202026">
                <button type="submit" class="btn-accion" style="margin-top: 10px;">Ingresar al Panel</button>
            </form>
            <button onclick="toggleModalLogin()" style="background: #ccc; border:none; padding: 8px; width: 100%; margin-top: 5px; border-radius:4px; cursor:pointer;">Cerrar</button>
        </div>
    </div>

    <script>
        function toggleModalLogin() {
            const modal = document.getElementById('modal-login');
            modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
        }
    </script>
</body>
</html>