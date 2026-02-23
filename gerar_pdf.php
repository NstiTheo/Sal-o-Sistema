<?php
include("db.php");
require __DIR__ . "/dompdf/vendor/autoload.php";

use Dompdf\Dompdf;

/* ================================
   CONFIG
================================ */
$tipo = $_GET["tipo"] ?? "funcionarios";
$periodo = $_GET["periodo"] ?? "mensal";
$mes = $_GET["mes"] ?? date("m");
$ano = $_GET["ano"] ?? date("Y");

$dataHoje = date("d/m/Y");


/* ================================
   FUNÇÃO: ACHAR COLUNA DE DATA
================================ */
function detectarCampoData($conn, $tabela)
{
    $possiveis = [
        "data",
        "data_registro",
        "data_checklist",
        "data_esterilizacao",
        "criado_em",
        "created_at",
        "dia"
    ];

    $colunas = $conn->query("DESCRIBE $tabela")->fetchAll(PDO::FETCH_COLUMN);

    foreach ($possiveis as $campo) {
        if (in_array($campo, $colunas)) {
            return $campo;
        }
    }

    return null;
}


/* ================================
   FORMATAR NOMES
================================ */
function nomeBonito($campo)
{
    return ucwords(str_replace("_", " ", $campo));
}


/* ================================
   FORMATAR VALORES
================================ */
function formatarValor($campo, $valor)
{
    if (str_contains($campo, "assinatura") || str_contains($campo, "foto")) {
        return "✔ Registrado no sistema";
    }

    if ($valor === 1 || $valor === "1")
        return "✔ Sim";
    if ($valor === 0 || $valor === "0")
        return "✘ Não";

    return htmlspecialchars($valor);
}


/* ================================
   ESTILO PDF
================================ */
$html = "
<style>
    body {
        font-family: Arial;
        font-size: 12px;
        color: #222;
    }

    .titulo {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .subtitulo {
        text-align: center;
        font-size: 13px;
        margin-bottom: 20px;
        color: #555;
    }

    .card {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 15px;
        page-break-inside: avoid;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 6px;
        border-bottom: 1px solid #eee;
    }

    .campo {
        font-weight: bold;
        width: 35%;
    }

    .valor {
        width: 65%;
    }

    .vazio {
        text-align: center;
        padding: 25px;
        font-size: 14px;
        color: gray;
    }
</style>

<div class='titulo'>
    Relatório Sanitário - " . strtoupper(str_replace("_", " ", $tipo)) . "
</div>

<div class='subtitulo'>
    Emitido em: $dataHoje
</div>
";


/* ============================================================
   CHECKLISTS
============================================================ */
if (str_contains($tipo, "checklist")) {

    $campoData = detectarCampoData($conn, "checklist_diario");

    if (!$campoData) {
        $html .= "<div class='vazio'>Tabela checklist não tem coluna de data.</div>";
    }

    /* ============================
       DIÁRIO
    ============================ */
    if ($tipo === "checklist_diario") {

        $hojeISO = date("Y-m-d");
        $hojeBR = date("d/m/Y");

        $sql = "SELECT * FROM checklist_diario
                WHERE $campoData = '$hojeISO'
                   OR $campoData = '$hojeBR'
                LIMIT 1";

        $registro = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);

        if (!$registro) {
            $html .= "<div class='vazio'>Nenhum checklist registrado hoje ($hojeBR).</div>";
        } else {

            $html .= "<div class='card'><b>Checklist Diário - $hojeBR</b><br><br><table>";

            foreach ($registro as $campo => $valor) {
                $html .= "
                <tr>
                    <td class='campo'>" . nomeBonito($campo) . "</td>
                    <td class='valor'>" . formatarValor($campo, $valor) . "</td>
                </tr>";
            }

            $html .= "</table></div>";
        }
    }

    /* ============================
       SEMANAL
    ============================ */
    if ($tipo === "checklist_semanal") {

        $inicioSemana = date("Y-m-d", strtotime("last sunday"));
        if (date("w") == 0)
            $inicioSemana = date("Y-m-d");

        for ($i = 0; $i < 7; $i++) {

            $diaISO = date("Y-m-d", strtotime("$inicioSemana +$i days"));
            $diaBR = date("d/m/Y", strtotime($diaISO));

            $sql = "SELECT * FROM checklist_diario
                    WHERE $campoData = '$diaISO'
                       OR $campoData = '$diaBR'
                    LIMIT 1";

            $registro = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);

            if (!$registro) {
                $html .= "<div class='card'><b>$diaBR</b><br>Nenhum checklist registrado.</div>";
            } else {

                $html .= "<div class='card'><b>$diaBR</b><br><br><table>";

                foreach ($registro as $campo => $valor) {
                    $html .= "
                    <tr>
                        <td class='campo'>" . nomeBonito($campo) . "</td>
                        <td class='valor'>" . formatarValor($campo, $valor) . "</td>
                    </tr>";
                }

                $html .= "</table></div>";
            }
        }
    }

    /* ============================
       MENSAL
    ============================ */
    if ($tipo === "checklist_mensal") {

        $diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

        for ($d = 1; $d <= $diasNoMes; $d++) {

            $diaISO = "$ano-" . str_pad($mes, 2, "0", STR_PAD_LEFT) . "-" . str_pad($d, 2, "0", STR_PAD_LEFT);
            $diaBR = date("d/m/Y", strtotime($diaISO));

            $sql = "SELECT * FROM checklist_diario
                    WHERE $campoData = '$diaISO'
                       OR $campoData = '$diaBR'
                    LIMIT 1";

            $registro = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);

            if (!$registro) {
                $html .= "<div class='card'><b>$diaBR</b><br>Nenhum checklist registrado.</div>";
            } else {

                $html .= "<div class='card'><b>$diaBR</b><br><br><table>";

                foreach ($registro as $campo => $valor) {
                    $html .= "
                    <tr>
                        <td class='campo'>" . nomeBonito($campo) . "</td>
                        <td class='valor'>" . formatarValor($campo, $valor) . "</td>
                    </tr>";
                }

                $html .= "</table></div>";
            }
        }
    }
}


/* ============================================================
   OUTROS RELATÓRIOS (SEM ERRO)
============================================================ */ else {

    $tabela = $tipo;

    $campoData = detectarCampoData($conn, $tabela);

    if ($campoData) {

        $inicio = "$ano-" . str_pad($mes, 2, "0", STR_PAD_LEFT) . "-01";
        $fim = date("Y-m-t", strtotime($inicio));

        $sql = "SELECT * FROM $tabela
                WHERE $campoData BETWEEN '$inicio' AND '$fim'
                ORDER BY id DESC";

    } else {

        $sql = "SELECT * FROM $tabela ORDER BY id DESC";
    }

    $dados = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    if (!$dados) {
        $html .= "<div class='vazio'>Nenhum registro encontrado.</div>";
    }

    foreach ($dados as $row) {

        $html .= "<div class='card'><table>";

        foreach ($row as $campo => $valor) {
            $html .= "
            <tr>
                <td class='campo'>" . nomeBonito($campo) . "</td>
                <td class='valor'>" . formatarValor($campo, $valor) . "</td>
            </tr>";
        }

        $html .= "</table></div>";
    }
}


/* ============================================================
   GERAR PDF
============================================================ */
$dompdf = new Dompdf();
$dompdf->setPaper("A4", "portrait");
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("relatorio_$tipo.pdf", ["Attachment" => false]);
exit;
?>