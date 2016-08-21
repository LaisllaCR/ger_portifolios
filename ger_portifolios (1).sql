-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 21-Ago-2016 às 05:15
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ger_portifolios`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fase`
--

CREATE TABLE `fase` (
  `fase_id` int(11) NOT NULL,
  `fase_nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fase`
--

INSERT INTO `fase` (`fase_id`, `fase_nome`) VALUES
(1, 'Iniciação'),
(2, 'Planejamento'),
(3, 'Execução'),
(4, 'Monitoramento e Controle'),
(5, 'Encerramento');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionalidade`
--

CREATE TABLE `funcionalidade` (
  `funcionalidade_id` int(11) NOT NULL,
  `funcionalidade_nome` varchar(255) NOT NULL,
  `funcionalidade_pai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionalidade`
--

INSERT INTO `funcionalidade` (`funcionalidade_id`, `funcionalidade_nome`, `funcionalidade_pai`) VALUES
(1, 'projeto', NULL),
(2, 'projeto/add', 1),
(3, 'projeto/edit', 1),
(4, 'projeto/detalhe', 1),
(5, 'projeto/delete', 1),
(6, 'membro_projeto/consulta', 1),
(7, 'indicador_projeto/consulta', 1),
(8, 'acompanhamento_projeto/consulta', 1),
(9, 'tarefa_projeto/consulta', 1),
(10, 'indicador', NULL),
(11, 'indicador/add', 10),
(12, 'indicador/edit', 10),
(13, 'indicador/detalhe', 10),
(14, 'indicador/delete', 10),
(15, 'usuario', NULL),
(16, 'usuario/add', 15),
(17, 'usuario/edit', 15),
(18, 'usuario/delete', 15),
(19, 'usuario/detalhe', 15),
(20, 'perfil-acesso', NULL),
(21, 'relatorios', NULL),
(22, 'projeto/status', 1),
(23, 'home', NULL),
(24, 'login', NULL),
(25, 'indicador_projeto/add', NULL),
(26, 'indicador_projeto/edit', NULL),
(27, 'indicador_projeto/delete', NULL),
(28, 'indicador_projeto/analise', NULL),
(29, 'membro_projeto/add', NULL),
(30, 'membro_projeto/detalhe', NULL),
(31, 'membro_projeto/edit', NULL),
(32, 'membro_projeto/delete', NULL),
(33, 'acompanhamento_projeto/detalhe', NULL),
(34, 'acompanhamento_projeto/edit', NULL),
(35, 'tarefa_projeto/detalhe', NULL),
(36, 'tarefa_projeto/add', NULL),
(37, 'tarefa_projeto/edit', NULL),
(38, 'tarefa_projeto/delete', NULL),
(39, 'indicador_projeto/detalhe', NULL),
(40, 'perfil-acesso/edit', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `indicadores`
--

CREATE TABLE `indicadores` (
  `indicador_id` int(11) NOT NULL,
  `indicador_nome` varchar(255) NOT NULL,
  `indicador_descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `indicadores`
--

INSERT INTO `indicadores` (`indicador_id`, `indicador_nome`, `indicador_descricao`) VALUES
(1, 'Performance', ''),
(4, 'Usabilidade', ''),
(5, 'Gasto Com Pessoal', ''),
(6, 'Eficiência', ''),
(7, 'Eficácia', ''),
(8, 'Capacidade', ''),
(9, 'Produtividade', ''),
(10, 'Qualidade', ''),
(11, 'Lucratividade', ''),
(12, 'Rentabilidade', ''),
(13, 'Competitividade', ''),
(14, 'Efetividade', ''),
(15, 'Valor', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `indicadores_projeto`
--

CREATE TABLE `indicadores_projeto` (
  `indicador_projeto_id` int(11) NOT NULL,
  `indicador_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `projeto_fase` enum('Iniciação','Planejamento','Execução','Monitoramento e Controle','Encerramento') NOT NULL,
  `valor_minimo` int(11) NOT NULL,
  `valor_maximo` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `indicador_projeto_valor` int(11) DEFAULT NULL,
  `indicador_projeto_descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `indicadores_projeto`
--

INSERT INTO `indicadores_projeto` (`indicador_projeto_id`, `indicador_id`, `projeto_id`, `projeto_fase`, `valor_minimo`, `valor_maximo`, `usuario_id`, `indicador_projeto_valor`, `indicador_projeto_descricao`) VALUES
(1, 8, 30, 'Iniciação', 1, 10, 1, 11, ' gdg '),
(2, 11, 30, 'Iniciação', 1, 10, 1, 11, ' fgjf '),
(3, 11, 30, 'Iniciação', 1, 10, 1, NULL, NULL),
(4, 1, 30, 'Iniciação', 1, 3, 1, 8, ' fdhf'),
(5, 1, 30, 'Iniciação', 1, 8, 1, 10, ' ds'),
(6, 15, 30, 'Iniciação', 1, 2, 1, 4, ' 42           '),
(7, 7, 30, 'Iniciação', 1, 2, 1, 4, ' ew   '),
(8, 1, 24, 'Iniciação', 1, 2, 1, 3, '3');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE `perfil` (
  `perfil_id` int(11) NOT NULL,
  `perfil_nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `perfil`
--

INSERT INTO `perfil` (`perfil_id`, `perfil_nome`) VALUES
(1, 'Administrador'),
(2, 'Líder do escritório de projetos'),
(3, 'Líder de projeto/Gerente de Projeto'),
(5, 'Equipe técnica'),
(6, 'Alta direção');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_acesso`
--

CREATE TABLE `perfil_acesso` (
  `perfil_acesso_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `funcionalidade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `perfil_acesso`
--

INSERT INTO `perfil_acesso` (`perfil_acesso_id`, `perfil_id`, `funcionalidade_id`) VALUES
(154, 1, 1),
(155, 1, 2),
(156, 1, 3),
(157, 1, 5),
(158, 1, 4),
(159, 1, 22),
(160, 1, 7),
(161, 1, 25),
(162, 1, 26),
(163, 1, 27),
(164, 1, 39),
(165, 1, 28),
(166, 1, 9),
(167, 1, 36),
(168, 1, 37),
(169, 1, 38),
(170, 1, 35),
(171, 1, 6),
(172, 1, 29),
(173, 1, 31),
(174, 1, 32),
(175, 1, 30),
(176, 1, 8),
(177, 1, 33),
(178, 1, 34),
(179, 1, 10),
(180, 1, 11),
(181, 1, 12),
(182, 1, 14),
(183, 1, 13),
(184, 1, 15),
(185, 1, 16),
(186, 1, 17),
(187, 1, 18),
(188, 1, 19),
(189, 1, 21),
(190, 1, 20),
(191, 1, 20),
(230, 2, 1),
(231, 2, 2),
(232, 2, 3),
(233, 2, 5),
(234, 2, 4),
(235, 2, 22),
(236, 2, 7),
(237, 2, 25),
(238, 2, 26),
(239, 2, 27),
(240, 2, 39),
(241, 2, 28),
(242, 2, 9),
(243, 2, 36),
(244, 2, 37),
(245, 2, 38),
(246, 2, 35),
(247, 2, 6),
(248, 2, 29),
(249, 2, 31),
(250, 2, 32),
(251, 2, 30),
(252, 2, 8),
(253, 2, 33),
(254, 2, 34),
(255, 2, 10),
(256, 2, 11),
(257, 2, 12),
(258, 2, 14),
(259, 2, 13),
(261, 6, 21),
(262, 5, 1),
(263, 5, 4),
(264, 5, 9),
(265, 5, 36),
(266, 5, 37),
(267, 5, 38),
(268, 5, 35),
(286, 3, 1),
(287, 3, 2),
(288, 3, 3),
(289, 3, 5),
(290, 3, 4),
(291, 3, 9),
(292, 3, 36),
(293, 3, 37),
(294, 3, 38),
(295, 3, 35),
(296, 3, 6),
(297, 3, 29),
(298, 3, 31),
(299, 3, 32),
(300, 3, 30),
(301, 3, 8),
(302, 3, 33),
(303, 3, 34),
(304, 1, 40);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `projeto_id` int(11) NOT NULL,
  `projeto_nome` varchar(255) NOT NULL,
  `projeto_data_inicio` date NOT NULL,
  `projeto_data_previsao_termino` date NOT NULL,
  `projeto_data_real_termino` date NOT NULL,
  `projeto_gerente_id` int(11) NOT NULL,
  `projeto_orcamento_total` float NOT NULL,
  `projeto_descricao` varchar(255) NOT NULL,
  `projeto_status` enum('Em analise','Analise realizada','Analise aprovada','Iniciado','Planejado','Em andamento','Encerrado','Cancelado') NOT NULL,
  `projeto_risco` enum('Baixo risco','Medio risco','Alto risco','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto`
--

INSERT INTO `projeto` (`projeto_id`, `projeto_nome`, `projeto_data_inicio`, `projeto_data_previsao_termino`, `projeto_data_real_termino`, `projeto_gerente_id`, `projeto_orcamento_total`, `projeto_descricao`, `projeto_status`, `projeto_risco`) VALUES
(24, 'Teste milesimo', '2016-08-01', '2016-08-24', '2016-08-31', 1, 4.24, '78         ', 'Em andamento', 'Alto risco'),
(27, 'Projeto Cancelado', '2016-08-13', '2016-08-14', '0000-00-00', 1, 0.45, 'gfdsg', 'Cancelado', 'Medio risco'),
(28, 'Projeto Cancelado 2', '2016-08-05', '2016-08-06', '0000-00-00', 1, 0.34, 'sfes', 'Cancelado', 'Baixo risco'),
(29, 'Projeto Cancelado 3', '2016-08-01', '2016-08-03', '0000-00-00', 1, 4.35, 'eger', 'Cancelado', 'Baixo risco'),
(30, 'Projeto Indicador Limite ', '2016-08-04', '2016-08-13', '0000-00-00', 1, 424.56, '6546546', 'Em analise', 'Medio risco');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_acompanhamento`
--

CREATE TABLE `projeto_acompanhamento` (
  `projeto_acompanhamento_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `projeto_acompanhamento_semana` int(11) NOT NULL,
  `projeto_acompanhamento_data_inicio` date NOT NULL,
  `projeto_acompanhamento_data_termino` date NOT NULL,
  `projeto_acompanhamento_descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_membro`
--

CREATE TABLE `projeto_membro` (
  `projeto_membro_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `projeto_membro_papel` enum('Desenvolvedor','Designer','Testador','Analista de Requisitos','Analista de negocio','Administrador de BD','Arquiteto da Informacao','Analista de Sistemas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto_membro`
--

INSERT INTO `projeto_membro` (`projeto_membro_id`, `usuario_id`, `projeto_id`, `projeto_membro_papel`) VALUES
(1, 1, 24, 'Desenvolvedor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_semana`
--

CREATE TABLE `projeto_semana` (
  `projeto_semana_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `projeto_semana` int(11) NOT NULL,
  `projeto_semana_data_inicio` date NOT NULL,
  `projeto_semana_data_fim` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto_semana`
--

INSERT INTO `projeto_semana` (`projeto_semana_id`, `projeto_id`, `projeto_semana`, `projeto_semana_data_inicio`, `projeto_semana_data_fim`) VALUES
(55, 24, 1, '2016-08-01', '2016-08-08'),
(69, 24, 2, '2016-08-08', '2016-08-15'),
(70, 24, 1, '2016-08-01', '2016-08-08'),
(71, 24, 1, '2016-08-01', '2016-08-08'),
(72, 24, 1, '2016-08-01', '2016-08-08'),
(73, 24, 1, '2016-08-01', '2016-08-08'),
(74, 24, 1, '2016-08-01', '2016-08-08'),
(75, 24, 1, '2016-08-01', '2016-08-08'),
(76, 24, 2, '2016-08-08', '2016-08-15'),
(77, 24, 3, '2016-08-15', '2016-08-22'),
(78, 24, 4, '2016-08-22', '2016-08-29'),
(79, 24, 5, '2016-08-29', '2016-08-31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_semana_justificativa`
--

CREATE TABLE `projeto_semana_justificativa` (
  `projeto_semana_justificativa_id` int(11) NOT NULL,
  `projeto_semana_id` int(11) NOT NULL,
  `projeto_semana_justificativa` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto_semana_justificativa`
--

INSERT INTO `projeto_semana_justificativa` (`projeto_semana_justificativa_id`, `projeto_semana_id`, `projeto_semana_justificativa`, `usuario_id`) VALUES
(6, 55, ' sd45', 3),
(7, 69, ' fdhgxvd6r', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_status_justificativa`
--

CREATE TABLE `projeto_status_justificativa` (
  `projeto_status_justificativa_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `projeto_status` varchar(255) NOT NULL,
  `projeto_status_justificativa` varchar(255) DEFAULT NULL,
  `projeto_status_data` date NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto_status_justificativa`
--

INSERT INTO `projeto_status_justificativa` (`projeto_status_justificativa_id`, `projeto_id`, `projeto_status`, `projeto_status_justificativa`, `projeto_status_data`, `usuario_id`) VALUES
(2, 5, 'Em analise', NULL, '2016-07-22', 1),
(3, 5, 'Analise realizada', NULL, '2016-07-22', 1),
(4, 5, 'Analise aprovada', NULL, '2016-07-22', 1),
(5, 5, 'Iniciado', NULL, '2016-07-22', 1),
(24, 24, 'Em analise', NULL, '2016-08-03', 1),
(25, 24, 'Analise realizada', 'kuytkuytku', '2016-08-08', 1),
(26, 24, 'Encerrado', 'rhtregtreht', '2016-08-08', 3),
(27, 27, 'Em analise', NULL, '2016-08-13', 3),
(28, 27, 'Cancelado', 'fdsgfds', '2016-08-13', 3),
(29, 28, 'Em analise', NULL, '2016-08-13', 3),
(30, 28, 'Cancelado', 'ewterwtwer', '2016-07-13', 3),
(31, 29, 'Em analise', NULL, '2016-08-13', 3),
(32, 29, 'Cancelado', 'wrw', '2016-08-13', 3),
(33, 30, 'Em analise', NULL, '2016-08-13', 3),
(34, 24, 'Em andamento', '', '2016-08-21', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_tarefa`
--

CREATE TABLE `projeto_tarefa` (
  `tarefa_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `tarefa_nome` varchar(255) NOT NULL,
  `tarefa_descricao` varchar(255) NOT NULL,
  `tarefa_status` enum('Aberta','Em Andamento','Suspensa','Encerrada') NOT NULL,
  `tarefa_data_inicio` date NOT NULL,
  `tarefa_data_termino` date NOT NULL,
  `tarefa_data_previsao_termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto_tarefa`
--

INSERT INTO `projeto_tarefa` (`tarefa_id`, `projeto_id`, `tarefa_nome`, `tarefa_descricao`, `tarefa_status`, `tarefa_data_inicio`, `tarefa_data_termino`, `tarefa_data_previsao_termino`) VALUES
(1, 24, 'daa', 'sda', 'Aberta', '2016-08-12', '0000-00-00', '2016-08-20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nome` varchar(255) NOT NULL,
  `usuario_email` varchar(255) NOT NULL,
  `usuario_senha` varchar(255) NOT NULL,
  `perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nome`, `usuario_email`, `usuario_senha`, `perfil_id`) VALUES
(1, 'Laislla Costa Ramos', 'laisllaramos@gmail.com', '475869', 1),
(3, 'Teste', 'la.toph@hotmail.com', '123456789', 1),
(4, 'g', 'l@g.com.br', '', 1),
(5, 'l', '2@gmail.com', '1', 1),
(6, 'L?l', 'la.toph@hotmail.com', '14654654654', 1),
(7, 'Teste Alta dire??o', 'la.toph@hotmail.com', '123456789', 6),
(8, 'Manoelvilco@hotmail.com', 'manoelvilco@hotmail.com', '123456', 6),
(9, 'administrador', 'administrador@gmail.com', '123456', 1),
(10, 'Líder do Escritório de Projetos', 'liderdoescritoriodeprojetos@gmail.com', '123456', 2),
(11, 'Líder de Projeto', 'liderdeprojeto@gmail.com', '123456', 3),
(12, 'Equipe Técnica', 'equipetecnica@gmail.com', '123456', 5),
(13, 'Alta Direção', 'altadirecao@gmail.com', '123456', 6),
(14, '?', 'la.toph@hotmail.com', '123456789', 1),
(15, 'é', 'la.toph@hotmail.com', '123456789', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fase`
--
ALTER TABLE `fase`
  ADD PRIMARY KEY (`fase_id`);

--
-- Indexes for table `funcionalidade`
--
ALTER TABLE `funcionalidade`
  ADD PRIMARY KEY (`funcionalidade_id`);

--
-- Indexes for table `indicadores`
--
ALTER TABLE `indicadores`
  ADD PRIMARY KEY (`indicador_id`);

--
-- Indexes for table `indicadores_projeto`
--
ALTER TABLE `indicadores_projeto`
  ADD PRIMARY KEY (`indicador_projeto_id`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`perfil_id`);

--
-- Indexes for table `perfil_acesso`
--
ALTER TABLE `perfil_acesso`
  ADD PRIMARY KEY (`perfil_acesso_id`);

--
-- Indexes for table `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`projeto_id`);

--
-- Indexes for table `projeto_acompanhamento`
--
ALTER TABLE `projeto_acompanhamento`
  ADD PRIMARY KEY (`projeto_acompanhamento_id`);

--
-- Indexes for table `projeto_membro`
--
ALTER TABLE `projeto_membro`
  ADD PRIMARY KEY (`projeto_membro_id`);

--
-- Indexes for table `projeto_semana`
--
ALTER TABLE `projeto_semana`
  ADD PRIMARY KEY (`projeto_semana_id`);

--
-- Indexes for table `projeto_semana_justificativa`
--
ALTER TABLE `projeto_semana_justificativa`
  ADD PRIMARY KEY (`projeto_semana_justificativa_id`);

--
-- Indexes for table `projeto_status_justificativa`
--
ALTER TABLE `projeto_status_justificativa`
  ADD PRIMARY KEY (`projeto_status_justificativa_id`);

--
-- Indexes for table `projeto_tarefa`
--
ALTER TABLE `projeto_tarefa`
  ADD PRIMARY KEY (`tarefa_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fase`
--
ALTER TABLE `fase`
  MODIFY `fase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `funcionalidade`
--
ALTER TABLE `funcionalidade`
  MODIFY `funcionalidade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `indicadores`
--
ALTER TABLE `indicadores`
  MODIFY `indicador_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `indicadores_projeto`
--
ALTER TABLE `indicadores_projeto`
  MODIFY `indicador_projeto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `perfil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `perfil_acesso`
--
ALTER TABLE `perfil_acesso`
  MODIFY `perfil_acesso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;
--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `projeto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `projeto_acompanhamento`
--
ALTER TABLE `projeto_acompanhamento`
  MODIFY `projeto_acompanhamento_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projeto_membro`
--
ALTER TABLE `projeto_membro`
  MODIFY `projeto_membro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `projeto_semana`
--
ALTER TABLE `projeto_semana`
  MODIFY `projeto_semana_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `projeto_semana_justificativa`
--
ALTER TABLE `projeto_semana_justificativa`
  MODIFY `projeto_semana_justificativa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `projeto_status_justificativa`
--
ALTER TABLE `projeto_status_justificativa`
  MODIFY `projeto_status_justificativa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `projeto_tarefa`
--
ALTER TABLE `projeto_tarefa`
  MODIFY `tarefa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
