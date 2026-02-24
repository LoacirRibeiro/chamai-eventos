@if(auth()->user()->unreadNotifications->count() > 0)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4 px-2">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                Novidades
            </h3>
            </div>
        
        <div class="space-y-3">
            @foreach(auth()->user()->unreadNotifications as $notification)
                <div class="flex items-center justify-between p-4 bg-white border border-indigo-100 rounded-3xl shadow-sm shadow-indigo-50/50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center">
                            <i class="fa-solid fa-bell text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-700 font-semibold">{{ $notification->data['mensagem'] }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ $notification->data['link'] }}" class="px-4 py-2 text-[11px] font-black bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 uppercase">
                            Ver
                        </a>
                    </div>
                </div>
                @php $notification->markAsRead(); @endphp
            @endforeach
        </div>
    </div>
@endif

<div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
    <div class="p-8">
        <h3 class="font-bold text-lg text-slate-800 mb-6">Meus Eventos Ativos</h3>
        
        <div class="space-y-4">
            @forelse ($eventos as $evento)
                <div class="flex items-center justify-between p-4 border border-slate-50 rounded-2xl hover:bg-slate-50 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex flex-col items-center justify-center font-bold transition group-hover:bg-indigo-600 group-hover:text-white">
                            <span class="text-lg leading-none">{{ \Carbon\Carbon::parse($evento->data_horario)->format('d') }}</span>
                            <span class="text-[10px] uppercase">{{ \Carbon\Carbon::parse($evento->data_horario)->translatedFormat('M') }}</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 group-hover:text-indigo-600 transition">{{ $evento->titulo }}</h4>
                            <p class="text-sm text-slate-500 font-medium">
                                <i class="fa-solid fa-location-dot mr-1 text-slate-300"></i> {{ $evento->local }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('events.show', $evento->id) }}" class="px-4 py-2 text-sm font-bold bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all">
                            Gerenciar
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="text-slate-200 text-6xl mb-4">
                        <i class="fa-regular fa-calendar-plus"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Você ainda não criou nenhum evento.</p>
                    <a href="{{ route('events.create') }}" class="text-indigo-600 font-black hover:underline mt-2 inline-block uppercase text-xs tracking-wider">
                        Criar meu primeiro evento agora!
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
