<x-slot name="header">
    <h2 class="text-center text-xl leading-tight text-[#d3979a]">
        PACIENTES CITADOS
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
            <x-button wire:click="crear()" class="ml-4 mb-4">Nueva Consulta</x-button>
            @if($modal)
                @include('livewire.crearConsulta')   
            @endif
            @if($modal2)
                @include('livewire.registroConsulta')   
            @endif
            @if($modalSeleccion)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg w-80">
            <h2 class="text-center text-xl mb-4">Seleccionar Tipo de Registro</h2>
            <div class="flex justify-center gap-4">
                <button wire:click="abrirModalNuevo" class="px-4 py-2 bg-green-500 text-white rounded">PX NUEVO</button>
                <button wire:click="abrirModalRegular" class="px-4 py-2 bg-blue-500 text-white rounded">PX REGULAR</button>
            </div>
            <button wire:click="cerrarModalSeleccion" class="mt-4 px-4 py-2 bg-red-500 text-white rounded block mx-auto">Cancelar</button>
        </div>
    </div>
@endif
            <div class="mb-4 flex items-center">
                <input type="text" wire:model.debounce.300ms="search1" placeholder="Buscar..." class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2">
                <input type="date" wire:model="selectedDate" class="ml-4 shadow appearance-none border rounded py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2">
            </div>
            <div class="overflow-x-auto">
                <table class="table-auto min-w-full bg-white border-collapse border border-[#d3979a]">
                    <thead class="bg-[#5d5c5c] text-white">
                        <tr class="bg-[#d3979a] text-white">
                            <th scope="col" class="border border-[#5d5c5c]">#</th>
                            <th scope="col" class="border border-[#5d5c5c]">Nombre</th>
                            <th scope="col" class="border border-[#5d5c5c]">Apellido</th>
                            <th scope="col" class="border border-[#5d5c5c]">Edad</th>
                            <th scope="col" class="border border-[#5d5c5c]">Teléfono</th>
                            <th scope="col" class="border border-[#5d5c5c]">Motivo de Consulta</th>

                            <th scope="col" class="border border-[#5d5c5c]">Fecha</th>
                            <th scope="col" class="border border-[#5d5c5c]">Hora</th>
                            <th scope="col" class="border border-[#5d5c5c]">Acciones</th>    
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultas as $index => $consulta)
                        <tr>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $consulta->nom_pac }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $consulta->ap_pac }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $consulta->edad_pac }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $consulta->tel_pac }}
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $consulta->tel_pac) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#d3979a] border border-transparent rounded-md text-xl text-white tracking-widest hover:bg-[#b17b7c] focus:bg-[#b17b7c] active:bg-[#8f6364] focus:outline-none focus:ring-2 focus:ring-[#d3979a] focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-brands fa-whatsapp "></i></a>
                            </td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $consulta->motivo_cons }}</td>
                            
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ \Carbon\Carbon::parse($consulta->fecha_cons)->format('d-m-Y') }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $consulta->hora_cons }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-center" style="min-width: 200px;">
                                <button wire:click="editar({{ $consulta->id }})" class="inline-flex items-center px-4 py-2 bg-[#d3979a] border border-transparent rounded-md text-xl text-white uppercase tracking-widest hover:bg-[#b17b7c] focus:bg-[#b17b7c] active:bg-[#8f6364] focus:outline-none focus:ring-2 focus:ring-[#d3979a] focus:ring-offset-2 transition ease-in-out duration-150 mb-3"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button wire:click="confirmarBorrado({{ $consulta->id }})" class="inline-flex items-center px-4 py-2 bg-[#5d5c5c] border border-transparent text-xl rounded-md text-white uppercase tracking-widest hover:bg-[#5f5e5e] focus:bg-[#5f5e5e] active:bg-[#5f5e5e] focus:outline-none focus:ring-2 focus:ring-[#5d5c5c] focus:ring-offset-2 transition ease-in-out duration-150 mb-3"><i class="fa-regular fa-trash-can"></i></button>
                                
                                <button wire:click="registrarConsulta({{ $consulta->id }})" class="inline-flex items-center px-4 py-2 bg-[#fcf6db] border border-transparent text-xl rounded-md text-[#333] uppercase tracking-widest hover:bg-[#e6e0d1] focus:bg-[#e6e0d1] active:bg-[#d4cfc1] focus:outline-none focus:ring-2 focus:ring-[#fcf6db] focus:ring-offset-2 transition ease-in-out duration-150 mb-3">
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
                        'La consulta ha sido borrada.',
                        'success'
                    )
                }
            })
        });
    });
</script>
