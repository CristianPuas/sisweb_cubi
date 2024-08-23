<x-slot name="header">
    <h2 class="text-center text-xl leading-tight text-[#d3979a]">
        PACIENTES TRATADOS
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if(session()->has('message'))
                <div class="bg-teal-100 rounded-b text-teal-900 px-4 py-4 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <h4>{{ session('message') }}</h4>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-500 text-white p-2 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <x-button wire:click="crear()" class="ml-4 mb-4">Registrar paciente tratado</x-button>
            

            @if($modal1)
                @include('livewire.crearRegistroPac')
            @endif
        
            @if($modalTratamiento)
                @include('livewire.agregarTratamiento')
            @endif
            @if($modalTratPac)
                @include('livewire.editarTratPac')
            @endif
            
            <div class="mb-4 flex items-center">
                <input type="text" wire:model.debounce.300ms="search1" placeholder="Buscar..." class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2">
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto min-w-full bg-white">
                    <thead class="bg-[#d3979a] text-white">
                        <tr>
                            <th scope="col" class="border border-[#5d5c5c]">#</th>
                            <th scope="col" class="border border-[#5d5c5c]">Nombres</th>
                            <th scope="col" class="border border-[#5d5c5c]">Ap Paterno</th>
                            <th scope="col" class="border border-[#5d5c5c]">Ap Materno</th>
                            <th scope="col" class="border border-[#5d5c5c]">Edad</th>
                            <th scope="col" class="border border-[#5d5c5c]">Telefono</th>
                            <th scope="col" class="w-1/4 border border-[#5d5c5c]">Dirección</th>
                            <th scope="col" class="border border-[#5d5c5c]">Cédula</th>
                            <th scope="col" class="border border-[#5d5c5c]">Genero</th>
                            <th scope="col" class="border border-[#5d5c5c]">Tratamiento realizado</th>
                            <th scope="col" class="w-1/4 border border-[#5d5c5c]" >Observaciones</th>
                            <th scope="col" class="border border-[#5d5c5c]">Estado</th>
                            <th scope="col" class="border border-[#5d5c5c]" >Precio</th>
                            <th scope="col" class="border border-[#5d5c5c]">A cuenta</th>
                            <th scope="col" class="border border-[#5d5c5c]">Saldo</th>
                            <th scope="col" class="border border-[#5d5c5c]">Fecha</th>
                            <th scope="col" class="border border-[#5d5c5c]">Hora</th>
                            <th scope="col" class="border border-[#5d5c5c]" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pacientes as $index => $paciente)
                        
                            <tr>
                                <td class="border px-2 py-1 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->nombres_pc }}</td>
                                <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->ap_pat_pc }}</td>
                                <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->ap_mat_pc }}</td>
                                <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->edad }}</td>
                                <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->tel_pac }}
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $paciente->tel_pac) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#d3979a] border border-transparent rounded-md text-xl text-white tracking-widest hover:bg-[#b17b7c] focus:bg-[#b17b7c] active:bg-[#8f6364] focus:outline-none focus:ring-2 focus:ring-[#d3979a] focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-brands fa-whatsapp "></i></a>
                                </td>
                                <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->direccion_pc }}</td>
                                <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->ci_pc }}</td>
                                <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">{{ $paciente->genero_pc }}</td>
        <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">
        <select wire:change="actualizarTratReg({{ $paciente->id }}, $event.target.value)" class="w-full border border-[#d3979a] rounded py-1 px-2">
        @if($paciente->trat_realizado)
    <option value="inicial" {{ isset($selectedTratamientos[$paciente->id]) && $selectedTratamientos[$paciente->id] == 'inicial' ? 'selected' : '' }}>
        {{ $paciente->trat_realizado }}
    </option>
    @endif
    @foreach($paciente->tratamientos as $tratamiento)
    <option value="{{ $tratamiento->id }}" {{ isset($selectedTratamientos[$paciente->id]) && $selectedTratamientos[$paciente->id] == $tratamiento->id ? 'selected' : '' }}>
        {{ $tratamiento->tratamiento->cod_trat }}
    </option>
    @endforeach
