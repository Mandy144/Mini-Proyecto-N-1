<?php
// ============================================
// utilidades.php - Clases de utilidades
// ============================================

/**
 * Clase para validación de datos
 */
class Validador
{
    /**
     * Valida que un valor sea numérico
     *
     * @param mixed $valor
     * @return bool
     */
    public static function esNumerico($valor): bool
    {
        return is_numeric($valor);
    }
    
    /**
     * Valida que un número sea entero positivo
     *
     * @param mixed $numero
     * @return bool
     */
    public static function esEnteroPositivo($numero): bool
    {
        return self::esNumerico($numero) && $numero > 0 && floor($numero) == $numero;
    }
    
    /**
     * Valida que un número esté en un rango específico
     *
     * @param float $numero
     * @param float $min
     * @param float $max
     * @return bool
     */
    public static function validarRango($numero, $min, $max): bool
    {
        return $numero >= $min && $numero <= $max;
    }
    
    /**
     * Limpia y valida entrada de formulario
     *
     * @param string $dato
     * @return string
     */
    public static function limpiarEntrada(string $dato): string
    {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato);
        return $dato;
    }
}

/**
 * Clase para utilidades generales
 */
class Utilidades
{
    /**
     * Formatea un número con separadores de miles
     *
     * @param float $numero
     * @param int $decimales
     * @return string
     */
    public static function formatearNumero(float $numero, int $decimales = 0): string
    {
        return number_format($numero, $decimales, '.', ',');
    }
    
    /**
     * Genera un mensaje de error estilizado
     *
     * @param string $mensaje
     * @return string
     */
    public static function generarMensajeError(string $mensaje): string
    {
        return '<div style="background: #fee; border-left: 4px solid #c33; 
                padding: 15px; margin: 20px 0; border-radius: 5px; color: #c33;">
                    <strong>⚠️ Error:</strong> ' . $mensaje . '
                </div>';
    }
    
    /**
     * Genera un mensaje de éxito estilizado
     *
     * @param string $mensaje
     * @return string
     */
    public static function generarMensajeExito(string $mensaje): string
    {
        return '<div style="background: #efe; border-left: 4px solid #3c3; 
                padding: 15px; margin: 20px 0; border-radius: 5px; color: #3c3;">
                    <strong>✅ Éxito:</strong> ' . $mensaje . '
                </div>';
    }
    
    /**
     * Genera un mensaje de información estilizado
     *
     * @param string $mensaje
     * @return string
     */
    public static function generarMensajeInfo(string $mensaje): string
    {
        return '<div style="background: #e3f2fd; border-left: 4px solid #2196f3; 
                padding: 15px; margin: 20px 0; border-radius: 5px; color: #1976d2;">
                    <strong>ℹ️ Información:</strong> ' . $mensaje . '
                </div>';
    }
}

/**
 * Clase para calcular múltiplos
 */
class CalculadorMultiplos
{
    /**
     * Genera múltiplos de un número usando ciclo for
     *
     * @param int $cantidad
     * @param int $base
     * @return array
     */
    public static function generarMultiplosConFor(int $cantidad, int $base = 4): array
    {
        $multiplos = [];
        
        for ($i = 1; $i <= $cantidad; $i++) {
            $multiplos[] = $base * $i;
        }
        
        return $multiplos;
    }
    
    /**
     * Genera múltiplos de un número usando ciclo while
     *
     * @param int $cantidad
     * @param int $base
     * @return array
     */
    public static function generarMultiplosConWhile(int $cantidad, int $base = 4): array
    {
        $multiplos = [];
        $i = 1;
        
        while ($i <= $cantidad) {
            $multiplos[] = $base * $i;
            $i++;
        }
        
        return $multiplos;
    }
    
    /**
     * Genera múltiplos usando range y array_map
     *
     * @param int $cantidad
     * @param int $base
     * @return array
     */
    public static function generarMultiplosConArray(int $cantidad, int $base = 4): array
    {
        $indices = range(1, $cantidad);
        return array_map(function($i) use ($base) {
            return $base * $i;
        }, $indices);
    }
    
