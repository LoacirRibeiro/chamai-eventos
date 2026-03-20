<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-black text-slate-800">Seus Projetos</h2>
            <div class="flex gap-3">
                <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-md font-bold text-sm hover:bg-indigo-700">Novo Evento</a>
                <a href="{{ route('doacoes.create') }}" class="bg-emerald-600 text-white px-5 py-2 rounded-md font-bold text-sm hover:bg-emerald-700">Nova Doação</a>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-12">
            <div>
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Meus Eventos</h3>
                @forelse($events as $event)
                    <div class="bg-white p-4 border rounded-md mb-3 flex justify-between items-center">
                        <span class="font-bold text-slate-700">{{ $event->titulo }}</span>
                        <a href="{{ route('events.show', $event) }}" class="text-indigo-600 text-sm font-bold">Gerenciar</a>
                    </div>
                @empty
                    <p class="text-slate-400 text-sm italic">Nenhum evento criado.</p>
                @endforelse
            </div>

            <div>
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Minhas Doações</h3>
                @forelse($doacoes as $doacao)
                    <div class="bg-white p-4 border rounded-md mb-3 flex justify-between items-center">
                        <span class="font-bold text-emerald-700">{{ $doacao->titulo }}</span>
                        <a href="{{ route('doacoes.show', $doacao) }}" class="text-emerald-600 text-sm font-bold">Ver Campanha</a>
                    </div>
                @empty
                    <p class="text-slate-400 text-sm italic">Nenhuma doação criada.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>