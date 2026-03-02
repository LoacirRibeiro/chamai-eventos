
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loacir Eventos | Organize sua Festa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased">

    <nav class="p-6 flex justify-between items-center bg-white shadow-sm">
        <div class="text-2xl font-black text-indigo-600 tracking-tighter">
            LOACIR <span class="text-slate-800">EVENTOS</span>
        </div>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-slate-600 hover:text-indigo-600 transition">Meu Painel</a>
                @else
                    <a href="{{ route('login') }}" class="mr-4 font-semibold text-slate-600 hover:text-indigo-600 transition">Entrar</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-md font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Começar Grátis</a>
                @endauth
            @endif
        </div>
    </nav>

    <header class="max-w-7xl mx-auto px-6 py-16 text-center">
        <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mb-6 leading-tight">
            Toda grande celebração <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">começa com organização.</span>
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-10">
            Cadastre sua festa, gerencie convidados, divida a lista de itens e guarde as melhores fotos em um só lugar.
        </p>
        
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-slate-900 text-white rounded-md font-bold text-lg hover:scale-105 transition-transform shadow-xl">
                Criar Meu Primeiro Evento
            </a>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white p-8 rounded-md border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-md flex items-center justify-center mb-6 text-xl">
                <i class="fa-solid fa-calendar-plus"></i>
            </div>
            <h3 class="font-bold text-xl mb-2 text-slate-800">Organize Tudo</h3>
            <p class="text-slate-500 text-sm">Defina local, data e horário com contagem regressiva inteligente.</p>
        </div>

        <div class="bg-white p-8 rounded-md border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-md flex items-center justify-center mb-6 text-xl">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <h3 class="font-bold text-xl mb-2 text-slate-800">Quem leva o quê?</h3>
            <p class="text-slate-500 text-sm">Compartilhe a lista de itens para que cada convidado saiba o que levar. Evita que em um churrasco apareçam 10 pessoas com pão de alho e ninguém com o carvão.</p>
        </div>

        <div class="bg-white p-8 rounded-md border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-md flex items-center justify-center mb-6 text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <h3 class="font-bold text-xl mb-2 text-slate-800">Lista VIP</h3>
            <p class="text-slate-500 text-sm">Controle as confirmações de presença (RSVP) em tempo real.</p>
        </div>

        <div class="bg-white p-8 rounded-md border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-md flex items-center justify-center mb-6 text-xl">
                <i class="fa-solid fa-camera-retro"></i>
            </div>
            <h3 class="font-bold text-xl mb-2 text-slate-800">Galeria Viva</h3>
            <p class="text-slate-500 text-sm">Espaço dedicado para os convidados subirem as fotos do evento.</p>
        </div>
    </section>

</body>
</html>