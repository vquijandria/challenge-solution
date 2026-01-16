<?php

namespace App\Infrastructure\CreditReports\Export\Xlsx;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

/**
 * Adaptador de exportación XLSX para reportes crediticios.
 *
 * Transforma el resultado de una consulta SQL optimizada
 * en un archivo Excel descargable, utilizando lectura por bloques
 * para soportar grandes volúmenes de datos.
 *
 * Responsabilidades:
 * - Definir la fuente de datos (Query Builder).
 * - Declarar las columnas del archivo Excel.
 * - Mapear cada fila del dataset plano a una fila del XLSX.
 * - Controlar el tamaño de lectura por bloques (chunking).
 *
 * Colaboradores:
 * - Illuminate\Database\Query\Builder: consulta que devuelve
 *   las filas normalizadas del reporte.
 * - Maatwebsite\Excel: librería encargada de la generación del XLSX.
 *
 * Consideraciones de rendimiento:
 * - Implementa WithChunkReading para evitar consumo excesivo de memoria.
 * - Diseñado para manejar cientos de miles o millones de registros.
 *
 * Notas de diseño:
 * - No contiene lógica de negocio.
 * - Depende exclusivamente de infraestructura.
 * - Puede reutilizarse con distintos queries mientras respeten el contrato
 *   de columnas esperado.
 *
 * Capa:
 * - Infrastructure
 */
final class CreditReportsExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    public function __construct(
        private Builder $query
    ) {}

    /**
     * Retorna la consulta base que alimenta el exportador.
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * Define los encabezados del archivo Excel.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre Completo',
            'DNI',
            'Email',
            'Teléfono',
            'Compañía',
            'Tipo de deuda',
            'Situación',
            'Atraso',
            'Entidad',
            'Monto total',
            'Línea total',
            'Línea usada',
            'Reporte subido el',
            'Estado',
        ];
    }

    /**
     * Mapea una fila del resultado de la consulta a una fila del XLSX.
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->nombre_completo,
            $row->dni,
            $row->email,
            $row->telefono,
            $row->compania,
            $row->tipo_deuda,
            $row->situacion,
            $row->atraso,
            $row->entidad,
            $row->monto_total,
            $row->linea_total,
            $row->linea_usada,
            $row->reporte_subido_el,
            $row->estado,
        ];
    }

    /**
     * Tamaño del bloque de lectura desde la base de datos.
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
