<?php
// funcionarios.php

include("db.php");

/* ---------------------------
   CADASTRAR FUNCIONÁRIO
----------------------------*/
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cadastrar"])) {

    $nome = $_POST["nome"] ?? "";
    $cpf = $_POST["cpf"] ?? "";
    $funcao = $_POST["funcao"] ?? "";
    $admissao = $_POST["admissao"] ?? null;
    $ester = $_POST["esterilizacao"] ?? "Não";
    $treino = $_POST["treinamento"] ?? null;
    $epi = $_POST["epis"] ?? "";
    $assinatura = $_POST["assinatura"] ?? "";

    if (empty($cpf)) {
        die("Erro: CPF não pode estar vazio.");
    }

    $stmt = $conn->prepare("
        INSERT INTO funcionarios 
        (nome, cpf, funcao, admissao, esterilizacao, treinamento, epis, assinatura)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $nome,
        $cpf,
        $funcao,
        $admissao ?: null,
        $ester,
        $treino ?: null,
        $epi,
        $assinatura
    ]);

    header("Location: funcionarios.php");
    exit;
}

/* ---------------------------
   EXCLUIR FUNCIONÁRIO
----------------------------*/
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);

    $stmt = $conn->prepare("DELETE FROM funcionarios WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: funcionarios.php");
    exit;
}

/* ---------------------------
   LISTAR FUNCIONÁRIOS
----------------------------*/
$result = $conn->query("SELECT * FROM funcionarios ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Funcionários</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-white dark:bg-gray-900">

    <?php include("header.php"); ?>
    
    <main class="mx-auto max-w-5xl p-6">

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">

            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
                Cadastro Sanitário de Funcionários
            </h1>

            <!-- FORM -->
            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <input type="hidden" name="cadastrar" value="1">

                <!-- Nome -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Nome</label>
                    <input name="nome" required class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- CPF -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">CPF</label>
                    <input id="cpf" name="cpf" required maxlength="14" placeholder="000.000.000-00"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Função -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Função</label>
                    <input name="funcao" required class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Admissão -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Data de Admissão</label>
                    <input type="date" name="admissao"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Esterilização -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">
                        Responsável Esterilização?
                    </label>
                    <select name="esterilizacao" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option value="Não">Não</option>
                        <option value="Sim">Sim</option>
                    </select>
                </div>

                <!-- Treinamento -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">
                        Último Treinamento
                    </label>
                    <input type="date" name="treinamento"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- EPIs -->
                <div class="md:col-span-2">
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">
                        EPIs Entregues
                    </label>
                    <input name="epis" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Assinatura -->
                <div class="md:col-span-2">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Assinatura Digital
                    </label>

                    <canvas id="assinaturaCanvas" class="border rounded-lg w-full h-40 bg-white"></canvas>

                    <input type="hidden" name="assinatura" id="assinaturaInput">

                    <button type="button" onclick="limparAssinatura()"
                        class="mt-2 text-sm text-red-500 hover:underline">
                        Limpar assinatura
                    </button>
                </div>

                <!-- Botão -->
                <div class="md:col-span-2">
                    <button type="submit" onclick="salvarAssinatura()"
                        class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-lg">
                        Cadastrar Funcionário
                    </button>
                </div>

            </form>

            <!-- LISTAGEM -->
            <div class="mt-10">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    Funcionários Registrados
                </h2>

                <table class="w-full border-collapse border">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <th class="border p-2">Nome</th>
                            <th class="border p-2">CPF</th>
                            <th class="border p-2">Função</th>
                            <th class="border p-2">EPIs</th>
                            <th class="border p-2">Assinatura</th>
                            <th class="border p-2">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td class="border p-2"><?= $row["nome"] ?></td>
                                <td class="border p-2"><?= $row["cpf"] ?></td>
                                <td class="border p-2"><?= $row["funcao"] ?></td>
                                <td class="border p-2"><?= $row["epis"] ?></td>

                                <td class="border p-2">
                                    <?php if (!empty($row["assinatura"])): ?>
                                        <img src="<?= $row["assinatura"] ?>" class="h-16 border bg-white rounded">
                                    <?php endif; ?>
                                </td>

                                <td class="border p-2">
                                    <a href="?delete=<?= $row["id"] ?>"
                                        onclick="return confirm('Deseja excluir este funcionário?')"
                                        class="text-red-500 hover:underline">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>

        </div>

    </main>

    <!-- SCRIPT ASSINATURA -->
    <script>
        const canvas = document.getElementById("assinaturaCanvas");
        const ctx = canvas.getContext("2d");
        let desenhando = false;

        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;

        canvas.addEventListener("mousedown", () => desenhando = true);
        canvas.addEventListener("mouseup", () => desenhando = false);
        canvas.addEventListener("mousemove", desenhar);

        function desenhar(e) {
            if (!desenhando) return;
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }

        function limparAssinatura() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        function salvarAssinatura() {
            document.getElementById("assinaturaInput").value =
                canvas.toDataURL();
        }
    </script>

    <!-- SCRIPT CPF -->
    <script>
        const cpfInput = document.getElementById("cpf");

        cpfInput.addEventListener("input", function () {
            let cpf = cpfInput.value.replace(/\D/g, "");
            cpf = cpf.substring(0, 11);

            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
            cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

            cpfInput.value = cpf;
        });
    </script>

</body>

</html>