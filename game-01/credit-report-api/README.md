# 📊 Credit Report Export API

## 📌 Descripción general

Este proyecto implementa una **API en Laravel para la generación de reportes crediticios en formato XLSX**.  
El sistema consolida información de suscriptores y sus distintas deudas (préstamos, tarjetas de crédito y otras deudas) dentro de un **rango de fechas**, y devuelve un archivo Excel descargable.

La solución fue diseñada priorizando:
- Separación clara de responsabilidades
- Escalabilidad ante grandes volúmenes de datos
- Bajo acoplamiento entre capas
- Aplicación de principios SOLID y Clean Code

---

## 🚀 Endpoint disponible

```http
GET /api/credit-reports/export?from=YYYY-MM-DD&to=YYYY-MM-DD
