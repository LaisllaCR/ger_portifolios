-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 28-Jul-2016 às 00:05
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 5.5.34

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
(1, 'Projetos', NULL),
(2, 'Cadastrar', 1),
(3, 'Editar', 1),
(4, 'Visualizar', 1),
(5, 'Excluir', 1),
(6, 'Membros', 1),
(7, 'Indicadores', 1),
(8, 'Acompanhamento', 1),
(9, 'Tarefa', 1),
(10, 'Indicadores', NULL),
(11, 'Cadastrar', 10),
(12, 'Editar', 10),
(13, 'Visualizar', 10),
(14, 'Excluir', 10),
(15, 'Usuarios', NULL),
(16, 'Cadastrar', 15),
(17, 'Editar', 15),
(18, 'Excluir', 15),
(19, 'Visualizar', 15),
(20, 'Perfil', NULL),
(21, 'Relatorios', NULL);

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
(1, 'Performance/Desempenho', ''),
(4, 'Usabilidade 3', '');

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
(1, 1, 3, 'Encerramento', 10, 54, 1, 0, ''),
(2, 4, 3, 'Monitoramento e Controle', 2, 7, 1, 0, ''),
(3, 1, 3, 'Execução', 2, 6, 1, 0, ''),
(4, 1, 3, 'Iniciação', 10, 10, 1, NULL, NULL),
(5, 4, 3, 'Planejamento', 2, 7, 1, NULL, NULL),
(7, 4, 4, 'Planejamento', 1, 5, 1, NULL, NULL),
(8, 1, 4, 'Iniciação', 1, 2, 1, NULL, NULL),
(9, 1, 4, 'Iniciação', 1, 2, 1, NULL, NULL),
(12, 4, 3, 'Monitoramento e Controle', 2, 4, 1, NULL, NULL),
(13, 4, 1, 'Planejamento', 3, 5, 1, 3, ' HGFHGDFHGF 555 GDGFD'),
(14, 1, 1, 'Iniciação', 1, 2, 1, NULL, NULL);

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
(1, 'Admin'),
(2, 'Líder do escritório de projetos'),
(3, 'Líder de projeto'),
(4, 'Gerente de projeto'),
(5, 'Equipe técnica');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_acesso`
--

CREATE TABLE `perfil_acesso` (
  `perfil_acesso_id` int(11) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `funcionalidade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Projeto Teste Editado 2 ', '2016-07-08', '2016-07-20', '2016-07-31', 1, 10, ' SERA?  ', 'Encerrado', 'Medio risco'),
(3, 'Projeto Teste Novo 2', '2016-07-07', '2016-08-19', '2016-08-02', 1, 10, 'asd ', 'Analise realizada', 'Medio risco'),
(4, 'Projeto de teste de justificativa eh yrjyejyte', '2016-07-22', '2016-07-23', '2016-07-22', 1, 10, 'jhgjhg  ', 'Em analise', 'Baixo risco'),
(9, 'Teste acompanhamento', '2016-07-26', '2016-08-23', '2016-08-11', 3, 12, '212121', 'Em analise', 'Alto risco'),
(10, 'Teste acompanhamento 2', '2016-07-26', '2016-07-27', '2016-07-28', 3, 10, '57181', 'Em analise', 'Alto risco'),
(11, 'Teste acompanhamento 3', '2016-07-26', '2016-11-30', '2017-01-26', 1, 14, 'hih,i', 'Em analise', 'Alto risco');

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

--
-- Extraindo dados da tabela `projeto_acompanhamento`
--

