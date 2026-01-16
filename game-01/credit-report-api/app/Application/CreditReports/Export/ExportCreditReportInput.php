<?php

namespace App\Application\CreditReports\Export;

use App\Domain\Shared\DateRange;

/**
 * DTO de entrada para la exportación de reportes de crédito.
 *
 * Representa los datos necesarios para iniciar el caso de uso
 * de exportación de reportes en formato XLSX.
 *
 * Responsabilidades:
 * - Encapsular el rango de fechas solicitado por el usuario.
 * - Transportar datos desde la capa de Interfaces (HTTP)
 *   hacia la capa de Application.
 *
 * Colaboradores:
 * - App\Domain\Shared\DateRange: define el periodo temporal
 *   sobre el cual se generan los reportes.
 *
 * Notas:
 * - Este objeto es inmutable (readonly).
 * - No contiene lógica de negocio ni validaciones.
 */
final class ExportCreditReportInput
{
    public function __construct(
        public readonly DateRange $dateRange
    ) {}
}
