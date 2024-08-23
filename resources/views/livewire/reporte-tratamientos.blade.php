<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Tratamientos</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #5d5c5c; padding: 8px; text-align: left; }
        th { background-color: #d3979a; color: white; }
    </style>
</head>
<body>
    <h2 class="text-center text-xl leading-tight text-[#d3979a]">REPORTE DE TRATAMIENTOS</h2>
    <div class="overflow-x-auto">
                    <table class="table-auto min-w-full bg-white">
                        <thead class="bg-[#d3979a] text-white">
                            <tr>
                                <th class="border border-[#5d5c5c]">#</th>
                                <th class="border border-[#5d5c5c]">Tratamiento</th>
                                <th class="border border-[#5d5c5c]">Estado</th>
                                <th class="border border-[#5d5c5c]">Fecha</th>
                                <th class="border border-[#5d5c5c]">Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($tratamientos as $index => $tratamiento)
                                <tr>
                                    <td class="border px-2 py-1 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $tratamiento->trat_realizado }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $tratamiento->estado_trat }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $tratamiento->fecha_trat }}</td>
                        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ \Carbon\Carbon::parse($tratamiento->hora_trat)->format('H:i') }}</td>
                                </tr>
                            @empty
                    <tr>
                        <td colspan="7" class="border px-4 py-2 border-[#d3979a] text-center text-[#5d5c5c]">No se encontraron tratamientos en este rango de fechas.</td>
                    </tr>
                @endforelse
                        </tbody>
                    </table>
                </div>
</body>
</html>
