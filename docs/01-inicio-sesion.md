# 🔐 Inicio de Sesión

## Descripción
La pantalla de inicio de sesión es el punto de entrada a la aplicación CuandoLibro. Todos los usuarios (administradores y empleados) deben autenticarse para acceder al sistema.

## Acceso

**URL**: `/index.php` (página principal)

## Interfaz de Usuario

![Pantalla de inicio de sesión](../img/loginPage.jpg)

La pantalla de inicio de sesión contiene:
- **Logo de la aplicación**: CuandoLibro
- **Campo de Usuario**: Donde se introduce el nombre de usuario o DNI
- **Campo de Contraseña**: Para introducir la contraseña del usuario
- **Botón "Acceder"**: Para enviar las credenciales

## Cómo Iniciar Sesión

1. **Accede a la aplicación** abriendo la URL en tu navegador
2. **Introduce tu usuario** en el campo "Usuario..."
   - Puede ser tu nombre de usuario o DNI
3. **Introduce tu contraseña** en el campo "Contraseña..."
4. **Haz clic en "Acceder"**

## Tipos de Usuario

### Administrador
- Tiene acceso completo a todas las funcionalidades
- Puede gestionar trabajadores, departamentos, categorías, turnos y avisos
- Accede al Dashboard administrativo

### Usuario/Empleado
- Tiene acceso limitado a su portal personal (My Portal)
- Puede ver sus horarios, avisos y nóminas
- No puede gestionar otros usuarios ni configuraciones

## Credenciales Temporales

Cuando un administrador da de alta a un nuevo trabajador:
- El sistema **genera automáticamente credenciales temporales**
- Las credenciales se envían al correo electrónico del trabajador
- Se recomienda cambiar la contraseña en el primer inicio de sesión

## Seguridad

El sistema incluye varias medidas de seguridad:
- **Cifrado de contraseñas**: Todas las contraseñas están cifradas en la base de datos
- **Control de sesiones**: Se gestiona la inactividad del usuario
- **Control de acceso por rol**: Usuarios y administradores tienen diferentes permisos
- **Mensajes de error**: Se muestran mensajes si las credenciales son incorrectas

## Mensajes de Error

Si introduces credenciales incorrectas, verás un mensaje de error en rojo indicando el problema.

## Recuperación de Contraseña

> [!NOTE]
> La funcionalidad de recuperación de contraseña está comentada en el código actual. Si necesitas recuperar tu contraseña, contacta con el administrador del sistema.

## Siguiente Paso

Después de iniciar sesión:
- **Administradores**: Serán redirigidos al [Dashboard](./02-dashboard.md)
- **Empleados**: Serán redirigidos a [My Portal](./08-my-portal.md)

## Archivo de Código

**Ubicación**: `/index.php`
**Script de control**: `/scripts/php/seguridad/control.php`
