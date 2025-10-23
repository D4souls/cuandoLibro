# 👥 Gestión de Trabajadores

## Descripción
La ventana de Gestión de Trabajadores permite a los administradores gestionar todos los empleados de la empresa: dar de alta nuevos trabajadores, modificar datos, eliminar empleados y ver su historial.

## Acceso

**URL**: `/sites/trabajadores.php`  
**Requerido**: Rol de administrador

## Vista Principal

### Elementos de la Interfaz

La pantalla muestra:
- **Título**: "Trabajadores"
- **Botón "Agregar empleado"**: Para dar de alta nuevos trabajadores
- **Tabla de trabajadores**: Lista con todos los empleados

### Tabla de Trabajadores

La tabla muestra las siguientes columnas:

| Columna | Descripción |
|---------|-------------|
| **DNI** | Documento de identidad del trabajador (parcialmente oculto por seguridad) |
| **Nombre** | Nombre completo del empleado |
| **Teléfono** | Número de teléfono de contacto |
| **Email** | Correo electrónico |
| **Departamento** | Departamento asignado |
| **Categoría** | Categoría laboral dentro del departamento |
| **Acciones** | Botones para gestionar al trabajador |

## Acciones Disponibles

### 1. Agregar Nuevo Empleado

**Cómo agregar un empleado:**

1. Haz clic en el botón **"Agregar empleado"** (icono de usuario con +)
2. Serás redirigido al formulario de alta de trabajador
3. Completa todos los campos requeridos:

#### Datos Personales
- **DNI** (requerido): Documento de identidad único
- **Nombre** (requerido): Nombre completo
- **Teléfono** (requerido): Número de contacto
- **Email** (requerido): Correo electrónico corporativo
- **Dirección** (opcional): Dirección completa
- **Fecha de nacimiento** (requerido)

#### Datos Laborales
- **Departamento** (requerido): Selecciona de la lista desplegable
- **Categoría** (requerido): Selecciona según el departamento
- **IBAN** (requerido): Cuenta bancaria para nóminas
  - Puedes usar el generador automático de IBAN
- **Número de Seguridad Social** (requerido)

#### Credenciales de Acceso
- **Usuario** (requerido): Nombre de usuario para el sistema
- El sistema genera automáticamente:
  - Una contraseña temporal
  - Una foto corporativa
  - Un directorio personal

4. Haz clic en **"Guardar"**
5. El sistema enviará automáticamente un email con las credenciales

#### Generación Automática

Al crear un empleado, el sistema automáticamente:
- ✅ Genera una **contraseña temporal cifrada**
- ✅ Crea una **fotografía corporativa** con las iniciales del empleado
- ✅ Crea un **directorio personal** para documentos
- ✅ Envía un **email con las credenciales** de acceso
- ✅ Asigna el rol de **usuario** (no administrador)

### 2. Editar Empleado

**Cómo editar un empleado:**

1. En la tabla de trabajadores, localiza al empleado
2. Haz clic en el botón de **editar** (icono de lápiz)
3. Modifica los campos necesarios:
   - Datos personales
   - Datos laborales
   - Cambio de departamento
   - Cambio de categoría
4. Haz clic en **"Guardar cambios"**

> [!NOTE]
> No se puede modificar el DNI una vez creado el empleado.

### 3. Eliminar Empleado

**Cómo eliminar un empleado:**

1. En la tabla de trabajadores, localiza al empleado
2. Haz clic en el botón de **eliminar** (icono de papelera)
3. Confirma la acción en el diálogo de confirmación
4. El empleado será dado de baja del sistema

> [!WARNING]
> Esta acción eliminará todos los datos asociados al empleado, incluyendo:
> - Turnos asignados
> - Avisos históricos
> - Nóminas generadas
> - Fotografía corporativa

### 4. Acceder a My Portal

**Cómo acceder al portal del empleado:**

1. En la tabla de trabajadores, localiza al empleado
2. Haz clic en el botón de **portal** (icono de entrada)
3. Accederás al My Portal del empleado
4. Podrás ver su información personal desde la perspectiva del empleado

### 5. Ver Historial de Avisos

**Cómo ver el historial:**

1. En la tabla de trabajadores, localiza al empleado
2. Haz clic en el botón de **historial** (icono de reloj)
3. Verás todos los avisos asociados al empleado:
   - Entradas tardías
   - Salidas tempranas
   - Faltas injustificadas

### 6. Restablecer Contraseña

**Cómo restablecer la contraseña:**

1. En la pantalla de edición del empleado
2. Haz clic en **"Restablecer contraseña"**
3. El sistema generará una nueva contraseña temporal
4. Se enviará por email al trabajador

## Búsqueda y Filtros

La tabla de trabajadores incluye funcionalidades de búsqueda:
- Búsqueda por DNI
- Búsqueda por nombre
- Filtro por departamento
- Filtro por categoría

## Validaciones

El sistema valida:
- ✅ **DNI único**: No puede haber dos empleados con el mismo DNI
- ✅ **Email único**: Cada empleado debe tener un email diferente
- ✅ **Usuario único**: No puede repetirse el nombre de usuario
- ✅ **Formato de email**: Debe ser un email válido
- ✅ **Formato de teléfono**: Debe ser un número válido
- ✅ **Formato de IBAN**: Debe cumplir el formato estándar

## Seguridad

### Protección de Datos
- Los DNI se muestran **parcialmente ocultos** (ej: ****1111A)
- Las contraseñas están **cifradas** en la base de datos
- Solo los administradores pueden acceder a esta sección

### Control de Sesión
- Se verifica la sesión activa del administrador
- Se previenen accesos no autorizados mediante `seguridad.php`

## Flujo de Trabajo Típico

### Dar de Alta a un Nuevo Empleado

1. Dashboard → Trabajadores
2. Clic en "Agregar empleado"
3. Completar formulario con todos los datos
4. Sistema genera credenciales y foto
5. Email automático enviado al empleado
6. Empleado puede iniciar sesión con sus credenciales

### Cambiar Departamento de un Empleado

1. Buscar empleado en la tabla
2. Clic en botón de editar
3. Seleccionar nuevo departamento
4. Seleccionar nueva categoría (según departamento)
5. Guardar cambios
6. Los turnos y avisos se actualizan automáticamente

## Archivos de Código

**Ubicación**: `/sites/trabajadores.php`  
**Alta de trabajador**: `/scripts/php/userAdd/alta-trabajador.php`  
**Edición**: `/scripts/php/userEdit/userEdit.php`  
**Eliminación**: `/scripts/php/userEdit/userDelete.php`  
**Historial**: `/scripts/php/userEdit/historial-avisos.php`

## Siguiente Paso

- [Gestión de Departamentos](./04-departamentos.md)
- [Gestión de Categorías](./05-categorias.md)
- [Dashboard](./02-dashboard.md)
