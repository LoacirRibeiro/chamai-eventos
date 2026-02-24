<div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
    <div class="p-8">
        <h3 class="font-bold text-lg text-slate-800 mb-6">Meus Eventos Ativos</h3>
        
        <div class="space-y-4">
            @forelse ($eventos as $evento)
                <div class="flex items-center justify-between p-4 border border-slate-50 rounded-2xl hover:bg-slate-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex flex-col items-center justify-center font-bold">
                            <span class="text-lg">{{ \Carbon\Carbon::parse($evento->data_horario)->format('d') }}</span>
                            <span class="text-[10px] uppercase">{{ \Carbon\Carbon::parse($evento->data_horario)->translatedFormat('M') }}</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $evento->titulo }}</h4>
                            <p class="text-sm text-slate-500 font-medium">
                                <i class="fa-solid fa-location-dot mr-1"></i> {{ $evento->local }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('events.show', $evento->id) }}" class="px-4 py-2 text-sm font-bold bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition">
                            Gerenciar
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="text-slate-300 text-5xl mb-4">
                        <i class="fa-regular fa-calendar-plus"></i>
                    </div>
                    <p class="text-slate-500">Você ainda não criou nenhum evento.</p>
                    <a href="{{ route('events.create') }}" class="text-indigo-600 font-bold hover:underline">Criar meu primeiro evento agora!</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
