<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estación del Año - Problema #8</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Problema #8</h1>
            <p>Estación del Año</p>
        </div>

        <div class="content">
            <div class="description">
                Al ingresar una fecha, el sistema determina la estación del año correspondiente según el clima tropical de Panamá.
            </div>

            <div class="form-section">
                <form method="POST">
                    <div class="form-group">
                        <label for="fecha">Seleccione una fecha:</label>
                        <input type="date" id="fecha" name="fecha" 
                               value="<?php echo isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : ''; ?>" 
                               required>
                    </div>
                    <button type="submit">Determinar Estación</button>
                </form>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fecha'])) {
                $fecha = $_POST['fecha'];
                $date = new DateTime($fecha);
                $mes = (int)$date->format('m');
                $dia = (int)$date->format('d');
                
                $estacion = '';
                $imagen = '';
                $icono = '';
                $descripcion = '';
                
                // Determinar estación según tabla exacta de la profesora
                // Verano: Del 21 de diciembre al 20 de marzo
                // Otoño: Del 21 de marzo al 21 de junio
                // Invierno: Del 22 de junio al 22 de septiembre
                // Primavera: Del 23 de septiembre al 20 de diciembre
                
                if (($mes == 3 && $dia >= 21) || ($mes == 4) || ($mes == 5) || ($mes == 6 && $dia <= 21)) {
                    // Otoño: 21 marzo - 21 junio
                    $estacion = 'Otoño';
                    $imagen = 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=600&h=400&fit=crop';
                    $icono = '🍂';
                    $descripcion = 'Estación de otoño: del 21 de marzo al 21 de junio. Clima templado y hojas que caen.';
                } elseif (($mes == 6 && $dia >= 22) || ($mes == 7) || ($mes == 8) || ($mes == 9 && $dia <= 22)) {
                    // Invierno: 22 junio - 22 septiembre
                    $estacion = 'Invierno';
                    $imagen = 'https://images.unsplash.com/photo-1483664852095-d6cc6870702d?w=600&h=400&fit=crop';
                    $icono = '❄️';
                    $descripcion = 'Estación de invierno: del 22 de junio al 22 de septiembre. Temperaturas frías y días cortos.';
                } elseif (($mes == 9 && $dia >= 23) || ($mes == 10) || ($mes == 11) || ($mes == 12 && $dia <= 20)) {
                    // Primavera: 23 septiembre - 20 diciembre
                    $estacion = 'Primavera';
                    $imagen = 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?w=600&h=400&fit=crop';
                    $icono = '🌸';
                    $descripcion = 'Estación de primavera: del 23 de septiembre al 20 de diciembre. Florecimiento y temperaturas agradables.';
                } else {
                    // Verano: 21 diciembre - 20 marzo
                    $estacion = 'Verano';
                    $imagen = 'https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?w=600&h=400&fit=crop';
                    $icono = '☀️';
                    $descripcion = 'Estación de verano: del 21 de diciembre al 20 de marzo. Temperaturas cálidas y días largos.';
                }
                
                $fechaFormateada = $date->format('d/m/Y');
                
                echo '<div class="resultado">';
                
                echo '<div class="resultado-card">';
                echo '<p class="fecha-info">Fecha seleccionada: <strong>' . $fechaFormateada . '</strong></p>';
                echo '</div>';
                
                echo '<div class="estacion-card">';
                echo '<div class="estacion-icono">' . $icono . '</div>';
                echo '<div class="estacion-nombre">' . $estacion . '</div>';
                echo '<img src="' . $imagen . '" alt="' . $estacion . '" class="estacion-imagen">';
                echo '<div class="estacion-descripcion">' . $descripcion . '</div>';
                echo '</div>';
                
                echo '</div>';
            }
            ?>

            <div class="referencia-box">
                <h3>📅 Tabla de Estaciones</h3>
                
                <div class="referencia-item">
                    <span class="referencia-icono">☀️</span>
                    <div class="referencia-texto">
                        <strong>Verano:</strong> Del 21 de diciembre al 20 de marzo
                    </div>
                </div>
                
                <div class="referencia-item">
                    <span class="referencia-icono">🍂</span>
                    <div class="referencia-texto">
                        <strong>Otoño:</strong> Del 21 de marzo al 21 de junio
                    </div>
                </div>
                
                <div class="referencia-item">
                    <span class="referencia-icono">❄️</span>
                    <div class="referencia-texto">
                        <strong>Invierno:</strong> Del 22 de junio al 22 de septiembre
                    </div>
                </div>
                
                <div class="referencia-item">
                    <span class="referencia-icono">🌸</span>
                    <div class="referencia-texto">
                        <strong>Primavera:</strong> Del 23 de septiembre al 20 de diciembre
                    </div>
                </div>
            </div>

            <button class="back-btn" onclick="window.history.back()">← Volver al Menú</button>
        </div>
    </div>
</body>
</html>