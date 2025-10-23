# ⏱️ Sistema de Fichaje

## Descripción
El Sistema de Fichaje es el componente que controla la entrada y salida de los empleados, registra las horas trabajadas y genera avisos automáticos ante incidencias.

## Cómo Funciona

### Flujo General del Sistema

```
┌────────────────────────────────────────────────────────────────────┐
│                     SISTEMA DE FICHAJE                             │
└────────────────────────────────────────────────────────────────────┘

EMPLEADO                    SISTEMA                    RESULTADO
   │                           │                           │
   │ 1. Tiene turno            │                           │
   │    08:00 - 16:00          │                           │
   │           │               │                           │
   │           ▼               │                           │
   │ 2. Llega al trabajo       │                           │
   │    Hora: 08:05            │                           │
   │           │               │                           │
   │           ▼               │                           │
   │ 3. Ficha entrada  ────────▶  Registra: 08:05         │
   │                           │           │               │
   │                           │           ▼               │
   │                           │  Compara horarios:        │
   │                           │  ┌──────────────────┐    │
   │                           │  │ Inicio: 08:00    │    │
   │                           │  │ Fichaje: 08:05   │    │
   │                           │  │ Diferencia: 5min │    │
   │                           │  └──────────────────┘    │
   │                           │           │               │
   │                           │           ▼               │
   │                           │  Aplica tolerancia:       │
   │                           │  ┌──────────────────┐    │
   │                           │  │ Tolerancia: 5min │    │
   │                           │  │ 5min ≤ 5min      │    │
   │                           │  │ ✓ Dentro límite  │    │
   │                           │  └──────────────────┘    │
   │                           │           │               │
   │                           │           └──────────────▶ ✅ Sin aviso
   │                           │                           │
   │ 4. Trabaja su jornada     │                           │
   │           │               │                           │
   │           ▼               │                           │
   │ 5. Ficha salida ──────────▶  Registra: 16:00         │
   │    Hora: 16:00            │           │               │
   │                           │           ▼               │
   │                           │  Compara horarios:        │
   │                           │  ┌──────────────────┐    │
   │                           │  │ Fin: 16:00       │    │
   │                           │  │ Salida: 16:00    │    │
   │                           │  │ Diferencia: 0min │    │
   │                           │  │ ✓ Correcto       │    │
   │                           │  └──────────────────┘    │
   │                           │           │               │
   │                           │           └──────────────▶ ✅ Turno completado
   │                           │                           │
   │                           │  Calcula horas:           │
   │                           │  ┌──────────────────┐    │
   │                           │  │ 08:05 - 16:00    │    │
   │                           │  │ = 7h 55min       │    │
   │                           │  │ ≈ 7.92 horas     │    │
   │                           │  └──────────────────┘    │
   │                           │           │               │
   │                           │           └──────────────▶ 💰 Para nómina
   │                           │                           │
   └───────────────────────────┴───────────────────────────┘
```

## Componentes del Sistema

### 1. Registro de Fichajes

#### Tabla de Base de Datos

```sql
CREATE TABLE `fichajes` (
  `id_fichaje` INT PRIMARY KEY AUTO_INCREMENT,
  `dni` VARCHAR(9) NOT NULL,
  `id_turnoP` INT NOT NULL,
  `hora_entrada` DATETIME,
  `hora_salida` DATETIME,
  `estado` VARCHAR(20)
);
```

#### Estados del Fichaje

- ✅ **Completo**: Entrada y salida fichadas correctamente
- ⏳ **En curso**: Solo entrada fichada, esperando salida
- ⚠️ **Tardío**: Entrada fuera de tolerancia
- ⚠️ **Temprano**: Salida fuera de tolerancia
- ❌ **Incompleto**: Falta entrada o salida

### 2. Sistema de Tolerancias

#### Configuración de Tolerancias

Las tolerancias definen el margen de tiempo permitido:

**Tolerancia de Entrada:**
```php
$tolerancia_entrada = 5; // minutos
```
- Tiempo permitido **después** de la hora de inicio
- Ejemplo: Turno 08:00 → Puede fichar hasta 08:05

**Tolerancia de Salida:**
```php
$tolerancia_salida = 5; // minutos
```
- Tiempo permitido **antes** de la hora de fin
- Ejemplo: Turno 16:00 → Puede salir desde 15:55

