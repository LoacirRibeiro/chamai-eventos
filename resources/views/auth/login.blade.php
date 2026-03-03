<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="text-center mb-8 ">
            <h2 class="text-xl font-bold text-slate-800">Bem-vindo de volta!</h2>
            <p class="text-sm text-slate-500 font-medium">Faça login para gerenciar seus eventos.</p>
        </div>

        <div>
            <label class="block text-[12px] font-black uppercase text-slate-400 mb-2 ml-1">Usuário</label>
            <x-text-input id="email" class="block mt-1 w-full !rounded-md border-slate-200 focus:ring-indigo-500 text-[14px]" type="email" name="email" :value="old('email')" placeholder="Ex: usuario@gmail.com" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">Senha</label>
            <x-text-input id="password" class="block mt-1 w-full !rounded-md border-slate-200 focus:ring-indigo-500" type="password" name="password"  required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-md border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-slate-500 font-medium italic">Lembrar de mim</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-800 font-bold" href="{{ route('password.request') }}">
                    Esqueceu?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button class="w-full bg-indigo-600 text-white py-4 rounded-md font-black text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 uppercase tracking-widest">
                Entrar
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-slate-500">
                Ainda não tem conta? 
                <a href="{{ route('register') }}" class="text-indigo-600 font-black">Crie uma agora</a>
            </p>
        </div>
    </form>
</x-guest-layout>