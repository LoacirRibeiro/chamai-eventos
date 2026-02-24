<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-black text-2xl text-slate-800 tracking-tight leading-none">
                        {{ $event->titulo }}
                    </h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">
                        <i class="fa-solid fa-location-dot text-indigo-400 mr-1"></i> {{ $event->local }}
                    </p>
                </div>
            </div>

            <div class="flex gap-2">
                <button class="bg-white text-slate-600 border border-slate-200 px-4 py-2 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Editar
                </button>
                <a href="{{ route('convidados.create', $event) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Convidar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total</p>
                        <h4 class="text-2xl font-black text-slate-800">{{ $event->convidados->count() }}</h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Confirmados</p>
                        <h4 class="text-2xl font-black text-emerald-600">
                            {{ $event->convidados->where('confirmado', true)->count() }}
                        </h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Pendentes</p>
                        <h4 class="text-2xl font-black text-amber-600">
                            {{ $event->convidados->where('confirmado', false)->count() }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-white">
                    <h3 class="font-black text-lg text-slate-800 uppercase tracking-tighter">Lista de Convidados</h3>
                    <div class="flex gap-2">
                         <button onclick="window.print()" class="text-slate-400 hover:text-indigo-600 transition text-sm font-bold uppercase tracking-widest">
                            <i class="fa-solid fa-print"></i> Imprimir
                         </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nome</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($event->convidados as $convidado)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-black text-sm uppercase">
                                                {{ substr($convidado->nome, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-700 leading-tight">{{ $convidado->nome }}</p>
                                                <p class="text-[10px] text-slate-400 font-bold tracking-tight">
                                                    {{ $convidado->telefone ?? 'Sem telefone' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        @if($convidado->confirmado)
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest">Confirmado</span>
                                        @else
                                            <span class="px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-black uppercase tracking-widest">Pendente</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex justify-end gap-3 items-center">
                                            
                                            @if($convidado->telefone)
                                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $convidado->telefone) }}?text={{ urlencode('Olá ' . explode(' ', $convidado->nome)[0] . '! 🚀' . PHP_EOL . 'Aqui está seu convite para o evento: ' . $event->titulo . '.' . PHP_EOL . 'Confirme sua presença pelo link:' . PHP_EOL . route('convite.publico', $convidado->id)) }}" 
                                                   target="_blank"
                                                   class="flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-600 hover:text-white transition-all border border-emerald-100 group">
                                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                                    <span class="text-[10px] font-black uppercase tracking-widest">Enviar</span>
                                                </a>
                                            @endif

                                            <form action="{{ route('convidados.update', [$event, $convidado]) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="p-2 text-slate-300 hover:text-indigo-600 transition" title="Alternar Presença">
                                                    <i class="fa-solid fa-arrows-rotate"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('convidados.destroy', [$event, $convidado]) }}" method="POST" class="inline" onsubmit="return confirm('Excluir este convidado?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-300 hover:text-rose-500 transition">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-12 text-center text-slate-400 font-medium italic bg-slate-50/30">
                                        Nenhum convidado na lista ainda. <br>
                                        <a href="{{ route('convidados.create', $event) }}" class="text-indigo-600 font-black uppercase text-[10px] tracking-widest mt-2 inline-block hover:underline">Adicionar Primeiro Convidado</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>