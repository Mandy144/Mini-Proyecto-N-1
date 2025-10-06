<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Proyecto N°2 - Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #c8d9e6;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Efectos de fondo animados */
        body::before {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite reverse;
            z-index: 0;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(30px, 30px);
            }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Header glassmorphism */
        .header-glass {
            background: #567c8d;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 50px 40px;
            margin-bottom: 50px;
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.2);
            text-align: center;
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header-glass h1 {
            color: white;
            font-size: 3em;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
            letter-spacing: -1px;
        }

        .header-glass .subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.3em;
            font-weight: 400;
        }

        .header-glass .divider {
            width: 100px;
            height: 4px;
            background: white;
            margin: 25px auto;
            border-radius: 2px;
            opacity: 0.7;
        }

        /* Grid moderno */
        .problems-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        /* Cards con efecto hover avanzado */
        .problem-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 35px;
            text-decoration: none;
            color: #1F2937;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .problem-card:nth-child(1) { animation-delay: 0.1s; }
        .problem-card:nth-child(2) { animation-delay: 0.15s; }
        .problem-card:nth-child(3) { animation-delay: 0.2s; }
        .problem-card:nth-child(4) { animation-delay: 0.25s; }
        .problem-card:nth-child(5) { animation-delay: 0.3s; }
        .problem-card:nth-child(6) { animation-delay: 0.35s; }
        .problem-card:nth-child(7) { animation-delay: 0.4s; }
        .problem-card:nth-child(8) { animation-delay: 0.45s; }
        .problem-card:nth-child(9) { animation-delay: 0.5s; }
        .problem-card:nth-child(10) { animation-delay: 0.55s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .problem-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: #3B82F6;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .problem-card:hover::before {
            transform: scaleX(1);
        }

        .problem-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(59, 130, 246, 0.3);
        }

        .problem-icon {
            width: 70px;
            height: 70px;
            background: #60A5FA;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            margin-bottom: 20px;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(96, 165, 250, 0.3);
        }

        .problem-card:hover .problem-icon {
            transform: rotate(10deg) scale(1.1);
            box-shadow: 0 8px 25px rgba(96, 165, 250, 0.5);
        }

        .problem-number {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 3em;
            font-weight: 900;
            color: rgba(59, 130, 246, 0.1);
            transition: all 0.4s ease;
        }

        .problem-card:hover .problem-number {
            color: rgba(59, 130, 246, 0.2);
            transform: scale(1.1);
        }

        .problem-title {
            font-size: 1.3em;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 12px;
            transition: color 0.3s ease;
        }

        .problem-card:hover .problem-title {
            color: #3B82F6;
        }

        .problem-description {
            font-size: 0.95em;
            color: #6B7280;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .problem-badge {
            display: inline-block;
            padding: 6px 14px;
            background: #DBEAFE;
            color: #1E40AF;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            margin-top: auto;
        }

        /* Footer moderno */
        .footer-glass {
            background: #567c8d;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.2);
            color: white;
        }

        .footer-glass .footer-title {
            font-size: 1.2em;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .footer-glass .footer-text {
            font-size: 0.95em;
            opacity: 0.9;
            margin: 5px 0;
        }

        .footer-glass .footer-year {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.9em;
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-glass h1 {
                font-size: 2em;
            }

            .header-glass .subtitle {
                font-size: 1.1em;
            }

            .problems-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .problem-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-glass">
            <h1>Mini Proyecto N°2</h1>
            <div class="divider"></div>
            <p class="subtitle">Sentencias de Control y POO en PHP</p>
        </div>

        <div class="problems-grid">
            <a href="problema1.php" class="problem-card">
                <div class="problem-icon">📊</div>
                <div class="problem-number">01</div>
                <h3 class="problem-title">Estadísticos Básicos</h3>
                <p class="problem-description">Calcula media, desviación estándar, mínimo y máximo de 5 números.</p>
                <span class="problem-badge">Matemáticas</span>
            </a>

            <a href="problema2.php" class="problem-card">
                <div class="problem-icon">➕</div>
                <div class="problem-number">02</div>
                <h3 class="problem-title">Suma 1 al 1000</h3>
                <p class="problem-description">Implementa diferentes métodos para sumar números del 1 al 1000.</p>
                <span class="problem-badge">Algoritmos</span>
            </a>

            <a href="problema3.php" class="problem-card">
                <div class="problem-icon">✖️</div>
                <div class="problem-number">03</div>
                <h3 class="problem-title">Múltiplos de 4</h3>
                <p class="problem-description">Genera y analiza múltiplos de 4 con estadísticas completas.</p>
                <span class="problem-badge">Ciclos</span>
            </a>

            <a href="problema4.php" class="problem-card">
                <div class="problem-icon">🔢</div>
                <div class="problem-number">04</div>
                <h3 class="problem-title">Pares e Impares</h3>
                <p class="problem-description">Clasifica y analiza números pares e impares del 1 al 100.</p>
                <span class="problem-badge">Clasificación</span>
            </a>

            <a href="problema5.php" class="problem-card">
                <div class="problem-icon">👥</div>
                <div class="problem-number">05</div>
                <h3 class="problem-title">Clasificación por Edad</h3>
                <p class="problem-description">Clasifica personas según su edad en diferentes categorías.</p>
                <span class="problem-badge">Condicionales</span>
            </a>

            <a href="problema6.php" class="problem-card">
                <div class="problem-icon">🏥</div>
                <div class="problem-number">06</div>
                <h3 class="problem-title">Presupuesto Hospital</h3>
                <p class="problem-description">Distribuye el presupuesto hospitalario entre 3 áreas principales.</p>
                <span class="problem-badge">Financiero</span>
            </a>

            <a href="problema7.php" class="problem-card">
                <div class="problem-icon">🎓</div>
                <div class="problem-number">07</div>
                <h3 class="problem-title">Calculadora de Notas</h3>
                <p class="problem-description">Analiza calificaciones con estadísticas y distribución.</p>
                <span class="problem-badge">Educación</span>
            </a>

            <a href="problema8.php" class="problem-card">
                <div class="problem-icon">🍂</div>
                <div class="problem-number">08</div>
                <h3 class="problem-title">Estación del Año</h3>
                <p class="problem-description">Determina la estación según la fecha ingresada.</p>
                <span class="problem-badge">Fechas</span>
            </a>

            <a href="problema9.php" class="problem-card">
                <div class="problem-icon">⚡</div>
                <div class="problem-number">09</div>
                <h3 class="problem-title">Potencias</h3>
                <p class="problem-description">Genera tabla de potencias de un número hasta el exponente 5.</p>
                <span class="problem-badge">Matemáticas</span>
            </a>

            <a href="problema10.php" class="problem-card">
                <div class="problem-icon">💰</div>
                <div class="problem-number">10</div>
                <h3 class="problem-title">Sistema de Ventas</h3>
                <p class="problem-description">Administra ventas de 3 vendedores con 4 productos diferentes.</p>
                <span class="problem-badge">Comercial</span>
            </a>
        </div>

        <?php include 'footer.php'; ?>
    </div>
</body>
</html>