</select>
        </td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">
                            @php
                                $selectedTratamientoId = $selectedTratamientos[$paciente->id] ?? 'inicial';
                                if ($selectedTratamientoId === 'inicial' && $paciente->trat_realizado) {
                                $selectedTratamiento = (object)['obs_trat' => '' . $paciente->obs_trat];
                                } else {
                                $selectedTratamiento = $paciente->tratamientos->firstWhere('id', $selectedTratamientoId);
                                }
                            @endphp

                            @if($selectedTratamiento)
                                {{ $selectedTratamiento->obs_trat }}   
                             @else
                                    No hay observaciones disponibles.
                            @endif
                            </td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">
                            @php
                                $selectedTratamientoId = $selectedTratamientos[$paciente->id] ?? 'inicial';
                                if ($selectedTratamientoId === 'inicial' && $paciente->trat_realizado) {
                                $selectedTratamiento = (object)['estado_trat' => '' . $paciente->estado_trat];
                                } else {
                                $selectedTratamiento = $paciente->tratamientos->firstWhere('id', $selectedTratamientoId);
                                }
                            @endphp

                            @if($selectedTratamiento)
                                {{ $selectedTratamiento->estado_trat }}   
                             @else
                                    No hay observaciones disponibles.
                            @endif
                                </td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">
                            @php
                                $selectedTratamientoId = $selectedTratamientos[$paciente->id] ?? 'inicial';
                                if ($selectedTratamientoId === 'inicial' && $paciente->trat_realizado) {
                                $selectedTratamiento = (object)['precio_trat' => '' . $paciente->precio_trat];
                                } else {
                                $selectedTratamiento = $paciente->tratamientos->firstWhere('id', $selectedTratamientoId);
                                }
                            @endphp

                            @if($selectedTratamiento)
                                {{ $selectedTratamiento->precio_trat }}   
                             @else
                                    No hay observaciones disponibles.
                            @endif
                                </td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">
                            @php
                                $selectedTratamientoId = $selectedTratamientos[$paciente->id] ?? 'inicial';
                                if ($selectedTratamientoId === 'inicial' && $paciente->trat_realizado) {
                                $selectedTratamiento = (object)['acuenta_trat' => '' . $paciente->acuenta_trat];
                                } else {
                                $selectedTratamiento = $paciente->tratamientos->firstWhere('id', $selectedTratamientoId);
                                }
                            @endphp

                            @if($selectedTratamiento)
                                {{ $selectedTratamiento->acuenta_trat }}   
                             @else
                                    No hay observaciones disponibles.
                            @endif
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">
                            @php
                                $selectedTratamientoId = $selectedTratamientos[$paciente->id] ?? 'inicial';
                                if ($selectedTratamientoId === 'inicial' && $paciente->trat_realizado) {
                                $selectedTratamiento = (object)['saldo_trat' => '' . $paciente->saldo_trat];
                                } else {
                                $selectedTratamiento = $paciente->tratamientos->firstWhere('id', $selectedTratamientoId);
                                }
                            @endphp

                            @if($selectedTratamiento)
                                {{ $selectedTratamiento->saldo_trat }}   
                             @else
                                    No hay observaciones disponibles.
                            @endif
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">                                    
                            @php
                                $selectedTratamientoId = $selectedTratamientos[$paciente->id] ?? 'inicial';
                                if ($selectedTratamientoId === 'inicial' && $paciente->trat_realizado) {
                                $selectedTratamiento = (object)['fecha_trat' => '' . $paciente->fecha_trat];
                                } else {
                                $selectedTratamiento = $paciente->tratamientos->firstWhere('id', $selectedTratamientoId);
                                }
                            @endphp

                            @if($selectedTratamiento)
                                {{ $selectedTratamiento->fecha_trat }}   
                             @else
                                    No hay observaciones disponibles.
                            @endif                              
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c] text-truncate">
                            @php
                                $selectedTratamientoId = $selectedTratamientos[$paciente->id] ?? 'inicial';
                                if ($selectedTratamientoId === 'inicial' && $paciente->trat_realizado) {
                                $selectedTratamiento = (object)['hora_trat' => '' . $paciente->hora_trat];
                                } else {
                                $selectedTratamiento = $paciente->tratamientos->firstWhere('id', $selectedTratamientoId);
                                }
                            @endphp

                            @if($selectedTratamiento)
                                {{ $selectedTratamiento->hora_trat }}   
                             @else
                                    No hay observaciones disponibles.
                            @endif   
                            <td class="border px-4 py-2 border-[#d3979a] text-center" style="min-width: 200px;">
                                    
                            <button wire:click="editar({{ $paciente->id }})" class="inline-flex items-center px-4 py-2 bg-[#d3979a] border border-transparent rounded-md text-xl text-white tracking-widest hover:bg-[#b17b7c] focus:bg-[#b17b7c] active:bg-[#8f6364] focus:outline-none focus:ring-2 focus:ring-[#d3979a] focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-regular fa-pen-to-square"></i></button>
                                 
    

                                    <button wire:click="confirmarBorrado({{ $paciente->id }})" class="inline-flex items-center px-4 py-2 bg-[#5d5c5c] border border-transparent text-xl rounded-md text-white uppercase tracking-widest hover:bg-[#5f5e5e] focus:bg-[#5f5e5e] active:bg-[#5f5e5e] focus:outline-none focus:ring-2 focus:ring-[#5d5c5c] focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-regular fa-trash-can"></i></button>
                                
                                    <button wire:click="agregarTratamiento({{ $paciente->id }})" class="inline-flex items-center px-4 py-2 bg-[#fcf6db] border border-transparent text-xl rounded-md text-[#333] uppercase tracking-widest hover:bg-[#e6e0d1] focus:bg-[#e6e0d1] active:bg-[#d4cfc1] focus:outline-none focus:ring-2 focus:ring-[#fcf6db] focus:ring-offset-2 transition ease-in-out duration-150 mb-3">
    <i class="fa-regular fa-address-card"></i>
</button>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('confirmarBorrado', id => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, borrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('borrarRegistro', id);
                    Swal.fire(
                        '¡Borrado!',
                        'El registro ha sido eliminado.',
                        'success'
                    )
                }
            })
        });
    });
</script>
