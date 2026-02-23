<?php include("header.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central de Relatórios</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <main class="max-w-6xl mx-auto mt-10 px-6 pb-20">

        <!-- HEADER -->
        <div class="text-center mb-14">
            <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white">
                📑 Central de Relatórios
            </h1>

            <p class="mt-4 text-gray-600 dark:text-gray-300 max-w-2xl mx-auto text-lg">
                Gere relatórios sanitários completos para auditorias internas,
                Vigilância Sanitária e conformidade com a Anvisa.
            </p>
        </div>


        <!-- ================================= -->
        <!-- RELATÓRIOS OPERACIONAIS -->
        <!-- ================================= -->
        <section class="mb-16">

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
                📌 Relatórios Operacionais (Com Configuração)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- CARD ESTERILIZAÇÃO -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border">

                    <h3 class="text-lg font-bold mb-2">🧼 Esterilizações</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Controle completo de autoclave e instrumentos.
                    </p>

                    <form action="gerar_pdf.php" method="GET" target="_blank" class="space-y-3">

                        <input type="hidden" name="tipo" value="esterilizacao">

                        <select name="periodo" class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">
                            <option value="mensal">Mensal</option>
                            <option value="anual">Anual</option>
                        </select>

                        <select name="mes" class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>"><?= $m ?></option>
                            <?php endfor; ?>
                        </select>

                        <input type="number" name="ano" value="<?= date("Y") ?>"
                            class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">

                        <button type="submit"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 rounded-xl">
                            Gerar PDF
                        </button>

                    </form>
                </div>


                <!-- CARD PRODUTOS -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border">

                    <h3 class="text-lg font-bold mb-2">📦 Produtos</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Controle sanitário de produtos e vencimentos.
                    </p>

                    <form action="gerar_pdf.php" method="GET" target="_blank" class="space-y-3">

                        <input type="hidden" name="tipo" value="produtos">

                        <select name="periodo" class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">
                            <option value="mensal">Mensal</option>
                            <option value="anual">Anual</option>
                        </select>

                        <select name="mes" class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>"><?= $m ?></option>
                            <?php endfor; ?>
                        </select>

                        <input type="number" name="ano" value="<?= date("Y") ?>"
                            class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">

                        <button type="submit"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded-xl">
                            Gerar PDF
                        </button>

                    </form>
                </div>


                <!-- CARD FUNCIONÁRIOS -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 border">

                    <h3 class="text-lg font-bold mb-2">👥 Funcionários</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Relatório da equipe e treinamentos internos.
                    </p>

                    <form action="gerar_pdf.php" method="GET" target="_blank" class="space-y-3">

                        <input type="hidden" name="tipo" value="funcionarios">

                        <select name="periodo" class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">
                            <option value="mensal">Mensal</option>
                            <option value="anual">Anual</option>
                        </select>

                        <select name="mes" class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>"><?= $m ?></option>
                            <?php endfor; ?>
                        </select>

                        <input type="number" name="ano" value="<?= date("Y") ?>"
                            class="w-full p-2 rounded-xl border dark:bg-gray-900 dark:text-white">

                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-xl">
                            Gerar PDF
                        </button>

                    </form>
                </div>

            </div>
        </section>


        <!-- ================================= -->
        <!-- CHECKLISTS DIRETOS -->
        <!-- ================================= -->
        <section>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">
                ✅ Checklists Sanitários (Clique Direto)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Diário -->
                <a href="gerar_pdf.php?tipo=checklist_diario" target="_blank"
                    class="block bg-gradient-to-br from-pink-500 to-pink-600 text-white rounded-2xl shadow-lg p-6 hover:scale-[1.02] transition">
                    <h3 class="text-xl font-bold mb-2">📅 Checklist Diário</h3>
                    <p class="text-sm opacity-90">
                        Higiene diária e rotina obrigatória.
                    </p>
                </a>

                <!-- Semanal -->
                <a href="gerar_pdf.php?tipo=checklist_semanal" target="_blank"
                    class="block bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl shadow-lg p-6 hover:scale-[1.02] transition">
                    <h3 class="text-xl font-bold mb-2">🗓️ Checklist Semanal</h3>
                    <p class="text-sm opacity-90">
                        Revisões e controle semanal.
                    </p>
                </a>

                <!-- Mensal -->
                <a href="gerar_pdf.php?tipo=checklist_mensal" target="_blank"
                    class="block bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-2xl shadow-lg p-6 hover:scale-[1.02] transition">
                    <h3 class="text-xl font-bold mb-2">📆 Checklist Mensal</h3>
                    <p class="text-sm opacity-90">
                        Auditoria mensal completa.
                    </p>
                </a>

            </div>

        </section>

    </main>

</body>

</html>