<div>
    <x-slot name="header">
        <h2 class="text-center text-xl leading-tight text-[#d3979a]">
            REPORTES
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <h2 class="text-center text-xl leading-tight text-[#d3979a]">
            REPORTE DE PACIENTES
        </h2>
        <div class="mb-4 text-right">
        <button wire:click="exportPacientesPDF" class="bg-[#d3979a] text-white py-2 px-4 rounded mt-4">
        Exportar Reporte de Pacientes a PDF
    </button>
            </div>
                <div class="mb-4">
                    <label for="startDate" class="block text-sm font-medium text-gray-700">Fecha de Inicio:</label>
                    <input type="date" id="startDate" wire:model="startDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="endDate" class="block text-sm font-medium text-gray-700">Fecha de Fin:</label>
                    <input type="date" id="endDate" wire:model="endDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="overflow-x-auto">
                    <table class="table-auto min-w-full bg-white">
                        <thead class="bg-[#d3979a] text-white">
                            <tr>
                                <th class="border border-[#5d5c5c]">#</th>
                                <th class="border border-[#5d5c5c]">Nombres y Apellidos</th>
                                <th class="border border-[#5d5c5c]">Edad</th>
                                <th class="border border-[#5d5c5c]">Teléfono</th>
                                <th class="w-1/4 border border-[#5d5c5c]">Dirección</th>
                                <th class="border border-[#5d5c5c]">Cédula</th>
                                <th class="border border-[#5d5c5c]">Género</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($pacientes as $index => $paciente)
                                <tr>
                                    <td class="border px-2 py-1 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->nombres_pc }} {{ $paciente->ap_pat_pc }} {{ $paciente->ap_mat_pc }}</td>
                                    <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->edad }}</td>
                                    <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->tel_pac }}</td>
                                    <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->direccion_pc }}</td>
                                    <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->ci_pc }}</td>
                                    <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->genero_pc }}</td>
                                </tr>
                                @empty
                    <tr>
                        <td colspan="8" class="border px-4 py-2 border-[#d3979a] text-center text-[#5d5c5c]">No se encontraron pacientes en este rango de fechas.</td>
                    </tr>
                @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <h2 class="text-center text-xl leading-tight text-[#d3979a]">
            REPORTE DE TRATAMIENTOS
        </h2>
        <div class="mb-4 text-right">
        <button wire:click="exportTratamientosPDF" class="bg-[#d3979a] text-white py-2 px-4 rounded mt-4">
        Exportar Reporte de Tratamientos a PDF
    </button>
            </div>
                <div class="mb-4">
                    <label for="tratamientoStartDate" class="block text-sm font-medium text-gray-700">Fecha de Inicio:</label>
                    <input type="date" id="tratamientoStartDate" wire:model="tratamientoStartDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="tratamientoEndDate" class="block text-sm font-medium text-gray-700">Fecha de Fin:</label>
                    <input type="date" id="tratamientoEndDate" wire:model="tratamientoEndDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

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

            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <h2 class="text-center text-xl leading-tight text-[#d3979a]">
            REPORTE DE INGRESOS
        </h2>
        <div class="mb-4 text-right">
        <button wire:click="exportIngresosPDF" class="bg-[#d3979a] text-white py-2 px-4 rounded mt-4">
        Exportar Reporte de Ingresos a PDF
    </button>
            </div>
                <div class="mb-4">
                    <label for="ingresosStartDate" class="block text-sm font-medium text-gray-700">Fecha de Inicio:</label>
                    <input type="date" id="ingresosStartDate" wire:model="ingresosStartDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="ingresosEndDate" class="block text-sm font-medium text-gray-700">Fecha de Fin:</label>
                    <input type="date" id="ingresosEndDate" wire:model="ingresosEndDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

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
            </div>
        </div>
    </div>
</div>
