<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800 tracking-tight">
                <i class="fa-solid fa-rocket text-indigo-500 mr-2"></i>Gerenciar: {{ $event->titulo }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600">Voltar</a>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('sucesso'))
            <div class="mb-6 p-4 bg-emerald-100 text-emerald-700 rounded-2xl font-bold shadow-sm">
                {{ session('sucesso') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <h3 class="font-black text-slate-800 mb-6 flex items-center gap-2 text-lg">
                        <i class="fa-solid fa-users text-indigo-500"></i> Convidados
                    </h3>
                    
                    <form action="{{ route('events.addGuest', $event) }}" method="POST" class="flex gap-2 mb-8">
                        @csrf
                        <input type="text" name="nome" placeholder="Nome do parente/amigo" class="flex-1 rounded-xl border-slate-200 text-sm focus:ring-indigo-500" required>
                        <button class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            +
                        </button>
                    </form>

                    <div class="space-y-3">
                        @forelse ($event->convidados as $convidado)
                            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $convidado->nome }}</p>
                                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md {{ $convidado->presenca == 'confirmado' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ $convidado->presenca }}
                                    </span>
                                </div>
                                <button onclick="copyLink('{{ route('convite.vip', $convidado->token_acesso) }}')" class="p-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                    <i class="fa-solid fa-share-nodes mr-1"></i> Link VIP
                                </button>
                            </div>
                        @empty
                            <p class="text-center text-slate-400 text-sm italic py-4">Nenhum convidado na lista.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <h3 class="font-black text-slate-800 mb-6 flex items-center gap-2 text-lg">
                        <i class="fa-solid fa-list-check text-indigo-500"></i> O que levar?
                    </h3>

                    <form action="{{ route('events.addItem', $event) }}" method="POST" class="grid grid-cols-3 gap-2 mb-8">
                        @csrf
                        <input type="text" name="nome" placeholder="Item" class="col-span-1 rounded-xl border-slate-200 text-sm" required>
                        <input type="text" name="quantidade" placeholder="Qtd" class="col-span-1 rounded-xl border-slate-200 text-sm">
                        <button class="bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition shadow-lg text-sm">
                            Adicionar
                        </button>
                    </form>

                    <div class="space-y-3">
                        @forelse ($event->itens as $item)
                            <div class="flex items-center justify-between p-4 border border-slate-50 rounded-2xl bg-white shadow-sm">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $item->nome }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium uppercase">{{ $item->quantidade }}</p>
                                </div>
                                <div class="text-right">
                                    @if($item->convidado_id)
                                        <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md">
                                            Leva: {{ $item->quemLeva->nome }}
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold text-slate-300 italic uppercase">Disponível</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-slate-400 text-sm italic py-4">Nenhum item cadastrado.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 mt-4">
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                    <h3 class="font-black text-slate-800 mb-6 flex items-center gap-2 text-lg">
                        <i class="fa-solid fa-camera-retro text-indigo-500"></i> Álbum de Fotos
                    </h3>

                    <form action="{{ route('events.uploadFotos', $event) }}" method="POST" enctype="multipart/form-data" class="mb-8 p-10 border-2 border-dashed border-slate-100 rounded-[2rem] bg-slate-50/50 text-center">
                        @csrf
                        <div class="max-w-xs mx-auto">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 mb-4"></i>
                            <input type="file" name="fotos[]" multiple class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                            <p class="mt-3 text-[10px] text-slate-400 font-bold uppercase tracking-wider">Formatos: JPG, PNG (Máx 5MB)</p>
                            <button type="submit" class="mt-6 w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                Enviar para o Álbum
                            </button>
                        </div>
                    </form>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @forelse($event->fotos as $foto)
                            <div class="aspect-square rounded-2xl overflow-hidden shadow-sm border border-slate-100 group relative">
                                <img src="{{ asset('storage/' . $foto->caminho) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-indigo-600/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center pointer-events-none">
                                    <i class="fa-solid fa-eye text-white text-xl"></i>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center">
                                <p class="text-slate-400 text-sm italic font-medium">O álbum ainda está vazio. Suba as fotos da festa aqui!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            </div>
    </div>

    <script>
        function copyLink(link) {
            const urlCompleta = window.location.origin + link;
            navigator.clipboard.writeText(urlCompleta);
            alert('Link do convidado copiado! Mande para ele no WhatsApp.');
        }
    </script>
</x-app-layout>