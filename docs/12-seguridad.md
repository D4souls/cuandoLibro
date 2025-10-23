# 🔒 Sistema de Seguridad

## Descripción
CuandoLibro incluye un robusto sistema de seguridad que protege los datos de la empresa y garantiza el correcto funcionamiento de la aplicación.

## Componentes de Seguridad

### 1. Autenticación de Usuarios

#### Control de Acceso

**Archivo**: `/scripts/php/seguridad/control.php`

El sistema verifica:
- ✅ **Usuario válido**: Existe en la base de datos
- ✅ **Contraseña correcta**: Coincide con la almacenada (cifrada)
- ✅ **Cuenta activa**: El usuario no está dado de baja

**Proceso de login:**
```
1. Usuario introduce credenciales
2. Sistema busca usuario en BD
3. Verifica contraseña cifrada
4. Crea sesión PHP
5. Redirige según rol (admin/usuario)
```

#### Cifrado de Contraseñas

**Tecnología**: Password hashing de PHP

- Las contraseñas se almacenan **cifradas** en la base de datos
- Se usa `password_hash()` con algoritmo bcrypt
- **No se pueden recuperar** las contraseñas originales
- Solo se pueden **restablecer** (generar nueva contraseña)

**Ejemplo del proceso:**
```php
// Al crear contraseña
$password = "MiContraseña123";
$hash = password_hash($password, PASSWORD_DEFAULT);
// Resultado en BD: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa...

// Al verificar login
password_verify($password_introducida, $hash_en_bd);
// Retorna true si coinciden
```

### 2. Gestión de Sesiones

#### Control de Sesión Activa

**Archivo**: `/scripts/php/seguridad/seguridad.php`

Todas las páginas protegidas incluyen:
```php
<?php
include_once('../scripts/php/seguridad/seguridad.php');
?>
```

Este archivo:
- ✅ Inicia la sesión PHP si no existe
- ✅ Verifica que el usuario esté autenticado
- ✅ Redirige al login si no hay sesión
- ✅ Previene acceso no autorizado

#### Inactividad

El sistema controla la inactividad:
- **Tiempo de sesión**: Configurable (por defecto 30 minutos)
- **Cierre automático**: Si no hay actividad
- **Última actividad**: Se registra en cada acción

**Variables de sesión:**
```php
$_SESSION['userwebdni']     // DNI del usuario conectado
$_SESSION['rol']            // Rol: 'admin' o 'usuario'
$_SESSION['last_activity']  // Timestamp última actividad
```

### 3. Control de Acceso por Rol

#### Roles del Sistema

**Administrador:**
- Acceso completo a todas las funcionalidades
- Gestión de trabajadores, departamentos, categorías
- Gestión de turnos y avisos
- Acceso al Dashboard administrativo
- Visualización de todos los datos

**Usuario/Empleado:**
- Acceso limitado a My Portal
- Solo puede ver sus propios datos
- No puede gestionar otros usuarios
- No puede modificar configuración

#### Verificación de Permisos

En cada página se verifica:
```php
if ($_SESSION['rol'] != 'admin') {
    header("Location: ../../../index.php?error=No tienes permisos");
    exit();
}
```

### 4. Protección contra Ataques

#### SQL Injection

**Prevención:**
- ✅ Uso de **prepared statements**
- ✅ Todas las consultas usan parámetros enlazados
- ✅ Nunca se concatena entrada del usuario en queries

**Ejemplo seguro:**
```php
$stmt = $conexion->prepare("SELECT * FROM trabajadores WHERE dni = ?");
$stmt->bind_param("s", $dni);
$stmt->execute();
```

**Ejemplo INSEGURO (NO usado):**
```php
// ❌ NUNCA hacer esto
$query = "SELECT * FROM trabajadores WHERE dni = '$dni'";
```

#### XSS (Cross-Site Scripting)

**Prevención:**
- ✅ Escapado de HTML en salidas
- ✅ Uso de `htmlspecialchars()`
- ✅ Validación de entradas

**Ejemplo:**
```php
echo htmlspecialchars($nombre_usuario);
```

#### CSRF (Cross-Site Request Forgery)

**Prevención:**
- ✅ Tokens en formularios (recomendado implementar)
- ✅ Verificación de origen de peticiones
- ✅ Uso de métodos HTTP apropiados (POST para modificaciones)

#### Control de Peticiones AJAX

El sistema controla que las peticiones AJAX:
- Provengan de sesiones válidas
- Incluyan datos válidos
- Respeten los permisos del usuario

### 5. Protección de Datos Sensibles

#### Privacidad de DNI

Los DNI se muestran **parcialmente ocultos**:
```php
// Muestra: ****1111A en lugar de 11111111A
substr_replace($dni, str_repeat("*", 4), 0, 4)
```

#### Datos Personales

- 📧 **Emails**: Solo visibles para el usuario y administradores
- 📱 **Teléfonos**: Protegidos en la visualización
- 💰 **Datos bancarios**: Cifrados en almacenamiento
- 📊 **Nóminas**: Solo accesibles por el empleado propietario

#### Cumplimiento GDPR

El sistema cumple con la normativa de protección de datos:
- ✅ Datos almacenados de forma segura
- ✅ Acceso controlado por roles
- ✅ Registro de accesos (auditoría)
- ✅ Derecho al olvido (eliminación de datos)
- ✅ Portabilidad de datos

### 6. Conexión a Base de Datos

#### Archivo de Conexión

**Ubicación**: `/scripts/php/seguridad/conexion.php`

