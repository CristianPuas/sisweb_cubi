<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white focus:ring-2 focus:ring-[#d3979a] focus:ring-offset-2 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
