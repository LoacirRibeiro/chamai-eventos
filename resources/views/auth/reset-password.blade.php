<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-xl font-bold text-slate-800">Nova Senha</h2>
        <p class="text-sm text-slate-500 font-medium">Escolha uma senha forte desta vez!</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">E-mail</label>
            <x-text-input id="email" class="block mt-1 w-full !rounded-md border-slate-100 bg-slate-50 text-slate-400" type="email" name="email" :value="old('email', $request->email)" required readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">Nova Senha</label>
            <x-text-input id="password" class="block mt-1 w-full !rounded-md border-slate-200 focus:ring-indigo-500" type="password" name="password" required autofocus autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label class="block text-xs font-black uppercase text-slate-400 mb-2 ml-1">Confirmar Nova Senha</label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full !rounded-md border-slate-200 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button class="w-full bg-emerald-600 text-white py-4 rounded-md font-black text-sm hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 uppercase tracking-widest">
                Redefinir Senha
            </button>
        </div>
    </form>
</x-guest-layout>