<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pares e Impares - Problema #4</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Problema #4</h1>
            <p>Suma de Números Pares e Impares</p>
        </div>

        <div class="content">
            <div class="description">
                Se desea calcular independientemente la suma de los números pares e impares comprendidos entre 1 y 200.
            </div>

            <?php
            // Inicializar variables
            $sumaPares = 0;
            $sumaImpares = 0;
            $cantidadPares = 0;
            $cantidadImpares = 0;

            // Calcular sumas del 1 al 200
            for ($i = 1; $i <= 200; $i++) {
                if ($i % 2 == 0) {
                    // Es par
                    $sumaPares += $i;
                    $cantidadPares++;
                } else {
                    // Es impar
                    $sumaImpares += $i;
                    $cantidadImpares++;
                }
            }

            // Calcular total
            $sumaTotal = $sumaPares + $sumaImpares;

            // Calcular altura proporcional para las barras
            $maxSuma = max($sumaPares, $sumaImpares);
            $alturaPares = ($sumaPares / $maxSuma) * 100;
            $alturaImpares = ($sumaImpares / $maxSuma) * 100;

            // Calcular promedios
            $promedioPares = $sumaPares / $cantidadPares;
            $promedioImpares = $sumaImpares / $cantidadImpares;
            ?>

            <!-- Tarjetas de resultados -->
            <div class="results-grid">
                <div class="result-card card-pares">
                    <h2>Números Pares</h2>
                    <div class="number"><?php echo number_format($sumaPares); ?></div>
                    <div class="count"><?php echo $cantidadPares; ?> números</div>
                </div>

                <div class="result-card card-impares">
                    <h2>Números Impares</h2>
                    <div class="number"><?php echo number_format($sumaImpares); ?></div>
                    <div class="count"><?php echo $cantidadImpares; ?> números</div>
                </div>

                <div class="result-card card-total">
                    <h2>Suma Total</h2>
                    <div class="number"><?php echo number_format($sumaTotal); ?></div>
                    <div class="count">200 números</div>
                </div>
            </div>

            <!-- Gráfica de comparación -->
            <div class="chart-section">
                <h3 class="chart-title">Comparación Visual</h3>
                <div class="comparison-chart">
                    <div class="bar-container">
                        <div class="bar bar-pares" style="height: <?php echo $alturaPares; ?>%;">
                            <span class="bar-value"><?php echo number_format($sumaPares); ?></span>
                        </div>
                        <div class="bar-label">Pares</div>
                    </div>

                    <div class="bar-container">
                        <div class="bar bar-impares" style="height: <?php echo $alturaImpares; ?>%;">
                            <span class="bar-value"><?php echo number_format($sumaImpares); ?></span>
                        </div>
                        <div class="bar-label">Impares</div>
                    </div>
                </div>
            </div>

            <!-- Detalles por categoría -->
            <div class="details-section">
                <div class="detail-card pares">
                    <h3>Detalles de Números Pares</h3>
                    <div class="detail-info">
                        <p><strong>Cantidad:</strong> <?php echo $cantidadPares; ?> números</p>
                        <p><strong>Suma total:</strong> <?php echo number_format($sumaPares); ?></p>
                        <p><strong>Promedio:</strong> <?php echo number_format($promedioPares, 2); ?></p>
                        <p><strong>Rango:</strong> 2, 4, 6, 8, ... 200</p>
                        <p><strong>Fórmula:</strong> n % 2 == 0</p>
                    </div>
                </div>

                <div class="detail-card impares">
                    <h3>Detalles de Números Impares</h3>
                    <div class="detail-info">
                        <p><strong>Cantidad:</strong> <?php echo $cantidadImpares; ?> números</p>
                        <p><strong>Suma total:</strong> <?php echo number_format($sumaImpares); ?></p>
                        <p><strong>Promedio:</strong> <?php echo number_format($promedioImpares, 2); ?></p>
                        <p><strong>Rango:</strong> 1, 3, 5, 7, ... 199</p>
                        <p><strong>Fórmula:</strong> n % 2 != 0</p>
                    </div>
                </div>
            </div>

            <button class="back-btn" onclick="window.history.back()">← Volver al Menú</button>
        </div>
    </div>
</body>
</html>