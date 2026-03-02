<!-- <x-guest-layout>
    <div class="text-center">
        <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-[2rem] flex items-center justify-center mx-auto mb-6 shadow-lg shadow-indigo-50 rotate-3">
            <i class="fa-solid fa-envelope-open-text text-3xl"></i>
        </div>

        <h2 class="text-xs font-black uppercase tracking-[0.2em] text-indigo-500 mb-2">Você foi convidado!</h2>
        <h1 class="text-3xl font-black text-slate-800 tracking-tighter mb-4">{{ $event->titulo }}</h1>
        
        <div class="space-y-4 mb-10">
            <div class="bg-slate-50 rounded-3xl p-6 text-left border border-slate-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-slate-400">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 leading-none">Data e Hora</p>
                        <p class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($event->data_horario)->translatedFormat('d \d\e F \a\s H:i') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-slate-400">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 leading-none">Localização</p>
                        <p class="text-sm font-bold text-slate-700">{{ $event->local }}</p>
                    </div>
                </div>
            </div>

            @if($event->descricao)
                <p class="text-slate-500 text-sm italic italic leading-relaxed px-4">
                    "{{ $event->descricao }}"
                </p>
            @endif
        </div>

        @if($convidado->confirmado)
            <div class="bg-emerald-50 border border-emerald-100 rounded-3xl p-6">
                <div class="w-12 h-12 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-emerald-100">
                    <i class="fa-solid fa-check text-xl"></i>
                </div>
                <h3 class="font-black text-emerald-800 uppercase text-xs tracking-widest">Presença Confirmada!</h3>
                <p class="text-emerald-600 text-xs font-bold mt-1">Nos vemos lá, {{ explode(' ', $convidado->nome)[0] }}!</p>
            </div>
        @else
            <form action="{{ route('convite.confirmar', $convidado->id) }}" method="POST">
                @csrf
                <p class="text-slate-400 text-[10px] font-black uppercase mb-4 tracking-widest">Olá, {{ $convidado->nome }}! Você vai?</p>
                <div class="grid grid-cols-1 gap-3">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-heart"></i> Sim, eu vou!
                    </button>
                    <p class="text-[10px] text-slate-300 font-bold mt-2 italic">* Ao confirmar, o organizador será notificado.</p>
                </div>
            </form>
        @endif
    </div>
</x-guest-layout> -->