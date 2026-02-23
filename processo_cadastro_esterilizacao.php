<?php
// processo_cadastro_esterilizacao.php

include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data_processo = $_POST["data_processo"];
    $funcionario_id = $_POST["funcionario_id"];

    $equipamento = $_POST["equipamento"];
    $equipamento_cod = $_POST["equipamento_codigo"];

    $instrumentos = $_POST["instrumentos"];
    $quantidade = $_POST["quantidade"];

    $pre_limpeza = $_POST["pre_limpeza"];
    $embalagem = $_POST["embalagem"];

    $indicador_externo = $_POST["indicador_externo"];
    $indicador_interno = $_POST["indicador_interno"];
    $indicador_biologico = $_POST["indicador_biologico"];

    $temperatura = $_POST["temperatura"];
    $pressao = $_POST["pressao"];
    $tempo = $_POST["tempo"];

    $validade = $_POST["validade"];
    $observacoes = $_POST["observacoes"];

    // STATUS AUTOMÁTICO
    $status_final = "Aprovado";

    if ($indicador_externo == "Reprovado" || $indicador_interno == "Reprovado") {
        $status_final = "Reprovado";
    }

    // UPLOAD FOTO
    $foto_painel = null;

    if (!empty($_FILES["foto_painel"]["name"])) {

        $pasta = "uploads/";
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $nomeArquivo = time() . "_" . basename($_FILES["foto_painel"]["name"]);
        $destino = $pasta . $nomeArquivo;

        if (move_uploaded_file($_FILES["foto_painel"]["tmp_name"], $destino)) {
            $foto_painel = $destino;
        }
    }

    // INSERT
    $sql = "INSERT INTO esterilizacoes (
        data_processo,
        funcionario_id,
        equipamento,
        equipamento_codigo,
        instrumentos,
        quantidade,
        pre_limpeza,
        embalagem,
        indicador_externo,
        indicador_interno,
        indicador_biologico,
        temperatura,
        pressao,
        tempo,
        validade,
        foto_painel,
        observacoes,
        status_final
    ) VALUES (
        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
    )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $data_processo,
        $funcionario_id,
        $equipamento,
        $equipamento_cod,
        $instrumentos,
        $quantidade,
        $pre_limpeza,
        $embalagem,
        $indicador_externo,
        $indicador_interno,
        $indicador_biologico,
        $temperatura,
        $pressao,
        $tempo,
        $validade,
        $foto_painel,
        $observacoes,
        $status_final
    ]);

    header("Location: esterilizacao.php?sucesso=1");
    exit();
}
?>