```php
<?php
$host = "localhost";
$user = "usuario_bd";
$password = "contraseña_bd";
$database = "fichajedb";

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
```

#### Configuración Segura

**Archivo**: `/config.php` (si existe)

- Almacena credenciales fuera del código
- Variables de entorno para producción
- No incluir en control de versiones
- Permisos restringidos en el servidor

**Recomendaciones:**
```php
// config.php
<?php
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'fichajedb');
?>
```

### 7. Cerrar Sesión

#### Proceso de Cierre

**Archivo**: `/scripts/php/seguridad/cerrarSesion.php`

Al cerrar sesión:
1. Se registra la última conexión en BD
2. Se destruyen todas las variables de sesión
3. Se elimina la cookie de sesión
4. Se redirige al login

```php
// Actualizar última conexión
$query = "UPDATE trabajadores SET lastlogout = NOW() WHERE dni = ?";

// Destruir sesión
session_destroy();

// Redirigir
header("Location: ../../../index.php");
```

## Configuración de Seguridad

### Variables de Seguridad

En `/scripts/php/seguridad/`:

```php
// Tiempo de inactividad (segundos)
$timeout = 1800; // 30 minutos

// Intentos de login fallidos permitidos
$max_attempts = 3;

// Tiempo de bloqueo tras intentos fallidos
$lockout_time = 900; // 15 minutos
```

### Política de Contraseñas

**Requisitos recomendados:**
- Mínimo 8 caracteres
- Combinar mayúsculas y minúsculas
- Incluir números
- Incluir caracteres especiales
- Cambio periódico (cada 90 días)
- No reutilizar últimas 5 contraseñas

### Registro de Actividad

El sistema registra:
- 📝 **Inicios de sesión**: Usuario, fecha, hora, IP
- 📝 **Acciones críticas**: Crear/editar/eliminar
- 📝 **Intentos fallidos**: Usuario, fecha, hora
- 📝 **Cierre de sesión**: Usuario, fecha, hora

## Auditoría y Logs

### Logs del Sistema

**Ubicación**: `/logs/` (si está configurado)

Tipos de logs:
- `access.log`: Accesos al sistema
- `error.log`: Errores de la aplicación
- `security.log`: Eventos de seguridad
- `audit.log`: Auditoría de acciones

### Monitoreo de Seguridad

Revisar periódicamente:
- Intentos de login fallidos
- Accesos fuera de horario
- Modificaciones masivas de datos
- Accesos desde IPs inusuales

## Respaldo y Recuperación

### Backup de Base de Datos

**Frecuencia recomendada:**
- ✅ Diario: Backup automático
- ✅ Semanal: Backup completo
- ✅ Mensual: Backup archivado

**Comando de backup:**
```bash
mysqldump -u usuario -p fichajedb > backup_$(date +%Y%m%d).sql
```

### Recuperación de Datos

En caso de pérdida de datos:
1. Identificar el último backup válido
2. Restaurar base de datos
3. Verificar integridad de datos
4. Notificar a usuarios si es necesario

```bash
mysql -u usuario -p fichajedb < backup_20251023.sql
```

## Recomendaciones de Seguridad

### Para Administradores

1. **Actualiza regularmente**:
   - Dependencias de Composer
   - Dependencias de npm
   - PHP y extensiones

2. **Configura el servidor correctamente**:
   - HTTPS obligatorio en producción
   - Certificado SSL válido
   - Cabeceras de seguridad HTTP

3. **Restringe accesos**:
   - .htaccess para proteger directorios
   - Permisos de archivos correctos
   - No exponer archivos sensibles

4. **Monitorea el sistema**:
   - Revisa logs regularmente
   - Configura alertas de seguridad
   - Analiza patrones de acceso

### Para Usuarios

1. **Contraseña segura**:
   - No usar contraseñas comunes
   - No compartir credenciales
   - Cambiar contraseña temporal

2. **Cierra sesión**:
   - Siempre que termines
   - Especialmente en equipos compartidos
   - No dejar sesión abierta

3. **Reporta incidencias**:
   - Actividad sospechosa en tu cuenta
   - Emails sospechosos
   - Problemas de acceso

## Configuración del Servidor

### .htaccess

```apache
# Proteger archivos sensibles
<Files "config.php">
    Require all denied
</Files>

<Files "conexion.php">
    Require all denied
</Files>

# Prevenir listado de directorios
Options -Indexes

# Protección XSS
Header set X-XSS-Protection "1; mode=block"

# Prevenir clickjacking
Header always append X-Frame-Options SAMEORIGIN

# Forzar HTTPS (en producción)
# RewriteEngine On
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### PHP Configuration

En `php.ini`:
```ini
# Deshabilitar display de errores en producción
display_errors = Off
log_errors = On

# Configurar sesiones
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1

# Límites de seguridad
max_execution_time = 30
upload_max_filesize = 2M
post_max_size = 8M
```

## Contacto de Seguridad

Si detectas una vulnerabilidad de seguridad:
1. **No la publiques públicamente**
2. **Contacta al administrador** de forma privada
3. **Proporciona detalles**: pero no explotes la vulnerabilidad
4. **Espera respuesta**: Se te informará de las acciones tomadas

## Archivos de Código

**Ubicación**: `/scripts/php/seguridad/`
- `control.php`: Control de login
- `seguridad.php`: Verificación de sesión
- `conexion.php`: Conexión a BD
- `cerrarSesion.php`: Cierre de sesión

## Siguiente Paso

- [Sistema de Fichaje](./13-fichaje.md)
- [Generación de Nóminas](./14-nominas.md)
- Volver a [Inicio](./README.md)
