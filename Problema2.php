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
    
    /**
     * Calcula el tiempo de ejecución en milisegundos
     *
     * @param float $inicio
     * @param float $fin
     * @return string
     */
    public static function calcularTiempoEjecucion(float $inicio, float $fin): string
    {
        $tiempo = ($fin - $inicio) * 1000;
        return number_format($tiempo, 4);
    }
}

/**
 * Clase para operaciones de suma
 */
class CalculadoraSuma
{
    /**
     * Calcula la suma de números del 1 al N usando ciclo for
     *
     * @param int $limite
     * @return array
     */
    public static function sumaConFor(int $limite): array
    {
        $inicio = microtime(true);
        $suma = 0;
        
        for ($i = 1; $i <= $limite; $i++) {
            $suma += $i;
        }
        
        $fin = microtime(true);
        
        return [
            'metodo' => 'Ciclo FOR',
            'resultado' => $suma,
            'tiempo' => Utilidades::calcularTiempoEjecucion($inicio, $fin)
        ];
    }
    
    /**
     * Calcula la suma de números del 1 al N usando ciclo while
     *
     * @param int $limite
     * @return array
     */
    public static function sumaConWhile(int $limite): array
    {
        $inicio = microtime(true);
        $suma = 0;
        $i = 1;
        
        while ($i <= $limite) {
            $suma += $i;
            $i++;
        }
        
        $fin = microtime(true);
        
        return [
            'metodo' => 'Ciclo WHILE',
            'resultado' => $suma,
            'tiempo' => Utilidades::calcularTiempoEjecucion($inicio, $fin)
        ];
    }
    
    /**
     * Calcula la suma usando la fórmula de Gauss: n(n+1)/2
     *
     * @param int $limite
     * @return array
     */
    public static function sumaConFormula(int $limite): array
    {
        $inicio = microtime(true);
        
        $suma = ($limite * ($limite + 1)) / 2;
        
        $fin = microtime(true);
        
        return [
            'metodo' => 'Fórmula de Gauss',
            'resultado' => $suma,
            'tiempo' => Utilidades::calcularTiempoEjecucion($inicio, $fin)
        ];
    }
    
    /**
     * Calcula la suma usando range y array_sum
     *
     * @param int $limite
     * @return array
     */
    public static function sumaConArray(int $limite): array
    {
        $inicio = microtime(true);
        
        $numeros = range(1, $limite);
        $suma = array_sum($numeros);
        
        $fin = microtime(true);
        
        return [
            'metodo' => 'Array Functions',
            'resultado' => $suma,
            'tiempo' => Utilidades::calcularTiempoEjecucion($inicio, $fin)
        ];
    }
    
    /**
     * Calcula todos los métodos y los compara
     *
     * @param int $limite
     * @return array
     */
    public static function calcularTodosLosMetodos(int $limite): array
    {
        $resultados = [
            self::sumaConFor($limite),
            self::sumaConWhile($limite),
            self::sumaConFormula($limite),
            self::sumaConArray($limite)
        ];
        
        // Encontrar el método más rápido usando operador ternario
        $tiempoMinimo = $resultados[0]['tiempo'];
        $metodoMasRapido = $resultados[0]['metodo'];
        
        foreach ($resultados as $resultado) {
            $tiempoMinimo = $resultado['tiempo'] < $tiempoMinimo ? $resultado['tiempo'] : $tiempoMinimo;
            $metodoMasRapido = $resultado['tiempo'] == $tiempoMinimo ? $resultado['metodo'] : $metodoMasRapido;
        }
        
        return [
            'resultados' => $resultados,
            'metodoMasRapido' => $metodoMasRapido,
            'tiempoMinimo' => $tiempoMinimo
        ];
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
$limite = 1000; // Valor por defecto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $limiteInput = $_POST['limite'] ?? '';
    $limiteInput = Validador::limpiarEntrada($limiteInput);
    
    // Validaciones
    if (empty($limiteInput)) {
        $errores[] = "El límite es requerido.";
    } elseif (!Validador::esNumerico($limiteInput)) {
        $errores[] = "El límite debe ser un número válido.";
    } elseif (!Validador::esEnteroPositivo($limiteInput)) {
        $errores[] = "El límite debe ser un número entero positivo.";
    } elseif (!Validador::validarRango($limiteInput, 1, 1000000)) {
        $errores[] = "El límite debe estar entre 1 y 1,000,000.";
    } else {
        $limite = intval($limiteInput);
        $resultados = CalculadoraSuma::calcularTodosLosMetodos($limite);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema 2 - Suma del 1 al 1000</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>🔢 Problema 2: Suma del 1 al 1000</h1>
        <p class="descripcion">
            Calcula la suma de todos los números del 1 al 1000. 
            Compara diferentes métodos de cálculo y sus tiempos de ejecución.
        </p>
        
       
        
        <?php
        // Mostrar errores si existen
        if (!empty($errores)) {
            foreach ($errores as $error) {
                echo Utilidades::generarMensajeError($error);
            }
        }
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="limite">
                    Límite Superior (1 - 1,000,000):
                </label>
                <input 
                    type="number" 
                    id="limite" 
                    name="limite" 
                    min="1"
                    max="1000"
                    value="<?php echo isset($_POST['limite']) ? htmlspecialchars($_POST['limite']) : '1000'; ?>"
                    placeholder="ej: 1000"
                    required
                >
            </div>
            
            <button type="submit">⚡ Calcular Suma con Todos los Métodos</button>
        </form>
        
        <?php if ($resultados !== null): ?>
            <div class="resultados">
                <h2>✨ Resultados de Cálculo</h2>
                
                <?php echo Utilidades::generarMensajeInfo("Calculando suma de 1 hasta {$limite}"); ?>
                
                <?php foreach ($resultados['resultados'] as $resultado): ?>
                    <div class="metodo-card">
                        <div class="metodo-titulo">
                            🔧 <?php echo $resultado['metodo']; ?>
                            <?php if ($resultado['metodo'] === $resultados['metodoMasRapido']): ?>
                                <span class="badge-rapido">⚡ MÁS RÁPIDO</span>
                            <?php endif; ?>
                        </div>
                        <div class="metodo-resultado">
                            <span class="metodo-label">Resultado:</span>
                            <span class="metodo-valor"><?php echo Utilidades::formatearNumero($resultado['resultado']); ?></span>
                        </div>
                        <div class="metodo-resultado">
                            <span class="metodo-label">Tiempo de ejecución:</span>
                            <span class="metodo-valor"><?php echo $resultado['tiempo']; ?> ms</span>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="resultado-final">
                    <div>✅ Resultado Final</div>
                    <div class="numero"><?php echo Utilidades::formatearNumero($resultados['resultados'][0]['resultado']); ?></div>
                    <div style="font-size: 0.8em; margin-top: 10px;">
                        Método más eficiente: <strong><?php echo $resultados['metodoMasRapido']; ?></strong>
                        (<?php echo $resultados['tiempoMinimo']; ?> ms)
                    </div>
                </div>
                
                <?php 
                $esperado = 500500;
                $calculado = $resultados['resultados'][0]['resultado'];
                $esCorrecto = ($limite === 1000 && $calculado === $esperado);
                
                if ($esCorrecto):
                    echo Utilidades::generarMensajeExito('¡Verificación exitosa! El resultado para 1-1000 es correcto: 500,500');
                endif;
                ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php echo generarFooter(); ?>
</body>
</html>