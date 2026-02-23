<?php
// dashboard.php
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <?php include("header.php"); ?>

    <!-- MAIN -->
    <main class="mx-auto max-w-7xl px-6 py-12">

        <!-- TÍTULO -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                Painel Sanitário do Salão
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                Controle completo de esterilização, validade e conformidade (ANVISA).
            </p>
        </div>

        <!-- CARDS PRINCIPAIS -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

            <!-- Esterilizações -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:scale-[1.02] transition">
                <div class="flex items-center justify-between">
                    <h2 class="text-gray-600 dark:text-gray-300 font-semibold">
                        Esterilizações Realizadas
                    </h2>
                    <span class="text-3xl">🧼</span>
                </div>
                <p class="text-5xl font-bold text-gray-900 dark:text-white mt-4">

                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Registros no sistema
                </p>
            </div>

            <!-- Produtos vencendo -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-8 border-yellow-400 hover:scale-[1.02] transition">
                <div class="flex items-center justify-between">
                    <h2 class="text-gray-600 dark:text-gray-300 font-semibold">
                        Produtos Próximos da Validade
                    </h2>
                    <span class="text-3xl">⚠️</span>
                </div>
                <p class="text-5xl font-bold text-yellow-500 mt-4">

                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Atenção: revisar estoque
                </p>
            </div>

            <!-- Produtos cadastrados -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 hover:scale-[1.02] transition">
                <div class="flex items-center justify-between">
                    <h2 class="text-gray-600 dark:text-gray-300 font-semibold">
                        Produtos Cadastrados
                    </h2>
                    <span class="text-3xl">📦</span>
                </div>
                <p class="text-5xl font-bold text-gray-900 dark:text-white mt-4">

                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Total no inventário sanitário
                </p>
            </div>

        </section>

        <!-- AÇÕES RÁPIDAS -->
        <section class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">

            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Ações Rápidas
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <a href="esterelizacao.php"
                    class="block bg-pink-500 hover:bg-pink-600 text-white font-semibold py-4 rounded-xl text-center shadow transition">
                    ✙ Registrar Esterilização
                </a>

                <a href="produtos.php"
                    class="block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-4 rounded-xl text-center shadow transition">
                    ✙ Cadastrar Produto
                </a>

                <a href="checklist.php"
                    class="block bg-green-500 hover:bg-green-600 text-white font-semibold py-4 rounded-xl text-center shadow transition">
                    📋 Fazer Checklist
                </a>

            </div>

        </section>

    </main>

</body>

</html>