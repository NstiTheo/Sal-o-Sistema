-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/02/2026 às 00:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `salao_sanitario`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `checklist_diario`
--

CREATE TABLE `checklist_diario` (
  `id` int(11) NOT NULL,
  `data_checklist` date NOT NULL,
  `responsavel` varchar(255) NOT NULL,
  `hig_bancadas` tinyint(1) DEFAULT 0,
  `hig_piso` tinyint(1) DEFAULT 0,
  `hig_banheiro` tinyint(1) DEFAULT 0,
  `hig_lixeiras` tinyint(1) DEFAULT 0,
  `hig_residuos` tinyint(1) DEFAULT 0,
  `est_lavados` tinyint(1) DEFAULT 0,
  `est_embalados` tinyint(1) DEFAULT 0,
  `est_autoclave` tinyint(1) DEFAULT 0,
  `est_indicadores` tinyint(1) DEFAULT 0,
  `est_registro` tinyint(1) DEFAULT 0,
  `prod_nao_vencidos` tinyint(1) DEFAULT 0,
  `prod_armazenados` tinyint(1) DEFAULT 0,
  `prod_anvisa` tinyint(1) DEFAULT 0,
  `prod_fracionados` tinyint(1) DEFAULT 0,
  `epi_luvas` tinyint(1) DEFAULT 0,
  `epi_mascaras` tinyint(1) DEFAULT 0,
  `epi_aventais` tinyint(1) DEFAULT 0,
  `epi_alcool` tinyint(1) DEFAULT 0,
  `con_uniforme` tinyint(1) DEFAULT 0,
  `con_sem_adornos` tinyint(1) DEFAULT 0,
  `con_treinamentos` tinyint(1) DEFAULT 0,
  `con_procedimentos` tinyint(1) DEFAULT 0,
  `assinatura_digital` longtext DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `epi_registros`
--

CREATE TABLE `epi_registros` (
  `id` int(11) NOT NULL,
  `funcionario` varchar(255) DEFAULT NULL,
  `motivo` varchar(100) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `entrega` date DEFAULT NULL,
  `substituicao` date DEFAULT NULL,
  `condicoes` text DEFAULT NULL,
  `obs` text DEFAULT NULL,
  `assinatura` longtext DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `esterilizacao`
--

CREATE TABLE `esterilizacao` (
  `id` int(11) NOT NULL,
  `data_processo` date NOT NULL,
  `responsavel` varchar(150) NOT NULL,
  `equipamento` varchar(100) NOT NULL,
  `equipamento_id` varchar(80) DEFAULT NULL,
  `material` text NOT NULL,
  `quantidade` int(11) NOT NULL,
  `pre_limpeza` varchar(10) NOT NULL,
  `embalagem` varchar(10) NOT NULL,
  `indicador_externo` varchar(20) NOT NULL,
  `indicador_interno` varchar(20) NOT NULL,
  `indicador_biologico` varchar(20) NOT NULL,
  `temperatura` int(11) DEFAULT NULL,
  `pressao` int(11) DEFAULT NULL,
  `tempo` int(11) DEFAULT NULL,
  `validade` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `pacote` varchar(100) DEFAULT NULL,
  `armazenado` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status_final` varchar(30) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `funcao` varchar(100) NOT NULL,
  `admissao` date DEFAULT NULL,
  `esterilizacao` varchar(10) NOT NULL,
  `treinamento` date DEFAULT NULL,
  `epis` text DEFAULT NULL,
  `assinatura` longtext DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `lote` varchar(100) NOT NULL,
  `anvisa` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `estoque` int(11) NOT NULL,
  `fabricacao` date DEFAULT NULL,
  `validade` date NOT NULL,
  `armazenamento` varchar(255) DEFAULT NULL,
  `foto` longtext DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `treinamentos`
--

CREATE TABLE `treinamentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `instrutor` varchar(150) NOT NULL,
  `data_realizacao` date NOT NULL,
  `carga_horaria` int(11) NOT NULL,
  `conteudo` text NOT NULL,
  `participantes` text NOT NULL,
  `avaliacao` varchar(100) NOT NULL,
  `certificado` varchar(10) NOT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `checklist_diario`
--
ALTER TABLE `checklist_diario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `epi_registros`
--
ALTER TABLE `epi_registros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `esterilizacao`
--
ALTER TABLE `esterilizacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `treinamentos`
--
ALTER TABLE `treinamentos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `checklist_diario`
--
ALTER TABLE `checklist_diario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `epi_registros`
--
ALTER TABLE `epi_registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `esterilizacao`
--
ALTER TABLE `esterilizacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `treinamentos`
--
ALTER TABLE `treinamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
