-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/10/2024 às 23:54
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbsam`
--
CREATE DATABASE IF NOT EXISTS `dbsam` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dbsam`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbladministracao`
--

CREATE TABLE `tbladministracao` (
  `id` int(11) NOT NULL,
  `nome_paciente` varchar(100) NOT NULL,
  `nome_medicamento` varchar(100) NOT NULL,
  `data_administracao` date NOT NULL,
  `hora_administracao` time NOT NULL,
  `dose` varchar(50) NOT NULL,
  `data_hora_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblenfermeiro`
--

CREATE TABLE `tblenfermeiro` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `coren` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblmedico`
--

CREATE TABLE `tblmedico` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `especialidade` varchar(100) NOT NULL,
  `crm` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblpaciente`
--

CREATE TABLE `tblpaciente` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `leito` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblreceitas`
--

CREATE TABLE `tblreceitas` (
  `id` int(11) NOT NULL,
  `nome_paciente` varchar(100) NOT NULL,
  `nome_medicamento` varchar(100) NOT NULL,
  `data_administracao` date NOT NULL,
  `hora_administracao` time NOT NULL,
  `dose` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbladministracao`
--
ALTER TABLE `tbladministracao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblenfermeiro`
--
ALTER TABLE `tblenfermeiro`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblmedico`
--
ALTER TABLE `tblmedico`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblpaciente`
--
ALTER TABLE `tblpaciente`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tblreceitas`
--
ALTER TABLE `tblreceitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbladministracao`
--
ALTER TABLE `tbladministracao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tblenfermeiro`
--
ALTER TABLE `tblenfermeiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tblmedico`
--
ALTER TABLE `tblmedico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tblpaciente`
--
ALTER TABLE `tblpaciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tblreceitas`
--
ALTER TABLE `tblreceitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
