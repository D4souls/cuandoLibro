# 📅 Gestión de Turnos

## Descripción
La ventana de Gestión de Turnos (Horarios) permite a los administradores crear, modificar y eliminar turnos de trabajo, así como asignar empleados a cada turno.

## Acceso

**URL**: `/sites/horarios.php`  
**Requerido**: Rol de administrador

## Vista Principal

### Elementos de la Interfaz

La pantalla muestra:
- **Título**: "Turnos publicados"
- **Botón "Nuevo turno"**: Para crear nuevos turnos
- **Tabla de turnos**: Lista con todos los turnos programados

### Tabla de Turnos

La tabla muestra las siguientes columnas:

| Columna | Descripción |
|---------|-------------|
| **Fecha** | Día del turno (formato: DD/MM/YYYY) |
| **Hora Inicio** | Hora de inicio del turno (formato: HH:MM) |
| **Hora Fin** | Hora de finalización del turno (formato: HH:MM) |
| **Departamento** | Departamento al que pertenece el turno |
| **Empleados Asignados** | Número de empleados asignados al turno |
| **Acciones** | Botones para editar o eliminar |

## Acciones Disponibles

### 1. Crear Nuevo Turno

**Cómo crear un turno:**

1. Haz clic en el botón **"Nuevo turno"**
2. Se abrirá el formulario de creación de turnos
3. Completa los siguientes campos:

#### Campos del Formulario

##### Datos del Turno

- **Fecha** (requerido)
  - Selecciona la fecha del turno
  - No se pueden crear turnos en fechas pasadas
  - Formato: DD/MM/YYYY

- **Hora de inicio** (requerido)
  - Hora en que comienza el turno
  - Formato: HH:MM (24 horas)
  - Ejemplo: 08:00

- **Hora de fin** (requerido)
  - Hora en que finaliza el turno
  - Debe ser posterior a la hora de inicio
  - Formato: HH:MM (24 horas)
  - Ejemplo: 16:00

- **Departamento** (requerido)
  - Selecciona el departamento desde el desplegable
  - Solo los empleados de este departamento podrán ser asignados

##### Asignación de Empleados

- **Lista de empleados disponibles**
  - Se muestran solo los empleados del departamento seleccionado
  - Incluye: foto, nombre, DNI, categoría
  - Checkboxes para seleccionar múltiples empleados

- **Selección múltiple**
  - Puedes asignar varios empleados al mismo turno
  - Solo aparecen empleados sin turno asignado en esa fecha/hora
  - Los empleados ya ocupados no aparecen en la lista

4. Selecciona los empleados deseados
5. Haz clic en **"Crear turno"**
6. El turno se publicará y los empleados serán notificados

#### Tipos de Turnos

El sistema distingue automáticamente:

- **Turno diurno**: Horario regular (06:00 - 22:00)
  - Se aplica sueldo normal
  
- **Turno nocturno**: Horario especial (22:00 - 06:00)
  - Se aplica sueldo plus
  
- **Turno festivo**: Días festivos
  - Se aplica sueldo plus

### 2. Crear Múltiples Turnos

**Cómo crear varios turnos a la vez:**

El sistema permite crear turnos para varios días consecutivos:

1. En el formulario de creación
2. Marca la opción **"Crear múltiples días"**
3. Selecciona:
   - **Fecha inicio**
   - **Fecha fin**
   - **Hora inicio** (igual para todos los días)
   - **Hora fin** (igual para todos los días)
   - **Departamento**
   - **Empleados** (mismos empleados para todos los días)
4. El sistema creará un turno por cada día en el rango
5. Útil para turnos semanales o mensuales recurrentes

### 3. Editar Turno

**Cómo editar un turno:**

1. En la tabla de turnos, localiza el turno
2. Haz clic en el botón de **editar** (icono de lápiz)
3. Se abrirá el formulario de edición
4. Puedes modificar:
   - **Fecha del turno**
   - **Hora de inicio**
   - **Hora de fin**
   - **Empleados asignados**: Añadir o quitar empleados
5. Haz clic en **"Guardar cambios"**

> [!NOTE]
> Si cambias el departamento del turno:
> - Deberás reasignar los empleados
> - Los empleados del departamento anterior se desasignarán automáticamente

### 4. Eliminar Turno

**Cómo eliminar un turno:**

1. En la tabla de turnos, localiza el turno
2. Haz clic en el botón de **eliminar** (icono de papelera)
3. Aparecerá un diálogo de confirmación
4. Confirma la eliminación
5. El turno se eliminará y los empleados serán notificados

> [!WARNING]
> Al eliminar un turno:
> - Se eliminan todas las asignaciones de empleados
> - Si ya hay fichajes realizados, se crearán avisos de "falta injustificada"
> - No se puede recuperar el turno eliminado

### 5. Asignar/Desasignar Empleados

**Cómo gestionar empleados en un turno:**

1. Edita el turno
2. En la lista de empleados:
   - **Marca el checkbox** para asignar un empleado
   - **Desmarca el checkbox** para desasignar un empleado
