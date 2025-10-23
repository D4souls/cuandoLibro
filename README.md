<h1 align="center">
  <img src="https://github.com/D4souls/cuandoLibro/blob/main/img/banner.png" alt="logoCuandoLibro" width="100%"><br>
  <img src="https://img.shields.io/badge/XAMPP-FB7A24.svg?style=for-the-badge&logo=XAMPP&logoColor=white" alt="xampp">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="php">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="html5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="css3"><br>
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="tailwind">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="javascript">
  <img src="https://img.shields.io/badge/Composer-885630.svg?style=for-the-badge&logo=Composer&logoColor=white" alt="composer-for-php">
  <img src="https://img.shields.io/badge/Node.js-43853D?style=for-the-badge&logo=node.js&logoColor=white" alt="node.js">
</h1>

## Descripción
Aplicación vía web para la administración de una pequeña empresa. Con esta aplicación podrás desde crear un usuario hasta gestionar las nóminas de cada mes, esta aplicación ofrece las herramientas necesarias para simplificar y agilizar los procesos de administración de la empresa. Con la aplicación podrás:

- **Gestionar trabajdores y departamentos:** Podrás dar de alta y actualizar información de tus trabajadores y de los departamentos.
- **Creación de turnos:** Crea y asigna distintos turnos para cada día según el departamento que lo necesite.
- **My-Portal:** Todos los usuarios tendrán un portal personal donde podrán ver sus próximos turnos, estado de estos, comprobar avisos, descargar las nóminas del mes.
- **Seguridad de fichaje:** La aplicación contiene unos sistemas de seguridad los cuales son capaces de captar, almacenar y comparar la hora a la que ficha y desficha el trabajador.
- **Gestión de avisos:** El sistema de turnos y de fichaje de los trabajadores está vinculado a un sistema de seguridad el cual notificará al administrador y al trabajador de las posibles incidencias.
- **Creación de nóminas mensuales:** Cuando se configure el sistema de generación de nóminas estas se generarán automanticamente y se notificará a cada trabajador.
  
![Preview Interface](https://github.com/D4souls/cuandoLibro/blob/main/img/preview-interface.png)

> [!NOTE]
> Para la automatización de las nóminas y el fichaje de cada empleado se requiere programarlo en el administrador del sistema.

## Instalación
Para poder usar todas las funcionalidades que tiene la aplicación se requiere tener instalado xampp y seguir estos pasos:
> [!CAUTION]
> Todas las rutas que hay son desde la carpeta raiz del proyecto.
1. **(Opcional) Instalar composer y node**<br>

   Si no tienes instalado `composer` y `node`, accede a:
   - [Composer Web](https://getcomposer.org/download/) y descarga su última versión.
   - [Node Web](https://nodejs.org/en) y descarga su última versión.
1. **Clonar repositorio**
   
   ```
   git clone https://github.com/D4souls/cuandoLibro
   ```
3. **Instalar phpmailer**

   ```
   cd .\scripts\php\seguridad\mail
   ```
   ```
   composer require phpmailer/phpmailer
   ```
5. **Instalar DOMPDF**
   
   ```
   cd .\scripts\php\seguridad\generarNominas
   ```
   ```
   composer require dompdf/dompdf
   ```
7. **Activar GD**
   Para este paso es necesario acceder a la configuración de *Apache* (php.ini) y activar esta extensión:<br>
   
   **Antes:**
   ```
   ;extension=gd
   ```
   **Después:**
   ```
   extension=gd
   ```
8. **Instalar Atropos**
    
   ```
   cd .\error
   ```
   ```
   npm i atropos
   ```

9. **Creación DB**

    Ejecutar el archivo [`SQL`](https://github.com/D4souls/cuandoLibro/blob/main/fichajedb.sql) en nuestro gestor de bases de datos.

> [!IMPORTANT]
> Se tendrá que incluir el repositorio en la carptea de *htdocs* o crear un *nuevo host virtual*.

## Funcionalidades
| Nombre | Funcionalidades |
| --- | ---|
| Empleados | Alta y baja del trabajador, modificación de datos personales, asignación de departamento y categoría, acceso a *My-portal*, generación automática de credenciales temporales, visualizador de historial de avisos |
| Departamentos | Creación y eliminación de departamento, asignación de dinero, gestión de gastos, gestión de categorías según departamento |
| Categorías | Creación y eliminación de categorías, asignación de sueldo /h |
| Turnos | Creación y eliminación de 1 o varios turnos, asignación y desasignación de turno a trabajador |
| Avisos | Creación de aviso por: entrada tardía, salida temprana, falta injustificada de asistencia |
| Seguridad | Gestión de inactividad, cifrado de contraseñas, control de acceso según rol (usuario o administrador), control de peticiones usando *ajax* |
| Extras | Creación de nóminas, autogeneración de fotografía corporativa, creación de directorios personales |

## 📚 Documentación

Para una guía completa sobre cómo usar todas las funcionalidades de la aplicación, consulta la **[Documentación completa](./docs/README.md)**.

La documentación incluye:
- **Guías para administradores**: Gestión de trabajadores, departamentos, categorías, turnos y avisos
- **Guías para empleados**: My Portal, consulta de horarios, avisos y nóminas
- **Documentación técnica**: Sistema de seguridad, fichaje y generación de nóminas

### Acceso Rápido

**Para Administradores:**
- [Inicio de Sesión](./docs/01-inicio-sesion.md)
- [Dashboard](./docs/02-dashboard.md)
- [Gestión de Trabajadores](./docs/03-trabajadores.md)
- [Gestión de Departamentos](./docs/04-departamentos.md)
- [Gestión de Turnos](./docs/06-turnos.md)

**Para Empleados:**
- [My Portal - Dashboard Personal](./docs/08-my-portal.md)
- [My Portal - Horarios](./docs/09-my-portal-horarios.md)
- [My Portal - Avisos](./docs/10-my-portal-avisos.md)
- [My Portal - Nóminas](./docs/11-my-portal-nominas.md)

## Licencia
GNU General Public License v3.0 ([Ver licencia](https://github.com/D4souls/cuandoLibro/blob/main/LICENSE))
