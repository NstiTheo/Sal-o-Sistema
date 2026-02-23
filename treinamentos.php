<?php
// treinamentos.php

include("db.php");

/* ============================
   UPLOAD DO ARQUIVO
============================ */
function uploadArquivo($file)
{
    if ($file["error"] === 0) {

        $pasta = "uploads/";
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $nomeOriginal = basename($file["name"]);
        $ext = pathinfo($nomeOriginal, PATHINFO_EXTENSION);

        $novoNome = uniqid("treinamento_") . "." . $ext;
        $destino = $pasta . $novoNome;

        if (move_uploaded_file($file["tmp_name"], $destino)) {
            return $destino;
        }
    }
    return null;
}

/* ============================
   CADASTRAR TREINAMENTO
============================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cadastrar"])) {

    $nome = $_POST["nome"] ?? "";
    $instrutor = $_POST["instrutor"] ?? "";
    $data = $_POST["data"] ?? "";
    $carga = $_POST["carga"] ?? 0;
    $conteudo = $_POST["conteudo"] ?? "";
    $participantes = $_POST["participantes"] ?? "";
    $avaliacao = $_POST["avaliacao"] ?? "";
    $certificado = $_POST["certificado"] ?? "";

    $arquivo = null;
    if (!empty($_FILES["arquivo"]["name"])) {
        $arquivo = uploadArquivo($_FILES["arquivo"]);
    }

    $stmt = $conn->prepare("
        INSERT INTO treinamentos 
        (nome, instrutor, data_realizacao, carga_horaria, conteudo, participantes, avaliacao, certificado, arquivo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $nome,
        $instrutor,
        $data,
        $carga,
        $conteudo,
        $participantes,
        $avaliacao,
        $certificado,
        $arquivo
    ]);

    header("Location: treinamentos.php");
    exit;
}

/* ============================
   EXCLUIR TREINAMENTO
============================ */
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);

    $stmt = $conn->prepare("DELETE FROM treinamentos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: treinamentos.php");
    exit;
}

/* ============================
   LISTAR TREINAMENTOS
============================ */
$result = $conn->query("SELECT * FROM treinamentos ORDER BY data_realizacao DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Treinamentos Internos</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-white dark:bg-gray-900">

    <?php include("header.php"); ?>
    
    <main class="mx-auto max-w-5xl p-6">

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">

            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
                Cadastro de Treinamentos Internos
            </h1>

            <!-- FORM -->
            <form method="POST" enctype="multipart/form-data" class="space-y-5">

                <input type="hidden" name="cadastrar" value="1">

                <!-- Nome + Instrutor -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">
                            Nome do Treinamento
                        </label>
                        <input name="nome" required
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">
                            Instrutor
                        </label>
                        <input name="instrutor" required
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>

                <!-- Data + Carga -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">
                            Data de Realização
                        </label>
                        <input type="date" name="data" required
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">
                            Carga Horária (h)
                        </label>
                        <input type="number" name="carga" min="1" required
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>

                <!-- Conteúdo -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">
                        Conteúdos Abordados
                    </label>
                    <textarea name="conteudo" required
                        class="w-full rounded-lg border p-2 h-24 dark:bg-gray-900 dark:text-white"></textarea>
                </div>

                <!-- Participantes -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">
                        Participantes Confirmados
                    </label>
                    <textarea name="participantes" required
                        class="w-full rounded-lg border p-2 h-20 dark:bg-gray-900 dark:text-white"></textarea>
                </div>

                <!-- Avaliação + Certificado -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">
                            Avaliação
                        </label>
                        <select name="avaliacao" required
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                            <option value="Realizada com Sucesso">Realizada com Sucesso</option>
                            <option value="Abaixo da Média">Abaixo da Média</option>
                            <option value="Não Aplicada">Não Aplicada</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">
                            Certificado?
                        </label>
                        <select name="certificado" required
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                            <option value="Sim">Sim</option>
                            <option value="Não">Não</option>
                        </select>
                    </div>
                </div>

                <!-- Arquivo -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">
                        Arquivo (Lista de Presença ou Foto)
                    </label>
                    <input type="file" name="arquivo"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-100 file:text-pink-700">
                </div>

                <!-- Botão -->
                <button type="submit"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-lg">
                    Salvar Treinamento
                </button>

            </form>

            <!-- TABELA -->
            <div class="mt-10 overflow-x-auto">

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    Treinamentos Registrados
                </h2>

                <table class="w-full border-collapse border border-gray-300 dark:border-gray-700 text-sm">

                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border p-2">Treinamento</th>
                            <th class="border p-2">Instrutor</th>
                            <th class="border p-2">Data</th>
                            <th class="border p-2">Carga</th>
                            <th class="border p-2">Certificado</th>
                            <th class="border p-2">Arquivo</th>
                            <th class="border p-2">Ação</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($t = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td class="border p-2 font-semibold"><?= $t["nome"] ?></td>
                                <td class="border p-2"><?= $t["instrutor"] ?></td>
                                <td class="border p-2"><?= date("d/m/Y", strtotime($t["data_realizacao"])) ?></td>
                                <td class="border p-2 text-center"><?= $t["carga_horaria"] ?>h</td>
                                <td class="border p-2 text-center"><?= $t["certificado"] ?></td>

                                <td class="border p-2 text-center">
                                    <?php if ($t["arquivo"]): ?>
                                        <a href="<?= $t["arquivo"] ?>" target="_blank" class="text-pink-500 hover:underline">
                                            Ver
                                        </a>
                                    <?php else: ?>
                                        Nenhum
                                    <?php endif; ?>
                                </td>

                                <td class="border p-2 text-center">
                                    <a href="?delete=<?= $t["id"] ?>"
                                        onclick="return confirm('Deseja excluir este treinamento?')"
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

</body>

</html>