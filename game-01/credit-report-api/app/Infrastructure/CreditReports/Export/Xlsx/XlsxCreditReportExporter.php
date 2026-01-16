<?php

namespace App\Infrastructure\CreditReports\Export\Xlsx;

use App\Domain\Shared\DateRange;
use App\Infrastructure\CreditReports\Export\CreditReportExporter;
use App\Infrastructure\CreditReports\Query\CreditReportRowsQuery;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Implementación XLSX del exportador de reportes crediticios.
 *
 * Genera y descarga un archivo Excel que contiene los reportes
 * crediticios filtrados por rango de fechas, utilizando consultas
 * optimizadas y exportación en streaming.
 *
 * Responsabilidades:
 * - Construir el dataset plano de reportes mediante una query optimizada.
 * - Delegar la generación del archivo XLSX a la librería de Excel.
 * - Retornar una respuesta binaria lista para descarga HTTP.
 *
 * Colaboradores:
 * - CreditReportExporter: contrato de exportación (DIP).
 * - CreditReportRowsQuery: construye la consulta SQL optimizada.
 * - CreditReportsExport: adaptador entre la query y el archivo XLSX.
 * - Maatwebsite\Excel: librería de infraestructura para Excel.
 *
 * Consideraciones de rendimiento:
 * - Utiliza Query Builder + chunking para soportar grandes volúmenes.
 * - Evita cargar el dataset completo en memoria.
 *
 * Notas de diseño:
 * - Cumple el principio de Inversión de Dependencias (DIP).
 * - Puede coexistir con otros exportadores (CSV, PDF).
 * - No contiene lógica de negocio.
 *
 * Capa:
 * - Infrastructure
 */
final class XlsxCreditReportExporter implements CreditReportExporter
{
    public function __construct(
        private CreditReportRowsQuery $query
    ) {}

    /**
     * Exporta el reporte crediticio en formato XLSX.
     *
     * @param DateRange $range Rango de fechas del reporte
     * @return BinaryFileResponse Archivo XLSX descargable
     */
    public function export(DateRange $range): BinaryFileResponse
    {
        return Excel::download(
            new CreditReportsExport(
                $this->query->build($range)
            ),
            'reporte_crediticio.xlsx'
        );
    }
}
