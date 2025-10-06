<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificación por Edad</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📊 Sistema de Clasificación de Edades</h1>
            <p>Ingresa 5 edades para analizar</p>
        </div>

        <div class="content">
            <form method="POST">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="form-group">
                        <label for="edad<?php echo $i; ?>">Edad <?php echo $i; ?>:</label>
                        <input type="number" id="edad<?php echo $i; ?>" name="edades[]" 
                               min="0" max="120" required 
                               value="<?php echo isset($_POST['edades'][$i-1]) ? htmlspecialchars($_POST['edades'][$i-1]) : ''; ?>">
                    </div>
                <?php endfor; ?>
                
                <button type="submit" class="btn">Analizar Edades</button>
            </form>

            <?php
            // Clase para clasificación de edades (PSR-1: StudlyCaps para clases)
            class AgeClassifier {
                // Método estático para clasificar edad
                public static function clasificarEdad($edad) {
                    // Usando switch-case
                    switch (true) {
                        case ($edad >= 0 && $edad <= 12):
                            return 'Niño';
                        case ($edad >= 13 && $edad <= 17):
                            return 'Adolescente';
                        case ($edad >= 18 && $edad <= 59):
                            return 'Adulto';
                        case ($edad >= 60):
                            return 'Adulto Mayor';
                        default:
                            return 'Edad inválida';
                    }
                }

                // Método estático para obtener clase CSS
                public static function obtenerClaseCss($clasificacion) {
                    // Usando operador ternario anidado
                    return $clasificacion === 'Niño' ? 'nino' :
                           ($clasificacion === 'Adolescente' ? 'adolescente' :
                           ($clasificacion === 'Adulto' ? 'adulto' : 'adulto-mayor'));
                }

                // Método estático para procesar edades
                public static function procesarEdades($edades) {
                    $resultados = [];
                    $estadisticas = [
                        'Niño' => 0,
                        'Adolescente' => 0,
                        'Adulto' => 0,
                        'Adulto Mayor' => 0
                    ];

                    // Usando foreach para iterar
                    foreach ($edades as $edad) {
                        $clasificacion = self::clasificarEdad($edad);
                        $resultados[] = [
                            'edad' => $edad,
                            'clasificacion' => $clasificacion,
                            'clase' => self::obtenerClaseCss($clasificacion)
                        ];
                        $estadisticas[$clasificacion]++;
                    }

                    return [
                        'resultados' => $resultados,
                        'estadisticas' => $estadisticas
                    ];
                }
            }

            // Procesamiento del formulario
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edades'])) {
                $edadesIngresadas = array_map('intval', $_POST['edades']);
                
                // Validación usando ciclo for
                $edadesValidas = true;
                for ($i = 0; $i < count($edadesIngresadas); $i++) {
                    if ($edadesIngresadas[$i] < 0 || $edadesIngresadas[$i] > 120) {
                        $edadesValidas = false;
                        break;
                    }
                }

                if ($edadesValidas) {
                    $datos = AgeClassifier::procesarEdades($edadesIngresadas);
                    $resultados = $datos['resultados'];
                    $estadisticas = $datos['estadisticas'];
                    $maxValor = max($estadisticas);
                    ?>

                    <div class="results">
                        <h2 style="text-align: center; color: #333; margin-bottom: 20px;">📈 Resultados del Análisis</h2>
                        
                        <!-- Estadísticas en tarjetas -->
                        <div class="stats-grid">
                            <?php foreach ($estadisticas as $categoria => $cantidad): ?>
                                <div class="stat-card <?php echo AgeClassifier::obtenerClaseCss($categoria); ?>">
                                    <h3><?php echo $categoria; ?></h3>
                                    <div class="number"><?php echo $cantidad; ?></div>
                                    <p><?php echo $cantidad === 1 ? 'persona' : 'personas'; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Gráfica de barras -->
                        <div class="chart-container">
                            <h3 class="chart-title">Distribución por Categoría</h3>
                            <div class="bar-chart">
                                <?php foreach ($estadisticas as $categoria => $cantidad): ?>
                                    <?php 
                                    // Calcular altura proporcional (usando operador ternario)
                                    $altura = $maxValor > 0 ? ($cantidad / $maxValor) * 100 : 0;
                                    ?>
                                    <div style="display: flex; flex-direction: column; align-items: center; flex: 1;">
                                        <div class="bar" style="height: <?php echo $altura; ?>%; min-height: 40px;">
                                            <span class="bar-value"><?php echo $cantidad; ?></span>
                                        </div>
                                        <div class="bar-label"><?php echo $categoria; ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Lista detallada de edades -->
                        <div class="age-list">
                            <h3 style="margin-bottom: 15px; color: #333;">Detalle de Edades Clasificadas</h3>
                            <?php 
                            // Usando while con contador
                            $contador = 0;
                            while ($contador < count($resultados)): 
                                $resultado = $resultados[$contador];
                            ?>
                                <div class="age-item">
                                    <span><strong>Persona <?php echo $contador + 1; ?>:</strong> <?php echo $resultado['edad']; ?> años</span>
                                    <span class="age-badge badge-<?php echo $resultado['clase']; ?>">
                                        <?php echo $resultado['clasificacion']; ?>
                                    </span>
                                </div>
                            <?php 
                                $contador++;
                            endwhile; 
                            ?>
                        </div>
                    </div>

                    <?php
                } else {
                    echo '<div style="background: #fee; color: #c33; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: center;">
                            ⚠️ Por favor, ingresa edades válidas entre 0 y 120 años.
                          </div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>