    /**
     * Calcula estadísticas de los múltiplos
     *
     * @param array $multiplos
     * @return array
     */
    public static function calcularEstadisticas(array $multiplos): array
    {
        $suma = 0;
        $cantidad = count($multiplos);
        
        foreach ($multiplos as $multiplo) {
            $suma += $multiplo;
        }
        
        $promedio = $cantidad > 0 ? $suma / $cantidad : 0;
        $minimo = !empty($multiplos) ? $multiplos[0] : 0;
        $maximo = !empty($multiplos) ? $multiplos[$cantidad - 1] : 0;
        
        return [
            'suma' => $suma,
            'promedio' => $promedio,
            'minimo' => $minimo,
            'maximo' => $maximo,
            'cantidad' => $cantidad
        ];
    }
    
    /**
     * Verifica si un número es múltiplo de otro
     *
     * @param int $numero
     * @param int $base
     * @return bool
     */
    public static function esMultiplo(int $numero, int $base): bool
    {
        return $numero % $base === 0;
    }
    
    /**
     * Agrupa múltiplos por rangos
     *
     * @param array $multiplos
     * @param int $tamanoRango
     * @return array
     */
    public static function agruparPorRangos(array $multiplos, int $tamanoRango = 100): array
    {
        $grupos = [];
        
        foreach ($multiplos as $multiplo) {
            $rangoInicio = floor($multiplo / $tamanoRango) * $tamanoRango;
            $rangoFin = $rangoInicio + $tamanoRango - 1;
            $clave = "{$rangoInicio}-{$rangoFin}";
            
            if (!isset($grupos[$clave])) {
                $grupos[$clave] = [];
            }
            
            $grupos[$clave][] = $multiplo;
        }
        
        return $grupos;
    }
}

// ============================================
// Función para generar footer
// ============================================
function generarFooter() {
    $fechaActual = date('d/m/Y H:i:s');
    $anio = date('Y');
    
    return "
    <footer style='background: #2d3748; color: white; text-align: center; 
                   padding: 20px; margin-top: 40px; border-radius: 10px;'>
        <p><strong>Sistema de Problemas PHP</strong></p>
        <p>Fecha actual: {$fechaActual}</p>
        <p>&copy; {$anio} - Todos los derechos reservados</p>
    </footer>";
}

// ============================================
// Procesamiento del formulario
// ============================================

