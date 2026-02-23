<?php
// epi.php — Controle Sanitário Completo – EPI

include("db.php");

/* ============================
   SALVAR REGISTRO
============================ */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $funcionario = $_POST["funcionario"];
    $motivo = $_POST["motivo"];
    $tipo = $_POST["tipo"];
    $marca = $_POST["marca"];
    $quantidade = $_POST["quantidade"];
    $entrega = $_POST["entrega"];
    $substituicao = $_POST["substituicao"];
    $condicoes = $_POST["condicoes"];
    $obs = $_POST["obs"];
    $assinatura = $_POST["assinatura"];

    $sql = "INSERT INTO epi_registros 
        (funcionario, motivo, tipo, marca, quantidade, entrega, substituicao, condicoes, obs, assinatura)
        VALUES 
        (:funcionario, :motivo, :tipo, :marca, :quantidade, :entrega, :substituicao, :condicoes, :obs, :assinatura)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ":funcionario" => $funcionario,
        ":motivo" => $motivo,
        ":tipo" => $tipo,
        ":marca" => $marca,
        ":quantidade" => $quantidade,
        ":entrega" => $entrega,
        ":substituicao" => $substituicao,
        ":condicoes" => $condicoes,
        ":obs" => $obs,
        ":assinatura" => $assinatura
    ]);

    header("Location: epi.php");
    exit;
}

/* ============================
   REMOVER REGISTRO
============================ */
if (isset($_GET["delete"])) {

    $id = intval($_GET["delete"]);

    $stmt = $conn->prepare("DELETE FROM epi_registros WHERE id = :id");
    $stmt->execute([":id" => $id]);

    header("Location: epi.php");
    exit;
}

/* ============================
   LISTAR REGISTROS
============================ */
$stmt = $conn->query("SELECT * FROM epi_registros ORDER BY id DESC");
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTROLE DE EPI</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-white dark:bg-gray-900">

    <?php include("header.php"); ?>

    <!-- MAIN -->
    <main class="mx-auto max-w-5xl p-6">

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Registro de Entrega de EPI (Vigilância Sanitária)
            </h1>

            <!-- FORM -->
            <form method="POST" id="formEpi">

                <input type="hidden" name="assinatura" id="assinaturaInput">

                <!-- FUNCIONÁRIO -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Funcionário
                    </label>
                    <input name="funcionario" required
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- MOTIVO -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Motivo
                    </label>
                    <select name="motivo" required
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option value="Novo">Novo EPI</option>
                        <option value="Substituição">Substituição</option>
                        <option value="Emergência">Emergência</option>
                    </select>
                </div>

                <!-- TIPO -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Tipo de EPI
                    </label>
                    <select name="tipo" required class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option value="Luva">Luva</option>
                        <option value="Máscara">Máscara</option>
                        <option value="Avental">Avental</option>
                        <option value="Óculos">Óculos</option>
                        <option value="Touca">Touca</option>
                        <option value="Protetor Facial">Protetor Facial</option>
                        <option value="Calçados">Calçados Fechados</option>
                        <option value="Outros">Outros</option>
                    </select>
                </div>

                <!-- MARCA -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Marca / CA
                    </label>
                    <input name="marca" required class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- DATA + QUANTIDADE -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">
                            Data da Entrega
                        </label>
                        <input type="date" name="entrega" required
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">
                            Quantidade
                        </label>
                        <input type="number" name="quantidade" min="1" required
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                    </div>

                </div>

                <!-- SUBSTITUIÇÃO -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Data de Substituição
                    </label>
                    <input type="date" name="substituicao" required
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- ASSINATURA -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Assinatura Digital
                    </label>

                    <canvas id="assinaturaCanvas" class="border rounded-lg w-full h-40 bg-white"></canvas>

                    <button type="button" onclick="limparAssinatura()"
                        class="mt-2 text-sm text-red-500 hover:underline">
                        Limpar assinatura
                    </button>
                </div>

                <!-- CONDIÇÕES -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Condições / Treinamento
                    </label>
                    <textarea name="condicoes" required
                        class="w-full rounded-lg border p-2 h-24 dark:bg-gray-900 dark:text-white"></textarea>
                </div>

                <!-- OBS -->
                <div class="mb-6">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Observações
                    </label>
                    <textarea name="obs"
                        class="w-full rounded-lg border p-2 h-20 dark:bg-gray-900 dark:text-white"></textarea>
                </div>

                <!-- BOTÃO -->
                <button type="submit" onclick="salvarAssinatura()"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-lg">
                    Salvar Registro
                </button>

            </form>

            <!-- TABELA -->
            <div class="mt-10 overflow-x-auto">
                <table class="w-full border-collapse border text-sm">

                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                        <tr>
                            <th class="border p-2">Funcionário</th>
                            <th class="border p-2">Motivo</th>
                            <th class="border p-2">Tipo</th>
                            <th class="border p-2">Marca/CA</th>
                            <th class="border p-2">Qtd</th>
                            <th class="border p-2">Entrega</th>
                            <th class="border p-2">Substituição</th>
                            <th class="border p-2">Assinatura</th>
                            <th class="border p-2">Ação</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">

                        <?php foreach ($registros as $e): ?>
                            <tr>
                                <td class="border p-2">
                                    <?= $e["funcionario"] ?>
                                </td>
                                <td class="border p-2">
                                    <?= $e["motivo"] ?>
                                </td>
                                <td class="border p-2">
                                    <?= $e["tipo"] ?>
                                </td>
                                <td class="border p-2">
                                    <?= $e["marca"] ?>
                                </td>
                                <td class="border p-2">
                                    <?= $e["quantidade"] ?>
                                </td>
                                <td class="border p-2">
                                    <?= $e["entrega"] ?>
                                </td>
                                <td class="border p-2">
                                    <?= $e["substituicao"] ?>
                                </td>

                                <td class="border p-2 text-center">
                                    <img src="<?= $e["assinatura"] ?>" class="h-12 mx-auto border rounded">
                                </td>

                                <td class="border p-2 text-center">
                                    <a href="?delete=<?= $e["id"] ?>"
                                        onclick="return confirm('Excluir registro?')"
                                        class="text-red-500 hover:underline text-sm">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

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

        canvas.addEventListener("mousedown", (e) => {
            desenhando = true;
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        });

        canvas.addEventListener("mousemove", (e) => {
            if (!desenhando) return;
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        });

        canvas.addEventListener("mouseup", () => desenhando = false);

        function limparAssinatura() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        function salvarAssinatura() {
            document.getElementById("assinaturaInput").value = canvas.toDataURL();
        }
    </script>

</body>

</html>