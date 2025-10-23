# ⚠️ My Portal - Avisos

## Descripción
La sección de Avisos en My Portal permite a los empleados consultar todas las incidencias relacionadas con su fichaje y asistencia.

## Acceso

**URL**: `/sites/my-portal-avisos.php`  
**Requerido**: Rol de usuario (empleado)  
**Acceso desde**: Menú lateral de My Portal → Avisos

## Vista Principal

### Elementos de la Interfaz

La pantalla muestra:
- **Título**: "Mis Avisos"
- **Resumen de avisos**: Estadísticas generales
- **Tabla de avisos**: Lista completa de tus incidencias

## Tabla de Avisos

### Columnas Mostradas

| Columna | Descripción |
|---------|-------------|
| **Fecha** | Fecha del aviso/incidencia |
| **Tipo de Aviso** | Categoría de la incidencia |
| **Turno Afectado** | Turno relacionado con el aviso |
| **Comentario** | Descripción detallada del aviso |
| **Estado** | Estado actual del aviso |

## Tipos de Avisos

### 🔴 Entrada Tardía

**Descripción:**
- Fichaste tu entrada después de la hora permitida (inicio + tolerancia)
- Se registra el tiempo de retraso exacto

**Ejemplo de aviso:**
```
Tipo: Entrada tardía
Fecha: 25/10/2025
Turno: 08:00 - 16:00
Comentario: El trabajador ha entrado tarde 00:08:12
Tiempo de retraso: 8 minutos y 12 segundos
```

**Impacto:**
- ⚠️ Queda registrado en tu historial
- 💰 Puede afectar evaluaciones de desempeño
- 📊 Cuenta para estadísticas de asistencia
- 💵 Generalmente no afecta el sueldo por ese pequeño retraso

**Qué hacer:**
- Revisa la información del aviso
- Intenta llegar puntual en futuros turnos
- Si es recurrente, habla con tu supervisor

### 🟡 Salida Temprana

**Descripción:**
- Fichaste tu salida antes de la hora permitida (fin - tolerancia)
- Se registra el tiempo de adelanto exacto

**Ejemplo de aviso:**
```
Tipo: Salida temprana
Fecha: 24/10/2025
Turno: 14:00 - 22:00
Comentario: El trabajador ha salido pronto 00:14:40
Tiempo de adelanto: 14 minutos y 40 segundos
```

**Impacto:**
- ⚠️ Queda registrado en tu historial
- 💰 Puede afectar evaluaciones de desempeño
- ⏰ Las horas no trabajadas no se contabilizan para la nómina
- 📊 Afecta estadísticas de cumplimiento

**Qué hacer:**
- Verifica el motivo de la salida temprana
- Si fue necesario, justifícalo con tu supervisor
- Completa tus horas programadas en el futuro

### 🔴 Falta Injustificada

**Descripción:**
- No fichaste entrada ni salida en un turno asignado
- Ausencia completa del puesto de trabajo

**Ejemplo de aviso:**
```
Tipo: Falta injustificada
Fecha: 23/10/2025
Turno: 08:00 - 16:00
Comentario: Falta injustificada de asistencia
Estado: Pendiente de justificación
```

**Impacto:**
- 🔴 Aviso grave en tu historial
- 💵 No se contabilizan horas para la nómina de ese día
- ⚠️ Puede tener consecuencias disciplinarias
- 📊 Afecta significativamente tu porcentaje de asistencia

**Qué hacer:**
1. **Si fue justificada (enfermedad, emergencia)**:
   - Contacta inmediatamente con tu supervisor o RRHH
   - Presenta justificante médico o documentación
   - Solicita que se actualice el estado del aviso

2. **Si fue un error del sistema**:
   - Verifica que fichaste correctamente
   - Contacta con el administrador técnico
   - Proporciona evidencia (emails, testimonios)

3. **Si fue un olvido**:
   - Reconoce el error
   - Toma medidas para evitarlo en el futuro
   - Habla con tu supervisor

## Resumen de Avisos

### Estadísticas Mostradas

En la parte superior de la pantalla verás:

```
📊 Resumen de Avisos

Este mes:
- Total de avisos: 3
- Entradas tardías: 1
- Salidas tempranas: 2
- Faltas injustificadas: 0

Este año:
- Total de avisos: 15
- Entradas tardías: 8
- Salidas tempranas: 6
- Faltas injustificadas: 1

Tasa de asistencia:
- Este mes: 95%
- Este año: 93%
```

### Interpretación de Estadísticas

**Tasa de asistencia:**
```
Tasa = (Turnos completados sin avisos graves / Total turnos) × 100
```

**Colores indicativos:**
- 🟢 Verde (95-100%): Excelente
- 🟡 Amarillo (85-94%): Bueno
- 🟠 Naranja (75-84%): Mejorable
- 🔴 Rojo (<75%): Requiere atención

## Estados del Aviso

Los avisos pueden tener diferentes estados:

### 🆕 Nuevo
- Aviso recién generado
- Aún no has visto los detalles
- Requiere tu atención

### 👁️ Visto
- Ya has consultado el aviso
- No requiere acción adicional
- Permanece en el historial

### ✅ Justificado
- Presentaste justificación válida
- Aceptada por supervisor/RRHH
- No cuenta negativamente en evaluaciones

### ❌ No Justificado
- Sin justificación presentada
- O justificación rechazada
- Cuenta en tu historial laboral

### 🔄 En Revisión
- Justificación en proceso de evaluación
- Esperando decisión del supervisor
- Temporal

## Filtros y Búsqueda

### Filtrar Avisos por Fecha

Puedes filtrar para ver:
- 📅 Este mes
- 📅 Último mes
- 📅 Este año
- 📅 Todo el historial
- 📅 Rango personalizado

### Filtrar por Tipo

