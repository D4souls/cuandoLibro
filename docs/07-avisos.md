# ⚠️ Gestión de Avisos

## Descripción
La ventana de Gestión de Avisos permite a los administradores visualizar y gestionar todas las incidencias relacionadas con el fichaje de los empleados. Los avisos se generan automáticamente cuando hay irregularidades en el control de entrada y salida.

## Acceso

**URL**: `/sites/avisos.php`  
**Requerido**: Rol de administrador

## Vista Principal

### Elementos de la Interfaz

La pantalla muestra:
- **Título**: "Avisos"
- **Tabla de avisos**: Lista con todas las incidencias registradas

### Tabla de Avisos

La tabla muestra las siguientes columnas:

| Columna | Descripción |
|---------|-------------|
| **DNI** | Documento del empleado (parcialmente oculto: \*\*\*\*1111A) |
| **Tipo Aviso** | Tipo de incidencia detectada |
| **Comentario** | Descripción detallada del aviso |

## Tipos de Avisos

El sistema genera automáticamente tres tipos de avisos:

### 1. 🔴 Entrada Tardía

**Se genera cuando:**
- El empleado ficha su entrada después de la hora de inicio del turno (+ tolerancia)

**Ejemplo de comentario:**
```
"El trabajador ha entrado tarde 00:08:12"
```

**Información incluida:**
- Tiempo de retraso (HH:MM:SS)
- Fecha y hora real de entrada
- Turno al que corresponde

### 2. 🟡 Salida Temprana

**Se genera cuando:**
- El empleado ficha su salida antes de la hora de fin del turno (- tolerancia)

**Ejemplo de comentario:**
```
"El trabajador ha salido pronto 00:14:40"
```

**Información incluida:**
- Tiempo de adelanto (HH:MM:SS)
- Fecha y hora real de salida
- Turno al que corresponde

### 3. 🔴 Falta Injustificada

**Se genera cuando:**
- El empleado no ficha entrada ni salida en su turno asignado
- Pasa la hora límite del turno sin fichaje

**Ejemplo de comentario:**
```
"Falta injustificada de asistencia"
```

**Información incluida:**
- Fecha del turno
- Turno al que no asistió
- Departamento afectado

## Visualización de Avisos

### Listado General

La vista principal muestra:
- **Todos los avisos** del sistema ordenados cronológicamente
- **DNI parcialmente oculto** por privacidad (GDPR)
- **Tipo de aviso** con color identificativo
- **Comentario completo** con detalles

### Colores Identificativos

- 🔴 **Rojo**: Entrada tardía y falta injustificada (crítico)
- 🟡 **Amarillo**: Salida temprana (advertencia)

## Historial de Avisos por Empleado

### Acceso al Historial Individual

Desde [Gestión de Trabajadores](./03-trabajadores.md):

1. Localiza al empleado en la tabla
2. Haz clic en el botón **"Historial"** (icono de reloj)
3. Se abrirá una vista con todos los avisos del empleado

### Información del Historial

El historial individual muestra:
- **Foto del empleado**
- **Datos personales**: Nombre, DNI, departamento
- **Lista completa de avisos**:
  - Fecha del aviso
  - Tipo de incidencia
  - Detalles específicos
  - Turno relacionado

### Estadísticas del Empleado

El historial puede incluir:
- Total de avisos
- Avisos por tipo
- Tendencias mensuales
- Porcentaje de asistencia

## Sistema Automático de Avisos

### Funcionamiento

Los avisos se generan **automáticamente** mediante:

```
┌─────────────────────────────────────────────────────────────────┐
│                    SISTEMA DE AVISOS                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  1. Comparación de horarios                                    │
│     ┌──────────────┐         ┌──────────────┐                 │
│     │ Hora turno   │    VS   │ Hora fichaje │                 │
│     │ programada   │         │ real         │                 │
│     └──────────────┘         └──────────────┘                 │
│              │                       │                          │
│              └───────────┬───────────┘                          │
│                          ▼                                      │
│              ┌──────────────────────┐                          │
│              │ Margen de tolerancia │                          │
│              └──────────────────────┘                          │
│                          │                                      │
│              ┌───────────┴───────────┐                         │
│              ▼                       ▼                          │
│      ┌──────────────┐       ┌──────────────┐                  │
│      │ Dentro de    │       │ Fuera de     │                  │
│      │ tolerancia   │       │ tolerancia   │                  │
│      │   ✓ OK       │       │   ✗ AVISO    │                  │
│      └──────────────┘       └──────────────┘                  │
│                                      │                          │
│  2. Almacenamiento                   ▼                          │
│     ┌────────────────────────────────────────┐                 │
│     │ Base de datos → Tabla 'aviso'         │                 │
│     │ - ID empleado (DNI)                   │                 │
│     │ - Tipo de aviso                       │                 │
│     │ - Comentario detallado                │                 │
│     │ - Turno relacionado                   │                 │
│     └────────────────────────────────────────┘                 │
│                          │                                      │
│  3. Notificación         ▼                                      │
│     ┌─────────────────────────────────────────┐                │
│     │ ✉ Email al administrador               │                │
│     │ ✉ Email al empleado                    │                │
│     │ 📝 Registro en historial               │                │
│     └─────────────────────────────────────────┘                │
└─────────────────────────────────────────────────────────────────┘
```

### Cálculo del Tiempo

El sistema calcula automáticamente:

**Para entrada tardía:**
```
Retraso = Hora_Real_Entrada - (Hora_Inicio_Turno + Tolerancia)
```

