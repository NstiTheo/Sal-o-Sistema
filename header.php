<?php
$paginaAtual = basename($_SERVER["PHP_SELF"]);
?>

<!-- HEADER -->
<header class="bg-white dark:bg-gray-900">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">

        <!-- LOGO -->
        <div class="flex lg:flex-1">
            <a href="index.php" class="-m-1.5 p-1.5">
                <img src="butterfly (1).png" alt="Logo" class="h-8 w-auto" />
            </a>
        </div>

        <!-- MENU -->
        <div class="hidden lg:flex lg:gap-x-12 items-center">

            <a href="dashboard.php" class="text-sm font-semibold transition
                <?= $paginaAtual == "dashboard.php"
                    ? "text-pink-500"
                    : "text-gray-900 dark:text-white hover:text-pink-500" ?>">
                DASHBOARD
            </a>

            <a href="esterelizacao.php" class="text-sm font-semibold transition
                <?= $paginaAtual == "esterilizacao.php"
                    ? "text-pink-500"
                    : "text-gray-900 dark:text-white hover:text-pink-500" ?>">
                ESTERILIZAÇÃO
            </a>

            <a href="produtos.php" class="text-sm font-semibold transition
                <?= $paginaAtual == "produtos.php"
                    ? "text-pink-500"
                    : "text-gray-900 dark:text-white hover:text-pink-500" ?>">
                PRODUTOS
            </a>

            <a href="epi.php" class="text-sm font-semibold transition
                <?= $paginaAtual == "epi.php"
                    ? "text-pink-500"
                    : "text-gray-900 dark:text-white hover:text-pink-500" ?>">
                EPI
            </a>

            <a href="funcionarios.php" class="text-sm font-semibold transition
                <?= $paginaAtual == "funcionarios.php"
                    ? "text-pink-500"
                    : "text-gray-900 dark:text-white hover:text-pink-500" ?>">
                FUNCIONÁRIOS
            </a>

            <a href="treinamentos.php" class="text-sm font-semibold transition
                <?= $paginaAtual == "treinamentos.php"
                    ? "text-pink-500"
                    : "text-gray-900 dark:text-white hover:text-pink-500" ?>">
                TREINAMENTOS
            </a>

            <a href="checklist.php" class="text-sm font-semibold transition
                <?= $paginaAtual == "checklist.php"
                    ? "text-pink-500"
                    : "text-gray-900 dark:text-white hover:text-pink-500" ?>">
                CHECKLIST
            </a>

        </div>

        <!-- RELATÓRIOS -->
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
            <a href="relatorios.php" class="text-sm font-semibold px-4 py-2 rounded-lg transition shadow
                <?= $paginaAtual == "relatorios.php"
                    ? "bg-pink-600 text-white"
                    : "bg-pink-500 text-white hover:bg-pink-600" ?>">
                RELATÓRIOS
            </a>
        </div>

    </nav>
</header>