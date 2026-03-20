<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-6 text-center">
        <h2 class="text-3xl font-black text-slate-800 mb-2">Bem-vindo ao Chamaí!</h2>
        <p class="text-slate-500 font-medium mb-12">Como você quer começar sua jornada hoje?</p>

        <div class="grid md:grid-cols-2 gap-8">
            <a href="{{ route('events.create') }}" class="group p-8 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-indigo-600 hover:shadow-xl transition-all text-left">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-6 text-2xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2">Criar Evento</h3>
                <p class="text-slate-400 text-sm">Organize festas, churrascos ou encontros. Gerencie convidados e itens facilmente.</p>
            </a>

            <a href="{{ route('doacoes.create') }}" class="group p-8 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-emerald-600 hover:shadow-xl transition-all text-left">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-6 text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-2">Nova Doação</h3>
                <p class="text-slate-400 text-sm">Crie uma campanha de arrecadação de itens para causas sociais ou solidárias.</p>
            </a>
        </div>
    </div>
</x-app-layout>