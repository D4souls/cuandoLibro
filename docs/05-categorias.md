# 🏷️ Gestión de Categorías

## Descripción
La ventana de Gestión de Categorías permite administrar las categorías laborales dentro de cada departamento. Las categorías definen los diferentes roles y sus correspondientes sueldos por hora.

## Acceso

**URL**: `/scripts/php/category/categoryEdit.php?id_departamento={id}`  
**Requerido**: Rol de administrador  
**Acceso desde**: Botón "Categorías" en [Gestión de Departamentos](./04-departamentos.md)

## Vista Principal

### Elementos de la Interfaz

La pantalla muestra:
- **Título**: "Categorías de [Nombre del Departamento]"
- **Botón "Nueva categoría"**: Para crear categorías
- **Tabla de categorías**: Lista con todas las categorías del departamento

### Tabla de Categorías

La tabla muestra las siguientes columnas:

| Columna | Descripción |
|---------|-------------|
| **Nombre** | Nombre de la categoría/rol |
| **Sueldo Normal** | Sueldo por hora en horario normal (€/h) |
| **Sueldo Plus** | Sueldo por hora en horario especial (€/h) |
| **Acciones** | Botones para editar o eliminar |

## Acciones Disponibles

### 1. Crear Nueva Categoría

**Cómo crear una categoría:**

1. Accede a las categorías desde un departamento
2. Haz clic en el botón **"Nueva categoría"**
3. Se abrirá el formulario de creación
4. Completa los siguientes campos:

#### Campos Requeridos

- **Nombre de la categoría** (requerido)
  - Ejemplo: "Desarrollador Senior", "Diseñador Junior"
  - Debe ser descriptivo del rol
  - Único dentro del departamento

- **Sueldo Normal (€/h)** (requerido)
  - Tarifa por hora en horario normal
  - Debe ser un número positivo con hasta 2 decimales
  - Ejemplo: 15.00 €/h

- **Sueldo Plus (€/h)** (requerido)
  - Tarifa por hora para turnos especiales (nocturnos, festivos)
  - Generalmente más alto que el sueldo normal
  - Debe ser un número positivo con hasta 2 decimales
  - Ejemplo: 25.00 €/h

5. Haz clic en **"Crear categoría"**
6. La categoría se añadirá al departamento

#### Validaciones

El sistema valida:
- ✅ Nombre de categoría único dentro del departamento
- ✅ Sueldo normal > 0
- ✅ Sueldo plus > 0
- ✅ Recomendado: Sueldo plus ≥ Sueldo normal

### 2. Editar Categoría

**Cómo editar una categoría:**

1. En la tabla de categorías, localiza la categoría
2. Haz clic en el botón de **editar** (icono de lápiz)
3. Se abrirá el formulario de edición
4. Puedes modificar:
   - **Nombre de la categoría**
   - **Sueldo Normal**: Ajustar tarifa horaria
   - **Sueldo Plus**: Ajustar tarifa especial
5. Haz clic en **"Guardar cambios"**

> [!NOTE]
> Al modificar los sueldos de una categoría:
> - Los empleados con esa categoría se verán afectados en las próximas nóminas
> - Las nóminas ya generadas NO se modifican
> - Se recomienda hacer cambios al inicio del mes

### 3. Eliminar Categoría

**Cómo eliminar una categoría:**

1. En la tabla de categorías, localiza la categoría
2. Haz clic en el botón de **eliminar** (icono de papelera)
3. Aparecerá un diálogo de confirmación
4. Confirma la eliminación

> [!WARNING]
> Solo se pueden eliminar categorías que:
> - No tengan empleados asignados
> - No tengan turnos asociados
> 
> Si la categoría tiene empleados:
> 1. Primero reasigna los empleados a otra categoría
> 2. O elimina/modifica los empleados
> 3. Luego podrás eliminar la categoría

## Tipos de Sueldo

### Sueldo Normal
- Se aplica en turnos de horario regular
- Días laborables estándar
- Horarios diurnos habituales

### Sueldo Plus
- Se aplica en turnos especiales:
  - 🌙 Turnos nocturnos
  - 📅 Fines de semana
  - 🎉 Días festivos
  - ⏰ Horarios extraordinarios

El sistema determina automáticamente qué tipo de sueldo aplicar según:
- Hora del turno
- Día de la semana
- Calendario de festivos

## Ejemplos de Categorías

### Departamento de Desarrollo

