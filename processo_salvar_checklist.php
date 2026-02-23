<?php
// Inclui sua conexão com o banco
include 'db.php';

// Define que a resposta será um JSON
header('Content-Type: application/json');

// Recebe os dados crus (JSON) enviados pelo Javascript
$json = file_get_contents('php://input');
$dados = json_decode($json, true);

if ($dados) {
    try {
        // Prepara o SQL de Inserção
        $sql = "INSERT INTO checklist_diario (
            data_checklist, responsavel, 
            hig_bancadas, hig_piso, hig_banheiro, hig_lixeiras, hig_residuos,
            est_lavados, est_embalados, est_autoclave, est_indicadores, est_registro,
            prod_nao_vencidos, prod_armazenados, prod_anvisa, prod_fracionados,
            epi_luvas, epi_mascaras, epi_aventais, epi_alcool,
            con_uniforme, con_sem_adornos, con_treinamentos, con_procedimentos,
            assinatura_digital
        ) VALUES (
            :data, :resp,
            :hig_bancadas, :hig_piso, :hig_banheiro, :hig_lixeiras, :hig_residuos,
            :est_lavados, :est_embalados, :est_autoclave, :est_indicadores, :est_registro,
            :prod_nao_vencidos, :prod_armazenados, :prod_anvisa, :prod_fracionados,
            :epi_luvas, :epi_mascaras, :epi_aventais, :epi_alcool,
            :con_uniforme, :con_sem_adornos, :con_treinamentos, :con_procedimentos,
            :assinatura
        )";

        // Usa $conn (que vem do seu db.php)
        $stmt = $conn->prepare($sql);

        // Bind dos valores de texto
        $stmt->bindValue(':data', $dados['data']);
        $stmt->bindValue(':resp', $dados['responsavel']);
        $stmt->bindValue(':assinatura', $dados['assinatura']);

        // Função auxiliar para converter true/false (JS) em 1/0 (MySQL)
        function b($val)
        {
            return $val ? 1 : 0;
        }

        // Bind dos checkboxes
        $stmt->bindValue(':hig_bancadas', b($dados['itens']['hig_bancadas']));
        $stmt->bindValue(':hig_piso', b($dados['itens']['hig_piso']));
        $stmt->bindValue(':hig_banheiro', b($dados['itens']['hig_banheiro']));
        $stmt->bindValue(':hig_lixeiras', b($dados['itens']['hig_lixeiras']));
        $stmt->bindValue(':hig_residuos', b($dados['itens']['hig_residuos']));

        $stmt->bindValue(':est_lavados', b($dados['itens']['est_lavados']));
        $stmt->bindValue(':est_embalados', b($dados['itens']['est_embalados']));
        $stmt->bindValue(':est_autoclave', b($dados['itens']['est_autoclave']));
        $stmt->bindValue(':est_indicadores', b($dados['itens']['est_indicadores']));
        $stmt->bindValue(':est_registro', b($dados['itens']['est_registro']));

        $stmt->bindValue(':prod_nao_vencidos', b($dados['itens']['prod_nao_vencidos']));
        $stmt->bindValue(':prod_armazenados', b($dados['itens']['prod_armazenados']));
        $stmt->bindValue(':prod_anvisa', b($dados['itens']['prod_anvisa']));
        $stmt->bindValue(':prod_fracionados', b($dados['itens']['prod_fracionados']));

        $stmt->bindValue(':epi_luvas', b($dados['itens']['epi_luvas']));
        $stmt->bindValue(':epi_mascaras', b($dados['itens']['epi_mascaras']));
        $stmt->bindValue(':epi_aventais', b($dados['itens']['epi_aventais']));
        $stmt->bindValue(':epi_alcool', b($dados['itens']['epi_alcool']));

        $stmt->bindValue(':con_uniforme', b($dados['itens']['con_uniforme']));
        $stmt->bindValue(':con_sem_adornos', b($dados['itens']['con_sem_adornos']));
        $stmt->bindValue(':con_treinamentos', b($dados['itens']['con_treinamentos']));
        $stmt->bindValue(':con_procedimentos', b($dados['itens']['con_procedimentos']));

        // Executa a query
        $stmt->execute();

        // Retorna sucesso para o Javascript
        echo json_encode(['sucesso' => true]);
    } catch (PDOException $e) {
        // Retorna erro para o Javascript
        echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Nenhum dado recebido pelo PHP']);
}
