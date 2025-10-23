# 📅 My Portal - Horarios

## Descripción
La sección de Horarios en My Portal permite a los empleados consultar todos sus turnos programados, tanto pasados como futuros, con información detallada de cada uno.

## Acceso

**URL**: `/sites/my-portal-horarios.php`  
**Requerido**: Rol de usuario (empleado)  
**Acceso desde**: Menú lateral de My Portal → Horarios

## Vista Principal

### Elementos de la Interfaz

La pantalla muestra:
- **Título**: "Horarios"
- **Tabla de turnos**: Todos tus turnos ordenados cronológicamente
- **Filtros**: Para buscar turnos específicos

## Tabla de Turnos

### Columnas Mostradas

| Columna | Descripción |
|---------|-------------|
| **Fecha** | Día del turno (formato: DD/MM/YYYY) |
| **Hora Inicio** | Hora de comienzo del turno (HH:MM) |
| **Hora Fin** | Hora de finalización del turno (HH:MM) |
| **Duración** | Horas totales del turno |
| **Departamento** | Departamento al que corresponde |
| **Estado** | Estado actual del turno |

### Estados del Turno

Los turnos pueden tener diferentes estados visuales:

#### ⏳ Pendiente
- El turno está programado pero aún no ha llegado
- Aparece en color gris o azul claro
- Aún no puedes fichar

#### ✅ Completado
- Has fichado entrada y salida correctamente
- Sin incidencias registradas
- Aparece en verde
- Horas contabilizadas para la nómina

#### ⚠️ Con Avisos
- El turno tiene incidencias registradas:
  - Entrada tardía
  - Salida temprana
  - Problemas de fichaje
- Aparece en amarillo/naranja
- Ver detalles en [My Portal - Avisos](./10-my-portal-avisos.md)

#### ❌ Falta
- No fichaste entrada ni salida
- Falta injustificada registrada
- Aparece en rojo
- No se contabilizan horas para la nómina

#### 🕐 En curso
- El turno está en progreso actualmente
- Has fichado entrada pero no salida
- Aparece en azul

## Información Detallada del Turno

### Al hacer clic en un turno, puedes ver:

- **Datos básicos**:
  - 📅 Fecha completa
  - 🕐 Hora de inicio programada
  - 🕐 Hora de fin programada
  - ⏱️ Duración total (en horas)

- **Datos de fichaje** (si ya fichaste):
  - ⏰ Hora real de entrada
  - ⏰ Hora real de salida
  - ⌚ Tiempo trabajado real
  - ✅ Estado del fichaje

- **Información adicional**:
  - 💼 Departamento
  - 🏷️ Tipo de turno (normal/nocturno/festivo)
  - 💰 Tipo de sueldo aplicado (normal/plus)

## Filtros y Búsqueda

### Filtrar Turnos por Fecha

Puedes filtrar turnos por:

**Fecha específica:**
1. Selecciona una fecha en el calendario
2. Verás solo los turnos de ese día

**Rango de fechas:**
1. Selecciona fecha de inicio
2. Selecciona fecha de fin
3. Verás turnos dentro del rango

**Período predefinido:**
- 📅 Esta semana
- 📅 Este mes
- 📅 Último mes
- 📅 Próximos 7 días
- 📅 Próximos 30 días

### Filtrar por Estado

Puedes filtrar para ver solo:
- ⏳ Turnos pendientes
- ✅ Turnos completados
- ⚠️ Turnos con avisos
- ❌ Faltas

### Filtrar por Departamento

Si trabajas en varios departamentos:
- Filtra por departamento específico
- Útil si tienes asignaciones cruzadas

## Vista de Calendario

### Calendario Mensual

Además de la tabla, hay una vista de calendario que muestra:
- **Días con turnos**: Marcados con punto o color
- **Múltiples turnos en un día**: Indicador especial
- **Días libres**: Sin marca
- **Festivos**: Marcados en color diferente

### Navegación del Calendario

- ⬅️ **Anterior**: Ver mes anterior
- ➡️ **Siguiente**: Ver mes siguiente
- 📅 **Hoy**: Volver al mes actual

## Tipos de Turnos

### 🌅 Turno Diurno (Normal)
- Horario: 06:00 - 22:00
- Sueldo: Tarifa normal
- Más común

**Ejemplo:**
```
📅 25/10/2025
🕐 08:00 - 16:00
⏱️ 8 horas
💰 Sueldo normal
```

### 🌙 Turno Nocturno (Plus)
- Horario: 22:00 - 06:00
- Sueldo: Tarifa plus (mayor)
- Compensación por horario especial

**Ejemplo:**
```
📅 25/10/2025
🕐 22:00 - 06:00
⏱️ 8 horas
💰 Sueldo plus
```

### 🎉 Turno Festivo (Plus)
- Días festivos nacionales/locales
- Sueldo: Tarifa plus (mayor)
- Independiente del horario

**Ejemplo:**
```
📅 25/12/2025 (Navidad)
🕐 08:00 - 16:00
⏱️ 8 horas
💰 Sueldo plus
```

## Sistema de Fichaje

### Cómo Funcionan los Turnos

1. **Turno asignado**: Recibes notificación
2. **Día del turno**: Acudes a tu puesto
3. **Hora de inicio**: Fichas tu entrada
4. **Durante el turno**: Trabajas tu jornada
5. **Hora de fin**: Fichas tu salida
6. **Registro**: El sistema registra las horas

