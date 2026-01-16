# Challenge Solution

Este repositorio contiene la solución a los dos challenges técnicos.
 Para correr el game-01 tenemos que ir a la carpeta


---

##  Estructura del repositorio

```text
challenge-solution/
│
├── game-01/
│   └── credit-report-api/     # API en Laravel (exportación de reportes XLSX)
│
├── game-02/
│   └── ...                    # Segundo challenge (editar un metodo sin malograr nada)

 Game 01 – Credit Report Export API
 Descripción

En este challenge desarrollé una API en Laravel que genera un reporte crediticio en formato XLSX a partir de un rango de fechas.

El sistema:

Consolida información de suscriptores

Une distintos tipos de deuda:

Préstamos

Tarjetas de crédito

Otras deudas

Exporta todo en un solo archivo Excel

Se utilizó una arquitectura por capas (Application / Domain / Infrastructure) inspirada en Clean Architecture.

 Tecnologías usadas

PHP 8.x

Laravel 12

MySQL

Maatwebsite Excel

Carbon

Arquitectura limpia (Use Cases, Queries, Exporters)

Cómo correr Game 01
1️ Entrar al proyecto
cd game-01/credit-report-api

2️ Instalar dependencias
composer install

3️ Configurar entorno
cp .env.example .env
php artisan key:generate


Configurar la conexión a MySQL en el archivo .env.

4️ Base de datos

Importar el archivo:

game-01/database.sql

5️ Levantar el servidor
php artisan serve

 Endpoint disponible
GET /api/credit-reports/export?from=YYYY-MM-DD&to=YYYY-MM-DD

Ejemplo real usado durante el desarrollo
http://127.0.0.1:8000/api/credit-reports/export?from=2026-01-12&to=2026-01-12


Esto descarga automáticamente el archivo:

reporte_crediticio.xlsx
<img width="1462" height="801" alt="Screenshot 2026-01-15 215440" src="https://github.com/user-attachments/assets/2ce64e6a-d6dc-4e53-bb4a-797fd50b1657" />

 Game 02 – Gilded Rose Kata
 Descripción

En este challenge resolví el clásico Gilded Rose Kata, respetando las reglas originales:

 No modificar la clase Item

 No romper el comportamiento existente

 Agregar soporte para Conjured Items

 Mantener todos los tests pasando

Se trabajó mediante refactor progresivo, hasta dejar el método updateQuality entendible y extensible.

 Tecnologías usadas

PHP

PHPUnit

Approval Tests

 Cómo correr Game 02
1️ Entrar al proyecto
cd game-02

2️ Instalar dependencias
composer install

3️ Ejecutar tests
vendor/bin/phpunit


Resultado esperado:

OK (3 tests, 3 assertions)

 Evidencia de tests pasando

<img width="586" height="160" alt="Screenshot 2026-01-15 210115" src="https://github.com/user-attachments/assets/be1eb179-2eed-4f8c-bb01-f4f85f94d7a3" />


Qué se hizo en Game 02

Refactor sin romper tests existentes

Separación clara de reglas por tipo de item

Manejo correcto de:

- Aged Brie

- Backstage passes

- Sulfuras

- Conjured items

Validación final mediante Approval Tests