**Para salida temprana:**
```
Adelanto = (Hora_Fin_Turno - Tolerancia) - Hora_Real_Salida
```

**Ejemplo:**
```
Turno: 08:00 - 16:00
Tolerancia: 5 minutos
Fichaje entrada: 08:12
Retraso calculado: 00:07:00 (12 - 5 = 7 minutos)
Aviso: "El trabajador ha entrado tarde 00:07:00"
```

## Configuración de Tolerancias

### Tolerancia de Entrada
- Tiempo permitido de retraso sin generar aviso
- Por defecto: 5 minutos
- Configurable en el sistema

### Tolerancia de Salida
- Tiempo permitido de salida anticipada sin generar aviso
- Por defecto: 5 minutos
- Configurable en el sistema

> [!NOTE]
> Las tolerancias se configuran en el código del sistema de seguridad.
> Ver [Sistema de Fichaje](./13-fichaje.md) para más detalles.

## Gestión de Avisos

### Revisión de Avisos

**Como administrador debes:**

1. **Revisar periódicamente** la lista de avisos
2. **Identificar patrones** de incidencias
3. **Contactar con empleados** con múltiples avisos
4. **Tomar acciones** según la política de la empresa

### Acciones Recomendadas

Según el tipo y frecuencia:

**Avisos ocasionales:**
- Revisión informativa
- No requieren acción inmediata

**Avisos recurrentes (mismo empleado):**
- Conversación con el empleado
- Revisión de causa raíz
- Ajuste de horarios si es necesario
- Medidas disciplinarias según política

**Avisos críticos (faltas injustificadas):**
- Contacto inmediato con el empleado
- Verificación de situación
- Registro formal
- Seguimiento de acciones

## Integración con Otras Secciones

### Sistema de Fichaje
- Los avisos se generan desde el sistema de fichaje
- Ver [Sistema de Fichaje](./13-fichaje.md)

### Trabajadores
- Cada empleado tiene su historial de avisos
- Ver [Gestión de Trabajadores](./03-trabajadores.md)

### Turnos
- Cada aviso está vinculado a un turno específico
- Ver [Gestión de Turnos](./06-turnos.md)

### My Portal - Avisos
- Los empleados pueden ver sus propios avisos
- Ver [My Portal - Avisos](./10-my-portal-avisos.md)

## Tabla de Base de Datos

### Estructura del Aviso

```sql
CREATE TABLE `aviso` (
  `id_aviso` INT PRIMARY KEY AUTO_INCREMENT,
  `tipo` INT NOT NULL,           -- Tipo de aviso (1=tardía, 5=temprana, etc.)
  `comentario` VARCHAR(500),      -- Descripción del aviso
  `dni` VARCHAR(9) NOT NULL,      -- DNI del empleado
  `id_turnoP` INT NOT NULL        -- ID del turno relacionado
);
```

### Tipos de Aviso en BD

| Código | Tipo de Aviso |
|--------|---------------|
| 1 | Entrada tardía |
| 5 | Salida temprana |
| Otro | Falta injustificada |

## Reportes y Análisis

### Métricas Importantes

Puedes analizar:
- **Total de avisos por mes**
- **Avisos por departamento**
- **Empleados con más avisos**
- **Tendencia temporal** (mejora/empeoramiento)
- **Días con más incidencias**

### Gráficos (Dashboard)

El [Dashboard](./02-dashboard.md) muestra:
- Cantidad total de avisos
- Visualización gráfica
- Comparación entre departamentos

## Privacidad y Seguridad

### Protección de Datos

- **DNI parcialmente oculto**: Solo visibles últimos caracteres
- **Acceso restringido**: Solo administradores
- **Registro de accesos**: Se registra quién consulta avisos
- **GDPR compliant**: Cumplimiento normativa protección de datos

### Auditoría

El sistema mantiene registro de:
- Fecha y hora de generación del aviso
- Usuario que consulta el aviso
- Acciones tomadas (si se implementa)

## Notificaciones por Email

Cuando se genera un aviso:

**Al administrador:**
- Email de notificación
- Resumen del aviso
- Datos del empleado
- Enlace al sistema

**Al empleado:**
- Email informativo
- Detalles del aviso
- Recomendaciones
- Enlace a My Portal

## Ejemplos de Avisos

### Ejemplo 1: Entrada Tardía
```
DNI: ****2222B
Tipo: Entrada tardía
Comentario: El trabajador ha entrado tarde 00:08:12
Turno: 25/10/2025 08:00-16:00
Departamento: Desarrollo
```

### Ejemplo 2: Salida Temprana
```
DNI: ****1111A
Tipo: Salida temprana
Comentario: El trabajador ha salido pronto 00:14:40
Turno: 24/10/2025 14:00-22:00
Departamento: Diseño
```

### Ejemplo 3: Falta Injustificada
```
DNI: ****3333C
Tipo: Falta injustificada
Comentario: Falta injustificada de asistencia
Turno: 23/10/2025 08:00-16:00
Departamento: Testing
```

## Archivos de Código

**Ubicación**: `/sites/avisos.php`  
**Historial empleado**: `/scripts/php/userEdit/historial-avisos.php`  
**Sistema de fichaje**: `/scripts/php/seguridad/`

## Siguiente Paso

- [Sistema de Fichaje](./13-fichaje.md)
- [Gestión de Trabajadores](./03-trabajadores.md)
- [My Portal - Avisos](./10-my-portal-avisos.md)
- [Gestión de Turnos](./06-turnos.md)
