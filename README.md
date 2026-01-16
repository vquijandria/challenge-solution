# Challenge Solution

Este repositorio contiene la solución a los dos challenges técnicos.
 Para correr el game-01 tenemos que ir a la carpeta


---

## 📁 Estructura del repositorio

```text
challenge-solution/
│
├── game-01/
│   └── credit-report-api/     # API en Laravel (exportación de reportes XLSX)
│
├── game-02/
│   └── ...                    # Segundo challenge (editar un metodo sin malograr nada)

🎯 Game 01 – Credit Report Export API
📌 Descripción

En este challenge desarrollé una API en Laravel que genera un reporte crediticio en formato XLSX a partir de un rango de fechas.

El sistema:

Consolida información de suscriptores

Une distintos tipos de deuda:

Préstamos

Tarjetas de crédito

Otras deudas

Exporta todo en un solo archivo Excel

Se utilizó una arquitectura por capas (Application / Domain / Infrastructure) inspirada en Clean Architecture.

⚙️ Tecnologías usadas

PHP 8.x

Laravel 12

MySQL

Maatwebsite Excel

Carbon

Arquitectura limpia (Use Cases, Queries, Exporters)

🚀 Cómo correr Game 01
1️⃣ Entrar al proyecto
cd game-01/credit-report-api

2️⃣ Instalar dependencias
composer install

3️⃣ Configurar entorno
cp .env.example .env
php artisan key:generate


Configurar la conexión a MySQL en el archivo .env.

4️⃣ Base de datos

Importar el archivo:

game-01/database.sql

5️⃣ Levantar el servidor
php artisan serve

📡 Endpoint disponible
GET /api/credit-reports/export?from=YYYY-MM-DD&to=YYYY-MM-DD

Ejemplo real usado durante el desarrollo
http://127.0.0.1:8000/api/credit-reports/export?from=2026-01-12&to=2026-01-12


Esto descarga automáticamente el archivo:

reporte_crediticio.xlsx