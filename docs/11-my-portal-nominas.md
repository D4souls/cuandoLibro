# 💰 My Portal - Nóminas

## Descripción
La sección de Nóminas en My Portal permite a los empleados consultar y descargar sus nóminas mensuales generadas por el sistema.

## Acceso

**URL**: `/sites/my-portal-nominas.php`  
**Requerido**: Rol de usuario (empleado)  
**Acceso desde**: Menú lateral de My Portal → Nóminas

## Vista Principal

### Elementos de la Interfaz

La pantalla muestra:
- **Título**: "Mis Nóminas"
- **Lista de nóminas**: Nóminas disponibles para descargar
- **Información del mes actual**: Estado de la nómina en curso

## Lista de Nóminas

### Información Mostrada

Para cada nómina disponible:

| Campo | Descripción |
|-------|-------------|
| **Mes y Año** | Período de la nómina (ej: Octubre 2025) |
| **Fecha de generación** | Cuándo se creó la nómina |
| **Estado** | Disponible, En proceso, Pendiente |
| **Acciones** | Botones para ver y descargar |

## Estructura de la Nómina

### Contenido del Documento PDF

Cada nómina incluye:

#### 1. Encabezado

```
NÓMINA MENSUAL

Empresa: [Nombre de tu empresa]
Período: Octubre 2025
Fecha de emisión: 01/11/2025
```

#### 2. Datos del Empleado

```
DATOS DEL TRABAJADOR

Nombre: Juan Pérez García
DNI: 11111111A
Número de Seguridad Social: 123456789012
Departamento: Desarrollo
Categoría: Desarrollador Senior
```

#### 3. Datos Bancarios

```
DATOS DE PAGO

IBAN: ES91 2100 0418 4502 0005 1332
Fecha de pago: 30/10/2025
```

#### 4. Devengos (Ingresos)

```
DEVENGOS

Concepto              Horas    €/Hora    Importe
---------------------------------------------------
Salario base (normal)  120h    15.00€    1,800.00€
Salario plus (noche)    20h    25.00€      500.00€
---------------------------------------------------
TOTAL DEVENGOS                           2,300.00€
```

#### 5. Deducciones

```
DEDUCCIONES

Concepto                          Porcentaje    Importe
--------------------------------------------------------
IRPF                                 15%        345.00€
Seguridad Social (empleado)         6.35%      146.05€
--------------------------------------------------------
TOTAL DEDUCCIONES                               491.05€
```

#### 6. Líquido a Percibir

```
RESUMEN

Total Devengos:          2,300.00€
Total Deducciones:        -491.05€
----------------------------------------
LÍQUIDO A PERCIBIR:      1,808.95€
```

## Cálculo de la Nómina

### Fórmula General

```
Líquido = Total Devengos - Total Deducciones
```

### Cálculo de Devengos

**Horas trabajadas:**
- El sistema suma todas las horas fichadas durante el mes
- Distingue entre horas normales y horas plus
- Solo cuenta turnos completados (con fichaje correcto)

**Fórmula:**
```
Devengos = (Horas Normales × Sueldo Normal) + (Horas Plus × Sueldo Plus)
```

**Ejemplo:**
```
Horas normales: 120h × 15.00€/h = 1,800.00€
Horas plus: 20h × 25.00€/h = 500.00€
Total Devengos = 2,300.00€
```

### Cálculo de Deducciones

**IRPF (Impuesto sobre la Renta):**
- Porcentaje según legislación vigente
- Varía según el salario bruto
- Ejemplo: 15% de 2,300.00€ = 345.00€

**Seguridad Social:**
- Cotización del empleado
- Generalmente 6.35% del salario bruto
- Ejemplo: 6.35% de 2,300.00€ = 146.05€

**Otras deducciones (si aplican):**
- Anticipos solicitados
- Embargos judiciales
- Cuotas sindicales
- Préstamos de empresa

### Horas No Contabilizadas

No se incluyen en la nómina:
- ❌ Turnos con falta injustificada
- ❌ Horas de retrasos significativos
- ❌ Horas de salidas tempranas
- ⚠️ Turnos con avisos pueden tener ajustes

