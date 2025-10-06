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
     * Valida que un número sea positivo
     *
     * @param float $numero
     * @return bool
     */
    public static function esPositivo($numero): bool
    {
        return self::esNumerico($numero) && $numero > 0;
    }
    
    /**
     * Valida que un arreglo tenga una cantidad específica de elementos
     *
     * @param array $arreglo
     * @param int $cantidad
     * @return bool
     */
    public static function validarCantidadElementos(array $arreglo, int $cantidad): bool
    {
        return count($arreglo) === $cantidad;
    }
    
    /**
     * Valida que todos los elementos de un arreglo sean numéricos
     *
     * @param array $arreglo
     * @return bool
     */
    public static function validarArregloNumerico(array $arreglo): bool
    {
        foreach ($arreglo as $elemento) {
            if (!self::esNumerico($elemento)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Valida que todos los números sean positivos
     *
     * @param array $numeros
     * @return bool
     */
    public static function validarNumerosPositivos(array $numeros): bool
    {
        foreach ($numeros as $numero) {
            if (!self::esPositivo($numero)) {
                return false;
            }
        }
        return true;
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
     * Formatea un número con decimales
     *
     * @param float $numero
     * @param int $decimales
     * @return string
     */
    public static function formatearNumero(float $numero, int $decimales = 2): string
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
}

/**
 * Clase para calcular estadísticos básicos
 */
class EstadisticosBasicos
{
    /**
     * Calcula la media aritmética
     *
     * @param array $numeros
     * @return float
     */
    public static function calcularMedia(array $numeros): float
    {
        $suma = 0;
        $cantidad = count($numeros);
        
        foreach ($numeros as $numero) {
            $suma += $numero;
        }
        
        return $cantidad > 0 ? $suma / $cantidad : 0;
    }
    
    /**
     * Calcula la desviación estándar
     *
     * @param array $numeros
     * @return float
     */
    public static function calcularDesviacionEstandar(array $numeros): float
    {
        $media = self::calcularMedia($numeros);
        $sumaCuadrados = 0;
        $cantidad = count($numeros);
        
        foreach ($numeros as $numero) {
            $sumaCuadrados += pow($numero - $media, 2);
        }
        
        return $cantidad > 0 ? sqrt($sumaCuadrados / $cantidad) : 0;
    }
    
    /**
     * Encuentra el valor mínimo
     *
     * @param array $numeros
     * @return float|null
     */
    public static function encontrarMinimo(array $numeros): ?float
    {
        if (empty($numeros)) {
            return null;
        }
        
        $minimo = $numeros[0];
        
        for ($i = 1; $i < count($numeros); $i++) {
            $minimo = $numeros[$i] < $minimo ? $numeros[$i] : $minimo;
        }
        
        return $minimo;
    }
    
    /**
     * Encuentra el valor máximo
     *
     * @param array $numeros
     * @return float|null
     */
    public static function encontrarMaximo(array $numeros): ?float
    {
        if (empty($numeros)) {
            return null;
        }
        
        $maximo = $numeros[0];
        
        for ($i = 1; $i < count($numeros); $i++) {
            $maximo = $numeros[$i] > $maximo ? $numeros[$i] : $maximo;
        }
        
        return $maximo;
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
                   padding: 20px; margin-top: 40px;'>
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numeros = [];
    
    // Recopilar y validar los 5 números
    for ($i = 1; $i <= 5; $i++) {
        $numero = $_POST["numero{$i}"] ?? '';
        $numero = Validador::limpiarEntrada($numero);
        
        if (empty($numero)) {
            $errores[] = "El número {$i} es requerido.";
        } elseif (!Validador::esNumerico($numero)) {
            $errores[] = "El número {$i} debe ser numérico.";
        } elseif (!Validador::esPositivo($numero)) {
            $errores[] = "El número {$i} debe ser positivo (mayor que 0).";
        } else {
            $numeros[] = floatval($numero);
        }
    }
    
    // Si no hay errores, calcular estadísticos
    if (empty($errores) && count($numeros) === 5) {
        $resultados = [
            'numeros' => $numeros,
            'media' => EstadisticosBasicos::calcularMedia($numeros),
            'desviacionEstandar' => EstadisticosBasicos::calcularDesviacionEstandar($numeros),
            'minimo' => EstadisticosBasicos::encontrarMinimo($numeros),
            'maximo' => EstadisticosBasicos::encontrarMaximo($numeros)
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema 1 - Estadísticos Básicos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>📊 Problema 1: Estadísticos Básicos</h1>
        <p class="descripcion">
            Ingresa 5 números positivos para calcular su <strong>media aritmética</strong>, 
            <strong>desviación estándar</strong>, <strong>valor mínimo</strong> y <strong>valor máximo</strong>.
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
            <div class="form-grid">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="form-group">
                        <label for="numero<?php echo $i; ?>">
                            Número <?php echo $i; ?>:
                        </label>
                        <input 
                            type="number" 
                            id="numero<?php echo $i; ?>" 
                            name="numero<?php echo $i; ?>" 
                            placeholder="Ej: <?php echo rand(10, 100); ?>"
                            value="<?php echo isset($_POST["numero{$i}"]) ? htmlspecialchars($_POST["numero{$i}"]) : ''; ?>"
                            required
                        >
                    </div>
                <?php endfor; ?>
            </div>
            
            <button type="submit">🔍 Calcular Estadísticos</button>
        </form>
        
        <?php if ($resultados !== null): ?>
            <div class="resultados">
                <h2>✨ Resultados Calculados</h2>
                
                <div class="resultado-item">
                    <span class="resultado-label">📝 Números ingresados:</span>
                    <div>
                        <?php foreach ($resultados['numeros'] as $num): ?>
                            <span class="numeros-badge"><?php echo $num; ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="resultado-item">
                    <span class="resultado-label">📊 Media Aritmética:</span>
                    <span class="resultado-valor"><?php echo Utilidades::formatearNumero($resultados['media']); ?></span>
                </div>
                
                <div class="resultado-item">
                    <span class="resultado-label">📈 Desviación Estándar:</span>
                    <span class="resultado-valor"><?php echo Utilidades::formatearNumero($resultados['desviacionEstandar']); ?></span>
                </div>
                
                <div class="resultado-item">
                    <span class="resultado-label">⬇️ Valor Mínimo:</span>
                    <span class="resultado-valor"><?php echo Utilidades::formatearNumero($resultados['minimo']); ?></span>
                </div>
                
                <div class="resultado-item">
                    <span class="resultado-label">⬆️ Valor Máximo:</span>
                    <span class="resultado-valor"><?php echo Utilidades::formatearNumero($resultados['maximo']); ?></span>
                </div>
                
                <?php echo Utilidades::generarMensajeExito('Cálculos realizados correctamente'); ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php echo generarFooter(); ?>
</body>
</html>