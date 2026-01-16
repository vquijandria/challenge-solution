# Game 02 – Gilded Rose Kata (PHP)

<img width="586" height="160" alt="Screenshot 2026-01-15 210115" src="https://github.com/user-attachments/assets/8fbff533-b23a-4141-9bf9-1207be725110" />


## Descripción general

Este módulo corresponde a la resolución del **Gilded Rose Kata**, un ejercicio clásico de refactorización y lógica de negocio.  
El objetivo es mantener y extender un sistema existente que actualiza diariamente el estado de un inventario, respetando un conjunto de reglas de negocio ya definidas y agregando una nueva categoría de ítems.

El código original presenta una lógica compleja y poco legible, por lo que el reto principal consiste en **entender el comportamiento actual**, **no romper funcionalidades existentes** y **agregar soporte para nuevos ítems** asegurando que todas las reglas se cumplan correctamente.

---

## Reglas del negocio

Cada ítem tiene dos atributos principales:

- **SellIn**: número de días restantes para vender el ítem.
- **Quality**: valor que representa la calidad del ítem.

Reglas generales:

- Al final de cada día, `sellIn` disminuye en 1 (excepto Sulfuras).
- Al final de cada día, `quality` se ajusta según el tipo de ítem.
- `quality` nunca puede ser negativa.
- `quality` nunca puede ser mayor a 50.
- **Sulfuras** es un ítem legendario:
  - Nunca se vende.
  - Su calidad es siempre 80.

Reglas específicas por tipo de ítem:

### Ítems normales
- `quality` disminuye en 1 por día.
- Cuando `sellIn < 0`, la calidad disminuye el doble.

### Aged Brie
- Incrementa su `quality` con el tiempo.
- Cuando `sellIn < 0`, incrementa su calidad más rápido.
- Nunca supera el valor 50.

### Backstage passes
- Incrementa su `quality` conforme se acerca el evento:
  - +1 cuando faltan más de 10 días.
  - +2 cuando faltan 10 días o menos.
  - +3 cuando faltan 5 días o menos.
- Cuando `sellIn < 0`, su `quality` pasa a 0.

### Conjured items
- Degradan su `quality` **el doble de rápido** que un ítem normal.
- También respetan el mínimo de 0.


---

## Enfoque de la solución

- Se respetó el contrato original del sistema:
  - **No se modificó la clase `Item`**.
- Se trabajó directamente sobre la lógica de `GildedRose::updateQuality()`.
- Se implementó la lógica para **Conjured items** sin afectar los demás comportamientos.
- Se garantizó que:
  - La calidad nunca sea negativa.
  - La calidad nunca supere 50 (excepto Sulfuras).
- Se validó el comportamiento usando **Approval Tests**, comparando el output completo del sistema durante 30 días.

---

## Sobre los Approval Tests

Este proyecto utiliza **Approval Tests**, un tipo de prueba que valida el resultado final completo del sistema como un texto.

- `*.approved.txt` → output esperado (contrato)
- `*.received.txt` → output generado por la ejecución actual

Si ambos coinciden, el test pasa.  
Si no coinciden, el test falla mostrando las diferencias.

Este enfoque es muy útil para:
- Refactorizar código legado.
- Asegurar que no se rompa comportamiento existente.
- Validar cambios complejos de forma segura.

---

## Cómo ejecutar el proyecto

### Requisitos
- PHP 8.x
- Composer

### Instalar dependencias
```bash
composer install




