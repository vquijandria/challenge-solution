# Game 02 – Gilded Rose Kata (PHP)

<img width="586" height="160" alt="Screenshot 2026-01-15 210115" src="https://github.com/user-attachments/assets/8fbff533-b23a-4141-9bf9-1207be725110" />

---

## 📌 Descripción general

Este módulo corresponde a la resolución del **Gilded Rose Kata**, un ejercicio clásico de refactorización y lógica de negocio.  
El objetivo es mantener y extender un sistema existente que actualiza diariamente el estado de un inventario, respetando un conjunto de reglas de negocio ya definidas y agregando una nueva categoría de ítems.

El código original presenta una lógica compleja y poco legible, por lo que el reto principal consiste en:

- Entender el comportamiento actual del sistema.
- **No romper funcionalidades existentes**.
- Reducir el código “spaghetti”.
- Aplicar buenas prácticas de diseño.
- Agregar soporte para nuevos ítems de forma segura.

---

## 📜 Reglas del negocio

Cada ítem tiene dos atributos principales:

- **SellIn**: número de días restantes para vender el ítem.
- **Quality**: valor que representa la calidad del ítem.

### Reglas generales

- Al final de cada día, `sellIn` disminuye en 1 (excepto Sulfuras).
- Al final de cada día, `quality` se ajusta según el tipo de ítem.
- `quality` nunca puede ser negativa.
- `quality` nunca puede ser mayor a 50.
- **Sulfuras** es un ítem legendario:
  - Nunca se vende.
  - Su calidad es siempre 80.

---

### Reglas específicas por tipo de ítem

#### Ítems normales
- `quality` disminuye en 1 por día.
- Cuando `sellIn < 0`, la calidad disminuye el doble.

#### Aged Brie
- Incrementa su `quality` con el tiempo.
- Cuando `sellIn < 0`, incrementa su calidad más rápido.
- Nunca supera el valor 50.

#### Backstage passes
- Incrementa su `quality` conforme se acerca el evento:
  - +1 cuando faltan más de 10 días.
  - +2 cuando faltan 10 días o menos.
  - +3 cuando faltan 5 días o menos.
- Cuando `sellIn < 0`, su `quality` pasa a 0.

#### Conjured items
- Degradan su `quality` **el doble de rápido** que un ítem normal.
- Cuando `sellIn < 0`, degradan aún más rápido.
- Respetan siempre el mínimo de 0.

---

## 🧠 Enfoque de la solución y refactor aplicado

Inicialmente, la lógica del sistema estaba concentrada en un único método (`GildedRose::updateQuality()`), con múltiples condicionales anidados y reglas mezcladas, lo que dificultaba su mantenimiento y extensión.

Para resolver esto, se realizó un **refactor aplicando principios SOLID y Clean Code**, utilizando principalmente el **patrón Strategy**, acompañado de un **resolver tipo Factory**.

### 🔧 Cambios clave realizados

- **Se encapsuló la lógica de actualización por tipo de ítem** en clases independientes.
- Cada regla de negocio vive en su propio archivo.
- Se eliminó el uso de grandes bloques `if/else`.
- El sistema ahora es **extensible** sin modificar código existente (Open/Closed Principle).

---

## 🧩 Patrón de diseño aplicado

### ✅ Strategy Pattern

Cada tipo de ítem utiliza una estrategia distinta para actualizar su estado:

- `NormalItemUpdater`
- `AgedBrieUpdater`
- `BackstagePassUpdater`
- `SulfurasUpdater`
- `ConjuredUpdater`

Todas implementan la interfaz común:

```php
ItemUpdater::update(Item $item): void