| Categoría | Sueldo Normal | Sueldo Plus | Descripción |
|-----------|---------------|-------------|-------------|
| Ingeniero de Sistemas Senior | 25.00 €/h | 40.00 €/h | Experto técnico |
| Desarrollador de Software Junior | 15.00 €/h | 25.00 €/h | Desarrollador en formación |
| Ingeniero de Soporte Técnico | 10.00 €/h | 20.00 €/h | Soporte técnico |

### Departamento de Diseño

| Categoría | Sueldo Normal | Sueldo Plus | Descripción |
|-----------|---------------|-------------|-------------|
| Director de Arte | 25.00 €/h | 40.00 €/h | Líder creativo |
| Diseñador UX | 15.00 €/h | 25.00 €/h | Experiencia de usuario |
| Diseñador Gráfico Junior | 12.00 €/h | 20.00 €/h | Diseñador junior |

### Departamento de Testing

| Categoría | Sueldo Normal | Sueldo Plus | Descripción |
|-----------|---------------|-------------|-------------|
| QA Manager | 25.00 €/h | 40.00 €/h | Responsable de calidad |
| Ingeniero de Pruebas Automatizadas | 15.00 €/h | 25.00 €/h | Automatización QA |
| Analista de Pruebas | 12.00 €/h | 20.00 €/h | Testing manual |

## Integración con Otras Secciones

### Trabajadores
- Al crear o editar un empleado, se selecciona su categoría
- La categoría determina el departamento del empleado
- Ver [Gestión de Trabajadores](./03-trabajadores.md)

### Nóminas
- Los sueldos de las categorías se usan para calcular las nóminas
- El sistema calcula: horas_trabajadas × sueldo_por_hora
- Se distingue entre horas normales y horas plus
- Ver [Generación de Nóminas](./14-nominas.md)

### Turnos
- Al crear turnos, se pueden filtrar empleados por categoría
- Útil para asignar turnos específicos a roles específicos
- Ver [Gestión de Turnos](./06-turnos.md)

## Gestión de Jerarquía

### Estructura Organizativa

```
Empresa
  └── Departamento (Desarrollo)
        ├── Categoría (Ingeniero Senior)
        │     └── Empleados (Juan, María)
        ├── Categoría (Desarrollador Junior)
        │     └── Empleados (Pedro, Ana)
        └── Categoría (Soporte Técnico)
              └── Empleados (Luis, Carmen)
```

### Flujo de Creación

1. Primero: Crear [Departamentos](./04-departamentos.md)
2. Segundo: Crear Categorías dentro de cada departamento
3. Tercero: Crear [Trabajadores](./03-trabajadores.md) y asignar categorías
4. Cuarto: Crear [Turnos](./06-turnos.md) y asignar trabajadores

## Cálculo de Nóminas

### Fórmula Básica

```
Sueldo del Mes = (Horas Normales × Sueldo Normal) + (Horas Plus × Sueldo Plus)
```

### Ejemplo de Cálculo

**Trabajador**: Juan Pérez  
**Categoría**: Desarrollador Senior  
**Sueldo Normal**: 15.00 €/h  
**Sueldo Plus**: 25.00 €/h

**Horas trabajadas en el mes:**
- Horas normales: 120 horas
- Horas plus (nocturnas): 20 horas

**Cálculo:**
```
Sueldo = (120 × 15.00) + (20 × 25.00)
Sueldo = 1,800.00 + 500.00
Sueldo Total = 2,300.00 €
```

## Recomendaciones

### Definición de Sueldos
1. **Investiga el mercado**: Compara con sueldos del sector
2. **Define jerarquías claras**: Senior > Mid > Junior
3. **Sueldo plus**: Generalmente 1.5x o 2x el sueldo normal
4. **Revisa periódicamente**: Ajusta según inflación y desempeño

### Organización de Categorías
1. **Nombres descriptivos**: Que reflejen el rol
2. **Niveles claros**: Junior, Mid, Senior, Lead
3. **Evita duplicados**: Una categoría por cada rol específico
4. **Documenta responsabilidades**: Fuera del sistema

## Archivos de Código

**Ubicación**: `/scripts/php/category/categoryEdit.php`  
**Crear categoría**: `/scripts/php/category/categoryAdd.php`  
**Editar categoría**: `/scripts/php/category/userEditCategoryGet.php`  
**Scripts**: `/scripts/php/category/`

## Siguiente Paso

- [Gestión de Trabajadores](./03-trabajadores.md)
- [Gestión de Turnos](./06-turnos.md)
- [Generación de Nóminas](./14-nominas.md)
- Volver a [Departamentos](./04-departamentos.md)
