<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potencias - Problema #9</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>🔢 Problema #9</h1>
        <p class="descripcion">
            Solicitar un número (1 al 9)<br>
            Generar o imprimir las <strong>15 primeras potencias</strong> del número<br>
            (4 elevado a la 1, 4 elevado a la 2, ...)
        </p>

        <div class="form-section">
            <form method="POST">
                <div class="form-group">
                    <label for="numero">Ingrese un número del 1 al 9:</label>
                    <input type="number" id="numero" name="numero" min="1" max="9" 
                           value="<?php echo isset($_POST['numero']) ? $_POST['numero'] : ''; ?>" 
                           required>
                </div>

                <div class="button-group">
                    <button type="submit" name="accion" value="generar" class="btn-generar">
                        📊 Generar Potencias
                    </button>
                    <button type="submit" name="accion" value="imprimir" class="btn-imprimir">
                        🖨️ Imprimir
                    </button>
                </div>
            </form>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numero']) && isset($_POST['accion'])) {
            $numero = (int)$_POST['numero'];
            
            // Validar que el número esté entre 1 y 9
            if ($numero < 1 || $numero > 9) {
                echo '<div class="error">⚠️ Error: El número debe estar entre 1 y 9</div>';
            } else {
                $accion = $_POST['accion'];
                
                // Si la acción es imprimir, agregar script de impresión
                if ($accion == 'imprimir') {
                    echo '<script>window.onload = function() { window.print(); }</script>';
                }
                
                echo '<div class="resultado">';
                echo '<div class="numero-seleccionado">Potencias del número: ' . $numero . '</div>';
                echo '<h2>Las 15 primeras potencias</h2>';
                echo '<div class="potencias-grid">';
                
                // Generar las 15 potencias
                for ($i = 1; $i <= 15; $i++) {
                    $resultado = pow($numero, $i);
                    
                    echo '<div class="potencia-item">';
                    echo '<div class="potencia-formula">' . $numero . '<sup>' . $i . '</sup></div>';
                    echo '<div class="potencia-resultado">' . number_format($resultado, 0, ',', '.') . '</div>';
                    echo '</div>';
                }
                
                echo '</div>';
                echo '</div>';
            }
        }
        ?>

        <button class="back-btn" onclick="window.history.back()">← Volver al Menú</button>
    </div>
</body>
</html>