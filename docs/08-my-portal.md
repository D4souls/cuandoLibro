# 🏠 My Portal - Dashboard Personal

## Descripción
My Portal es el espacio personal de cada empleado donde puede consultar su información laboral, próximos turnos, avisos recibidos y nóminas. Es la pantalla principal después de iniciar sesión como usuario/empleado.

## Acceso

**URL**: `/sites/my-portal.php`  
**Requerido**: Rol de usuario (empleado)

## Vista Principal

### Elementos de la Interfaz

El My Portal muestra:
- **Barra de navegación lateral personalizada**
- **Tarjeta de bienvenida con datos del empleado**
- **Próximos turnos programados**
- **Resumen de información laboral**

## Barra de Navegación Personal

La barra lateral incluye acceso a:

```
╔═══════════════════════════════════════╗
║        🏢 MY PORTAL                   ║
║                                       ║
║  🏠  Dashboard         (esta página) ║
║                                       ║
║  📅  Horarios          → Ver turnos   ║
║                                       ║
║  ⚠️  Avisos            → Ver avisos   ║
║                                       ║
║  💰  Nóminas           → Descargar    ║
║                                       ║
║  ─────────────────────────────────    ║
║                                       ║
║  🚪  Cerrar sesión                    ║
║                                       ║
╚═══════════════════════════════════════╝
```

- **🏠 Dashboard**: Vista principal (página actual)
- **📅 Horarios**: Ver todos tus [turnos programados](./09-my-portal-horarios.md)
- **⚠️ Avisos**: Ver tus [avisos e incidencias](./10-my-portal-avisos.md)
- **💰 Nóminas**: Descargar tus [nóminas mensuales](./11-my-portal-nominas.md)
- **🚪 Cerrar sesión**: Finalizar la sesión actual

### Uso de la Barra

1. **Expandir/Contraer**: Haz clic en el icono de flecha
2. **Navegación**: Haz clic en cualquier opción del menú
3. **Estado visual**: La sección actual se resalta

## Tarjeta de Bienvenida

### Información Mostrada

La tarjeta principal contiene:

- **Foto corporativa**: Tu imagen generada automáticamente
- **Mensaje de bienvenida**: "Bienvenido de nuevo [Tu Nombre]"
- **Información laboral**:
  - 💼 **Departamento**: Departamento al que perteneces
  - 🏷️ **Categoría**: Tu categoría laboral
  - 🕐 **Última conexión**: Fecha y hora de tu último acceso
  - ⏰ **Hora actual**: Hora del sistema

### Foto Corporativa

- Se genera automáticamente al crear tu cuenta
- Contiene tus iniciales
- Color de fondo personalizado
- Formato estándar para todos los empleados

## Próximos Turnos

### Vista de Turnos Próximos

El dashboard muestra:
- **Turnos de los próximos días**
- **Información de cada turno**:
  - 📅 Fecha del turno
  - 🕐 Hora de inicio
  - 🕐 Hora de fin
  - 💼 Departamento
  - ⏱️ Duración total

### Estados del Turno

Los turnos pueden tener diferentes estados:

- ⏳ **Pendiente**: Aún no ha llegado la fecha
- ✅ **Completado**: Ya fichaste entrada y salida correctamente
- ⚠️ **Con avisos**: Hay incidencias registradas
- ❌ **Incompleto**: Falta fichar o hay errores

### Información Visual

Cada turno muestra:
```
📅 25/10/2025
🕐 08:00 - 16:00
💼 Desarrollo
⏱️ 8 horas
```

## Acciones Disponibles

### 1. Ver Información Personal

**Desde la tarjeta de perfil:**
- Consulta tus datos básicos
- Verifica tu departamento y categoría
- Comprueba tu última conexión

### 2. Consultar Próximos Turnos

**Desde el dashboard:**
- Visualiza tus próximos turnos programados
- Planifica tu semana
- Conoce tu horario del mes

**Para ver todos los turnos:**
- Haz clic en **"Horarios"** en el menú
- Ver [My Portal - Horarios](./09-my-portal-horarios.md)

### 3. Revisar Avisos

**Desde el dashboard:**
- Ve un resumen de avisos recientes
- Identifica si tienes incidencias pendientes

**Para ver todos los avisos:**
- Haz clic en **"Avisos"** en el menú
- Ver [My Portal - Avisos](./10-my-portal-avisos.md)

### 4. Acceder a Nóminas

**Para descargar tus nóminas:**
- Haz clic en **"Nóminas"** en el menú
- Ver [My Portal - Nóminas](./11-my-portal-nominas.md)

### 5. Editar Perfil

**Para actualizar tus datos personales:**
1. Haz clic en tu tarjeta de perfil
2. Se abrirá el formulario de edición
3. Puedes modificar:
   - 📧 Email
   - 📱 Teléfono
   - 🏠 Dirección
   - 🔑 Contraseña

> [!NOTE]
> No puedes modificar:
> - DNI (dato identificativo único)
> - Departamento (solo administradores)
> - Categoría (solo administradores)
> - Usuario de acceso

## Información Laboral

### Datos que Puedes Consultar

En My Portal tienes acceso a:
- ✅ Tus datos personales y laborales
- ✅ Historial completo de turnos
- ✅ Avisos e incidencias propias
- ✅ Nóminas mensuales
- ✅ Estadísticas personales

### Datos que NO Puedes Ver

Por privacidad y seguridad, NO puedes ver:
- ❌ Datos de otros empleados
- ❌ Turnos de otros empleados
- ❌ Avisos de otros empleados
- ❌ Configuración del sistema
- ❌ Gestión de departamentos

