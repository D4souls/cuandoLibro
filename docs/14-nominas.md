# 💵 Generación de Nóminas

## Descripción
El sistema de generación automática de nóminas calcula y crea documentos PDF con los recibos de salario mensuales de todos los empleados basándose en las horas trabajadas y fichadas.

## Proceso de Generación

### Automatización Completa

El sistema genera nóminas automáticamente mediante una tarea programada (cron job):

```bash
# Ejecutar el último día del mes a las 23:00
0 23 28-31 * * [ $(date -d tomorrow +\%d) -eq 1 ] && php /path/to/generarNominas.php
```

## Flujo del Sistema

```
┌────────────────────────────────────────────────────────────────────┐
│              PROCESO DE GENERACIÓN DE NÓMINAS                      │
└────────────────────────────────────────────────────────────────────┘

1. FIN DE MES → Tarea programada se activa
   │
   ▼
2. Sistema obtiene lista de empleados activos
   │
   ▼
3. Para cada empleado:
   │
   ├─→ a. Recopilar turnos del mes
   │    ┌────────────────────────────┐
   │    │ Turnos trabajados          │
   │    │ - Fecha                    │
   │    │ - Horas entrada/salida     │
   │    │ - Tipo (normal/nocturno)   │
   │    └────────────────────────────┘
   │
   ├─→ b. Verificar fichajes
   │    ┌────────────────────────────┐
   │    │ Solo turnos completos      │
   │    │ (con entrada Y salida)     │
   │    └────────────────────────────┘
   │
   ├─→ c. Calcular horas trabajadas
   │    ┌────────────────────────────┐
   │    │ Horas normales: 120h       │
   │    │ Horas plus: 20h            │
   │    │ Total: 140h                │
   │    └────────────────────────────┘
   │
   ├─→ d. Obtener tarifas
   │    ┌────────────────────────────┐
   │    │ Sueldo normal: 15€/h       │
   │    │ Sueldo plus: 25€/h         │
   │    └────────────────────────────┘
   │
   ├─→ e. Calcular devengos
   │    ┌────────────────────────────┐
   │    │ 120h × 15€ = 1,800€        │
   │    │ 20h × 25€ = 500€           │
   │    │ TOTAL: 2,300€              │
   │    └────────────────────────────┘
   │
   ├─→ f. Calcular deducciones
   │    ┌────────────────────────────┐
   │    │ IRPF (15%): 345€           │
   │    │ Seg. Social: 146€          │
   │    │ TOTAL: 491€                │
   │    └────────────────────────────┘
   │
   ├─→ g. Generar PDF
   │    ┌────────────────────────────┐
   │    │ DOMPDF                     │
   │    │ HTML → PDF                 │
   │    └────────────────────────────┘
   │
   ├─→ h. Guardar archivo
   │    ┌────────────────────────────┐
   │    │ /userFiles/DNI/nominas/    │
   │    │ nomina_DNI_Mes_Año.pdf     │
   │    └────────────────────────────┘
   │
   └─→ i. Enviar notificación
        ┌────────────────────────────┐
        │ ✉ Email al empleado        │
        │ Nómina disponible          │
        │ Líquido: 1,809€            │
        └────────────────────────────┘
   │
   ▼
4. Registro de log → Nóminas generadas exitosamente
```

### Flujo del Sistema

## Componentes del Sistema

### 1. Recopilación de Datos

#### Datos del Empleado

```php
$query = "SELECT t.*, c.nombre as categoria, c.sueldo_normal, c.sueldo_plus,
          d.nombre as departamento
          FROM trabajadores t
          JOIN categorias c ON t.id_categoria = c.id_categoria
          JOIN departamentos d ON c.id_departamento = d.id_departamento
          WHERE t.activo = 1";
```

**Información extraída:**
- Datos personales (nombre, DNI, NSS)
- Datos laborales (departamento, categoría)
- Datos bancarios (IBAN)
- Tarifas por hora (normal y plus)

