<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-xl font-bold text-slate-800">Recuperar Senha</h2>
        <p class="text-sm text-slate-500 font-medium px-4">
            Esqueceu? Sem problemas. Diga seu e-mail e enviaremos um link para você escolher uma nova.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">Seu E-mail cadastrado</label>
            <x-text-input id="email" class="block mt-1 w-full !rounded-2xl border-slate-200 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 uppercase tracking-widest">
                Enviar Link de Resgate
            </button>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-slate-400 font-bold hover:text-slate-600 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Voltar para o Login
            </a>
        </div>
    </form>
</x-guest-layout>