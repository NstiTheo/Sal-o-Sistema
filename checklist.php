<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist Diário Sanitário</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900">

    <?php include("header.php"); ?>
    
    <main class="max-w-5xl mx-auto p-8">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">

            <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">
                Checklist Diário Sanitário
            </h1>

            <form id="formChecklist">

                <div class="mb-6">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
                        Data do Checklist
                    </label>
                    <input id="data" type="date" required
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <section class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl">
                        <h2 class="text-lg font-bold mb-3">🧼 Higienização do Ambiente</h2>
                        <label class="block"><input type="checkbox" id="hig_bancadas"> Bancadas limpas e desinfetadas</label>
                        <label class="block"><input type="checkbox" id="hig_piso"> Piso higienizado</label>
                        <label class="block"><input type="checkbox" id="hig_banheiro"> Banheiro limpo e abastecido</label>
                        <label class="block"><input type="checkbox" id="hig_lixeiras"> Lixeiras com tampa e pedal</label>
                        <label class="block"><input type="checkbox" id="hig_residuos"> Descarte correto de resíduos</label>
                    </section>

                    <section class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl">
                        <h2 class="text-lg font-bold mb-3">🔥 Esterilização e Instrumentais</h2>
                        <label class="block"><input type="checkbox" id="est_lavados"> Instrumentos lavados após uso</label>
                        <label class="block"><input type="checkbox" id="est_embalados"> Instrumentos embalados corretamente</label>
                        <label class="block"><input type="checkbox" id="est_autoclave"> Autoclave/Estufa funcionando</label>
                        <label class="block"><input type="checkbox" id="est_indicadores"> Indicadores químicos conferidos</label>
                        <label class="block"><input type="checkbox" id="est_registro"> Registro atualizado</label>
                    </section>

                    <section class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl">
                        <h2 class="text-lg font-bold mb-3">🧴 Produtos e Validade</h2>
                        <label class="block"><input type="checkbox" id="prod_nao_vencidos"> Nenhum produto vencido em uso</label>
                        <label class="block"><input type="checkbox" id="prod_armazenados"> Produtos armazenados corretamente</label>
                        <label class="block"><input type="checkbox" id="prod_anvisa"> Produtos registrados na ANVISA</label>
                        <label class="block"><input type="checkbox" id="prod_fracionados"> Produtos fracionados identificados</label>
                    </section>

                    <section class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl">
                        <h2 class="text-lg font-bold mb-3">🧤 EPIs e Segurança</h2>
                        <label class="block"><input type="checkbox" id="epi_luvas"> Uso de luvas quando necessário</label>
                        <label class="block"><input type="checkbox" id="epi_mascaras"> Máscaras disponíveis e utilizadas</label>
                        <label class="block"><input type="checkbox" id="epi_aventais"> Aventais limpos</label>
                        <label class="block"><input type="checkbox" id="epi_alcool"> Álcool 70% disponível</label>
                    </section>

                    <section class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl md:col-span-2">
                        <h2 class="text-lg font-bold mb-3">👥 Conduta e Treinamento</h2>
                        <label class="block"><input type="checkbox" id="con_uniforme"> Funcionários com uniforme limpo</label>
                        <label class="block"><input type="checkbox" id="con_sem_adornos"> Sem adornos (anel, pulseira, relógio)</label>
                        <label class="block"><input type="checkbox" id="con_treinamentos"> Treinamentos atualizados</label>
                        <label class="block"><input type="checkbox" id="con_procedimentos"> Procedimentos seguidos corretamente</label>
                    </section>

                </div>

                <div class="mt-8">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
                        Responsável pelo Checklist
                    </label>
                    <input id="responsavel" type="text" required placeholder="Nome do responsável"
                        class="w-full rounded-lg border p-2 dark:bg-gray-900 dark:text-white">
                </div>

                <div class="mt-6">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">
                        Assinatura Digital
                    </label>
                    <canvas id="assinatura" class="border rounded-lg w-full h-40 bg-white"></canvas>
                    <button type="button" onclick="limparAssinatura()"
                        class="mt-2 text-sm text-red-500 hover:underline">
                        Limpar assinatura
                    </button>
                </div>

                <button type="submit"
                    class="mt-8 w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-lg transition">
                    Salvar Checklist Diário
                </button>

            </form>

            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                    Checklists Registrados (MySQL)
                </h2>

                <ul id="lista" class="space-y-4">
                    <?php
                    // Consulta ao Banco de Dados usando $conn (do db.php)
                    try {
                        if (isset($conn)) {
                            $sql = "SELECT * FROM checklist_diario ORDER BY data_checklist DESC LIMIT 10";
                            $stmt = $conn->query($sql);

                            if ($stmt->rowCount() == 0) {
                                echo '<li class="text-gray-500">Nenhum checklist registrado no banco de dados ainda.</li>';
                            }

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $dataFormatada = date('d/m/Y', strtotime($row['data_checklist']));

                                echo "
                                <li class='border rounded-xl p-6 bg-gray-50 dark:bg-gray-900'>
                                    <div class='flex justify-between mb-3'>
                                        <strong>📅 {$dataFormatada}</strong>
                                        <span class='text-xs text-gray-400'>ID: {$row['id']}</span>
                                    </div>
                                    <p class='text-sm mb-2'>Responsável: <b>{$row['responsavel']}</b></p>
                                    <div class='text-sm grid grid-cols-2 gap-2 mb-4'>
                                        <div class='flex items-center gap-2'>
                                            <span>Higienização Bancadas:</span>
                                            <span class='" . ($row['hig_bancadas'] ? "text-green-600" : "text-red-500") . " font-bold'>" . ($row['hig_bancadas'] ? "✔" : "✘") . "</span>
                                        </div>
                                        <div class='flex items-center gap-2'>
                                            <span>Autoclave Func.:</span>
                                            <span class='" . ($row['est_autoclave'] ? "text-green-600" : "text-red-500") . " font-bold'>" . ($row['est_autoclave'] ? "✔" : "✘") . "</span>
                                        </div>
                                    </div>
                                    <div class='mt-2'>
                                        <p class='text-xs text-gray-500 mb-1'>Assinatura:</p>
                                        <img src='{$row['assinatura_digital']}' class='h-16 border bg-white rounded object-contain'>
                                    </div>
                                </li>
                                ";
                            }
                        } else {
                            echo "<li class='text-red-500'>Erro: Variável de conexão não encontrada.</li>";
                        }
                    } catch (PDOException $e) {
                        echo "<li class='text-red-500'>Erro ao carregar lista: " . $e->getMessage() . "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </main>

    <script>
        const form = document.getElementById("formChecklist");
        const canvas = document.getElementById("assinatura");
        const ctx = canvas.getContext("2d");
        let desenhando = false;

        // --- Configuração do Canvas (Igual ao anterior) ---
        function ajustarCanvas() {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
            ctx.lineWidth = 2;
            ctx.lineCap = "round";
            ctx.strokeStyle = "#000";
        }
        ajustarCanvas();
        window.addEventListener("resize", ajustarCanvas);

        function getPosicao(event) {
            const rect = canvas.getBoundingClientRect();
            if (event.touches) {
                return {
                    x: event.touches[0].clientX - rect.left,
                    y: event.touches[0].clientY - rect.top
                };
            }
            return {
                x: event.offsetX,
                y: event.offsetY
            };
        }

        function iniciarDesenho(e) {
            desenhando = true;
            ctx.beginPath();
            const pos = getPosicao(e);
            ctx.moveTo(pos.x, pos.y);
        }

        function desenhar(e) {
            if (!desenhando) return;
            e.preventDefault();
            const pos = getPosicao(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }

        function pararDesenho() {
            desenhando = false;
        }

        function limparAssinatura() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        canvas.addEventListener("mousedown", iniciarDesenho);
        canvas.addEventListener("mousemove", desenhar);
        document.addEventListener("mouseup", pararDesenho);
        canvas.addEventListener("touchstart", iniciarDesenho);
        canvas.addEventListener("touchmove", desenhar);
        document.addEventListener("touchend", pararDesenho);

        // --- NOVA LÓGICA DE ENVIO COM DIAGNÓSTICO DE ERRO ---
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const dados = {
                data: document.getElementById("data").value,
                responsavel: document.getElementById("responsavel").value,
                assinatura: canvas.toDataURL("image/png"),
                itens: {
                    hig_bancadas: document.getElementById("hig_bancadas").checked,
                    hig_piso: document.getElementById("hig_piso").checked,
                    hig_banheiro: document.getElementById("hig_banheiro").checked,
                    hig_lixeiras: document.getElementById("hig_lixeiras").checked,
                    hig_residuos: document.getElementById("hig_residuos").checked,

                    est_lavados: document.getElementById("est_lavados").checked,
                    est_embalados: document.getElementById("est_embalados").checked,
                    est_autoclave: document.getElementById("est_autoclave").checked,
                    est_indicadores: document.getElementById("est_indicadores").checked,
                    est_registro: document.getElementById("est_registro").checked,

                    prod_nao_vencidos: document.getElementById("prod_nao_vencidos").checked,
                    prod_armazenados: document.getElementById("prod_armazenados").checked,
                    prod_anvisa: document.getElementById("prod_anvisa").checked,
                    prod_fracionados: document.getElementById("prod_fracionados").checked,

                    epi_luvas: document.getElementById("epi_luvas").checked,
                    epi_mascaras: document.getElementById("epi_mascaras").checked,
                    epi_aventais: document.getElementById("epi_aventais").checked,
                    epi_alcool: document.getElementById("epi_alcool").checked,

                    con_uniforme: document.getElementById("con_uniforme").checked,
                    con_sem_adornos: document.getElementById("con_sem_adornos").checked,
                    con_treinamentos: document.getElementById("con_treinamentos").checked,
                    con_procedimentos: document.getElementById("con_procedimentos").checked
                }
            };

            try {
                const response = await fetch('processo_salvar_checklist.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dados)
                });

                // Verifica se o arquivo foi encontrado (Erro 404) ou se o servidor quebrou (Erro 500)
                if (!response.ok) {
                    throw new Error(`Erro HTTP: ${response.status} - Verifique se o arquivo processo_salvar_checklist.php existe.`);
                }

                // Pega a resposta como TEXTO primeiro para ver o que veio
                const textoResposta = await response.text();
                console.log("Resposta do PHP:", textoResposta); // Olha no F12 do navegador

                let resultado;
                try {
                    resultado = JSON.parse(textoResposta);
                } catch (jsonError) {
                    throw new Error("O PHP retornou erro ou texto inválido: " + textoResposta);
                }

                if (resultado.sucesso) {
                    alert("✅ Checklist salvo com sucesso!");
                    window.location.reload();
                } else {
                    alert("❌ O PHP retornou um erro: " + resultado.mensagem);
                }

            } catch (error) {
                console.error("Erro detalhado:", error);
                alert("DETALHE DO ERRO:\n" + error.message);
            }
        });
    </script>
</body>

</html>