#### Fichajes del Mes

```php
$query = "SELECT f.*, tp.fecha, tp.hora_inicio, tp.hora_fin, tp.tipo_turno
          FROM fichajes f
          JOIN turnos_publicados tp ON f.id_turnoP = tp.id_turnoP
          WHERE f.dni = ? 
          AND MONTH(tp.fecha) = ? 
          AND YEAR(tp.fecha) = ?
          AND f.hora_salida IS NOT NULL";
```

**Información extraída:**
- Fecha de cada turno
- Horas de entrada y salida reales
- Duración del turno
- Tipo de turno (normal/nocturno/festivo)

### 2. Cálculo de Horas

#### Clasificación de Horas

```php
function calcularHoras($fichajes) {
    $horas_normales = 0;
    $horas_plus = 0;
    
    foreach ($fichajes as $fichaje) {
        // Calcular duración
        $entrada = strtotime($fichaje['hora_entrada']);
        $salida = strtotime($fichaje['hora_salida']);
        $duracion_horas = ($salida - $entrada) / 3600;
        
        // Clasificar según tipo de turno
        if ($fichaje['tipo_turno'] == 'nocturno' || 
            $fichaje['tipo_turno'] == 'festivo') {
            $horas_plus += $duracion_horas;
        } else {
            $horas_normales += $duracion_horas;
        }
    }
    
    return [
        'normales' => $horas_normales,
        'plus' => $horas_plus,
        'total' => $horas_normales + $horas_plus
    ];
}
```

#### Ajustes por Avisos

```php
function ajustarPorAvisos($horas, $dni, $mes, $anio) {
    // Obtener avisos del empleado en el mes
    $query = "SELECT * FROM aviso a
              JOIN turnos_publicados tp ON a.id_turnoP = tp.id_turnoP
              WHERE a.dni = ? 
              AND MONTH(tp.fecha) = ? 
              AND YEAR(tp.fecha) = ?";
    
    $avisos = ejecutarConsulta($query, [$dni, $mes, $anio]);
    
    foreach ($avisos as $aviso) {
        if ($aviso['tipo'] == 3) { // Falta injustificada
            // Restar horas completas del turno
            $horas -= calcularDuracionTurno($aviso['id_turnoP']);
        }
        // Entradas tardías y salidas tempranas ya están ajustadas
        // en el fichaje real
    }
    
    return $horas;
}
```

### 3. Cálculo de Devengos

#### Salario Bruto

```php
function calcularDevengos($horas, $tarifa_normal, $tarifa_plus) {
    $salario_normal = $horas['normales'] * $tarifa_normal;
    $salario_plus = $horas['plus'] * $tarifa_plus;
    $total_devengos = $salario_normal + $salario_plus;
    
    return [
        'salario_normal' => $salario_normal,
        'salario_plus' => $salario_plus,
        'total' => $total_devengos
    ];
}
```

**Ejemplo:**
```
Horas normales: 120h × 15.00€/h = 1,800.00€
Horas plus: 20h × 25.00€/h = 500.00€
Total devengos: 2,300.00€
```

### 4. Cálculo de Deducciones

#### IRPF (Impuesto sobre la Renta)

```php
function calcularIRPF($salario_bruto) {
    // Tramos de IRPF (ejemplo, puede variar según legislación)
    if ($salario_bruto <= 12450) {
        $porcentaje = 0.19;
    } elseif ($salario_bruto <= 20200) {
        $porcentaje = 0.24;
    } elseif ($salario_bruto <= 35200) {
        $porcentaje = 0.30;
    } else {
        $porcentaje = 0.37;
    }
    
    return $salario_bruto * $porcentaje;
}
```

> [!NOTE]
> Los porcentajes de IRPF son ejemplos. El sistema debe usar las tablas oficiales actualizadas de la Agencia Tributaria.

#### Seguridad Social