## Acciones Disponibles

### 1. Ver Nómina

**Cómo ver una nómina:**

1. En la lista de nóminas, localiza el mes deseado
2. Haz clic en el botón **"Ver"** (icono de ojo)
3. La nómina se abrirá en una nueva pestaña del navegador
4. Puedes visualizar todos los detalles

### 2. Descargar Nómina

**Cómo descargar una nómina:**

1. En la lista de nóminas, localiza el mes deseado
2. Haz clic en el botón **"Descargar"** (icono de descarga)
3. El archivo PDF se descargará a tu dispositivo
4. El nombre del archivo será: `nomina_[DNI]_[Mes]_[Año].pdf`

**Ejemplo de nombre:**
```
nomina_11111111A_Octubre_2025.pdf
```

### 3. Imprimir Nómina

**Cómo imprimir una nómina:**

1. Abre la nómina (botón "Ver")
2. En el visor PDF, haz clic en el icono de impresora
3. O usa el atajo de teclado: Ctrl+P (Windows) / Cmd+P (Mac)
4. Selecciona tu impresora
5. Imprime el documento

## Generación de Nóminas

### Proceso Automático

Las nóminas se generan **automáticamente** cada mes:

1. **Último día del mes** (o primer día del siguiente)
2. El sistema calcula:
   - Todas las horas trabajadas del mes
   - Distingue horas normales vs plus
   - Aplica la tarifa de tu categoría
   - Calcula deducciones legales
3. **Genera el PDF** con toda la información
4. **Te notifica por email** cuando está disponible

### Notificación de Nómina

Recibes un email como:

```
Asunto: Tu nómina de Octubre 2025 está disponible

Hola Juan,

Tu nómina del mes de Octubre 2025 ya está disponible 
en tu My Portal.

Resumen:
- Horas trabajadas: 140h
- Líquido a percibir: 1,808.95€
- Fecha de pago: 30/10/2025

Accede a My Portal > Nóminas para descargar el documento.

Saludos,
Sistema CuandoLibro
```

### Fechas Importantes

- 📅 **Generación**: Último día del mes / Día 1 del siguiente
- 💰 **Pago**: Según política de empresa (ej: día 30 de cada mes)
- ✉️ **Notificación**: Inmediatamente después de la generación

## Verificación de la Nómina

### Qué Revisar

Cuando recibas tu nómina, verifica:

1. **Datos personales**:
   - ✅ Nombre y DNI correctos
   - ✅ Número de Seguridad Social correcto
   - ✅ IBAN correcto

2. **Horas trabajadas**:
   - ✅ Número total de horas
   - ✅ Distribución horas normales/plus
   - ✅ Coincide con tus turnos fichados

3. **Cálculos**:
   - ✅ Tarifa por hora correcta
   - ✅ Total devengos = horas × tarifa
   - ✅ Deducciones según porcentajes legales
   - ✅ Líquido final correcto

4. **Información adicional**:
   - ✅ Período correcto
   - ✅ Fecha de pago
   - ✅ Fecha de emisión

### Comparar con tus Turnos

**Cómo verificar las horas:**

1. Accede a [My Portal - Horarios](./09-my-portal-horarios.md)
2. Filtra los turnos del mes de la nómina
3. Suma las horas de turnos completados
4. Compara con las horas en la nómina
5. Considera los avisos que afecten las horas

**Ejemplo de verificación:**

```
Turnos del mes de Octubre:
- Turno 1: 8h (completado)
- Turno 2: 8h (completado)
- Turno 3: 8h (entrada tardía -10min)
- ...
- Total esperado: 138h 50min

Nómina muestra: 138.83h ✅ Correcto
```

## Problemas Comunes

### No veo mi nómina del mes

**Posibles causas:**
- Aún no se ha generado (espera al día 1 del siguiente mes)
- No trabajaste ningún turno ese mes
- Problema técnico en la generación

**Solución:**
- Verifica la fecha actual
- Consulta si trabajaste turnos ese mes
- Contacta al administrador si ya debería estar

### Las horas no coinciden

