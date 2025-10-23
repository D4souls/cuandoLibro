# 💼 Gestión de Departamentos

## Descripción
La ventana de Gestión de Departamentos permite administrar todos los departamentos de la empresa, incluyendo la creación, edición, eliminación y control de presupuestos y gastos.

## Acceso

**URL**: `/sites/departamentos.php`  
**Requerido**: Rol de administrador

## Vista Principal

### Elementos de la Interfaz

La pantalla muestra:
- **Título**: "Departamentos"
- **Botón "Nuevo departamento"**: Para crear departamentos
- **Tabla de departamentos**: Lista con todos los departamentos existentes

### Tabla de Departamentos

La tabla muestra las siguientes columnas:

| Columna | Descripción |
|---------|-------------|
| **Nombre** | Nombre del departamento |
| **Presupuesto** | Presupuesto total asignado (en €) |
| **Gastos** | Gastos acumulados del departamento (en €) |
| **Categorías** | Botón para gestionar categorías del departamento |
| **Acciones** | Botones para editar o eliminar |

## Acciones Disponibles

### 1. Crear Nuevo Departamento

**Cómo crear un departamento:**

1. Haz clic en el botón **"Nuevo departamento"**
2. Se abrirá el formulario de creación
3. Completa los siguientes campos:

#### Campos Requeridos
- **Nombre del departamento** (requerido)
  - Ejemplo: "Desarrollo", "Diseño", "Testing"
  - Debe ser único en el sistema
  
- **Presupuesto inicial** (requerido)
  - Cantidad en euros (€)
  - Ejemplo: 50000.00
  - Debe ser un número positivo

- **Gastos iniciales** (opcional)
  - Por defecto: 0.00 €
  - Se puede especificar si ya hay gastos previos

4. Haz clic en **"Crear departamento"**
5. El departamento se añadirá al sistema

### 2. Editar Departamento

**Cómo editar un departamento:**

1. En la tabla de departamentos, localiza el departamento
2. Haz clic en el botón de **editar** (icono de lápiz)
3. Se abrirá el formulario de edición
4. Puedes modificar:
   - **Nombre del departamento**
   - **Presupuesto**: Aumentar o disminuir el presupuesto
   - **Gastos**: Actualizar los gastos acumulados
5. Haz clic en **"Guardar cambios"**

#### Control de Presupuesto

El sistema controla:
- ✅ Los gastos **no pueden superar** el presupuesto
- ✅ Se muestra una **alerta visual** si los gastos están cerca del límite
- ✅ Se calcula automáticamente el **presupuesto disponible**

### 3. Eliminar Departamento

**Cómo eliminar un departamento:**

1. En la tabla de departamentos, localiza el departamento
2. Haz clic en el botón de **eliminar** (icono de papelera)
3. Aparecerá un diálogo de confirmación
4. Confirma la eliminación

> [!WARNING]
> Solo se pueden eliminar departamentos que:
> - No tengan empleados asignados
> - No tengan turnos activos
> - No tengan categorías asociadas
> 
> Si el departamento tiene datos asociados, primero deberás:
> 1. Reasignar o eliminar los empleados
> 2. Eliminar las categorías del departamento
> 3. Eliminar los turnos asociados

### 4. Gestionar Categorías

**Cómo gestionar las categorías de un departamento:**

1. En la tabla de departamentos, localiza el departamento
2. Haz clic en el botón **"Categorías"**
3. Serás redirigido a la [Gestión de Categorías](./05-categorias.md) del departamento
4. Desde ahí podrás:
   - Ver todas las categorías del departamento
   - Crear nuevas categorías
   - Editar categorías existentes
   - Eliminar categorías
   - Asignar sueldos por hora

## Gestión de Presupuesto

### Visualización de Presupuesto

Para cada departamento se muestra:
- **Presupuesto total**: Cantidad asignada
- **Gastos acumulados**: Cantidad gastada
- **Presupuesto disponible**: Calculado automáticamente
  ```
  Disponible = Presupuesto Total - Gastos
  ```

### Cómo Funciona el Control de Gastos

Los gastos de un departamento incluyen:
- **Nóminas de empleados**: Sueldos calculados por hora
- **Gastos extraordinarios**: Registrados manualmente

El sistema actualiza automáticamente los gastos cuando:
- Se generan las nóminas mensuales
- Se registran gastos adicionales desde el departamento

### Indicadores Visuales

El Dashboard muestra gráficos con:
- Barras de presupuesto por departamento
- Barras de gastos por departamento
- Colores distintivos para cada departamento

## Integración con Otras Secciones

### Trabajadores
- Los empleados se asignan a departamentos
- Al crear un trabajador, se debe seleccionar su departamento
- Ver [Gestión de Trabajadores](./03-trabajadores.md)

### Categorías
- Cada departamento tiene múltiples categorías
- Las categorías definen roles y sueldos
- Ver [Gestión de Categorías](./05-categorias.md)

### Turnos
- Los turnos se crean por departamento
- Solo los empleados del departamento pueden ser asignados
- Ver [Gestión de Turnos](./06-turnos.md)

## Validaciones

El sistema valida:
- ✅ **Nombre único**: No puede haber dos departamentos con el mismo nombre
- ✅ **Presupuesto positivo**: El presupuesto debe ser mayor que 0
- ✅ **Gastos no negativos**: Los gastos no pueden ser negativos
- ✅ **Gastos ≤ Presupuesto**: Se recomienda que los gastos no superen el presupuesto

## Ejemplos de Departamentos

### Departamento de Desarrollo
```
Nombre: Desarrollo
Presupuesto: 75,000.00 €
Gastos: 45,230.50 €
Categorías:
  - Ingeniero de Sistemas Senior (25€/h normal, 40€/h plus)
  - Desarrollador de Software Junior (15€/h normal, 25€/h plus)
  - Ingeniero de Soporte Técnico (10€/h normal, 20€/h plus)
```

### Departamento de Diseño
```
Nombre: Diseño
Presupuesto: 50,000.00 €
Gastos: 32,100.00 €
Categorías:
  - Director de Arte (25€/h normal, 40€/h plus)
  - Diseñador UX (15€/h normal, 25€/h plus)
  - Diseñador Gráfico Junior (12€/h normal, 20€/h plus)
```

### Departamento de Testing
```
Nombre: Testing
Presupuesto: 40,000.00 €
Gastos: 28,500.00 €
Categorías:
  - QA Manager (25€/h normal, 40€/h plus)
  - Ingeniero de Pruebas Automatizadas (15€/h normal, 25€/h plus)
  - Analista de Pruebas (12€/h normal, 20€/h plus)
```

## Reportes

Desde el Dashboard puedes ver:
- Gráfico comparativo de presupuestos
- Gráfico de gastos por departamento
- Porcentaje de presupuesto utilizado

## Archivos de Código

**Ubicación**: `/sites/departamentos.php`  
**Crear departamento**: `/scripts/php/departmentAdd/departmentAdd.php`  
**Editar departamento**: `/scripts/php/departmentEdit/departmentEdit.php`  
**Eliminar departamento**: `/scripts/php/departmentEdit/departmentDelete.php`  
**Guardar cambios**: `/scripts/php/departmentEdit/departmentSave.php`

## Siguiente Paso

- [Gestión de Categorías](./05-categorias.md)
- [Gestión de Trabajadores](./03-trabajadores.md)
- [Dashboard](./02-dashboard.md)
