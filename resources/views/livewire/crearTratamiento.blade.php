<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">    
                <form>
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
                            <label for="cod_trat" class="block text-[#d3979a] text-sm font-bold mb-2">Codigo Tratamiento:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="cod_trat" wire:model="cod_trat">
                        </div>
                        <div class="mb-4">
                            <label for="nomb_trat" class="block text-[#d3979a] text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="nomb_trat" wire:model="nomb_trat">
                        </div>
                        <div class="mb-4">
                            <label for="costo_trat" class="block text-[#d3979a] text-sm font-bold mb-2">Costo Promedio:</label>
                            <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-[#5d5c5c] leading-tight focus:outline-none focus:shadow-outline focus:border-[#d3979a] focus:ring-[#d3979a] focus:ring-opacity-50 focus:ring-2 focus:ring-offset-2" id="costo_trat" wire:model="costo_trat" step="0.01">
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button wire:click.prevent="guardar()" type="button" class="inline-flex items-center px-4 py-2 bg-[#d3979a] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#b17b7c] focus:bg-[#b17b7c] active:bg-[#8f6364] focus:outline-none focus:ring-2 focus:ring-[#d3979a] focus:ring-offset-2 transition ease-in-out duration-150">Guardar</button>
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