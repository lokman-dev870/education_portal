<div>
    @if($showBanner)
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 animate-bounce">
            <div class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-3">
                <span class="text-2xl">🔥</span>
                <span class="font-bold">{{ $newContentCount }} contenido{{ $newContentCount > 1 ? 's' : '' }} nuevo{{ $newContentCount > 1 ? 's' : '' }}!</span>
                <button wire:click="refreshContent" 
                        class="px-4 py-1 bg-white text-purple-600 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                    Ver ahora
                </button>
                <button wire:click="dismissBanner" 
                        class="ml-2 hover:bg-white/20 rounded-full p-1 transition-colors">
                    ✕
                </button>
            </div>
        </div>
    @endif
</div>

<script>
    // Simular chequeo de nuevo contenido cada 30 segundos
    setInterval(() => {
        @this.call('checkNewContent');
    }, 30000);
</script>
