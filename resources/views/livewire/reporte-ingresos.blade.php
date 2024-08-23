<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ingresos</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #5d5c5c; padding: 8px; text-align: left; }
        th { background-color: #d3979a; color: white; }
    </style>
</head>
<body>
    <h2 class="text-center text-xl leading-tight text-[#d3979a]">REPORTE DE INGRESOS</h2>
    <div class="overflow-x-auto">
                    <table class="table-auto min-w-full bg-white">
                        <thead class="bg-[#d3979a] text-white">
                            <tr>
                                <th class="border border-[#5d5c5c]">#</th>
                                <th class="border border-[#5d5c5c]">Tratamiento</th>
                                <th class="border border-[#5d5c5c]">Observaciones</th>
                                <th class="border border-[#5d5c5c]">Precio</th>
                                <th class="border border-[#5d5c5c]">A cuenta</th>
                                <th class="border border-[#5d5c5c]">Saldo</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($ingresos as $index => $ingreso)
                                <tr>
                                    <td class="border px-2 py-1 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $ingreso->trat_realizado }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $ingreso->obs_trat }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $ingreso->precio_trat }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $ingreso->acuenta_trat }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $ingreso->saldo_trat }}</td>
                                </tr>
                            @empty
                    <tr>
                        <td colspan="7" class="border px-4 py-2 border-[#d3979a] text-center text-[#5d5c5c]">No se encontraron ingresos en este rango de fechas.</td>
                    </tr>
                @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-lg font-semibold text-gray-700">Total Ingresos:</span>
                        <span class="text-lg font-semibold text-[#d3979a]">Bs {{ number_format($totalIngresos, 2) }}</span>
                    </div>
                    <div>
                        <span class="text-lg font-semibold text-gray-700">A Deber:</span>
                        <span class="text-lg font-semibold text-[#d3979a]">Bs {{ number_format($aDeber, 2) }}</span>
                    </div>
                </div>
            </div>
</body>
</html>
