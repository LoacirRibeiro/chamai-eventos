<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-6">
        <div class="mb-8">
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Editar Necessidade</h2>
            <p class="text-slate-500 font-medium">Ajuste os dados de: {{ $item->nome }}</p>
        </div>

        <form action="{{ route('doacao_itens.update', $item) }}" method="POST" 
              class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-black text-slate-700 uppercase mb-2">Nome do Item</label>
                <input type="text" name="nome" value="{{ old('nome', $item->nome) }}" required
                    class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 p-4">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase mb-2">Meta de Quantidade</label>
                    <input type="number" name="quantidade_meta" value="{{ old('quantidade_meta', $item->quantidade_meta) }}" required
                        class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 p-4">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-700 uppercase mb-2">Unidade</label>
                    <select name="unidade_medida" class="w-full border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 p-4">
                        @foreach(['un', 'kg', 'litros', 'pacotes'] as $unidade)
                            <option value="{{ $unidade }}" {{ old('unidade_medida', $item->unidade_medida) == $unidade ? 'selected' : '' }}>
                                {{ $unidade }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('doacoes.show', $item->doacao_id) }}" 
                   class="flex-1 bg-slate-100 text-slate-600 text-center py-4 rounded-xl font-black uppercase hover:bg-slate-200 transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="flex-1 bg-emerald-600 text-white py-4 rounded-xl font-black uppercase hover:bg-emerald-700 transition shadow-lg shadow-emerald-100">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</x-app-layout>