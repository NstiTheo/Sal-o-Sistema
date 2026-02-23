<?php
include("db.php");

/* ===========================
   SALVAR NO BANCO
=========================== */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = $_POST["estData"];
    $resp = $_POST["estResp"];
    $equip = $_POST["estEquip"];
    $equipID = $_POST["estEquipID"];

    $material = $_POST["estMaterial"];
    $qtd = $_POST["estQtd"];

    $limpeza = $_POST["estLimpeza"];
    $embalagem = $_POST["estEmbalagem"];

    $externo = $_POST["estExterno"];
    $interno = $_POST["estInterno"];
    $biologico = $_POST["estBiologico"];

    $temp = $_POST["estTemp"];
    $press = $_POST["estPress"];
    $tempo = $_POST["estTempo"];

    $validade = $_POST["estValidade"];

    $pacote = $_POST["estPacote"];
    $armazenado = $_POST["estArmazenado"];

    $obs = $_POST["estObs"];

    /* STATUS FINAL */
    $status = "Aprovado ✅";
    if ($interno === "Reprovado" || $externo === "Reprovado") {
        $status = "Reprovado ❌";
    }

    /* FOTO */
    $fotoNome = "";
    if (!empty($_FILES["estFoto"]["name"])) {
        $fotoNome = time() . "_" . $_FILES["estFoto"]["name"];
        move_uploaded_file($_FILES["estFoto"]["tmp_name"], "uploads/" . $fotoNome);
    }

    /* INSERT */
    $sql = "INSERT INTO esterilizacao (
        data_processo, responsavel,
        equipamento, equipamento_id,
        material, quantidade,
        pre_limpeza, embalagem,
        indicador_externo, indicador_interno, indicador_biologico,
        temperatura, pressao, tempo,
        validade, foto,
        pacote, armazenado,
        observacoes, status_final
    ) VALUES (
        '$data', '$resp',
        '$equip', '$equipID',
        '$material', '$qtd',
        '$limpeza', '$embalagem',
        '$externo', '$interno', '$biologico',
        '$temp', '$press', '$tempo',
        '$validade', '$fotoNome',
        '$pacote', '$armazenado',
        '$obs', '$status'
    )";

    $conn->query($sql);
}

/* ===========================
   LISTAR DO BANCO
=========================== */
$stmt = $conn->prepare("
    SELECT * 
    FROM esterilizacao 
    WHERE data_processo = CURDATE()
    ORDER BY id DESC
");

$stmt->execute();
$result = $stmt;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTERILIZAÇÃO</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-white dark:bg-gray-900">

    <?php include("header.php"); ?>

    <!-- MAIN -->
    <main class="mx-auto max-w-5xl p-6">

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                Registro Sanitário Completo de Esterilização (Padrão ANVISA)
            </h1>

            <!-- FORM -->
            <form method="POST" enctype="multipart/form-data">

                <!-- DATA -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Data do Processo</label>
                    <input name="estData" type="date" required
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- RESPONSÁVEL -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Responsável</label>
                    <input name="estResp" type="text" required placeholder="Nome completo"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- EQUIPAMENTO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Equipamento Utilizado</label>
                        <select name="estEquip" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                            <option>Autoclave</option>
                            <option>Estufa</option>
                            <option>Químico (Imersão)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">ID do Equipamento</label>
                        <input name="estEquipID" placeholder="Ex: AUTOCLAVE-01"
                            class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                    </div>

                </div>

                <!-- MATERIAL -->
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-6 mb-3">
                    Instrumentos Esterilizados
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <input name="estMaterial" placeholder="Ex: Alicates, tesouras..."
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">

                    <input name="estQtd" type="number" placeholder="Quantidade"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- PRÉ-LIMPEZA -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Pré-limpeza realizada?</label>
                    <select name="estLimpeza" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option>Sim</option>
                        <option>Não</option>
                    </select>
                </div>

                <!-- EMBALAGEM -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Material embalado corretamente?</label>
                    <select name="estEmbalagem" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option>Sim</option>
                        <option>Não</option>
                    </select>
                </div>

                <!-- INDICADORES -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Indicador Químico Externo</label>
                        <select name="estExterno" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                            <option>Aprovado</option>
                            <option>Reprovado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700 dark:text-gray-300">Indicador Químico Interno</label>
                        <select name="estInterno" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                            <option>Aprovado</option>
                            <option>Reprovado</option>
                        </select>
                    </div>
                </div>

                <!-- BIOLÓGICO -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Indicador Biológico</label>
                    <select name="estBiologico" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option>Aprovado</option>
                        <option>Reprovado</option>
                        <option>Não realizado</option>
                    </select>
                </div>

                <!-- PARÂMETROS -->
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-6 mb-3">
                    Parâmetros do Ciclo
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <input name="estTemp" type="number" placeholder="Temperatura °C"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">

                    <input name="estPress" type="number" placeholder="Pressão (bar)"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">

                    <input name="estTempo" type="number" placeholder="Tempo (min)"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- VALIDADE -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Validade da Esterilização</label>
                    <input name="estValidade" type="date"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- FOTO -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">
                        Foto do Painel (Comprovante do Ciclo)
                    </label>
                    <input name="estFoto" type="file" accept="image/*"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <!-- CHECKLIST FINAL -->
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-6 mb-3">
                    Pós-Ciclo
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <select name="estPacote" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option value="Íntegro e seco">Pacote íntegro e seco</option>
                        <option value="Com falhas">Pacote com falhas</option>
                    </select>

                    <select name="estArmazenado" class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                        <option value="Armazenado corretamente">Armazenado corretamente</option>
                        <option value="Armazenamento inadequado">Armazenamento inadequado</option>
                    </select>
                </div>

                <!-- OBS -->
                <div class="mb-4">
                    <label class="block mb-2 text-gray-700 dark:text-gray-300">Observações</label>
                    <textarea name="estObs"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white"></textarea>
                </div>

                <!-- BOTÃO -->
                <button type="submit"
                    class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 rounded-lg transition">
                    Salvar Registro Sanitário
                </button>

            </form>

            <!-- LISTA -->
            <div class="mt-10 overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 dark:border-gray-700 text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border p-2">Data</th>
                            <th class="border p-2">Responsável</th>
                            <th class="border p-2">Instrumentos</th>
                            <th class="border p-2">Equipamento</th>
                            <th class="border p-2">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr class="text-gray-900 dark:text-gray-200">
                                <td class="border p-2"><?= $row["data_processo"] ?></td>
                                <td class="border p-2"><?= $row["responsavel"] ?></td>
                                <td class="border p-2"><?= $row["material"] ?> (<?= $row["quantidade"] ?>)</td>
                                <td class="border p-2"><?= $row["equipamento"] ?> (<?= $row["equipamento_id"] ?>)</td>
                                <td class="border p-2 font-bold"><?= $row["status_final"] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </main>

</body>

</html>