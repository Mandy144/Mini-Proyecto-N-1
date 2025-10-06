<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora Estadística</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📊 Calculadora Estadística de Notas</h1>
            <p style="color: #666;">Análisis completo de calificaciones con estadísticas detalladas</p>
        </div>

        <div class="content">
            <div class="form-section">
                <form method="POST">
                    <div class="form-group">
                        <label for="notas">📝 Ingresa las Notas</label>
                        <textarea 
                            id="notas" 
                            name="notas" 
                            placeholder="Ingresa las notas separadas por comas, espacios o saltos de línea&#10;Ejemplo: 85, 92, 78, 95, 88"
                            required><?php echo isset($_POST['notas']) ? htmlspecialchars($_POST['notas']) : ''; ?></textarea>
                        <div class="hint">💡 Puedes ingresar las notas separadas por comas, espacios o saltos de línea</div>
                    </div>


                    <button type="submit" class="btn">🔍 Calcular Estadísticas</button>
                </form>
            </div>

            <?php
            // Clase para cálculos estadísticos (PSR-1: StudlyCaps)
            class StatisticsCalculator {
                private $notas;
                private $notaAprobatoria;

                public function __construct($notas, $notaAprobatoria = 61) {
                    $this->notas = $notas;
                    $this->notaAprobatoria = $notaAprobatoria;
                }

                // Método estático para calcular promedio usando foreach
                public static function calcularPromedio($notas) {
                    $suma = 0;
                    $cantidad = 0;

                    foreach ($notas as $nota) {
                        $suma += $nota;
                        $cantidad++;
                    }

                    return $cantidad > 0 ? $suma / $cantidad : 0;
                }

                // Método estático para encontrar valor mínimo usando foreach
                public static function encontrarMinima($notas) {
                    $minima = null;

                    foreach ($notas as $nota) {
                        // Usando operador ternario
                        $minima = ($minima === null || $nota < $minima) ? $nota : $minima;
                    }

                    return $minima;
                }

                // Método estático para encontrar valor máximo usando foreach
                public static function encontrarMaxima($notas) {
                    $maxima = null;

                    foreach ($notas as $nota) {
                        // Usando operador ternario
                        $maxima = ($maxima === null || $nota > $maxima) ? $nota : $maxima;
                    }

                    return $maxima;
                }

                // Método estático para calcular desviación estándar usando foreach
                public static function calcularDesviacionEstandar($notas) {
                    $promedio = self::calcularPromedio($notas);
                    $sumaCuadrados = 0;
                    $cantidad = 0;

                    foreach ($notas as $nota) {
                        $diferencia = $nota - $promedio;
                        $sumaCuadrados += $diferencia * $diferencia;
                        $cantidad++;
                    }

                    return $cantidad > 0 ? sqrt($sumaCuadrados / $cantidad) : 0;
                }

                // Método para clasificar notas usando foreach
                public function clasificarNotas() {
                    $aprobados = 0;
                    $reprobados = 0;
                    $notasClasificadas = [];

                    foreach ($this->notas as $index => $nota) {
                        $estado = $nota >= $this->notaAprobatoria ? 'Aprobado' : 'Reprobado';
                        
                        // Usando switch para incrementar contadores
                        switch ($estado) {
                            case 'Aprobado':
                                $aprobados++;
                                break;
                            case 'Reprobado':
                                $reprobados++;
                                break;
                        }

                        $notasClasificadas[] = [
                            'numero' => $index + 1,
                            'nota' => $nota,
                            'estado' => $estado
                        ];
                    }

                    return [
                        'clasificadas' => $notasClasificadas,
                        'aprobados' => $aprobados,
                        'reprobados' => $reprobados
                    ];
                }

                // Método para obtener distribución por rangos usando foreach
                public function obtenerDistribucion() {
                    $rangos = [
                        '0-60' => 0,
                        '61-70' => 0,
                        '71-80' => 0,
                        '81-90' => 0,
                        '91-100' => 0
                    ];

                    foreach ($this->notas as $nota) {
                        // Usando if-elseif para clasificar en rangos
                        if ($nota < 61) {
                            $rangos['0-60']++;
                        } elseif ($nota < 71) {
                            $rangos['61-70']++;
                        } elseif ($nota < 81) {
                            $rangos['71-80']++;
                        } elseif ($nota < 91) {
                            $rangos['81-90']++;
                        } else {
                            $rangos['91-100']++;
                        }
                    }

                    return $rangos;
                }

                // Método para calcular todas las estadísticas
                public function calcularEstadisticas() {
                    $clasificacion = $this->clasificarNotas();
                    $distribucion = $this->obtenerDistribucion();

                    return [
                        'promedio' => self::calcularPromedio($this->notas),
                        'minima' => self::encontrarMinima($this->notas),
                        'maxima' => self::encontrarMaxima($this->notas),
                        'desviacion' => self::calcularDesviacionEstandar($this->notas),
                        'cantidad' => count($this->notas),
                        'aprobados' => $clasificacion['aprobados'],
                        'reprobados' => $clasificacion['reprobados'],
                        'clasificadas' => $clasificacion['clasificadas'],
                        'distribucion' => $distribucion,
                        'porcentajeAprobados' => (count($this->notas) > 0) ? 
                            ($clasificacion['aprobados'] / count($this->notas)) * 100 : 0
                    ];
                }
            }

            // Procesamiento del formulario
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notas'])) {
                // Procesar entrada de notas
                $notasInput = $_POST['notas'];
                $notaAprobatoria = isset($_POST['nota_aprobatoria']) && $_POST['nota_aprobatoria'] !== '' 
                    ? floatval($_POST['nota_aprobatoria']) 
                    : 61;

                // Separar notas por comas, espacios o saltos de línea
                $notasArray = preg_split('/[\s,]+/', trim($notasInput));
                $notasArray = array_filter($notasArray, function($valor) {
                    return $valor !== '';
                });

                // Convertir a números usando array_map
                $notas = array_map('floatval', $notasArray);

                // Validar que haya al menos una nota
                if (count($notas) > 0) {
                    // Crear calculadora y obtener estadísticas
                    $calculadora = new StatisticsCalculator($notas, $notaAprobatoria);
                    $stats = $calculadora->calcularEstadisticas();

                    // Calcular alturas de barras para la gráfica
                    $maxDistribucion = max($stats['distribucion']);
                    ?>

                    <!-- Tarjetas de estadísticas principales -->
                    <div class="stats-grid">
                        <div class="stat-card card-promedio">
                            <h3>📊 Promedio</h3>
                            <div class="value"><?php echo number_format($stats['promedio'], 2); ?></div>
                            <div class="subtitle"><?php echo $stats['cantidad']; ?> notas analizadas</div>
                        </div>

                        <div class="stat-card card-desviacion">
                            <h3>📏 Desviación Estándar</h3>
                            <div class="value"><?php echo number_format($stats['desviacion'], 2); ?></div>
                            <div class="subtitle">Dispersión de datos</div>
                        </div>

                        <div class="stat-card card-minima">
                            <h3>📉 Nota Mínima</h3>
                            <div class="value"><?php echo number_format($stats['minima'], 2); ?></div>
                            <div class="subtitle">Calificación más baja</div>
                        </div>

                        <div class="stat-card card-maxima">
                            <h3>📈 Nota Máxima</h3>
                            <div class="value"><?php echo number_format($stats['maxima'], 2); ?></div>
                            <div class="subtitle">Calificación más alta</div>
                        </div>

                    </div>

                    <!-- Gráfica de distribución -->
                    <div class="chart-section">
                        <h3 class="chart-title">📊 Distribución de Notas por Rangos</h3>
                        <div class="distribution-chart">
                            <?php 
                            $colores = [
                                '0-60' => 'linear-gradient(to top, #f44336, #e57373)',
                                '61-70' => 'linear-gradient(to top, #ff9800, #ffb74d)',
                                '71-80' => 'linear-gradient(to top, #ffc107, #ffd54f)',
                                '81-90' => 'linear-gradient(to top, #8bc34a, #aed581)',
                                '91-100' => 'linear-gradient(to top, #4caf50, #81c784)'
                            ];

                            foreach ($stats['distribucion'] as $rango => $cantidad): 
                                $altura = $maxDistribucion > 0 ? ($cantidad / $maxDistribucion) * 100 : 0;
                            ?>
                                <div class="bar-wrapper">
                                    <div class="bar" style="height: <?php echo $altura; ?>%; min-height: 50px; background: <?php echo $colores[$rango]; ?>;">
                                        <span class="bar-value"><?php echo $cantidad; ?></span>
                                    </div>
                                    <div class="bar-label"><?php echo $rango; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Sección de análisis -->
                    <div class="analysis-section">
                        <div class="analysis-card">
                            <h3>✅ Aprobación</h3>
                            <div class="analysis-item">
                                <span>Aprobados:</span>
                                <strong style="color: #4caf50;"><?php echo $stats['aprobados']; ?></strong>
                            </div>
                            <div class="analysis-item">
                                <span>Reprobados:</span>
                                <strong style="color: #f44336;"><?php echo $stats['reprobados']; ?></strong>
                            </div>
                            <div class="analysis-item">
                                <span>Porcentaje Aprobación:</span>
                                <strong style="color: #667eea;"><?php echo number_format($stats['porcentajeAprobados'], 1); ?>%</strong>
                            </div>
                            <div class="analysis-item">
                                <span>Nota Aprobatoria:</span>
                                <strong><?php echo number_format($notaAprobatoria, 2); ?></strong>
                            </div>
                        </div>

                        <div class="analysis-card">
                            <h3>📐 Análisis Adicional</h3>
                            <div class="analysis-item">
                                <span>Rango:</span>
                                <strong><?php echo number_format($stats['maxima'] - $stats['minima'], 2); ?></strong>
                            </div>
                            <div class="analysis-item">
                                <span>Mediana:</span>
                                <strong>
                                    <?php 
                                    $notasOrdenadas = $notas;
                                    sort($notasOrdenadas);
                                    $mediana = count($notasOrdenadas) % 2 === 0 
                                        ? ($notasOrdenadas[count($notasOrdenadas)/2 - 1] + $notasOrdenadas[count($notasOrdenadas)/2]) / 2
                                        : $notasOrdenadas[floor(count($notasOrdenadas)/2)];
                                    echo number_format($mediana, 2);
                                    ?>
                                </strong>
                            </div>
                            <div class="analysis-item">
                                <span>Suma Total:</span>
                                <strong><?php echo number_format(array_sum($notas), 2); ?></strong>
                            </div>
                            <div class="analysis-item">
                                <span>Coeficiente de Variación:</span>
                                <strong>
                                    <?php 
                                    $cv = $stats['promedio'] > 0 ? ($stats['desviacion'] / $stats['promedio']) * 100 : 0;
                                    echo number_format($cv, 2) . '%';
                                    ?>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de notas clasificadas -->
                    <div class="chart-section" style="margin-top: 30px;">
                        <h3 class="chart-title">📝 Detalle de Todas las Notas</h3>
                        <div class="notes-list">
                            <?php foreach ($stats['clasificadas'] as $nota): ?>
                                <div class="note-item">
                                    <span><strong>Nota #<?php echo $nota['numero']; ?>:</strong> <?php echo number_format($nota['nota'], 2); ?></span>
                                    <span class="note-badge badge-<?php echo strtolower($nota['estado']); ?>">
                                        <?php echo $nota['estado']; ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php
                } else {
                    echo '<div class="alert alert-error">⚠️ Por favor, ingresa al menos una nota válida.</div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>