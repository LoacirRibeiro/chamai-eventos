<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-6">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-indigo-600 text-sm font-bold transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Voltar ao Início
            </a>
            <h2 class="text-3xl font-black text-slate-800 mt-4">Nova Campanha de Doação</h2>
            <p class="text-slate-500 font-medium">Preencha os dados básicos para começar a arrecadar.</p>
        </div>

        <form action="{{ route('doacoes.store') }}" method="POST" class="space-y-6 bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
            @csrf

            <div>
                <label for="titulo" class="block text-sm font-black text-slate-700 uppercase tracking-tight mb-2">Título da Campanha</label>
                <input type="text" name="titulo" id="titulo" required placeholder="Ex: Arrecadação de Alimentos - Natal 2026"
                    class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 p-4">
            </div>

            <div>
                <label for="descricao" class="block text-sm font-black text-slate-700 uppercase tracking-tight mb-2">Descrição / Objetivo</label>
                <textarea name="descricao" id="descricao" rows="4" placeholder="Explique para que serve essa doação..."
                    class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 p-4"></textarea>
            </div>

            <div>
                <label for="data_limite" class="block text-sm font-black text-slate-700 uppercase tracking-tight mb-2">Data Limite (Opcional)</label>
                <input type="date" name="data_limite" id="data_limite" 
                    class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 p-4 text-slate-500">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-xl font-black uppercase tracking-widest hover:bg-emerald-700 transition shadow-lg shadow-emerald-100">
                    Criar Campanha agora
                </button>
            </div>
        </form>
    </div>
</x-app-layout>