**Posibles causas:**
- Avisos que redujeron horas contabilizadas
- Turnos incompletos (sin fichaje de salida)
- Errores en el sistema de fichaje

**Solución:**
1. Revisa tus avisos en [My Portal - Avisos](./10-my-portal-avisos.md)
2. Verifica todos los turnos del mes
3. Compara fichajes con turnos programados
4. Si encuentras un error, contacta al administrador con:
   - Fecha del turno en cuestión
   - Horas esperadas vs horas en nómina
   - Captura de pantalla si es posible

### Error al descargar el PDF

**Posibles causas:**
- Problema de conexión
- Bloqueador de ventanas emergentes activo
- Archivo corrupto

**Solución:**
- Refresca la página e intenta de nuevo
- Desactiva bloqueadores temporalmente
- Prueba con otro navegador
- Contacta al administrador si persiste

## Conservación de Nóminas

### Recomendaciones

1. **Descarga todas las nóminas**:
   - En cuanto estén disponibles
   - Guárdalas en tu dispositivo
   - Haz copias de respaldo

2. **Organiza tus archivos**:
   ```
   📁 Nóminas/
   ├── 📁 2024/
   │   ├── nomina_enero_2024.pdf
   │   ├── nomina_febrero_2024.pdf
   │   └── ...
   └── 📁 2025/
       ├── nomina_enero_2025.pdf
       └── ...
   ```

3. **Almacenamiento en la nube**:
   - Sube copias a Google Drive, Dropbox, etc.
   - Protege con contraseña si es sensible
   - Mantén respaldos actualizados

### Uso de Nóminas

Necesitarás tus nóminas para:
- 🏦 **Solicitudes de préstamos**
- 🏠 **Alquiler de vivienda**
- 💳 **Solicitudes de tarjetas de crédito**
- 📊 **Declaración de impuestos**
- 🛂 **Trámites administrativos**
- 📄 **Solicitudes de visado**

> [!IMPORTANT]
> Conserva tus nóminas durante al menos 4 años, según la legislación laboral.

## Consultas sobre Nóminas

### Contactar con el Administrador

Si tienes dudas sobre tu nómina:

1. **Revisa primero**:
   - Esta documentación
   - Tus turnos y avisos
   - Cálculos básicos

2. **Prepara información**:
   - Mes de la nómina
   - Descripción del problema
   - Cálculos que has hecho
   - Capturas de pantalla relevantes

3. **Contacta**:
   - Email al administrador o RRHH
   - Especifica claramente tu consulta
   - Adjunta documentación de soporte

### Reclamaciones

Si crees que hay un error en tu nómina:

1. **Documenta el error**:
   - ¿Qué esperabas?
   - ¿Qué muestra la nómina?
   - ¿Cuál es la diferencia?

2. **Contacta rápidamente**:
   - Dentro del mismo mes si es posible
   - No esperes al siguiente mes

3. **Sigue el proceso**:
   - Presenta tu caso al administrador
   - Proporciona evidencias
   - Solicita revisión formal si es necesario

## Privacidad y Seguridad

### Protección de Datos

- 🔒 Las nóminas son documentos **confidenciales**
- 🔐 Solo tú tienes acceso a tus nóminas
- 👤 Administradores tienen acceso por gestión
- 🛡️ No compartas tus nóminas públicamente

### Acceso Seguro

- Inicia sesión con tus credenciales
- No dejes la sesión abierta en equipos compartidos
- Descarga en dispositivos seguros
- Protege los archivos PDF descargados

## Sistema de Generación

El sistema usa **DOMPDF** para generar las nóminas:
- Conversión de HTML a PDF
- Formato profesional y estándar
- Incluye todos los datos legales requeridos
- Compatible con todos los lectores PDF

## Archivos de Código

**Ubicación**: `/sites/my-portal-nominas.php`  
**Generación**: `/scripts/php/seguridad/generarNominas/`  
**Librería**: DOMPDF

## Siguiente Paso

- [Generación de Nóminas (Detalles técnicos)](./14-nominas.md)
- [My Portal - Horarios](./09-my-portal-horarios.md)
- Volver a [My Portal](./08-my-portal.md)