$errores = [];
$resultados = null;
$metodoSeleccionado = 'for';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidadInput = $_POST['cantidad'] ?? '';
    $cantidadInput = Validador::limpiarEntrada($cantidadInput);
    $metodoSeleccionado = $_POST['metodo'] ?? 'for';
    
    // Validaciones
    if (empty($cantidadInput)) {
        $errores[] = "La cantidad es requerida.";
    } elseif (!Validador::esNumerico($cantidadInput)) {
        $errores[] = "La cantidad debe ser un número válido.";
    } elseif (!Validador::esEnteroPositivo($cantidadInput)) {
        $errores[] = "La cantidad debe ser un número entero positivo.";
    } elseif (!Validador::validarRango($cantidadInput, 1, 1000)) {
        $errores[] = "La cantidad debe estar entre 1 y 1,000.";
    } else {
        $cantidad = intval($cantidadInput);
        
        // Generar múltiplos según el método seleccionado
        switch ($metodoSeleccionado) {
            case 'while':
                $multiplos = CalculadorMultiplos::generarMultiplosConWhile($cantidad);
                $metodoNombre = 'Ciclo WHILE';
                break;
            case 'array':
                $multiplos = CalculadorMultiplos::generarMultiplosConArray($cantidad);
                $metodoNombre = 'Funciones de Array';
                break;
            case 'for':
            default:
                $multiplos = CalculadorMultiplos::generarMultiplosConFor($cantidad);
                $metodoNombre = 'Ciclo FOR';
                break;
        }
        
        $estadisticas = CalculadorMultiplos::calcularEstadisticas($multiplos);
        $grupos = CalculadorMultiplos::agruparPorRangos($multiplos);
        
        $resultados = [
            'multiplos' => $multiplos,
            'estadisticas' => $estadisticas,
            'grupos' => $grupos,
            'metodo' => $metodoNombre
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema 3 - Múltiplos de 4</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>🔢 Problema 3: Múltiplos de 4</h1>
        <p class="descripcion">
            Genera e imprime los N primeros múltiplos de 4. Visualiza los resultados, 
            estadísticas y agrupaciones por rangos.
        </p>
        
        <div class="info-box">
            <h3>📐 Fórmula de Múltiplos</h3>
            <div class="formula">Múltiplo(n) = 4 × n</div>
            <p style="margin-top: 10px; font-size: 0.9em;">
                Donde n es la posición del múltiplo (1, 2, 3, ...)
            </p>
        </div>
        
        <?php
        // Mostrar errores si existen
        if (!empty($errores)) {
            foreach ($errores as $error) {
                echo Utilidades::generarMensajeError($error);
            }
        }
        ?>
        
        <form method="POST" action="">
            <div class="form-grid">
                <div class="form-group">
                    <label for="cantidad">
                        Cantidad de Múltiplos (1 - 1,000):
                    </label>
                    <input 
                        type="number" 
                        id="cantidad" 
                        name="cantidad" 
                        min="1"
                        max="1000"
                        value="<?php echo isset($_POST['cantidad']) ? htmlspecialchars($_POST['cantidad']) : '25'; ?>"
                        placeholder="Ej: 25"
                        required
                    >
                </div>
                
                <div class="form-group">
                    <label for="metodo">
                        Método de Cálculo:
                    </label>
                    <select id="metodo" name="metodo">
                        <option value="for" <?php echo $metodoSeleccionado === 'for' ? 'selected' : ''; ?>>Ciclo FOR</option>
                        <option value="while" <?php echo $metodoSeleccionado === 'while' ? 'selected' : ''; ?>>Ciclo WHILE</option>
                        <option value="array" <?php echo $metodoSeleccionado === 'array' ? 'selected' : ''; ?>>Array Functions</option>
                    </select>
                </div>
            </div>
            
            <button type="submit">🚀 Generar Múltiplos de 4</button>
        </form>
        
        <?php if ($resultados !== null): ?>
            <div class="resultados">
                <h2>✨ Resultados Generados</h2>
                
                <div style="text-align: center;">
                    <span class="metodo-badge">Método: <?php echo $resultados['metodo']; ?></span>
                </div>
                
                <?php echo Utilidades::generarMensajeInfo("Se generaron {$resultados['estadisticas']['cantidad']} múltiplos de 4"); ?>
                
                <div class="estadisticas-grid">
                    <div class="stat-card">
                        <div class="stat-label">🔢 Total de Múltiplos</div>
                        <div class="stat-valor"><?php echo $resultados['estadisticas']['cantidad']; ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-label">➕ Suma Total</div>
                        <div class="stat-valor"><?php echo Utilidades::formatearNumero($resultados['estadisticas']['suma']); ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-label">📊 Promedio</div>
                        <div class="stat-valor"><?php echo Utilidades::formatearNumero($resultados['estadisticas']['promedio'], 2); ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-label">⬇️ Mínimo</div>
                        <div class="stat-valor"><?php echo $resultados['estadisticas']['minimo']; ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-label">⬆️ Máximo</div>
                        <div class="stat-valor"><?php echo $resultados['estadisticas']['maximo']; ?></div>
                    </div>
                </div>
                
                <div class="multiplos-container">
                    <h3 style="color: #667eea; margin-bottom: 15px;">
                        📋 Listado de Múltiplos
                    </h3>
                    <div class="multiplos-grid">
                        <?php 
                        // Mostrar máximo 100 múltiplos en la vista para evitar sobrecarga
                        $multiplosAMostrar = count($resultados['multiplos']) > 100 
                            ? array_slice($resultados['multiplos'], 0, 100) 
                            : $resultados['multiplos'];
                        
                        foreach ($multiplosAMostrar as $multiplo): 
                        ?>
                            <div class="multiplo-item"><?php echo $multiplo; ?></div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (count($resultados['multiplos']) > 100): ?>
                        <p style="text-align: center; margin-top: 15px; color: #666;">
                            ... y <?php echo count($resultados['multiplos']) - 100; ?> múltiplos más
                        </p>
                    <?php endif; ?>
                </div>
                
                <?php if (count($resultados['grupos']) > 1): ?>
                <div class="grupos-container">
                    <h3 style="color: #667eea; margin-bottom: 15px;">
                        📊 Agrupación por Rangos
                    </h3>
                    <?php foreach ($resultados['grupos'] as $rango => $multiplosGrupo): ?>
                        <div class="grupo-item">
                            <div class="grupo-titulo">Rango: <?php echo $rango; ?></div>
                            <div class="grupo-numeros">
                                <strong>Cantidad:</strong> <?php echo count($multiplosGrupo); ?> múltiplos<br>
                                <strong>Números:</strong> <?php echo implode(', ', $multiplosGrupo); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <?php echo Utilidades::generarMensajeExito('Múltiplos generados exitosamente'); ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php echo generarFooter(); ?>
</body>
</html>