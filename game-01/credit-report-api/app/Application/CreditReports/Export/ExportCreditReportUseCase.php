<?php

namespace App\Application\CreditReports\Export;

use App\Infrastructure\CreditReports\Export\CreditReportExporter;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Caso de uso: Exportar reporte de crédito.
 *
 * Orquesta el proceso completo de exportación de reportes
 * de crédito en formato XLSX a partir de un rango de fechas.
 *
 * Responsabilidades:
 * - Recibir el input de la capa Application (DTO).
 * - Delegar la generación del archivo al componente exportador.
 * - Retornar una respuesta binaria lista para descarga HTTP.
 *
 * Colaboradores:
 * - ExportCreditReportInput: encapsula los datos de entrada.
 * - CreditReportExporter: contrato de infraestructura encargado
 *   de generar el archivo físico (XLSX).
 *
 * Detalles de diseño:
 * - No contiene lógica de negocio.
 * - No conoce detalles de base de datos ni formato del archivo.
 * - Depende de una abstracción (exporter), facilitando testing
 *   y reemplazo de implementación.
 *
 * Capa:
 * - Application
 */
final class ExportCreditReportUseCase
{
    public function __construct(
        private readonly CreditReportExporter $exporter
    ) {}

    public function handle(
        ExportCreditReportInput $input
    ): BinaryFileResponse {
        return $this->exporter->export($input->dateRange);
    }
}
