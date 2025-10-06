<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto Hospital - Problema #6</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>🏥 Problema #6</h1>
        <p class="descripcion">
            En un hospital existen tres áreas: <strong>Ginecología, Pediatría y Traumatología</strong>.<br>
            El presupuesto anual del hospital se reparte conforme a la siguiente tabla.<br>
        </p>

        <div class="form-section">
            <form method="POST">
                <div class="form-group">
                    <label for="presupuesto">💰 Ingrese el presupuesto anual del hospital ($):</label>
                    <input type="number" id="presupuesto" name="presupuesto" min="1" step="0.01"
                           value="<?php echo isset($_POST['presupuesto']) ? htmlspecialchars($_POST['presupuesto']) : ''; ?>" 
                           placeholder="Ejemplo: 100000" required>
                </div>

                <button type="submit">📊 Calcular Distribución</button>
            </form>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['presupuesto'])) {
            $presupuesto = floatval($_POST['presupuesto']);
            
            if ($presupuesto <= 0) {
                echo '<div class="error">⚠️ Error: El presupuesto debe ser mayor a 0</div>';
            } else {
                // Porcentajes según tabla de referencia
                $porcentajes = array(
                    'Ginecología' => 40,
                    'Traumatología' => 35,
                    'Pediatría' => 25
                );
                
                // Calcular montos
                $ginecologia = ($presupuesto * $porcentajes['Ginecología']) / 100;
                $traumatologia = ($presupuesto * $porcentajes['Traumatología']) / 100;
                $pediatria = ($presupuesto * $porcentajes['Pediatría']) / 100;
                
                echo '<div class="resultado">';
                echo '<h2>📈 Distribución del Presupuesto</h2>';
                
                // Tabla de resultados
                echo '<div class="tabla-container">';
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Área</th>';
                echo '<th>Porcentaje</th>';
                echo '<th>Monto Asignado</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                echo '<tr>';
                echo '<td>🩺 Ginecología</td>';
                echo '<td>' . $porcentajes['Ginecología'] . '%</td>';
                echo '<td class="moneda">$' . number_format($ginecologia, 2, '.', ',') . '</td>';
                echo '</tr>';
                
                echo '<tr>';
                echo '<td>🔧 Traumatología</td>';
                echo '<td>' . $porcentajes['Traumatología'] . '%</td>';
                echo '<td class="moneda">$' . number_format($traumatologia, 2, '.', ',') . '</td>';
                echo '</tr>';
                
                echo '<tr>';
                echo '<td>👶 Pediatría</td>';
                echo '<td>' . $porcentajes['Pediatría'] . '%</td>';
                echo '<td class="moneda">$' . number_format($pediatria, 2, '.', ',') . '</td>';
                echo '</tr>';
                
                echo '<tr class="total-row">';
                echo '<td><strong>TOTAL</strong></td>';
                echo '<td><strong>100%</strong></td>';
                echo '<td><strong>$' . number_format($presupuesto, 2, '.', ',') . '</strong></td>';
                echo '</tr>';
                
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                
                // Resumen con iconos
                echo '<div class="resumen-container">';
                echo '<h3>Resultados del Presupuesto</h3>';
                
                echo '<div class="resumen-item">';
                echo '<span class="resumen-icono">🩺</span>';
                echo '<span class="resumen-texto">Ginecología (' . $porcentajes['Ginecología'] . '%): <strong>$' . number_format($ginecologia, 2, '.', ',') . '</strong></span>';
                echo '</div>';
                
                echo '<div class="resumen-item">';
                echo '<span class="resumen-icono">🔧</span>';
                echo '<span class="resumen-texto">Traumatología (' . $porcentajes['Traumatología'] . '%): <strong>$' . number_format($traumatologia, 2, '.', ',') . '</strong></span>';
                echo '</div>';
                
                echo '<div class="resumen-item">';
                echo '<span class="resumen-icono">👶</span>';
                echo '<span class="resumen-texto">Pediatría (' . $porcentajes['Pediatría'] . '%): <strong>$' . number_format($pediatria, 2, '.', ',') . '</strong></span>';
                echo '</div>';
                
                echo '</div>';
                
                // Gráfica de pastel (pie chart)
                echo '<div class="grafico-container">';
                echo '<h3>Distribución del presupuesto: $' . number_format($presupuesto, 2, '.', ',') . '</h3>';
                echo '<div class="chart-wrapper">';
                echo '<canvas id="pieChart"></canvas>';
                echo '</div>';
                echo '</div>';
                
                // Script para la gráfica
                $ginecologia_js = number_format($ginecologia, 2, '.', '');
                $traumatologia_js = number_format($traumatologia, 2, '.', '');
                $pediatria_js = number_format($pediatria, 2, '.', '');
                
                echo '<script>';
                echo 'const ctx = document.getElementById("pieChart");';
                echo 'new Chart(ctx, {';
                echo '  type: "pie",';
                echo '  data: {';
                echo '    labels: ["Ginecología (40%)", "Traumatología (35%)", "Pediatría (25%)"],';
                echo '    datasets: [{';
                echo '      data: [40, 35, 25],';
                echo '      backgroundColor: ["#4472C4", "#ED7D31", "#E15759"],';
                echo '      borderWidth: 2,';
                echo '      borderColor: "#fff"';
                echo '    }]';
                echo '  },';
                echo '  options: {';
                echo '    responsive: true,';
                echo '    maintainAspectRatio: true,';
                echo '    plugins: {';
                echo '      legend: {';
                echo '        position: "bottom",';
                echo '        labels: { padding: 15, font: { size: 13 } }';
                echo '      },';
                echo '      tooltip: {';
                echo '        callbacks: {';
                echo '          label: function(context) {';
                echo '            var amounts = [' . $ginecologia_js . ', ' . $traumatologia_js . ', ' . $pediatria_js . '];';
                echo '            return context.label + ": $" + amounts[context.dataIndex].toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");';
                echo '          }';
                echo '        }';
                echo '      }';
                echo '    }';
                echo '  }';
                echo '});';
                echo '</script>';
                
                echo '</div>';
            }
        }
        ?>

        <button class="back-btn" onclick="window.history.back()">← Volver al Menú</button>
    </div>
</body>
</html>