```php
function calcularSeguridadSocial($salario_bruto) {
    // Cotización del empleado (ejemplo 6.35%)
    $porcentaje_empleado = 0.0635;
    $cotizacion = $salario_bruto * $porcentaje_empleado;
    
    // Tope máximo de cotización (si aplica)
    $tope_maximo = 4495.50; // Ejemplo, actualizar según año
    if ($cotizacion > $tope_maximo) {
        $cotizacion = $tope_maximo;
    }
    
    return $cotizacion;
}
```

#### Otras Deducciones

```php
function calcularOtrasDeducciones($dni, $mes, $anio) {
    $deducciones = 0;
    
    // Anticipos solicitados
    $anticipos = obtenerAnticipos($dni, $mes, $anio);
    $deducciones += $anticipos;
    
    // Embargos judiciales
    $embargos = obtenerEmbargos($dni);
    $deducciones += $embargos;
    
    // Cuotas sindicales
    $cuotas = obtenerCuotasSindicales($dni);
    $deducciones += $cuotas;
    
    return $deducciones;
}
```

### 5. Cálculo del Líquido

```php
function calcularLiquido($devengos, $deducciones) {
    $irpf = $deducciones['irpf'];
    $seguridad_social = $deducciones['seguridad_social'];
    $otras = $deducciones['otras'];
    
    $total_deducciones = $irpf + $seguridad_social + $otras;
    $liquido = $devengos - $total_deducciones;
    
    return [
        'total_deducciones' => $total_deducciones,
        'liquido_a_percibir' => $liquido
    ];
}
```

## Generación del PDF

### Librería DOMPDF

**Instalación:**
```bash
cd /scripts/php/seguridad/generarNominas
composer require dompdf/dompdf
```

**Uso en el código:**
```php
<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opciones
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');

// Crear instancia
$dompdf = new Dompdf($options);
```

### Plantilla HTML

El PDF se genera a partir de una plantilla HTML:

```php
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #695CFE; color: white; }
        .total { font-weight: bold; background-color: #f0f0f0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>NÓMINA MENSUAL</h1>
        <p>Empresa: ' . $nombre_empresa . '</p>
        <p>Período: ' . $mes . ' ' . $anio . '</p>
        <p>Fecha de emisión: ' . date('d/m/Y') . '</p>
    </div>
    
    <div class="section">
        <h2>DATOS DEL TRABAJADOR</h2>
        <p><strong>Nombre:</strong> ' . $nombre . '</p>
        <p><strong>DNI:</strong> ' . $dni . '</p>
        <p><strong>NSS:</strong> ' . $nss . '</p>
        <p><strong>Departamento:</strong> ' . $departamento . '</p>
        <p><strong>Categoría:</strong> ' . $categoria . '</p>
    </div>
    
    <div class="section">
        <h2>DEVENGOS</h2>
        <table>
            <tr>
                <th>Concepto</th>
                <th>Horas</th>
                <th>€/Hora</th>
                <th>Importe</th>
            </tr>
            <tr>
                <td>Salario base (normal)</td>
                <td>' . number_format($horas_normales, 2) . 'h</td>
                <td>' . number_format($tarifa_normal, 2) . '€</td>
                <td>' . number_format($salario_normal, 2) . '€</td>
            </tr>
            <tr>
                <td>Salario plus</td>
                <td>' . number_format($horas_plus, 2) . 'h</td>
                <td>' . number_format($tarifa_plus, 2) . '€</td>
                <td>' . number_format($salario_plus, 2) . '€</td>
            </tr>
            <tr class="total">
                <td colspan="3">TOTAL DEVENGOS</td>
                <td>' . number_format($total_devengos, 2) . '€</td>
            </tr>
        </table>
    </div>
    
    <div class="section">
        <h2>DEDUCCIONES</h2>
        <table>
            <tr>
                <th>Concepto</th>
                <th>Porcentaje</th>
                <th>Importe</th>
            </tr>
            <tr>
                <td>IRPF</td>
                <td>' . number_format($porcentaje_irpf * 100, 2) . '%</td>
                <td>' . number_format($irpf, 2) . '€</td>
            </tr>
            <tr>
                <td>Seguridad Social</td>
                <td>6.35%</td>
                <td>' . number_format($seg_social, 2) . '€</td>
            </tr>
            <tr class="total">
                <td colspan="2">TOTAL DEDUCCIONES</td>
                <td>' . number_format($total_deducciones, 2) . '€</td>
            </tr>
        </table>
    </div>
    
    <div class="section">
        <h2>RESUMEN</h2>
        <table>
            <tr>
                <td>Total Devengos:</td>
                <td>' . number_format($total_devengos, 2) . '€</td>
            </tr>
            <tr>
                <td>Total Deducciones:</td>
                <td>-' . number_format($total_deducciones, 2) . '€</td>
            </tr>
            <tr class="total">
                <td>LÍQUIDO A PERCIBIR:</td>
                <td>' . number_format($liquido, 2) . '€</td>
            </tr>
        </table>
    </div>
    
    <div class="section">
        <h2>DATOS DE PAGO</h2>
        <p><strong>IBAN:</strong> ' . $iban . '</p>
        <p><strong>Fecha de pago:</strong> ' . $fecha_pago . '</p>
    </div>
</body>
</html>
';
```