INSERT INTO `projeto_acompanhamento` (`projeto_acompanhamento_id`, `projeto_id`, `projeto_acompanhamento_semana`, `projeto_acompanhamento_data_inicio`, `projeto_acompanhamento_data_termino`, `projeto_acompanhamento_descricao`) VALUES
(1, 9, 1, '2016-07-26', '2016-08-02', NULL),
(2, 9, 2, '2016-08-02', '2016-08-09', NULL),
(3, 9, 3, '2016-08-09', '2016-08-11', NULL),
(4, 10, 1, '2016-07-26', '2016-07-28', NULL),
(5, 11, 1, '0000-00-00', '0000-00-00', ' tetetestre2222'),
(6, 11, 2, '0000-00-00', '0000-00-00', ' hgfdhgfdhgf'),
(7, 11, 3, '0000-00-00', '0000-00-00', 'testeeeeeeeeeeeeeee'),
(8, 11, 4, '0000-00-00', '0000-00-00', ' testeeeeeeeeeeeeeeeee2343'),
(9, 11, 5, '0000-00-00', '2016-08-30', ' oiioioioioio'),
(10, 11, 6, '0000-00-00', '2016-09-06', ' htdhtrdhtr'),
(11, 11, 7, '2016-09-06', '2016-09-13', 'uytiuytiuytiyytuyt7876888887ytiuytiuytiyytuyt7876888887 uytiuytiuytiyytuyt7876888887 uytiuytiuytiyytuyt7876888887'),
(12, 11, 8, '2016-09-13', '2016-09-20', ' Estou testando a descricao na opcao de detalhes Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas et gravida lorem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla facilisi. In non lacin'),
(13, 11, 9, '2016-09-20', '2016-09-27', NULL),
(14, 11, 10, '2016-09-27', '2016-10-04', NULL),
(15, 11, 11, '2016-10-04', '2016-10-11', NULL),
(16, 11, 12, '2016-10-11', '2016-10-18', NULL),
(17, 11, 13, '2016-10-18', '2016-10-25', NULL),
(18, 11, 14, '2016-10-25', '2016-11-01', NULL),
(19, 11, 15, '2016-11-01', '2016-11-08', NULL),
(20, 11, 16, '2016-11-08', '2016-11-15', NULL),
(21, 11, 17, '2016-11-15', '2016-11-22', NULL),
(22, 11, 18, '2016-11-22', '2016-11-29', NULL),
(23, 11, 19, '2016-11-29', '2016-12-06', NULL),
(24, 11, 20, '2016-12-06', '2016-12-13', NULL),
(25, 11, 21, '2016-12-13', '2016-12-20', NULL),
(26, 11, 22, '2016-12-20', '2016-12-27', NULL),
(27, 11, 23, '2016-12-27', '2017-01-03', NULL),
(28, 11, 24, '2017-01-03', '2017-01-10', NULL),
(29, 11, 25, '2017-01-10', '2017-01-17', NULL),
(30, 11, 26, '2017-01-17', '2017-01-24', NULL),
(31, 11, 27, '2017-01-24', '2017-01-26', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_membro`
--

CREATE TABLE `projeto_membro` (
  `projeto_membro_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `perfil_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto_membro`
--

INSERT INTO `projeto_membro` (`projeto_membro_id`, `usuario_id`, `projeto_id`, `perfil_id`) VALUES
(1, 1, 3, 5),
(3, 3, 3, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_status_justificativa`
--

CREATE TABLE `projeto_status_justificativa` (
  `projeto_status_justificativa_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `projeto_status` varchar(255) NOT NULL,
  `projeto_status_justificativa` varchar(255) DEFAULT NULL,
  `projeto_status_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projeto_status_justificativa`
--

INSERT INTO `projeto_status_justificativa` (`projeto_status_justificativa_id`, `projeto_id`, `projeto_status`, `projeto_status_justificativa`, `projeto_status_data`) VALUES
(1, 3, 'Analise realizada', NULL, '2016-07-22'),
(2, 5, 'Em analise', NULL, '2016-07-22'),
(3, 5, 'Analise realizada', NULL, '2016-07-22'),
(4, 5, 'Analise aprovada', NULL, '2016-07-22'),
(5, 5, 'Iniciado', NULL, '2016-07-22'),
(6, 1, 'Encerrado', NULL, '2016-07-25'),
(7, 9, 'Em analise', NULL, '2016-07-26'),
(8, 10, 'Em analise', NULL, '2016-07-26'),
(9, 11, 'Em analise', NULL, '2016-07-26');

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
(2, 1, 'TAP 4', ' Termo de Abertura do Projeto 4', 'Suspensa', '2016-07-28', '2016-07-30', '2016-07-29');

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
(1, 'Laislla Ramos 2', 'la.toph@hotmail.com', '123456789', 4),
(3, 'Teste', 'la.toph@hotmail.com', '123456789', 1),
(4, 'testeuser', 'testeuser@gmail.com', '123456', 5);

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
  MODIFY `funcionalidade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `indicadores`
--
ALTER TABLE `indicadores`
  MODIFY `indicador_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `indicadores_projeto`
--
ALTER TABLE `indicadores_projeto`
  MODIFY `indicador_projeto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `perfil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `perfil_acesso`
--
ALTER TABLE `perfil_acesso`
  MODIFY `perfil_acesso_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `projeto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `projeto_acompanhamento`
--
ALTER TABLE `projeto_acompanhamento`
  MODIFY `projeto_acompanhamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `projeto_membro`
--
ALTER TABLE `projeto_membro`
  MODIFY `projeto_membro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `projeto_status_justificativa`
--
ALTER TABLE `projeto_status_justificativa`
  MODIFY `projeto_status_justificativa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `projeto_tarefa`
--
ALTER TABLE `projeto_tarefa`
  MODIFY `tarefa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