### Fichaje Correcto

Para un fichaje correcto:
- ✅ Ficha **dentro del margen de tolerancia**
- ✅ Ficha tanto **entrada como salida**
- ✅ Ficha en el **dispositivo autorizado**
- ✅ Verifica que se **registró correctamente**

### Tolerancias

El sistema permite cierta flexibilidad:

**Entrada:**
- Tolerancia típica: 5 minutos después de la hora de inicio
- Ejemplo: Turno 08:00, puedes fichar hasta 08:05 sin aviso

**Salida:**
- Tolerancia típica: 5 minutos antes de la hora de fin
- Ejemplo: Turno finaliza 16:00, puedes salir desde 15:55 sin aviso

> [!WARNING]
> Si excedes la tolerancia:
> - Se genera un aviso automáticamente
> - Recibes notificación por email
> - Queda registrado en tu historial

Ver más en [Sistema de Fichaje](./13-fichaje.md)

## Notificaciones de Turnos

### Recibes notificaciones cuando:

- 📧 **Turno nuevo asignado**:
  ```
  Asunto: Nuevo turno asignado
  Fecha: 25/10/2025
  Horario: 08:00 - 16:00
  Departamento: Desarrollo
  ```

- 📧 **Turno modificado**:
  ```
  Asunto: Cambio en tu turno
  Turno original: 25/10/2025 08:00-16:00
  Nuevo turno: 25/10/2025 09:00-17:00
  ```

- 📧 **Turno eliminado**:
  ```
  Asunto: Turno cancelado
  Tu turno del 25/10/2025 ha sido cancelado
  ```

- ⚠️ **Recordatorio del turno** (opcional):
  ```
  Asunto: Recordatorio de turno
  Mañana tienes turno a las 08:00
  ```

## Planificación Personal

### Cómo usar la información de horarios:

1. **Planifica tu semana**:
   - Consulta turnos al inicio de semana
   - Organiza tu tiempo personal
   - Prepara transporte si es necesario

2. **Verifica cambios**:
   - Revisa diariamente por si hay modificaciones
   - Activa notificaciones por email
   - Consulta antes de tu turno

3. **Gestiona tu tiempo**:
   - Conoce tus días libres
   - Planifica vacaciones considerando turnos
   - Solicita cambios con anticipación al administrador

## Estadísticas Personales

### Información que puedes ver:

- 📊 **Horas trabajadas este mes**
- 📊 **Horas trabajadas este año**
- 📊 **Turnos completados**
- 📊 **Turnos pendientes**
- 📊 **Porcentaje de asistencia**
- 📊 **Promedio de horas semanales**

### Ejemplo de estadísticas:

```
Mes actual (Octubre 2025):
- Turnos asignados: 20
- Turnos completados: 18
- Horas trabajadas: 144h
- Horas normales: 120h
- Horas plus: 24h
- Asistencia: 90%
```

## Consultar Turnos Pasados

### Historial de Turnos

Puedes consultar todos tus turnos históricos:
- 📅 Desde tu fecha de alta en la empresa
- 📅 Organizados por mes/año
- 📅 Con toda la información de fichaje
- 📅 Útil para verificar horas trabajadas

### Usos del Historial:

1. **Verificar nóminas**: Comprobar horas facturadas
2. **Justificaciones**: Demostrar asistencia en fechas específicas
3. **Estadísticas personales**: Análisis de tu trabajo
4. **Revisión anual**: Para evaluaciones de desempeño

## Problemas Comunes

### No veo turnos asignados

**Posibles causas:**
- Aún no te han asignado turnos
- Los turnos están en el futuro (ajusta filtros)
- Problema de conexión

**Solución:**
- Verifica los filtros de fecha
- Contacta al administrador
- Refresca la página

### El estado del turno es incorrecto

**Posibles causas:**
- El sistema aún no ha actualizado
- Problema en el fichaje
- Aviso pendiente de revisión

**Solución:**
- Espera unos minutos y refresca
- Verifica tus fichajes
- Consulta [My Portal - Avisos](./10-my-portal-avisos.md)
- Contacta al administrador si persiste

### No puedo fichar

**Posibles causas:**
- No es la hora del turno
- Dispositivo de fichaje no disponible
- Problema técnico

**Solución:**
- Verifica la hora actual
- Intenta en otro dispositivo autorizado
- Contacta al administrador inmediatamente

## Impresión y Exportación

### Imprimir tu horario:

1. Selecciona el rango de fechas deseado
2. Haz clic en "Imprimir" o usa Ctrl+P
3. Selecciona tu impresora
4. Imprime tu calendario de turnos

### Exportar a calendario personal:

> [!NOTE]
> Funcionalidad que podría implementarse:
> - Exportar a Google Calendar
> - Exportar a iCal/Outlook
> - Descargar PDF con horarios

## Diseño Responsive

La vista de horarios se adapta a:
- 📱 **Móvil**: Vista de lista simplificada
- 📱 **Tablet**: Vista de tabla compacta
- 💻 **Escritorio**: Vista completa con calendario

## Archivos de Código

**Ubicación**: `/sites/my-portal-horarios.php`  
**Funciones**: `/scripts/php/login/datosTurnos.php`

## Siguiente Paso

- [My Portal - Avisos](./10-my-portal-avisos.md)
- [Sistema de Fichaje](./13-fichaje.md)
- Volver a [My Portal](./08-my-portal.md)