Muestra solo:
- 🔴 Entradas tardías
- 🟡 Salidas tempranas
- ❌ Faltas injustificadas

### Filtrar por Estado

Muestra solo:
- 🆕 Nuevos (no vistos)
- ✅ Justificados
- ❌ No justificados
- 🔄 En revisión

## Justificación de Avisos

### Cómo Justificar un Aviso

> [!NOTE]
> La funcionalidad de justificación puede variar según la configuración de tu empresa.

**Proceso general:**

1. **Localiza el aviso** en la tabla
2. **Haz clic en "Justificar"** (si está disponible)
3. **Proporciona información**:
   - Motivo del aviso
   - Documentación de respaldo
   - Fecha del incidente
4. **Adjunta archivos** (si es necesario):
   - Parte médico
   - Documentos oficiales
   - Capturas de pantalla
5. **Envía la justificación**
6. **Espera revisión** del supervisor

**Alternativamente:**
- Contacta directamente con tu supervisor
- Envía documentación por email a RRHH
- Presenta justificantes en persona

## Notificaciones de Avisos

### Recibes notificación cuando:

**Se genera un aviso:**
```
Asunto: Aviso de fichaje - Entrada tardía
Fecha: 25/10/2025
Turno: 08:00 - 16:00
Retraso: 8 minutos
Detalles: Fichaste a las 08:13

Consulta más detalles en My Portal > Avisos
```

**Se actualiza el estado:**
```
Asunto: Estado de aviso actualizado
Tu justificación ha sido: ACEPTADA
Aviso: Entrada tardía del 25/10/2025
Estado anterior: En revisión
Estado actual: Justificado
```

## Impacto de los Avisos

### En tu Nómina

**Entradas tardías:**
- Generalmente no afectan el sueldo
- Se pagan las horas realmente trabajadas
- Ejemplo: Entrar 10 min tarde = -10 min de sueldo

**Salidas tempranas:**
- No se pagan las horas no trabajadas
- Ejemplo: Salir 15 min antes = -15 min de sueldo

**Faltas injustificadas:**
- No se paga ese turno completo
- Puede aplicarse descuento adicional según política
- Ejemplo: Falta de 8h = -8h de sueldo

### En tu Evaluación de Desempeño

Los avisos pueden afectar:
- 📊 Evaluaciones periódicas
- 💰 Bonos por asistencia
- 📈 Promociones internas
- 🏆 Reconocimientos de puntualidad

### En tu Historial Laboral

- Todos los avisos quedan registrados
- Forman parte de tu expediente
- Se consideran en decisiones de RRHH
- Pueden revisarse en auditorías

## Consejos para Evitar Avisos

### Puntualidad en la Entrada

1. ⏰ **Planifica tu llegada** con tiempo extra
2. 🚗 **Considera el tráfico** en tu ruta
3. ⏱️ **Llega 10-15 minutos antes** como margen
4. 📱 **Pon alarmas** para recordatorios
5. 🌤️ **Revisa el clima** el día anterior

### Cumplir el Horario de Salida

1. ⏰ **Conoce tu hora de salida** exacta
2. 📋 **Planifica tu trabajo** para terminar a tiempo
3. 🚫 **No salgas antes** sin autorización
4. 🗣️ **Comunica** si necesitas salir antes
5. ⏱️ **Ficha antes de irte**

### Prevenir Faltas

1. 📅 **Consulta tus turnos** regularmente
2. 🔔 **Activa notificaciones** de turnos
3. 💬 **Comunica ausencias** con antelación
4. 📄 **Presenta justificantes** cuando sea necesario
5. 🤝 **Coordina cambios** con tu supervisor

## Comunicación con Supervisores

### Cuándo contactar a tu supervisor:

- 🏥 **Enfermedad o emergencia**
- 🚗 **Problema de transporte grave**
- 👨‍👩‍👧 **Situación familiar urgente**
- ⚠️ **Error en el sistema de fichaje**
- 📋 **Justificar un aviso**

### Cómo comunicarte:

1. **Lo antes posible**: Idealmente antes del turno
2. **Por múltiples vías**: Email + teléfono
3. **Con detalles**: Explica la situación claramente
4. **Con profesionalismo**: Mantén un tono respetuoso
5. **Con seguimiento**: Confirma que recibieron el mensaje

## Consultar Avisos Antiguos

### Historial Completo

Puedes acceder a:
- 📜 Todos tus avisos desde tu alta
- 📊 Estadísticas por período
- 📈 Evolución temporal
- 🔍 Búsqueda por palabra clave

### Usos del Historial

- **Verificar mejoras**: Ver si has reducido avisos
- **Preparar justificaciones**: Consultar incidentes pasados
- **Revisión anual**: Para evaluaciones de desempeño
- **Auditorías**: Proporcionar información si se requiere

## Privacidad de tus Avisos

### Quién puede ver tus avisos:

- ✅ **Tú**: Acceso completo a tus avisos
- ✅ **Administradores**: Para gestión del sistema
- ✅ **Supervisores directos**: Para evaluaciones
- ✅ **RRHH**: Para expedientes laborales
- ❌ **Otros empleados**: NO tienen acceso

### Protección de datos:

- 🔒 Datos cifrados en la base de datos
- 🔐 Acceso controlado por roles
- 📊 Cumplimiento GDPR
- 🛡️ Auditoría de accesos

## Archivos de Código

**Ubicación**: `/sites/my-portal-avisos.php`  
**Historial**: Integrado con sistema de avisos general

## Siguiente Paso

- [My Portal - Nóminas](./11-my-portal-nominas.md)
- [Sistema de Fichaje](./13-fichaje.md)
- [Gestión de Avisos (Admin)](./07-avisos.md)
- Volver a [My Portal](./08-my-portal.md)
