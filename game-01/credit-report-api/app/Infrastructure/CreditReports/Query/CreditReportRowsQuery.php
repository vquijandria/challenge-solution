<?php

namespace App\Infrastructure\CreditReports\Query;

use App\Domain\Shared\DateRange;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Query builder para obtener filas normalizadas del reporte crediticio.
 *
 * Construye una consulta SQL optimizada que retorna un dataset "plano"
 * (una fila por deuda) combinando diferentes tipos de obligaciones:
 * - Préstamos (report_loans)
 * - Tarjetas de crédito (report_credit_cards)
 * - Otras deudas (report_other_debts)
 *
 * La salida está diseñada para consumo directo por el exportador XLSX,
 * unificando columnas mediante UNION ALL y alias consistentes.
 *
 * Responsabilidades:
 * - Aplicar filtro por rango de fechas sobre la creación del reporte (sr.created_at).
 * - Unir suscriptor + reporte (subscriptions + subscription_reports).
 * - Normalizar columnas para que todos los tipos de deuda compartan el mismo esquema.
 * - Retornar un Builder listo para streaming/chunking por la capa de exportación.
 *
 * Colaboradores:
 * - DateRange: define el periodo de filtrado.
 * - DB (Query Builder): ejecuta la consulta en la base de datos.
 * - Export (Maatwebsite\Excel): consume el Builder para exportación eficiente.
 *
 * Consideraciones de rendimiento y escalabilidad:
 * - Usa UNION ALL (más rápido que UNION al no deduplicar).
 * - Proyecta solo columnas necesarias (evita SELECT *).
 * - Mantiene un esquema uniforme para simplificar mapeo y evitar lógica condicional
 *   en el exportador.
 * - Compatible con exportación por chunks para grandes volúmenes de registros.
 *
 * Notas:
 * - Si se requiere performance adicional, se recomienda índices en:
 *   subscription_reports.created_at, report_* .subscription_report_id, subscriptions.id.
 *
 * Capa:
 * - Infrastructure
 */
final class CreditReportRowsQuery
{
    public function build(DateRange $range): Builder
    {
        // Base: suscriptor + reporte
        $base = DB::table('subscription_reports as sr')
            ->join('subscriptions as s', 's.id', '=', 'sr.subscription_id')
            ->whereBetween('sr.created_at', [
                $this->start($range),
                $this->end($range),
            ]);

        // 1) Loans
        $loans = (clone $base)
            ->join('report_loans as rl', 'rl.subscription_report_id', '=', 'sr.id')
            ->selectRaw("
                sr.id as id,
                s.full_name as nombre_completo,
                s.document as dni,
                s.email as email,
                s.phone as telefono,
                rl.bank as compania,
                'Préstamo' as tipo_deuda,
                rl.status as situacion,
                rl.expiration_days as atraso,
                rl.bank as entidad,
                rl.amount as monto_total,
                NULL as linea_total,
                NULL as linea_usada,
                sr.created_at as reporte_subido_el,
                'ACTIVO' as estado
            ");

        // 2) Credit cards
        $cards = (clone $base)
            ->join('report_credit_cards as rcc', 'rcc.subscription_report_id', '=', 'sr.id')
            ->selectRaw("
                sr.id as id,
                s.full_name as nombre_completo,
                s.document as dni,
                s.email as email,
                s.phone as telefono,
                rcc.bank as compania,
                'Tarjeta de crédito' as tipo_deuda,
                NULL as situacion,
                NULL as atraso,
                rcc.bank as entidad,
                NULL as monto_total,
                rcc.line as linea_total,
                rcc.used as linea_usada,
                sr.created_at as reporte_subido_el,
                'ACTIVO' as estado
            ");

        // 3) Other debts
        $others = (clone $base)
            ->join('report_other_debts as rod', 'rod.subscription_report_id', '=', 'sr.id')
            ->selectRaw("
                sr.id as id,
                s.full_name as nombre_completo,
                s.document as dni,
                s.email as email,
                s.phone as telefono,
                rod.entity as compania,
                'Otra deuda' as tipo_deuda,
                NULL as situacion,
                rod.expiration_days as atraso,
                rod.entity as entidad,
                rod.amount as monto_total,
                NULL as linea_total,
                NULL as linea_usada,
                sr.created_at as reporte_subido_el,
                'ACTIVO' as estado
            ");

        // Unimos todo y ordenamos
        return $loans
            ->unionAll($cards)
            ->unionAll($others)
            ->orderBy('reporte_subido_el', 'asc')
            ->orderBy('id', 'asc');
    }

    private function start(DateRange $range): string
    {
        return $range->from()->toDateTimeString();
    }

    private function end(DateRange $range): string
    {
        return $range->to()->toDateTimeString();
    }
}
