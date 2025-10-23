# 📊 Dashboard Administrativo

## Descripción
El Dashboard es la pantalla principal para los administradores después de iniciar sesión. Proporciona una vista general del estado de la empresa con información estadística y gráficos.

## Acceso

**URL**: `/sites/dashboard.php`  
**Requerido**: Rol de administrador

## Componentes del Dashboard

### 1. Información del Usuario Conectado

Muestra una tarjeta con:
- **Foto del usuario**: Imagen corporativa generada automáticamente
- **Mensaje de bienvenida**: "Bienvenido de nuevo [Nombre]"
- **Departamento**: Departamento al que pertenece el administrador
- **Categoría**: Categoría laboral del administrador
- **Última conexión**: Fecha y hora del último cierre de sesión

### 2. Gráfico de Departamentos

Visualización gráfica que muestra:
- **Presupuesto por departamento**: Cantidad asignada a cada departamento
- **Gastos por departamento**: Gastos acumulados
- **Colores aleatorios**: Cada departamento tiene un color distintivo

**Interacción**: Al hacer clic en el gráfico, te redirige a la [Gestión de Departamentos](./04-departamentos.md)

### 3. Estadísticas de Empleados

Muestra:
- **Total de empleados**: Cantidad total de trabajadores en el sistema
- **Iconos visuales**: Representación gráfica de los empleados

### 4. Estadísticas de Avisos

Presenta:
- **Cantidad de avisos**: Número total de avisos en el sistema
- **Tipos de avisos**: Clasificación de avisos por tipo

## Barra de Navegación Lateral

El Dashboard incluye una barra lateral con acceso rápido a:

- **🏠 Dashboard**: Vuelve a la vista principal (página actual)
- **📅 Horarios**: Accede a la [Gestión de Turnos](./06-turnos.md)
- **👥 Trabajadores**: Accede a la [Gestión de Trabajadores](./03-trabajadores.md)
- **💼 Departamentos**: Accede a la [Gestión de Departamentos](./04-departamentos.md)
- **⚠️ Avisos**: Accede a la [Gestión de Avisos](./07-avisos.md)
- **🚪 Cerrar sesión**: Cierra la sesión actual

### Uso de la Barra Lateral

1. **Expandir/Contraer**: Haz clic en el icono de flecha para expandir o contraer el menú
2. **Navegación**: Haz clic en cualquier opción para navegar a esa sección
3. **Estado visual**: La página actual se resalta en el menú

## Visualización de Datos

### Gráficos Interactivos

El Dashboard utiliza **Chart.js** para crear gráficos dinámicos:
- Gráficos de barras para presupuestos y gastos
- Actualización en tiempo real con datos de la base de datos

### Tarjetas Informativas

Todas las tarjetas del Dashboard son:
- **Interactivas**: Se pueden hacer clic para obtener más detalles
- **Responsive**: Se adaptan a diferentes tamaños de pantalla
- **Animadas**: Efecto hover al pasar el ratón

## Acciones Rápidas

Desde el Dashboard puedes:

1. **Ver tu perfil**: Haz clic en tu tarjeta de usuario
2. **Gestionar departamentos**: Haz clic en el gráfico de departamentos
3. **Acceder a cualquier sección**: Usa el menú lateral

## Diseño Responsive

El Dashboard está diseñado con **Tailwind CSS** y se adapta a:
- 📱 Dispositivos móviles
- 📱 Tablets
- 💻 Pantallas de escritorio

### Distribución en Diferentes Dispositivos

- **Móvil (sm)**: 1 columna
- **Tablet y Escritorio (md)**: 3 columnas, 4 filas

## Tecnologías Utilizadas

- **PHP**: Backend y lógica de negocio
- **Chart.js**: Visualización de gráficos
- **Tailwind CSS**: Diseño y estilos
- **Boxicons**: Iconografía
- **JavaScript**: Interactividad

## Permisos Requeridos

Para acceder al Dashboard necesitas:
- ✅ Sesión iniciada
- ✅ Rol de administrador
- ✅ Credenciales válidas

## Siguiente Paso

Desde aquí puedes navegar a:
- [Gestión de Trabajadores](./03-trabajadores.md)
- [Gestión de Departamentos](./04-departamentos.md)
- [Gestión de Turnos](./06-turnos.md)

## Archivo de Código

**Ubicación**: `/sites/dashboard.php`  
**Estilos**: `/css/dashboard.css`  
**Scripts**: `/scripts/js/dashboard.js`