## Sistema de Fichaje

### Cómo Fichar

> [!IMPORTANT]
> El sistema de fichaje debe estar configurado por el administrador.
> Generalmente se accede desde:
> - Terminal física en la empresa
> - Aplicación móvil
> - Portal web específico

### Control de Asistencia

El sistema controla:
- ⏰ **Hora de entrada**: Debes fichar al llegar
- ⏰ **Hora de salida**: Debes fichar al marcharte
- ⚠️ **Tolerancia**: Hay un margen de tiempo permitido
- 📧 **Notificaciones**: Recibes avisos si hay incidencias

Ver más en [Sistema de Fichaje](./13-fichaje.md)

## Notificaciones

### Recibes notificaciones cuando:

- ✉️ **Nuevo turno asignado**: Email con detalles del turno
- ✉️ **Turno modificado**: Cambios en horario o asignación
- ✉️ **Turno eliminado**: Cancelación de un turno
- ⚠️ **Aviso generado**: Incidencia en fichaje
- 💰 **Nómina disponible**: Nueva nómina lista para descargar

### Configuración de Notificaciones

Las notificaciones se envían a:
- Tu email corporativo registrado
- Pueden verse también dentro de My Portal

## Diseño Responsive

My Portal está optimizado para:
- 📱 Teléfonos móviles
- 📱 Tablets
- 💻 Ordenadores de escritorio

Puedes acceder desde cualquier dispositivo con conexión a internet.

## Seguridad y Privacidad

### Protección de tu Cuenta

- 🔒 **Contraseña cifrada**: Tu contraseña está encriptada
- 🔐 **Sesión segura**: Control de inactividad
- 👤 **Acceso privado**: Solo tú ves tu información
- 📊 **Auditoría**: Se registran accesos para seguridad

### Recomendaciones de Seguridad

1. **Cambia tu contraseña temporal** tras el primer acceso
2. **No compartas tus credenciales** con nadie
3. **Cierra sesión** al terminar, especialmente en equipos compartidos
4. **Verifica la URL** antes de introducir tus credenciales
5. **Contacta al administrador** si detectas actividad sospechosa

## Cambio de Contraseña

### Cómo cambiar tu contraseña:

1. Accede a editar perfil (clic en tu tarjeta)
2. Introduce tu **contraseña actual**
3. Introduce tu **nueva contraseña**
4. Confirma la **nueva contraseña**
5. Haz clic en **"Guardar cambios"**

### Requisitos de Contraseña:

- Mínimo 8 caracteres
- Combinar mayúsculas y minúsculas (recomendado)
- Incluir números (recomendado)
- Incluir caracteres especiales (recomendado)

> [!TIP]
> Usa una contraseña segura y diferente a otras cuentas personales.

## Recuperación de Contraseña

Si olvidaste tu contraseña:
1. **Contacta con el administrador**
2. El administrador puede **restablecer tu contraseña**
3. Recibirás un **email con la nueva contraseña temporal**
4. **Cámbiala** en tu primer inicio de sesión

## Primera Vez en My Portal

### Pasos iniciales:

1. ✅ **Recibe credenciales**: Por email al ser dado de alta
2. ✅ **Inicia sesión**: Con usuario y contraseña temporal
3. ✅ **Cambia tu contraseña**: Pon una contraseña segura personal
4. ✅ **Actualiza tu perfil**: Verifica y completa tus datos
5. ✅ **Explora My Portal**: Familiarízate con las secciones
6. ✅ **Consulta tus turnos**: Revisa tu calendario

## Flujo de Trabajo Típico

### Uso Diario de My Portal

**Por la mañana:**
1. Inicia sesión en My Portal
2. Consulta tu turno del día
3. Verifica la hora de inicio
4. Ficha tu entrada puntualmente

**Durante el día:**
- Consulta si hay cambios en turnos
- Revisa notificaciones

**Al finalizar:**
1. Ficha tu salida
2. Verifica que no hay avisos
3. Cierra sesión

**Mensualmente:**
1. Descarga tu nómina
2. Revisa tus horas trabajadas
3. Verifica que todo es correcto

## Soporte y Ayuda

### Si tienes dudas:

- 📧 **Email**: Contacta al administrador
- 👥 **Recursos Humanos**: Consulta políticas de la empresa
- 📚 **Documentación**: Revisa esta documentación

### Problemas Comunes:

- **No puedo iniciar sesión**: Verifica usuario y contraseña, contacta al admin
- **No veo mis turnos**: Espera a que te asignen turnos o contacta al admin
- **No puedo descargar mi nómina**: Verifica que se haya generado, contacta al admin

## Tecnologías Utilizadas

- **PHP**: Backend y gestión de sesiones
- **HTML/CSS**: Estructura y diseño
- **Tailwind CSS**: Estilos responsive
- **JavaScript**: Interactividad
- **Boxicons**: Iconografía

## Archivos de Código

**Ubicación**: `/sites/my-portal.php`  
**Edición de perfil**: `/scripts/php/userEdit/myportlaEdit.php`  
**Guardar cambios**: `/scripts/php/userEdit/myPortalSave.php`

## Siguiente Paso

Explora las demás secciones de My Portal:
- [My Portal - Horarios](./09-my-portal-horarios.md)
- [My Portal - Avisos](./10-my-portal-avisos.md)
- [My Portal - Nóminas](./11-my-portal-nominas.md)
