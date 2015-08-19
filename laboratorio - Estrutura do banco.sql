-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- MÃ¡quina: localhost
-- Data de CriaÃ§Ã£o: 17-Ago-2015 Ã s 03:28
-- VersÃ£o do servidor: 5.6.12-log
-- versÃ£o do PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `laboratorio`
--
CREATE DATABASE IF NOT EXISTS `laboratorio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `laboratorio`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `caixa`
--

CREATE TABLE IF NOT EXISTS `caixa` (
  `id_caixa` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_fk` int(11) NOT NULL,
  `nome_usuario` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `valor_recebido` decimal(9,2) NOT NULL DEFAULT '0.00',
  `data_recebimento` datetime DEFAULT NULL,
  `funcionario` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_caixa`),
  KEY `usuario_fk` (`usuario_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_categoria` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome_categoria`) VALUES
(1, 'Acadêmico da Unimontes'),
(2, 'Policial Militar'),
(3, 'SAMU'),
(4, 'Tribunal de Justiça'),
(5, 'Servidor da Unimontes'),
(6, 'Público em Geral'),
(7, 'Bombeiro'),
(8, 'Agente de Seg. Penitenciaria'),
(9, 'Policial Civil');

-- --------------------------------------------------------

--
-- Estrutura da tabela `data_mensalidade`
--

CREATE TABLE IF NOT EXISTS `data_mensalidade` (
  `id_data_mensalidade` int(11) NOT NULL AUTO_INCREMENT,
  `data_ultima_atualizacao` date NOT NULL,
  PRIMARY KEY (`id_data_mensalidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `data_mensalidade`
--

INSERT INTO `data_mensalidade` (`id_data_mensalidade`, `data_ultima_atualizacao`) VALUES
(1, '2015-09-01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `frequencia`
--

CREATE TABLE IF NOT EXISTS `frequencia` (
  `id_frequencia` int(11) NOT NULL AUTO_INCREMENT,
  `data_presenca` datetime DEFAULT NULL,
  `usuario_fk` int(11) NOT NULL,
  `funcionario` varchar(255) NOT NULL,
  PRIMARY KEY (`id_frequencia`),
  KEY `usuario_fk` (`usuario_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



--
-- Estrutura da tabela `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `login_user` varchar(50) NOT NULL,
  `senha_user` varchar(40) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `privilegio` int(11) NOT NULL DEFAULT '0',
  `ativo` varchar(50) NOT NULL DEFAULT 'nÃ£o',
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id_login`, `login_user`, `senha_user`, `nome`, `privilegio`, `ativo`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrador', 1, 'sim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensalidade`
--

CREATE TABLE IF NOT EXISTS `mensalidade` (
  `id_mensalidade` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_fk` int(11) NOT NULL,
  `nome_usuario_fk` varchar(255) NOT NULL,
  `data_vencimento` date NOT NULL,
  `categoria_fk` int(11) NOT NULL,
  `horario_usuario` int(11) NOT NULL,
  `valor_a_receber` decimal(9,2) NOT NULL DEFAULT '0.00',
  `desconto_a_receber` decimal(9,2) NOT NULL DEFAULT '0.00',
  `valor_recebido` decimal(9,2) DEFAULT '0.00',
  `data_pagamento` datetime DEFAULT NULL,
  `funcionario` varchar(255) DEFAULT NULL,
  `status_pagamento` varchar(50) NOT NULL DEFAULT 'em aberto',
  PRIMARY KEY (`id_mensalidade`),
  KEY `usuario_fk` (`usuario_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


--
-- Estrutura da tabela `preco_avaliacao`
--

CREATE TABLE IF NOT EXISTS `preco_avaliacao` (
  `id_preco_avaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(9,2) NOT NULL DEFAULT '0.00',
  `categoria_fk` int(11) NOT NULL,
  `funcionario` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_preco_avaliacao`),
  KEY `categoria_fk` (`categoria_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


--
-- Estrutura da tabela `preco_diaria`
--

CREATE TABLE IF NOT EXISTS `preco_diaria` (
  `id_preco_diaria` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(9,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_preco_diaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `preco_mensalidade`
--

CREATE TABLE IF NOT EXISTS `preco_mensalidade` (
  `id_preco_mensalidade` int(11) NOT NULL AUTO_INCREMENT,
  `horario` int(11) NOT NULL,
  `valor` decimal(9,2) NOT NULL DEFAULT '0.00',
  `desconto` decimal(9,2) NOT NULL DEFAULT '0.00',
  `categoria_fk` int(11) NOT NULL,
  `funcionario` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_preco_mensalidade`),
  KEY `categoria_fk` (`categoria_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `preco_reavaliacao`
--

CREATE TABLE IF NOT EXISTS `preco_reavaliacao` (
  `id_preco_reavaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(9,2) NOT NULL DEFAULT '0.00',
  `categoria_fk` int(11) NOT NULL,
  `funcionario` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_preco_reavaliacao`),
  KEY `categoria_fk` (`categoria_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `responsavel`
--

CREATE TABLE IF NOT EXISTS `responsavel` (
  `id_responsavel` int(11) NOT NULL AUTO_INCREMENT,
  `nome_responsavel` varchar(255) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `rg` varchar(50) DEFAULT NULL,
  `data_nasc` datetime DEFAULT NULL,
  `usuario_fk` int(11) NOT NULL,
  `parentesco` varchar(50) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `funcionario` varchar(255) NOT NULL,
  PRIMARY KEY (`id_responsavel`),
  KEY `usuario_fk` (`usuario_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `rg` varchar(50) DEFAULT NULL,
  `data_nasc` datetime DEFAULT NULL,
  `sexo` varchar(50) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `complemento` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `outro_telefone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `dia_vencimento` varchar(20) NOT NULL,
  `horario` varchar(255) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `funcionario` varchar(255) NOT NULL,
  `categoria_fk` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `categoria_fk` (`categoria_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `caixa`
--
ALTER TABLE `caixa`
  ADD CONSTRAINT `caixa_ibfk_1` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `frequencia`
--
ALTER TABLE `frequencia`
  ADD CONSTRAINT `frequencia_ibfk_1` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `mensalidade`
--
ALTER TABLE `mensalidade`
  ADD CONSTRAINT `mensalidade_ibfk_1` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `preco_avaliacao`
--
ALTER TABLE `preco_avaliacao`
  ADD CONSTRAINT `preco_avaliacao_ibfk_1` FOREIGN KEY (`categoria_fk`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `preco_mensalidade`
--
ALTER TABLE `preco_mensalidade`
  ADD CONSTRAINT `preco_mensalidade_ibfk_1` FOREIGN KEY (`categoria_fk`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `preco_reavaliacao`
--
ALTER TABLE `preco_reavaliacao`
  ADD CONSTRAINT `preco_reavaliacao_ibfk_1` FOREIGN KEY (`categoria_fk`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `responsavel`
--
ALTER TABLE `responsavel`
  ADD CONSTRAINT `responsavel_ibfk_1` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`categoria_fk`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


