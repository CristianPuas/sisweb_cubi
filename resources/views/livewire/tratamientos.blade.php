<x-slot name="header">
    <h2 class="text-center text-xl leading-tight text-[#d3979a]">
        TRATAMIENTOS ODONTOLOGICOS
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

            <x-button wire:click="crear()" class="ml-4 mb-4">Nuevo</x-button>
            @if($modal)
                @include('livewire.crearTratamiento')
            @endif

            <div class="mb-4">
                <input type="text" wire:model.debounce.300ms="search" placeholder="Buscar tratamiento..." class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2">
            </div>

            <div class="overflow-x-auto">
                <table class="table-auto min-w-full bg-white border-collapse border border-[#5d5c5c]">
                    <thead class="bg-[#d3979a] text-white">
                        <tr>
                            <th scope="col" class="border border-[#5d5c5c]">#</th>
                            <th scope="col" class="border border-[#5d5c5c]">Codigo tratamiento</th>
                            <th scope="col" class="border border-[#5d5c5c]">Nombre</th>
                            <th scope="col" class="border border-[#5d5c5c]">Costo Promedio</th>
                            <th scope="col" class="border border-[#5d5c5c]">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tratamientos as $index => $tratamiento)
                        <tr>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $tratamiento->cod_trat }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $tratamiento->nomb_trat }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-[#5d5c5c]">{{ $tratamiento->costo_trat }}</td>
                            <td class="border px-4 py-2 border-[#d3979a] text-center">
                                
                                <button wire:click="editar({{ $tratamiento->id }})" class="inline-flex items-center px-4 py-2 bg-[#d3979a] border border-transparent rounded-md text-xl text-white uppercase tracking-widest hover:bg-[#b17b7c] focus:bg-[#b17b7c] active:bg-[#8f6364] focus:outline-none focus:ring-2 focus:ring-[#d3979a] focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button wire:click="confirmarBorrado({{ $tratamiento->id }})" class="inline-flex items-center px-4 py-2 bg-[#5d5c5c] border border-transparent text-xl rounded-md text-white uppercase tracking-widest hover:bg-[#5f5e5e] focus:bg-[#5f5e5e] active:bg-[#5f5e5e] focus:outline-none focus:ring-2 focus:ring-[#5d5c5c] focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-regular fa-trash-can"></i></button>
                                
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
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('borrarRegistro', id);
                    Swal.fire(
                        '¡Borrado!',
                        'El tratamiento ha sido borrado.',
                        'success'
                    )
                }
            })
        });
    });
</script>
