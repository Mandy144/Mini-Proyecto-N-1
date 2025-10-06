<?php
/**
 * Footer del proyecto - Mini Proyecto #2
 * Universidad Tecnológica de Panamá
 */

// Obtener la fecha actual en español
$meses = [
    1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
    5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
    9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
];

$dia = date('d');
$mes = $meses[(int)date('m')];
$anio = date('Y');
$fechaActual = "$dia de $mes de $anio";
?>

<div class="footer-glass">
    <div class="footer-title">Universidad Tecnológica de Panamá</div>
    <p class="footer-text"><strong>Facultad de Ingeniería en Sistemas Computacionales</strong></p>
    <p class="footer-text">Campus Victor Levis Sasso</p>
    <p class="footer-text" style="margin-top: 15px;"><strong>Curso:</strong> Ingeniería Web | <strong>Instructor:</strong> Ing. Irina Fong</p>
    
    <div style="margin-top: 15px;">
        <p class="footer-text"><strong>Integrantes del Grupo:</strong></p>
        <p class="footer-text">Estudiante N°1: Felix, Eimy - eimy.felix@utp.ac.pa</p>
        <p class="footer-text">Estudiante N°2: Green, Amanda - amanda.green@utp.ac.pa</p>
    </div>
    
    <div class="footer-year">
        Fecha de ejecución: <?php echo htmlspecialchars($fechaActual); ?><br>
        Mini Proyecto #2 - Sentencias de Control y Clases | © <?php echo $anio; ?>
    </div>
</div>