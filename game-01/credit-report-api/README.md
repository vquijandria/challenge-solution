# 📊 Credit Report Export API (Game 01)

<img width="1462" height="801" alt="image" src="https://github.com/user-attachments/assets/1bc798b6-b30b-44ba-a279-067d33094c33" />


## 📌 Descripción general

Este proyecto implementa una **API REST en Laravel** que permite **generar y exportar reportes crediticios en formato XLSX** a partir de la información almacenada en la base de datos.

El sistema consolida, por cada suscriptor, la información de sus **préstamos**, **tarjetas de crédito** y **otras deudas**, dentro de un **rango de fechas**, y devuelve un **archivo Excel descargable**.

La solución fue diseñada priorizando:

- Separación clara de responsabilidades
- Escalabilidad para grandes volúmenes de datos
- Bajo acoplamiento entre capas
- Aplicación de principios **SOLID**
- Arquitectura inspirada en **Clean Architecture / DDD-lite**

---

## 🧱 Arquitectura y capas

El proyecto está organizado en capas bien definidas, cada una con una responsabilidad clara:

### 1️⃣ Capa HTTP (Interface / Delivery)

**Ubicación:**  
`App\Http\Controllers`

**Responsabilidad:**
- Recibir las solicitudes HTTP
- Validar y mapear los parámetros de entrada
- Delegar la ejecución al caso de uso

**Ejemplo:**
- `CreditReportExportController`

Esta capa **no contiene lógica de negocio**.

---

### 2️⃣ Capa Application (Casos de uso)

**Ubicación:**  
`App\Application\CreditReports\Export`

**Responsabilidad:**
- Orquestar el flujo de la aplicación
- Coordinar dominios e infraestructura
- Definir inputs explícitos (DTOs)

**Clases clave:**
- `ExportCreditReportUseCase`
- `ExportCreditReportInput`

Aquí se define **qué hace el sistema**, pero no **cómo** se hace técnicamente.

---

### 3️⃣ Capa Domain (Reglas de negocio)

**Ubicación:**  
`App\Domain\Shared`

**Responsabilidad:**
- Modelar conceptos del dominio
- Validar invariantes del negocio

**Ejemplo:**
- `DateRange`

Esta capa:
- No depende de Laravel
- No conoce bases de datos ni frameworks
- Representa reglas puras del dominio

---

### 4️⃣ Capa Infrastructure (Implementación técnica)

**Ubicación:**  
`App\Infrastructure\CreditReports`

**Responsabilidad:**
- Acceso a datos (queries SQL)
- Exportación del archivo XLSX
- Integraciones con librerías externas

**Componentes principales:**

#### 📄 Queries
- `CreditReportRowsQuery`
- Construye un único dataset consolidado usando `UNION ALL`
- Une préstamos, tarjetas y otras deudas en una sola vista exportable

#### 📦 Export
- `CreditReportExporter` (interface)
- `XlsxCreditReportExporter` (implementación concreta)

#### 📊 XLSX
- `CreditReportsExport`
- Define:
  - Encabezados del Excel
  - Mapeo fila por fila
  - Lectura por chunks (optimización de memoria)

---

## 🗄️ Modelo de datos (resumen)

Relaciones principales:

- `subscriptions`
  - Datos del suscriptor
- `subscription_reports`
  - Reporte por período
- `report_loans`
  - Préstamos
- `report_credit_cards`
  - Tarjetas de crédito
- `report_other_debts`
  - Otras deudas

Un **reporte** puede tener múltiples tipos de deuda, los cuales se consolidan en el Excel final.

---

## 🚀 Endpoint disponible

### Exportar reporte crediticio

```http
GET /api/credit-reports/export?from=YYYY-MM-DD&to=YYYY-MM-DD

API BASE
http://127.0.0.1:8000/api/credit-reports/export

API ENVIANDOLE PARAMETRO
http://127.0.0.1:8000/api/credit-reports/export?from=2026-01-12&to=2026-01-12