#### Aplicación de Tolerancias

**Para la entrada:**
```
Hora límite = Hora inicio turno + Tolerancia
Si (Hora fichaje entrada > Hora límite):
    Generar aviso "Entrada tardía"
```

**Para la salida:**
```
Hora límite = Hora fin turno - Tolerancia
Si (Hora fichaje salida < Hora límite):
    Generar aviso "Salida temprana"
```

### 3. Proceso de Fichaje

#### Fichaje de Entrada

**Pasos del sistema:**

1. **Empleado ficha**: Introduce DNI o usa sistema biométrico
2. **Sistema verifica**:
   - ¿Existe un turno programado para hoy?
   - ¿Ya fichó entrada previamente?
   - ¿Es el momento correcto para fichar?
3. **Sistema registra**:
   - DNI del empleado
   - ID del turno
   - Hora exacta de entrada (timestamp)
4. **Sistema compara**:
   - Hora programada vs hora real
   - Aplica tolerancia
5. **Sistema decide**:
   - ✅ Sin aviso: Dentro de tolerancia
   - ⚠️ Generar aviso: Fuera de tolerancia

**Ejemplo de código:**
```php
// Obtener hora actual
$hora_fichaje = date('Y-m-d H:i:s');

// Obtener hora de inicio del turno
$hora_inicio_turno = "2025-10-25 08:00:00";

// Calcular hora límite con tolerancia
$hora_limite = date('Y-m-d H:i:s', 
    strtotime($hora_inicio_turno . ' +5 minutes'));

// Comparar
if ($hora_fichaje > $hora_limite) {
    // Entrada tardía
    $retraso = strtotime($hora_fichaje) - strtotime($hora_inicio_turno);
    generarAviso("Entrada tardía", $retraso);
}

// Registrar fichaje
$query = "INSERT INTO fichajes (dni, id_turnoP, hora_entrada) 
          VALUES (?, ?, ?)";
```

#### Fichaje de Salida

**Pasos del sistema:**

1. **Empleado ficha salida**: Introduce DNI
2. **Sistema verifica**:
   - ¿Existe un fichaje de entrada hoy?
   - ¿Ya fichó salida previamente?
   - ¿Es el turno correcto?
3. **Sistema registra**:
   - Hora exacta de salida
   - Actualiza el registro de fichaje
4. **Sistema compara**:
   - Hora programada vs hora real de salida
   - Aplica tolerancia
5. **Sistema decide**:
   - ✅ Sin aviso: Dentro de tolerancia
   - ⚠️ Generar aviso: Salida temprana
6. **Sistema calcula**:
   - Horas totales trabajadas
   - Tipo de horas (normales/plus)

**Ejemplo de código:**
```php
// Obtener hora actual
$hora_salida = date('Y-m-d H:i:s');

// Obtener hora de fin del turno
$hora_fin_turno = "2025-10-25 16:00:00";

// Calcular hora límite con tolerancia
$hora_limite = date('Y-m-d H:i:s', 
    strtotime($hora_fin_turno . ' -5 minutes'));

// Comparar
if ($hora_salida < $hora_limite) {
    // Salida temprana
    $adelanto = strtotime($hora_fin_turno) - strtotime($hora_salida);
    generarAviso("Salida temprana", $adelanto);
}

// Actualizar fichaje
$query = "UPDATE fichajes SET hora_salida = ? 
          WHERE dni = ? AND id_turnoP = ? AND hora_salida IS NULL";

// Calcular horas trabajadas
$horas_trabajadas = calcularHoras($hora_entrada, $hora_salida);
```

### 4. Generación Automática de Avisos

#### Tipos de Avisos Generados

**1. Entrada Tardía (Tipo 1)**

Generado cuando:
```php
if (hora_fichaje_entrada > (hora_inicio_turno + tolerancia)) {
    // Calcular retraso
    $retraso = hora_fichaje_entrada - hora_inicio_turno;
    
    // Crear aviso
    crearAviso(
        tipo: 1,
        comentario: "El trabajador ha entrado tarde " . formatTime($retraso),
        dni: $dni,
        id_turnoP: $id_turno
    );
}
```

**2. Salida Temprana (Tipo 5)**

