<?php
// produtos.php
require "db.php";

/* ---------------------------
   SALVAR PRODUTO
----------------------------*/
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["salvar_produto"])) {

    $nome = $_POST["nome"];
    $marca = $_POST["marca"];
    $lote = $_POST["lote"];
    $anvisa = $_POST["anvisa"];
    $categoria = $_POST["categoria"];
    $estoque = $_POST["estoque"];
    $fabricacao = $_POST["fabricacao"] ?: null;
    $validade = $_POST["validade"];
    $armazenamento = $_POST["armazenamento"];

    // Foto opcional
    $fotoBase64 = "";

    if (!empty($_FILES["foto"]["tmp_name"])) {
        $imgData = file_get_contents($_FILES["foto"]["tmp_name"]);
        $fotoBase64 = base64_encode($imgData);
    }

    $stmt = $conn->prepare("
        INSERT INTO produtos
        (nome, marca, lote, anvisa, categoria, estoque, fabricacao, validade, armazenamento, foto)
        VALUES
        (:nome, :marca, :lote, :anvisa, :categoria, :estoque, :fabricacao, :validade, :armazenamento, :foto)
    ");

    $stmt->execute([
        ":nome" => $nome,
        ":marca" => $marca,
        ":lote" => $lote,
        ":anvisa" => $anvisa,
        ":categoria" => $categoria,
        ":estoque" => $estoque,
        ":fabricacao" => $fabricacao,
        ":validade" => $validade,
        ":armazenamento" => $armazenamento,
        ":foto" => $fotoBase64
    ]);

    header("Location: produtos.php");
    exit;
}


/* ---------------------------
   REMOVER PRODUTO
----------------------------*/
if (isset($_GET["remover"])) {

    $id = intval($_GET["remover"]);

    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: produtos.php");
    exit;
}


/* ---------------------------
   LISTAR PRODUTOS DO DIA
----------------------------*/
$stmt = $conn->prepare("
    SELECT * 
    FROM produtos 
    WHERE DATE(criado_em) = CURDATE()
    ORDER BY id DESC
");


$stmt->execute();

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUTOS</title>

    <!-- Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <?php include("header.php"); ?>

    <!-- MAIN -->
    <main class="mx-auto max-w-6xl p-6">

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">

            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">
                Controle Sanitário de Produtos (ANVISA)
            </h1>

            <p class="text-center text-gray-500 dark:text-gray-300 mb-10">
                Cadastro completo para rastreabilidade, validade e controle de estoque.
            </p>

            <!-- FORMULÁRIO -->
            <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

                <input type="hidden" name="salvar_produto" value="1">

                <!-- Nome -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Nome Comercial
                    </label>
                    <input id="nome" name="nome" required placeholder="Ex: Álcool 70%"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Marca -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Marca
                    </label>
                    <input id="marca" name="marca" required placeholder="Ex: Asseptgel"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Lote -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Lote (Obrigatório)
                    </label>
                    <input id="lote" name="lote" required placeholder="Código do lote"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Registro ANVISA -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Registro ANVISA
                    </label>
                    <input id="anvisa" name="anvisa" required placeholder="Número do registro"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Categoria -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Categoria Sanitária
                    </label>
                    <select id="categoria" name="categoria" required
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option value="" disabled selected>Selecione...</option>
                        <option value="Cosmético">Cosmético</option>
                        <option value="Desinfetante">Desinfetante</option>
                        <option value="Esterilizante">Esterilizante</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>

                <!-- Estoque -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Quantidade em Estoque
                    </label>
                    <input id="estoque" name="estoque" type="number" min="0" required placeholder="Ex: 10"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Fabricação -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Data de Fabricação
                    </label>
                    <input id="fabricacao" name="fabricacao" type="date"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Validade -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Data de Validade *
                    </label>
                    <input id="validade" name="validade" type="date" required
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Armazenamento -->
                <div class="md:col-span-2">
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Condições de Armazenamento
                    </label>
                    <input id="armazenamento" name="armazenamento" placeholder="Ex: Local seco, protegido da luz..."
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Foto -->
                <div class="md:col-span-2">
                    <label class="block mb-1 text-gray-700 dark:text-gray-300 font-semibold">
                        Foto do Produto (opcional)
                    </label>
                    <input id="foto" name="foto" type="file" accept="image/*"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- Botão -->
                <div class="md:col-span-2">
                    <button type="submit"
                        class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-lg transition">
                        Salvar Produto
                    </button>
                </div>

            </form>

            <!-- TABELA -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm">

                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <th class="p-3">Produto</th>
                            <th class="p-3">Categoria</th>
                            <th class="p-3">Validade</th>
                            <th class="p-3">Estoque</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800 dark:text-gray-200">

                        <?php foreach ($produtos as $p):

                            $hoje = new DateTime();
                            $validade = new DateTime($p["validade"]);
                            $dias = $validade->diff($hoje)->days;

                            $status = "✅ OK";
                            $classe = "text-green-600 font-bold";

                            if ($validade < $hoje) {
                                $status = "❌ VENCIDO";
                                $classe = "text-red-600 font-bold";
                            } elseif ($dias <= 30) {
                                $status = "⚠ ALERTA (vence em breve)";
                                $classe = "text-yellow-500 font-bold";
                            }

                            if ($p["estoque"] <= 2) {
                                $status .= "<br>⚠ Estoque Baixo";
                                $classe = "text-orange-500 font-bold";
                            }
                            ?>

                            <tr class="border-b dark:border-gray-700">

                                <td class="p-3">
                                    <strong><?= $p["nome"] ?></strong><br>
                                    <span class="text-xs"><?= $p["marca"] ?> | Lote: <?= $p["lote"] ?></span>
                                </td>

                                <td class="p-3"><?= $p["categoria"] ?></td>
                                <td class="p-3"><?= $p["validade"] ?></td>
                                <td class="p-3"><?= $p["estoque"] ?></td>

                                <td class="p-3 <?= $classe ?>">
                                    <?= $status ?>
                                </td>

                                <td class="p-3 space-x-2">

                                    <?php if (!empty($p["foto"])): ?>
                                        <a target="_blank" href="data:image/png;base64,<?= $p["foto"] ?>"
                                            class="text-blue-500 hover:underline text-sm">
                                            Foto
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">Sem Foto</span>
                                    <?php endif; ?>

                                    <a href="?remover=<?= $p["id"] ?>"
                                        onclick="return confirm('Deseja remover este produto?')"
                                        class="text-red-500 hover:underline text-sm">
                                        Remover
                                    </a>

                                </td>

                                

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>

        </div>

    </main>

</body>

</html>