### Generación y Guardado

```php
// Cargar HTML en DOMPDF
$dompdf->loadHtml($html);

// Configurar tamaño de página
$dompdf->setPaper('A4', 'portrait');

// Renderizar PDF
$dompdf->render();

// Guardar en archivo
$nombre_archivo = "nomina_{$dni}_{$mes}_{$anio}.pdf";
$ruta = "../userFiles/{$dni}/nominas/{$nombre_archivo}";

// Crear directorios si no existen
if (!file_exists(dirname($ruta))) {
    mkdir(dirname($ruta), 0755, true);
}

// Guardar PDF
file_put_contents($ruta, $dompdf->output());
```

## Notificaciones

### Email al Empleado

Cuando se genera la nómina, se envía un email:

```php
function enviarNotificacionNomina($email, $nombre, $mes, $anio, $liquido) {
    require 'PHPMailer/PHPMailerAutoload.php';
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tu_email@gmail.com';
    $mail->Password = 'tu_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    $mail->setFrom('noreply@cuandolibro.com', 'CuandoLibro');
    $mail->addAddress($email, $nombre);
    
    $mail->Subject = "Tu nómina de {$mes} {$anio} está disponible";
    $mail->Body = "
        Hola {$nombre},
        
        Tu nómina del mes de {$mes} {$anio} ya está disponible en tu My Portal.
        
        Resumen:
        - Líquido a percibir: " . number_format($liquido, 2) . "€
        - Fecha de pago: {$fecha_pago}
        
        Accede a My Portal > Nóminas para descargar el documento completo.
        
        Saludos,
        Sistema CuandoLibro
    ";
    
    $mail->send();
}
```

## Configuración del Sistema

### Datos de la Empresa

```php
// Configuración en config.php o BD
define('EMPRESA_NOMBRE', 'Tu Empresa SL');
define('EMPRESA_CIF', 'B12345678');
define('EMPRESA_DIRECCION', 'Calle Principal 123, 28001 Madrid');
define('EMPRESA_TELEFONO', '+34 91 234 56 78');
```

### Parámetros Fiscales

```php
// Actualizar anualmente según legislación
$parametros_fiscales = [
    'anio' => 2025,
    'irpf' => [
        ['hasta' => 12450, 'porcentaje' => 0.19],
        ['hasta' => 20200, 'porcentaje' => 0.24],
        ['hasta' => 35200, 'porcentaje' => 0.30],
        ['hasta' => 60000, 'porcentaje' => 0.37],
        ['hasta' => 300000, 'porcentaje' => 0.45],
        ['hasta' => PHP_INT_MAX, 'porcentaje' => 0.47]
    ],
    'seg_social' => 0.0635, // 6.35% empleado
    'tope_cotizacion' => 4495.50
];
```