Generado cuando:
```php
if (hora_fichaje_salida < (hora_fin_turno - tolerancia)) {
    // Calcular adelanto
    $adelanto = hora_fin_turno - hora_fichaje_salida;
    
    // Crear aviso
    crearAviso(
        tipo: 5,
        comentario: "El trabajador ha salido pronto " . formatTime($adelanto),
        dni: $dni,
        id_turnoP: $id_turno
    );
}
```

**3. Falta Injustificada**

Generado cuando:
```php
// Ejecutado automáticamente después de que pase el turno
if (turno_finalizado && (!existe_fichaje_entrada || !existe_fichaje_salida)) {
    crearAviso(
        tipo: 3,
        comentario: "Falta injustificada de asistencia",
        dni: $dni,
        id_turnoP: $id_turno
    );
}
```

#### Formato de Tiempo

Los avisos muestran el tiempo en formato HH:MM:SS:
```php
function formatTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $secs = $seconds % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
}
```

Ejemplo: `00:08:12` = 8 minutos y 12 segundos

### 5. Cálculo de Horas Trabajadas

#### Fórmula Básica

```php
$horas_trabajadas = (hora_salida - hora_entrada) / 3600;
```

#### Distinción Horas Normales vs Plus

**Turno Nocturno** (22:00 - 06:00):
```php
if (hora_inicio >= 22:00 || hora_fin <= 06:00) {
    $tipo_turno = "nocturno";
    $tipo_sueldo = "plus";
} else {
    $tipo_turno = "diurno";
    $tipo_sueldo = "normal";
}
```

**Turno Festivo**:
```php
$fecha_turno = date('Y-m-d', strtotime($turno['fecha']));
if (esFestivo($fecha_turno)) {
    $tipo_sueldo = "plus";
}
```

#### Ajuste por Avisos

Si hay avisos que reducen horas:
```php
// Entrada tardía
if (aviso_entrada_tardia) {
    $horas_trabajadas -= ($minutos_retraso / 60);
}

// Salida temprana
if (aviso_salida_temprana) {
    $horas_trabajadas -= ($minutos_adelanto / 60);
}

// Falta injustificada
if (falta_injustificada) {
    $horas_trabajadas = 0;
}
```

## Métodos de Fichaje

### 1. Terminal de Fichaje Física

**Características:**
- Dispositivo físico en las instalaciones
- Lector de tarjetas RFID
- Teclado para introducir DNI/código
- Pantalla para confirmación

**Proceso:**
1. Empleado se acerca al terminal
2. Pasa su tarjeta o introduce código
3. Terminal conecta con el servidor
4. Sistema registra el fichaje
5. Terminal muestra confirmación

### 2. Aplicación Web

**Características:**
- Acceso desde navegador
- Requiere autenticación
- Geolocalización (opcional)
- Verificación por IP

**Proceso:**
1. Empleado accede a URL de fichaje
2. Inicia sesión con sus credenciales
3. Hace clic en "Fichar entrada/salida"
4. Sistema registra hora y ubicación
5. Muestra confirmación

### 3. Aplicación Móvil

**Características:**
- App instalada en smartphone
- Geolocalización obligatoria
- Notificaciones push
- Funciona sin conexión (sincroniza después)

**Proceso:**
1. Empleado abre la app
2. Pulsa botón de fichaje
3. App captura: hora, ubicación, dispositivo
4. Envía datos al servidor
5. Recibe confirmación

### 4. Sistema Biométrico

**Características:**
- Huella dactilar o reconocimiento facial
- Mayor seguridad
- No se pueden compartir credenciales
- Registro único

**Proceso:**
1. Empleado coloca dedo en lector
2. Sistema verifica identidad
3. Registra fichaje automáticamente
4. Muestra confirmación

## Automatización

### Tareas Programadas (Cron Jobs)

El sistema requiere tareas automáticas programadas:

#### 1. Generar Avisos de Faltas

**Frecuencia**: Cada hora o al finalizar cada turno

```bash
# crontab entry
0 * * * * php /path/to/scripts/php/seguridad/verificarFaltas.php
```

**Función:**
- Revisa turnos que ya pasaron
- Busca turnos sin fichajes
- Genera avisos de falta injustificada
- Envía notificaciones

#### 2. Verificar Turnos del Día

**Frecuencia**: Cada mañana

```bash
# crontab entry
0 6 * * * php /path/to/scripts/php/seguridad/verificarTurnosDia.php
```

**Función:**
- Lista todos los turnos del día
- Envía recordatorios a empleados
- Prepara el sistema de fichaje

