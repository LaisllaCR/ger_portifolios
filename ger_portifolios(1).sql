-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 08-Jul-2016 às 23:45
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
-- Estrutura da tabela `indicadores`
--

CREATE TABLE `indicadores` (
  `indicador_id` int(11) NOT NULL,
  `indicador_nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `indicadores`
--

INSERT INTO `indicadores` (`indicador_id`, `indicador_nome`) VALUES
(1, 'Performance/Desempenho'),
(3, 'Empenho');

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
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `indicadores_projeto`
--

INSERT INTO `indicadores_projeto` (`indicador_projeto_id`, `indicador_id`, `projeto_id`, `projeto_fase`, `valor_minimo`, `valor_maximo`, `usuario_id`) VALUES
(1, 1, 3, 'Iniciação', 10, 50, 1),
(2, 3, 3, 'Monitoramento e Controle', 2, 6, 1),
(3, 1, 3, '', 2, 6, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `membro`
--

CREATE TABLE `membro` (
  `membro_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `usuario_perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(4, 'Gerente de projeto');

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
(1, 'Projeto Teste Editado 2 ', '2016-07-08', '2016-07-20', '2016-07-31', 1, 10, ' SERA?  ', 'Em andamento', 'Medio risco'),
(3, 'Projeto Teste Novo 2', '2016-07-07', '2016-07-08', '2016-07-08', 1, 0, 'asd', 'Em andamento', 'Alto risco');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_acompanhamento`
--

CREATE TABLE `projeto_acompanhamento` (
  `projeto_acompanhamento_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `projeto_acompanhamento_data` date NOT NULL,
  `projeto_acompanhamento_justificativa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_tarefa`
--

CREATE TABLE `projeto_tarefa` (
  `projeto_tarefa_id` int(11) NOT NULL,
  `projeto_id` int(11) NOT NULL,
  `tarefa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefa`
--

CREATE TABLE `tarefa` (
  `tarefa_id` int(11) NOT NULL,
  `tarefa_nome` int(11) NOT NULL,
  `tarefa_descricao` int(11) NOT NULL,
  `tarefa_status` int(11) NOT NULL,
  `tarefa_data_inicio` int(11) NOT NULL,
  `tarefa_data_termino` int(11) NOT NULL
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
  `usuario_tipo` enum('administrador','comum','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fase`
--
ALTER TABLE `fase`
  ADD PRIMARY KEY (`fase_id`);

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
-- Indexes for table `membro`
--
ALTER TABLE `membro`
  ADD PRIMARY KEY (`membro_id`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`perfil_id`);

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
-- Indexes for table `projeto_tarefa`
--
ALTER TABLE `projeto_tarefa`
  ADD PRIMARY KEY (`projeto_tarefa_id`);

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
-- AUTO_INCREMENT for table `indicadores`
--
ALTER TABLE `indicadores`
  MODIFY `indicador_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `indicadores_projeto`
--
ALTER TABLE `indicadores_projeto`
  MODIFY `indicador_projeto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `membro`
--
ALTER TABLE `membro`
  MODIFY `membro_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `perfil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `projeto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `projeto_acompanhamento`
--
ALTER TABLE `projeto_acompanhamento`
  MODIFY `projeto_acompanhamento_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projeto_tarefa`
--
ALTER TABLE `projeto_tarefa`
  MODIFY `projeto_tarefa_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
