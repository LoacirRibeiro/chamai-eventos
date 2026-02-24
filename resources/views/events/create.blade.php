<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Novo Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100 p-8">
                
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="titulo" class="block text-sm font-medium text-slate-700 mb-2">Título do Evento</label>
                        <input type="text" name="titulo" id="titulo" placeholder="Ex: Churrasco da Família Loacir" 
                               class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="data_horario" class="block text-sm font-medium text-slate-700 mb-2">Quando?</label>
                            <input type="datetime-local" name="data_horario" id="data_horario" 
                                   class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                        </div>

                        <div>
                            <label for="local" class="block text-sm font-medium text-slate-700 mb-2">Onde?</label>
                            <input type="text" name="local" id="local" placeholder="Endereço ou link do Maps" 
                                   class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="descricao" class="block text-sm font-medium text-slate-700 mb-2">Descrição (Opcional)</label>
                        <textarea name="descricao" id="descricao" rows="3" placeholder="Informações extras para os convidados..." 
                                  class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-bold transition shadow-lg shadow-indigo-100">
                            Criar Evento
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>