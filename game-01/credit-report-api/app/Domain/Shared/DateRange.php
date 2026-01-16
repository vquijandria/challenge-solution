<?php

namespace App\Domain\Shared;

use Carbon\CarbonImmutable;
use InvalidArgumentException;

/**
 * Value Object que representa un rango de fechas inmutable.
 *
 * Encapsula la lógica de validación y normalización de periodos
 * temporales utilizados en consultas y casos de uso del dominio.
 *
 * Responsabilidades:
 * - Representar un intervalo de tiempo válido.
 * - Normalizar fechas de entrada a inicio y fin del día.
 * - Garantizar consistencia temporal (to >= from).
 *
 * Características:
 * - Inmutable (usa CarbonImmutable).
 * - Auto-validado al momento de creación.
 * - Independiente del framework y de infraestructura.
 *
 * Casos de uso comunes:
 * - Filtrado de reportes por rango de fechas.
 * - Consultas a base de datos basadas en periodos.
 *
 * Notas de diseño:
 * - Se implementa como Value Object siguiendo DDD.
 * - Evita la propagación de strings de fecha por el sistema.
 * - Centraliza reglas temporales en un único punto.
 *
 * Capa:
 * - Domain
 */
final class DateRange
{
    private CarbonImmutable $from;
    private CarbonImmutable $to;

    private function __construct(CarbonImmutable $from, CarbonImmutable $to)
    {
        if ($to->lessThan($from)) {
            throw new InvalidArgumentException('Invalid date range');
        }

        $this->from = $from;
        $this->to   = $to;
    }

    /**
     * Crea un rango de fechas a partir de strings.
     *
     * Normaliza:
     * - Fecha inicial al inicio del día (00:00:00).
     * - Fecha final al final del día (23:59:59).
     */
    public static function fromStrings(?string $from, ?string $to): self
    {
        $fromDate = CarbonImmutable::parse($from)->startOfDay();
        $toDate   = CarbonImmutable::parse($to)->endOfDay();

        return new self($fromDate, $toDate);
    }

    /**
     * Retorna la fecha inicial del rango.
     */
    public function from(): CarbonImmutable
    {
        return $this->from;
    }

    /**
     * Retorna la fecha final del rango.
     */
    public function to(): CarbonImmutable
    {
        return $this->to;
    }
}
