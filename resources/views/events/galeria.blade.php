<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('events.show', $event) }}" 
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-slate-800 tracking-tight leading-none">
                        Galeria de Fotos
                    </h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">
                        <i class="fa-solid fa-camera-retro text-indigo-400 mr-1"></i> 
                        Memórias de: {{ $event->titulo }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-24 md:py-28 lg:py-32">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- UPLOAD --}}
            <div class="max-w-2xl mx-auto">
                <div class="bg-white p-3 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <form action="{{ route('fotos.store', $event) }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          id="form-galeria">
                        @csrf
                        <label for="fotos-input" 
                               class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-[2.2rem] py-16 px-6 hover:border-indigo-400 hover:bg-indigo-50/30 transition cursor-pointer group">
                            
                            <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition duration-300">
                                <i class="fa-solid fa-images"></i>
                            </div>

                            <h3 class="font-black text-slate-700 uppercase tracking-tighter">
                                Subir Fotos
                            </h3>

                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2 text-center">
                                Selecione várias fotos de uma vez <br>
                                <span class="text-[10px] text-indigo-400">
                                    (JPG, PNG ou WEBP)
                                </span>
                            </p>

                            <input type="file" 
                                   name="fotos[]" 
                                   id="fotos-input" 
                                   multiple 
                                   class="hidden" 
                                   onchange="handleFiles(this)">
                        </label>
                    </form>
                </div>
            </div>

            {{-- 🔥 MAIS RESPIRO APÓS DIVISOR --}}
            <div class="h-20 md:h-28"></div>

            {{-- DIVISOR --}}
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-8 py-1 text-xs font-black tracking-widest text-slate-400 uppercase rounded-full shadow-sm">
                        Mural do Evento
                    </span>
                </div>
            </div>

            {{-- 🔥 MAIS RESPIRO APÓS DIVISOR --}}
            <div class="h-20 md:h-28"></div>

            {{-- GALERIA --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    @forelse($event->fotos as $foto)
        <div class="group relative aspect-square rounded-[2.5rem] overflow-hidden bg-slate-100 shadow-xl border-4 border-white transition-transform duration-300 hover:-translate-y-2">
            
            <img src="{{ asset('storage/' . $foto->caminho) }}" 
                 alt="Foto do evento"
                 class="w-full h-full object-cover transition duration-700 group-hover:scale-110 group-hover:rotate-1">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                
                <div class="flex justify-between items-center">
                    
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">
                        Por: {{ $foto->user->name ?? 'Dono' }}
                    </span>
                    
                    <div class="flex gap-2">
                        
                        {{-- BOTÃO EXPANDIR --}}
                        <a href="{{ asset('storage/' . $foto->caminho) }}" 
                           target="_blank" 
                           class="w-8 h-8 bg-white/20 backdrop-blur-md text-white rounded-lg flex items-center justify-center hover:bg-white hover:text-slate-900 transition">
                            <i class="fa-solid fa-expand text-xs"></i>
                        </a>

                        {{-- BOTÃO EXCLUIR --}}
                        @if(Auth::id() === $foto->user_id || Auth::id() === $event->user_id)
                            <button type="button" 
                                    onclick="confirmarExclusaoFoto('{{ $foto->id }}')"
                                    class="w-8 h-8 bg-rose-500/80 backdrop-blur-md text-white rounded-lg flex items-center justify-center hover:bg-rose-600 transition">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>

                            <form id="delete-foto-{{ $foto->id }}" 
                                  action="{{ route('fotos.destroy', $foto) }}" 
                                  method="POST" 
                                  class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-32 text-center">
            <div class="w-24 h-24 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-camera"></i>
            </div>
            <h4 class="font-black text-slate-800 uppercase tracking-tight text-xl">
                Nenhuma foto ainda
            </h4>
            <p class="text-slate-400 font-bold italic mt-2">
                As melhores memórias começam aqui. Suba a primeira foto!
            </p>
        </div>
    @endforelse
</div>

        </div>
    </div>

</x-app-layout>