#### 3. Limpiar Fichajes Antiguos

**Frecuencia**: Mensual

```bash
# crontab entry
0 0 1 * * php /path/to/scripts/php/seguridad/limpiarFichajes.php
```

**Función:**
- Archiva fichajes de hace más de X meses
- Mantiene BD optimizada
- Conserva datos para auditorías

## Reportes de Fichaje

### Información Disponible

Para administradores:
- 📊 Fichajes del día
- 📊 Fichajes por empleado
- 📊 Fichajes por departamento
- 📊 Resumen semanal/mensual
- 📊 Empleados con más avisos
- 📊 Análisis de puntualidad

### Exportación de Datos

Los datos de fichaje se pueden exportar a:
- CSV para Excel
- PDF para reportes
- JSON para integraciones
- Formato para nóminas

## Casos Especiales

### 1. Turno que cruza medianoche

**Ejemplo**: 22:00 - 06:00

```php
if ($hora_fin < $hora_inicio) {
    // El turno cruza medianoche
    $fecha_fin = date('Y-m-d', strtotime($fecha_inicio . ' +1 day'));
}
```

### 2. Fichaje olvidado

**Solución manual**:
1. Empleado contacta al administrador
2. Proporciona evidencia (emails, testimonios)
3. Administrador registra fichaje manualmente
4. Se documenta la excepción

### 3. Error del sistema

**Protocolo**:
1. Empleado reporta inmediatamente
2. Se registra incidencia
3. Administrador verifica logs
4. Se corrige el fichaje si procede
5. Se documenta para auditoría

### 4. Múltiples turnos en un día

```php
// El sistema debe permitir
$query = "SELECT * FROM fichajes 
          WHERE dni = ? AND DATE(hora_entrada) = CURDATE()
          ORDER BY hora_entrada";
```

## Notificaciones del Sistema

### Empleados reciben notificaciones cuando:

- ⏰ **Recordatorio de turno**: 1 hora antes
- ✅ **Fichaje confirmado**: Entrada/salida registrada
- ⚠️ **Aviso generado**: Incidencia detectada
- ❌ **Fichaje faltante**: No fichaste hoy

### Administradores reciben cuando:

- 📧 **Resumen diario**: Fichajes del día
- ⚠️ **Avisos nuevos**: Incidencias detectadas
- 🚨 **Errores del sistema**: Problemas técnicos
- 📊 **Reportes semanales**: Estadísticas de asistencia

## Integración con Nóminas

El sistema de fichaje alimenta directamente el sistema de nóminas:

1. **Al finalizar el mes**:
   - Se suman todas las horas fichadas
   - Se clasifican en normales/plus
   - Se ajustan por avisos

2. **Datos enviados a nóminas**:
   ```php
   [
       'dni' => '11111111A',
       'mes' => 'Octubre',
       'anio' => 2025,
       'horas_normales' => 120,
       'horas_plus' => 20,
       'avisos' => [
           'entradas_tardias' => 2,
           'salidas_tempranas' => 1,
           'faltas' => 0
       ]
   ]
   ```

3. **Cálculo de nómina**:
   - Horas × Tarifa según categoría
   - Deducciones legales
   - Bonos/penalizaciones según política

Ver más en [Generación de Nóminas](./14-nominas.md)

## Seguridad del Sistema de Fichaje

### Prevención de Fraude

- 🔒 **Biometría**: No se pueden compartir huellas
- 📍 **Geolocalización**: Verificar ubicación del fichaje
- 🖥️ **Registro de IP**: Detectar patrones anómalos
- ⏱️ **Timestamps**: Imposible modificar fecha/hora del servidor
- 📸 **Foto al fichar**: Opcional, captura imagen

### Auditoría

Todos los fichajes quedan registrados:
- Quién fichó
- Cuándo fichó
- Desde dónde (IP, ubicación)
- Con qué método
- Modificaciones posteriores (con autorización)

## Archivos de Código

**Ubicación**: `/scripts/php/seguridad/`
- Fichaje de entrada/salida
- Verificación de turnos
- Generación de avisos
- Cálculo de horas

## Siguiente Paso

- [Generación de Nóminas](./14-nominas.md)
- [Gestión de Avisos](./07-avisos.md)
- [Sistema de Seguridad](./12-seguridad.md)
