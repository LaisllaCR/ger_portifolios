-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08-Set-2016 às 01:21
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
(14, 'Efetividade', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `indicadores_projeto`
--

CREATE TABLE `indicadores_projeto` (
  `indicador_projeto_id` int(11) NOT NULL,
  `indicador_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `projeto_fase` enum('Iniciacao','Planejamento','Execucao','Monitoramento e Controle','Encerramento') NOT NULL,
  `valor_minimo` int(11) NOT NULL,
  `valor_maximo` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `indicador_projeto_valor` int(11) DEFAULT NULL,
  `indicador_projeto_descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `acao` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `logs`
--

INSERT INTO `logs` (`log_id`, `usuario_id`, `data`, `acao`, `id`) VALUES
(1, 1, '2016-09-07', 'usuario/edit', 5),
(2, 7, '2016-09-08', 'projeto/add', 1),
(3, 7, '2016-09-08', 'usuario/detalhe', 2),
(4, 7, '2016-09-08', 'indicador/delete', 16),
(5, 7, '2016-09-08', 'indicador/delete', 15),
(6, 7, '2016-09-08', 'indicador/delete', 17),
(7, 7, '2016-09-08', 'indicador/delete', 21),
(8, 7, '2016-09-08', 'indicador/delete', 20),
(9, 7, '2016-09-08', 'indicador/delete', 19),
(10, 7, '2016-09-08', 'indicador/delete', 18),
(11, 7, '2016-09-08', 'indicador/add', 22),
(12, 7, '2016-09-08', 'indicador/delete', 22);

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
(261, 6, 21),
(766, 1, 1),
(767, 1, 2),
(768, 1, 3),
(769, 1, 5),
(770, 1, 4),
(771, 1, 22),
(772, 1, 7),
(773, 1, 25),
(774, 1, 26),
(775, 1, 27),
(776, 1, 39),
(777, 1, 28),
(778, 1, 9),
(779, 1, 36),
(780, 1, 37),
(781, 1, 38),
(782, 1, 35),
(783, 1, 6),
(784, 1, 29),
(785, 1, 31),
(786, 1, 32),
(787, 1, 30),
(788, 1, 8),
(789, 1, 33),
(790, 1, 34),
(791, 1, 10),
(792, 1, 11),
(793, 1, 12),
(794, 1, 14),
(795, 1, 13),
(796, 1, 15),
(797, 1, 16),
(798, 1, 17),
(799, 1, 18),
(800, 1, 19),
(801, 1, 21),
(802, 1, 20),
(891, 2, 1),
(892, 2, 2),
(893, 2, 3),
(894, 2, 5),
(895, 2, 4),
(896, 2, 22),
(897, 2, 7),
(898, 2, 25),
(899, 2, 26),
(900, 2, 27),
(901, 2, 39),
(902, 2, 28),
(903, 2, 9),
(904, 2, 36),
(905, 2, 37),
(906, 2, 38),
(907, 2, 35),
(908, 2, 6),
(909, 2, 29),
(910, 2, 31),
(911, 2, 32),
(912, 2, 30),
(913, 2, 33),
(914, 2, 34),
(915, 2, 10),
(916, 2, 11),
(917, 2, 12),
(918, 2, 14),
(919, 2, 13),
(920, 5, 1),
(921, 5, 4),
(922, 5, 9),
(923, 5, 37),
(924, 5, 35),
(955, 3, 1),
(956, 3, 3),
(957, 3, 4),
(958, 3, 9),
(959, 3, 36),
(960, 3, 37),
(961, 3, 38),
(962, 3, 35),
(963, 3, 6),
(964, 3, 29),
(965, 3, 31),
(966, 3, 32),
(967, 3, 30),
(968, 3, 8),
(969, 3, 33),
(970, 3, 34);

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
(1, 'Sistema de Venda de Passagens', '2016-01-01', '2016-12-31', '0000-00-00', 2, 1000000, 'Sistema para gerenciar a venda de passagens aereas', 'Em analise', 'Medio risco');

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
(1, 1, 1, '2016-01-01', '2016-01-08'),
(2, 1, 2, '2016-01-08', '2016-01-15'),
(3, 1, 3, '2016-01-15', '2016-01-22'),
(4, 1, 4, '2016-01-22', '2016-01-29'),
(5, 1, 5, '2016-01-29', '2016-02-05'),
(6, 1, 6, '2016-02-05', '2016-02-12'),
(7, 1, 7, '2016-02-12', '2016-02-19'),
(8, 1, 8, '2016-02-19', '2016-02-26'),
(9, 1, 9, '2016-02-26', '2016-03-04'),
(10, 1, 10, '2016-03-04', '2016-03-11'),
(11, 1, 11, '2016-03-11', '2016-03-18'),
(12, 1, 12, '2016-03-18', '2016-03-25'),
(13, 1, 13, '2016-03-25', '2016-04-01'),
(14, 1, 14, '2016-04-01', '2016-04-08'),
(15, 1, 15, '2016-04-08', '2016-04-15'),
(16, 1, 16, '2016-04-15', '2016-04-22'),
(17, 1, 17, '2016-04-22', '2016-04-29'),
(18, 1, 18, '2016-04-29', '2016-05-06'),
(19, 1, 19, '2016-05-06', '2016-05-13'),
(20, 1, 20, '2016-05-13', '2016-05-20'),
(21, 1, 21, '2016-05-20', '2016-05-27'),
(22, 1, 22, '2016-05-27', '2016-06-03'),
(23, 1, 23, '2016-06-03', '2016-06-10'),
(24, 1, 24, '2016-06-10', '2016-06-17'),
(25, 1, 25, '2016-06-17', '2016-06-24'),
(26, 1, 26, '2016-06-24', '2016-07-01'),
(27, 1, 27, '2016-07-01', '2016-07-08'),
(28, 1, 28, '2016-07-08', '2016-07-15'),
(29, 1, 29, '2016-07-15', '2016-07-22'),
(30, 1, 30, '2016-07-22', '2016-07-29'),
(31, 1, 31, '2016-07-29', '2016-08-05'),
(32, 1, 32, '2016-08-05', '2016-08-12'),
(33, 1, 33, '2016-08-12', '2016-08-19'),
(34, 1, 34, '2016-08-19', '2016-08-26'),
(35, 1, 35, '2016-08-26', '2016-09-02'),
(36, 1, 36, '2016-09-02', '2016-09-09'),
(37, 1, 37, '2016-09-09', '2016-09-16'),
(38, 1, 38, '2016-09-16', '2016-09-23'),
(39, 1, 39, '2016-09-23', '2016-09-30'),
(40, 1, 40, '2016-09-30', '2016-10-07'),
(41, 1, 41, '2016-10-07', '2016-10-14'),
(42, 1, 42, '2016-10-14', '2016-10-21'),
(43, 1, 43, '2016-10-21', '2016-10-28'),
(44, 1, 44, '2016-10-28', '2016-11-04'),
(45, 1, 45, '2016-11-04', '2016-11-11'),
(46, 1, 46, '2016-11-11', '2016-11-18'),
(47, 1, 47, '2016-11-18', '2016-11-25'),
(48, 1, 48, '2016-11-25', '2016-12-02'),
(49, 1, 49, '2016-12-02', '2016-12-09'),
(50, 1, 50, '2016-12-09', '2016-12-16'),
(51, 1, 51, '2016-12-16', '2016-12-23'),
(52, 1, 52, '2016-12-23', '2016-12-30'),
(53, 1, 53, '2016-12-30', '2016-12-31');

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
(1, 1, 'Em analise', NULL, '2016-09-08', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_tarefa`
--

CREATE TABLE `projeto_tarefa` (
  `tarefa_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tarefa_nome` varchar(255) NOT NULL,
  `tarefa_descricao` varchar(255) NOT NULL,
  `tarefa_status` enum('Aberta','Em Andamento','Suspensa','Encerrada') NOT NULL,
  `tarefa_data_inicio` date NOT NULL,
  `tarefa_data_termino` date NOT NULL,
  `tarefa_data_previsao_termino` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Administrador', 'administrador@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'Gerente', 'gerente@gerportifolio.com', 'e10adc3949ba59abbe56e057f20f883e', 3),
(3, 'Coordenador', 'coordenador@gerportifolio.com', 'e10adc3949ba59abbe56e057f20f883e', 2),
(4, 'Diretor', 'gerportifolio@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 6),
(5, 'João', 'joao@gerportifolio.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(6, 'Maria', 'maria@gerportifolio.com', 'e10adc3949ba59abbe56e057f20f883e', 5),
(7, 'Laislla Ramos', 'laisllaramos@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1);

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
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

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
  MODIFY `indicador_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `indicadores_projeto`
--
ALTER TABLE `indicadores_projeto`
  MODIFY `indicador_projeto_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `perfil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `perfil_acesso`
--
ALTER TABLE `perfil_acesso`
  MODIFY `perfil_acesso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=971;
--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `projeto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `projeto_membro`
--
ALTER TABLE `projeto_membro`
  MODIFY `projeto_membro_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projeto_semana`
--
ALTER TABLE `projeto_semana`
  MODIFY `projeto_semana_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `projeto_semana_justificativa`
--
ALTER TABLE `projeto_semana_justificativa`
  MODIFY `projeto_semana_justificativa_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projeto_status_justificativa`
--
ALTER TABLE `projeto_status_justificativa`
  MODIFY `projeto_status_justificativa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `projeto_tarefa`
--
ALTER TABLE `projeto_tarefa`
  MODIFY `tarefa_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
