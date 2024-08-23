<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">    
                <form wire:submit.prevent="guardar">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">¡Error!</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                        <div class="mb-4">
                            <label for="nom_pac" class="block text-[#d3979a] text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="nom_pac" wire:model="nombres_pc">
                        </div>
                        <div class="mb-4">
                            <label for="ap_pat_pc" class="block text-[#d3979a] text-sm font-bold mb-2">Apellido Paterno:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="ap_pat_pc" wire:model="ap_pat_pc">
                        </div>
                        <div class="mb-4">
                            <label for="ap_mat_pc" class="block text-[#d3979a] text-sm font-bold mb-2">Apellido Materno:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="ap_mat_pc" wire:model="ap_mat_pc">
                        </div>
                        <div class="mb-4">
                            <label for="edad" class="block text-[#d3979a] text-sm font-bold mb-2">Edad:</label>
                            <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="edad" wire:model="edad">
                        </div>
                        <div class="mb-4">
                            <label for="tel_pac" class="block text-[#d3979a] text-sm font-bold mb-2">Telefono:</label>
                            <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="tel_pac" wire:model="tel_pac">
                        </div>
                        <div class="mb-4">
                            <label for="direccion_pc" class="block text-[#d3979a] text-sm font-bold mb-2">Direccion domicilio:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="direccion_pc" wire:model="direccion_pc">
                        </div>
                        <div class="mb-4">
                            <label for="ci_pc" class="block text-[#d3979a] text-sm font-bold mb-2">Documento de identidad:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="ci_pc" wire:model="ci_pc">
                        </div>
                        <div class="mb-4">
                            <label for="genero_pc" class="block text-[#d3979a] text-sm font-bold mb-2">Género:</label>
                                <select id="genero_pc" wire:model="genero_pc" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2">
                                <option value="" disabled>Selecciona una opción</option>
                                <option value="M">M</option>
                            <option value="F">F</option>
                                </select>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button wire:click.prevent="guardar" type="submit" class="inline-flex items-center px-4 py-2 bg-[#d3979a] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#b17b7c] focus:bg-[#b17b7c] active:bg-[#8f6364] focus:outline-none focus:ring-2 focus:ring-[#d3979a] focus:ring-offset-2 transition ease-in-out duration-150">Guardar</button>
                            </span>

                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button wire:click="cerrarModal()" type="button" class="inline-flex items-center px-4 py-2 bg-[#5d5c5c] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#5f5e5e] focus:bg-[#5f5e5e] active:bg-[#5f5e5e] focus:outline-none focus:ring-2 focus:ring-[#5d5c5c] focus:ring-offset-2 transition ease-in-out duration-150">Cancelar</button>
                            </span>
                        </div>

                    </div>
                </form>    
            </div>


    </div>
</div>