### Fecha de Pago

```php
// Configurar fecha de pago
function calcularFechaPago($mes, $anio) {
    // Ejemplo: último día del mes
    return date('Y-m-t', strtotime("{$anio}-{$mes}-01"));
    
    // O día fijo, ej: día 30
    // return "{$anio}-{$mes}-30";
}
```

## Directorio de Nóminas

### Estructura de Archivos

```
/scripts/php/userFiles/
└── [DNI]/
    └── nominas/
        ├── nomina_11111111A_Enero_2025.pdf
        ├── nomina_11111111A_Febrero_2025.pdf
        ├── nomina_11111111A_Marzo_2025.pdf
        └── ...
```

### Permisos

```bash
# Crear directorios con permisos correctos
mkdir -p /scripts/php/userFiles
chmod 755 /scripts/php/userFiles

# Cada directorio de empleado
chmod 755 /scripts/php/userFiles/[DNI]
chmod 755 /scripts/php/userFiles/[DNI]/nominas
chmod 644 /scripts/php/userFiles/[DNI]/nominas/*.pdf
```

## Logs y Auditoría

### Registro de Generación

```php
function registrarGeneracionNomina($dni, $mes, $anio, $exito, $error = null) {
    $log = [
        'fecha' => date('Y-m-d H:i:s'),
        'dni' => $dni,
        'mes' => $mes,
        'anio' => $anio,
        'exito' => $exito,
        'error' => $error
    ];
    
    // Guardar en BD
    $query = "INSERT INTO log_nominas (fecha, dni, mes, anio, exito, error)
              VALUES (?, ?, ?, ?, ?, ?)";
    ejecutarConsulta($query, array_values($log));
    
    // También en archivo de log
    $log_file = '/logs/nominas.log';
    $mensaje = json_encode($log) . PHP_EOL;
    file_put_contents($log_file, $mensaje, FILE_APPEND);
}
```

## Manejo de Errores

### Errores Comunes

1. **Empleado sin fichajes**:
   ```php
   if (count($fichajes) == 0) {
       registrarError("Empleado {$dni} sin fichajes en {$mes}");
       // No generar nómina o generar con 0 horas
   }
   ```

2. **Error al crear PDF**:
   ```php
   try {
       $dompdf->render();
       file_put_contents($ruta, $dompdf->output());
   } catch (Exception $e) {
       registrarError("Error PDF para {$dni}: " . $e->getMessage());
       enviarAlertaAdministrador($dni, $e->getMessage());
   }
   ```

3. **Error al enviar email**:
   ```php
   if (!$mail->send()) {
       registrarError("Error email para {$dni}: " . $mail->ErrorInfo);
       // Nómina se genera igualmente, solo falla notificación
   }
   ```

## Verificación Post-Generación

### Checklist Automático

```php
function verificarNominas($mes, $anio) {
    $total_empleados = contarEmpleadosActivos();
    $nominas_generadas = contarNominasGeneradas($mes, $anio);
    $emails_enviados = contarEmailsEnviados($mes, $anio);
    
    $reporte = [
        'total_empleados' => $total_empleados,
        'nominas_generadas' => $nominas_generadas,
        'emails_enviados' => $emails_enviados,
        'errores' => obtenerErrores($mes, $anio)
    ];
    
    enviarReporteAdministrador($reporte);
    return $reporte;
}
```

## Archivos de Código

**Ubicación**: `/scripts/php/seguridad/generarNominas/`
- Script principal de generación
- Plantillas HTML
- Configuración DOMPDF
- Funciones de cálculo

## Siguiente Paso

- [My Portal - Nóminas](./11-my-portal-nominas.md)
- [Sistema de Fichaje](./13-fichaje.md)
- Volver a [Inicio](./README.md)
