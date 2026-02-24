<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-xl font-bold text-slate-800">Crie sua conta</h2>
            <p class="text-sm text-slate-500 font-medium">Comece a organizar seus eventos hoje.</p>
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">Seu Nome</label>
            <x-text-input id="name" class="block mt-1 w-full !rounded-2xl border-slate-200 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ex: Loacir Santos" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">E-mail</label>
            <x-text-input id="email" class="block mt-1 w-full !rounded-2xl border-slate-200 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">Senha</label>
            <x-text-input id="password" class="block mt-1 w-full !rounded-2xl border-slate-200 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">Confirmar Senha</label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full !rounded-2xl border-slate-200 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black text-sm hover:bg-slate-800 transition shadow-lg shadow-slate-100 uppercase tracking-widest">
                Criar Minha Conta
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-slate-500 font-medium">
                Já tem uma conta? 
                <a href="{{ route('login') }}" class="text-indigo-600 font-black">Fazer Login</a>
            </p>
        </div>
    </form>
</x-guest-layout>