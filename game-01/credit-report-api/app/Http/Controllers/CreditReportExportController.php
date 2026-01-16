<?php

namespace App\Http\Controllers;

use App\Application\CreditReports\Export\ExportCreditReportUseCase;
use App\Application\CreditReports\Export\ExportCreditReportInput;
use App\Domain\Shared\DateRange;
use Illuminate\Http\Request;

/**
 * Controlador HTTP para la exportación de reportes crediticios.
 *
 * Expone un endpoint REST que permite generar y descargar
 * reportes de crédito en formato XLSX filtrados por rango de fechas.
 *
 * Responsabilidades:
 * - Recibir la solicitud HTTP.
 * - Extraer y mapear parámetros de entrada (query params).
 * - Construir objetos del dominio (DateRange).
 * - Delegar la ejecución al caso de uso correspondiente.
 *
 * Colaboradores:
 * - ExportCreditReportUseCase: orquesta la exportación.
 * - ExportCreditReportInput: DTO de entrada del caso de uso.
 * - DateRange: Value Object que representa el rango temporal.
 *
 * Notas de diseño:
 * - El controlador no contiene lógica de negocio.
 * - No conoce detalles de exportación, base de datos ni formato.
 * - Actúa como adaptador entre HTTP y la capa Application.
 *
 * Endpoint:
 * - GET /api/credit-reports/export?from=YYYY-MM-DD&to=YYYY-MM-DD
 *
 * Capa:
 * - Interfaces / Presentation
 */
final class CreditReportExportController extends Controller
{
    public function __construct(
        private readonly ExportCreditReportUseCase $useCase
    ) {}

    public function export(Request $request)
    {
        $range = DateRange::fromStrings(
            $request->query('from'),
            $request->query('to')
        );

        return $this->useCase->handle(
            new ExportCreditReportInput($range)
        );
    }
}
