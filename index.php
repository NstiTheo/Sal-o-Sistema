<?php
// index.php
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salão Sistem</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-white dark:bg-gray-900">

    <!-- PAGE WRAPPER -->
    <div class="min-h-screen flex flex-col">

        <!-- HEADER -->
        <?php include("header.php"); ?>

        <!-- HERO SECTION -->
        <main class="flex-1 relative isolate px-6 pt-20 lg:px-8">

            <!-- FUNDO GRADIENTE (NUNCA BLOQUEIA CLIQUES) -->
            <div aria-hidden="true"
                class="pointer-events-none absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">

                <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-1/2 aspect-[1155/678] w-[36rem] -translate-x-1/2 rotate-30 
                    bg-gradient-to-tr from-pink-400 to-indigo-400 opacity-30 sm:w-[72rem]">
                </div>
            </div>

            <!-- CONTEÚDO PRINCIPAL -->
            <section class="mx-auto max-w-3xl py-20 sm:py-32 lg:py-40 text-center">

                <!-- TÍTULO -->
                <h1
                    class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-gray-900 dark:text-white leading-tight">
                    Cuidando da Beleza com Responsabilidade e Segurança.
                </h1>

                <!-- TEXTO -->
                <p class="mt-6 text-base sm:text-lg lg:text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                    Promova um ambiente mais seguro para clientes e profissionais através do registro correto
                    dos processos sanitários, reduzindo riscos e facilitando fiscalizações.
                </p>

                <!-- BOTÕES -->
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">

                    <!-- BOTÃO PRINCIPAL -->
                    <a href="dashboard.php"
                        class="w-full sm:w-auto rounded-lg bg-pink-500 px-6 py-3 text-sm sm:text-base font-semibold text-white shadow-md hover:bg-pink-600 transition">
                        Acessar Registros
                    </a>

                    <!-- BOTÃO SECUNDÁRIO -->
                    <a href="relatorios.php"
                        class="w-full sm:w-auto rounded-lg border border-gray-300 dark:border-gray-700 px-6 py-3 text-sm sm:text-base font-semibold text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Saiba Mais →
                    </a>

                </div>

            </section>

        </main>

        <!-- FOOTER SIMPLES -->
        <footer class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
            © <?= date("Y") ?> Salão Sistem — Controle Sanitário e Gestão Profissional.
        </footer>

    </div>

</body>

</html>