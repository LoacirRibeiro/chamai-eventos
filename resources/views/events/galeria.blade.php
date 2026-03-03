<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('events.show', $event) }}" 
                   class="w-10 h-10 flex items-center justify-center rounded-md bg-white border-4 border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-[40px] text-slate-800 tracking-tight leading-none">
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

    <div class="py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- SEÇÃO DE UPLOAD --}}
            <div class="max-w-2xl mx-auto">
                <div class="bg-white p-3 rounded-md border-4 border-slate-100 shadow-sm">
                    <form action="{{ route('fotos.store', $event) }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          id="form-galeria">
                        @csrf
                        <label for="fotos-input" 
                               class="flex flex-col items-center justify-center border-4 border-dashed border-slate-100 rounded-md py-16 px-6 hover:border-indigo-400 hover:bg-indigo-50/30 transition cursor-pointer group">
                            
                            <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-md flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition duration-300">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>

                            <h3 class="font-black text-slate-700 uppercase tracking-tighter text-lg">
                                Subir Fotos
                            </h3>

                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2 text-center">
                                Arraste ou clique para selecionar <br>
                                <span class="text-[10px] text-indigo-400">
                                    (Vários arquivos JPG, PNG ou WEBP)
                                </span>
                            </p>

                            {{-- O input chama a função JS 'handleFiles' assim que muda --}}
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

            <div class="h-16 md:h-24"></div>

            {{-- DIVISOR ESTILIZADO --}}
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t-4 border-slate-100"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-slate-50 px-8 py-2 text-xs font-black tracking-widest text-slate-400 uppercase rounded-md border-4 border-slate-100">
                        Mural do Evento
                    </span>
                </div>
            </div>

            <div class="h-16 md:h-24"></div>

            {{-- GRID DA GALERIA --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
                @forelse($event->fotos as $foto)
                    <div class="group relative aspect-square rounded-md overflow-hidden bg-slate-100 shadow-xl border-4 border-white transition-all duration-500 hover:-translate-y-2 hover:shadow-indigo-200/50">
                        
                        <img src="{{ asset('storage/' . $foto->caminho) }}" 
                             alt="Foto do evento"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-110 group-hover:rotate-2">

                        {{-- Overlay de Ações --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                            
                            <div class="flex justify-between items-end">
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-indigo-300 uppercase tracking-widest mb-1">Enviada por</span>
                                    <span class="text-xs font-bold text-white truncate max-w-[100px]">
                                        {{ $foto->user->name ?? 'Anônimo' }}
                                    </span>
                                </div>
                                
                                <div class="flex gap-2">
                                    {{-- Expandir --}}
                                    <a href="{{ asset('storage/' . $foto->caminho) }}" 
                                       target="_blank" 
                                       class="w-9 h-9 bg-white/10 backdrop-blur-md text-white rounded-md flex items-center justify-center hover:bg-white hover:text-indigo-600 transition shadow-lg">
                                        <i class="fa-solid fa-expand"></i>
                                    </a>

                                    {{-- Excluir --}}
                                    @if(Auth::id() === $foto->user_id || Auth::id() === $event->user_id)
                                        <button type="button" 
                                                onclick="confirmarExclusaoFoto('{{ $foto->id }}')"
                                                class="w-9 h-9 bg-rose-500/80 backdrop-blur-md text-white rounded-md flex items-center justify-center hover:bg-rose-600 transition shadow-lg">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
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
                    <div class="col-span-full py-20 text-center">
                        <div class="w-20 h-20 bg-white border-4 border-slate-100 text-slate-200 rounded-md flex items-center justify-center text-3xl mx-auto mb-6 shadow-sm">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <h4 class="font-black text-slate-800 uppercase tracking-tight text-xl">Nenhuma foto ainda</h4>
                        <p class="text-slate-400 font-bold italic mt-2">Seja o primeiro a registrar esse momento!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- SCRIPTS DE FUNCIONAMENTO --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Upload Automático
        function handleFiles(input) {
            if (input.files.length > 0) {
                Swal.fire({
                    title: 'Lançando memórias!',
                    text: 'Aguarde enquanto subimos suas fotos...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                document.getElementById('form-galeria').submit();
            }
        }

        // 2. Confirmação de Exclusão
        function confirmarExclusaoFoto(id) {
            Swal.fire({
                title: 'Remover esta foto?',
                text: "Ela sumirá do mural para sempre!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'SIM, APAGAR',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-md border-4 border-slate-100',
                    confirmButton: 'rounded-md font-black',
                    cancelButton: 'rounded-md font-black'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-foto-' + id).submit();
                }
            });
        }

        // 3. Feedback de Sucesso
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Perfeito!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'rounded-md border-4 border-slate-100' }
            });
        @endif
    </script>
</x-app-layout>