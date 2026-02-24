<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 tracking-tight">
                Meus <span class="text-indigo-600">Eventos</span>
            </h2>
            <a href="{{ route('events.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-black text-sm transition shadow-lg shadow-indigo-100 flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Novo Evento
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            <div class="mb-10">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2 mb-4 px-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Novidades
                </h3>
                
                <div class="grid gap-3">
                    @foreach(auth()->user()->unreadNotifications as $notification)
                        <div class="flex items-center justify-between p-4 bg-white border border-indigo-50 rounded-[2rem] shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center">
                                    <i class="fa-solid fa-bell text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-700 font-bold">{{ $notification->data['mensagem'] }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ $notification->data['link'] }}" class="px-4 py-2 text-[10px] font-black bg-slate-100 text-slate-600 rounded-xl hover:bg-indigo-600 hover:text-white transition uppercase">
                                Ver
                            </a>
                        </div>
                        @php $notification->markAsRead(); @endphp
                    @endforeach
                </div>
            </div>
        @endif

        <div class="px-2 mb-6">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Seus Eventos Ativos</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($events as $evento)
                <div class="group bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-6">
                            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl px-4 py-2 text-center transition group-hover:bg-indigo-600 group-hover:border-indigo-600">
                                <span class="block text-indigo-600 font-black text-xl leading-none group-hover:text-white">
                                    {{ \Carbon\Carbon::parse($evento->data_horario)->format('d') }}
                                </span>
                                <span class="text-[10px] uppercase font-black text-indigo-400 tracking-tighter group-hover:text-indigo-100">
                                    {{ \Carbon\Carbon::parse($evento->data_horario)->translatedFormat('M') }}
                                </span>
                            </div>
                            
                            <span class="text-[10px] font-black bg-slate-50 text-slate-400 px-3 py-1 rounded-full uppercase border border-slate-100">
                                {{ $evento->convidados_count ?? $evento->convidados->count() }} Convidados
                            </span>
                        </div>

                        <h3 class="text-xl font-black text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">
                            {{ $evento->titulo }}
                        </h3>
                        
                        <p class="text-sm text-slate-500 font-medium mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-indigo-400"></i>
                            <span class="truncate">{{ $evento->local ?? 'Local a definir' }}</span>
                        </p>

                        <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Festa em andamento</span>
                            
                            <a href="{{ route('events.show', $evento->id) }}" class="flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl font-black text-[11px] uppercase hover:bg-indigo-600 transition-all shadow-lg shadow-slate-100 hover:shadow-indigo-100">
                                Gerenciar <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-[3rem] border border-dashed border-slate-200">
                    <div class="text-slate-200 text-6xl mb-4">
                        <i class="fa-regular fa-calendar-plus"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Você ainda não criou nenhum evento.</h3>
                    <p class="text-slate-500 mb-6">Organize sua próxima festa em poucos cliques!</p>
                    <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-indigo-700 transition inline-block">
                        Criar meu primeiro evento
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>