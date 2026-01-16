<?php

namespace App\Infrastructure\CreditReports\Export;

use App\Domain\Shared\DateRange;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Contrato de exportación de reportes crediticios.
 *
 * Define el comportamiento esperado para cualquier
 * implementación encargada de generar y entregar
 * reportes crediticios en un formato específico.
 *
 * Responsabilidades:
 * - Exponer una operación de exportación basada en un rango de fechas.
 * - Retornar un archivo listo para ser entregado vía HTTP.
 *
 * Colaboradores:
 * - DateRange: Value Object que define el periodo del reporte.
 * - BinaryFileResponse: respuesta HTTP para descargas de archivos.
 *
 * Notas de diseño:
 * - Aplica el principio de Inversión de Dependencias (DIP).
 * - Permite múltiples implementaciones (XLSX, CSV, PDF).
 * - Desacopla la capa Application de detalles de infraestructura.
 *
 * Capa:
 * - Infrastructure (contrato consumido por Application)
 */
interface CreditReportExporter
{
    /**
     * Genera y retorna el reporte crediticio.
     *
     * @param DateRange $range Rango de fechas a exportar
     * @return BinaryFileResponse Archivo descargable
     */
    public function export(DateRange $range): BinaryFileResponse;
}