3. Los empleados ya asignados aparecen marcados
4. Guarda los cambios

## Sistema de Fichaje

### Control de Entrada y Salida

Los turnos están integrados con el sistema de fichaje:

- **Fichaje de entrada**: El empleado debe fichar al comenzar su turno
- **Fichaje de salida**: El empleado debe fichar al terminar su turno
- **Tolerancia**: Se define un margen de tiempo aceptable
- **Avisos automáticos**: Se generan si hay incidencias

### Estados del Fichaje

- ✅ **Completo**: Entrada y salida fichadas correctamente
- ⚠️ **Entrada tardía**: Fichó después de la hora de inicio (+ tolerancia)
- ⚠️ **Salida temprana**: Fichó antes de la hora de fin (- tolerancia)
- ❌ **Falta injustificada**: No fichó entrada ni salida

Ver más en [Sistema de Fichaje](./13-fichaje.md)

## Visualización de Turnos

### Filtros y Búsqueda

Puedes filtrar turnos por:
- **Fecha específica**
- **Rango de fechas**
- **Departamento**
- **Empleado específico**
- **Estado** (pendiente, completado, con avisos)

### Calendario Visual

El sistema muestra:
- Vista de calendario mensual
- Turnos marcados por día
- Colores según departamento
- Indicadores de empleados asignados

## Integración con Otras Secciones

### Trabajadores
- Solo empleados activos pueden ser asignados
- Se respeta el departamento del empleado
- Ver [Gestión de Trabajadores](./03-trabajadores.md)

### Avisos
- Se generan avisos automáticos por incidencias de fichaje
- Los empleados y administradores son notificados
- Ver [Gestión de Avisos](./07-avisos.md)

### My Portal
- Los empleados ven sus turnos asignados en My Portal
- Pueden consultar horarios futuros
- Ver [My Portal - Horarios](./09-my-portal-horarios.md)

### Nóminas
- Las horas trabajadas (según fichajes) se usan para calcular nóminas
- Se distingue entre horas normales y plus
- Ver [Generación de Nóminas](./14-nominas.md)

## Validaciones del Sistema

El sistema valida:
- ✅ Fecha del turno no puede ser en el pasado (al crear)
- ✅ Hora fin debe ser posterior a hora inicio
- ✅ No se pueden solapar turnos del mismo empleado
- ✅ Departamento debe existir
- ✅ Empleados deben pertenecer al departamento del turno
- ✅ Turno debe tener al menos un empleado asignado

## Ejemplos de Turnos

### Turno de Mañana (Desarrollo)
```
Fecha: 25/10/2025
Hora inicio: 08:00
Hora fin: 14:00
Departamento: Desarrollo
Empleados: Juan (Senior), Pedro (Junior)
Tipo: Turno diurno (sueldo normal)
```

### Turno de Tarde (Diseño)
```
Fecha: 25/10/2025
Hora inicio: 14:00
Hora fin: 22:00
Departamento: Diseño
Empleados: María (UX), Ana (Gráfica)
Tipo: Turno diurno (sueldo normal)
```

### Turno de Noche (Soporte)
```
Fecha: 25/10/2025
Hora inicio: 22:00
Hora fin: 06:00
Departamento: Desarrollo
Empleados: Luis (Soporte)
Tipo: Turno nocturno (sueldo plus)
```

## Flujo de Trabajo Típico

### Programación Semanal

1. **Lunes**: Planificar turnos de la semana siguiente
2. **Crear turnos**: Usar la función de múltiples días
3. **Asignar empleados**: Distribuir equitativamente
4. **Publicar**: Los empleados ven sus turnos en My Portal
5. **Durante la semana**: Empleados fichan entrada/salida
6. **Fin de semana**: Revisar avisos y ajustar si necesario

### Gestión de Cambios

**Empleado no puede asistir:**
1. Editar el turno
2. Desasignar al empleado que no puede asistir
3. Asignar a otro empleado disponible
4. Guardar cambios
5. Ambos empleados reciben notificación

## Notificaciones

El sistema envía notificaciones cuando:
- ✉️ Se crea un turno y se asigna a un empleado
- ✉️ Se modifica un turno existente
- ✉️ Se desasigna a un empleado de un turno
- ✉️ Se elimina un turno
- ⚠️ Se genera un aviso por fichaje incorrecto

## Archivos de Código

**Ubicación**: `/sites/horarios.php`  
**Crear turno**: `/scripts/php/schedule/scheduleAdd.php`  
**Editar turno**: `/scripts/php/schedule/scheduleEdit.php`  
**Funciones**: `/scripts/php/schedule/functionSchedule.php`

## Siguiente Paso

- [Sistema de Fichaje](./13-fichaje.md)
- [Gestión de Avisos](./07-avisos.md)
- [My Portal - Horarios](./09-my-portal-horarios.md)
- [Generación de Nóminas](./14-nominas.md)
