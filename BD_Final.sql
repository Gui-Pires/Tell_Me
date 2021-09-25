-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 15-Jul-2020 às 20:06
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_blacktec`
--
DROP DATABASE IF EXISTS `bd_blacktec`;
CREATE DATABASE IF NOT EXISTS `bd_blacktec` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bd_blacktec`;

DELIMITER $$
--
-- Procedimentos
--
DROP PROCEDURE IF EXISTS `AltChamado_atu`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AltChamado_atu` (IN `id` INT(11), IN `pro` VARCHAR(50) CHARSET utf8)  NO SQL
UPDATE chamados SET id_cha=id_cha, id_user=id_user, titulo=titulo, descricao=descricao, DtChamado=DtChamado, progresso=pro, prioridade=prioridade, prazo=prazo WHERE id_cha=id$$

DROP PROCEDURE IF EXISTS `AltChamado_res`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AltChamado_res` (IN `id` INT(11), IN `pri` VARCHAR(50) CHARSET utf8, IN `pra` DATE)  NO SQL
UPDATE chamados SET id_cha=id_cha, id_user=id_user, titulo=titulo, descricao=descricao, DtChamado=DtChamado, progresso="Em Análise", prioridade=pri, prazo=pra WHERE id_cha=id$$

DROP PROCEDURE IF EXISTS `AltChamado_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AltChamado_user` (IN `id` INT(11))  NO SQL
UPDATE user SET Qtde_chamados=Qtde_chamados+1 WHERE id_user=id$$

DROP PROCEDURE IF EXISTS `Cad_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Cad_user` (IN `nome` VARCHAR(120) CHARSET utf8, IN `email` VARCHAR(120) CHARSET utf8, IN `senha` VARCHAR(120) CHARSET utf8, IN `DtCad` DATE, IN `departamento` VARCHAR(120) CHARSET utf8, IN `permissao` INT(5))  NO SQL
INSERT INTO user VALUES
(null, nome, email, senha, DtCad, departamento, permissao, 0)$$

DROP PROCEDURE IF EXISTS `Inc_chamado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Inc_chamado` (IN `id_usuario` INT(11), IN `titulo` VARCHAR(50) CHARSET utf8, IN `descricao` VARCHAR(250) CHARSET utf8, IN `DtChamado` DATE)  NO SQL
INSERT INTO chamados
(`id_cha`, `id_user`, `titulo`, `descricao`, `DtChamado`, `progresso`, `prioridade`)
VALUES
(null, id_usuario, titulo, descricao, DtChamado, "Aberto", "N/A")$$

DROP PROCEDURE IF EXISTS `Sel_All`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sel_All` ()  NO SQL
SELECT * FROM chamados, user WHERE user.id_user=chamados.id_user ORDER BY id_cha$$

DROP PROCEDURE IF EXISTS `Sel_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sel_user` ()  NO SQL
SELECT * FROM user ORDER BY id_user$$

DROP PROCEDURE IF EXISTS `Varredura`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Varredura` (IN `data` DATE)  NO SQL
DELETE FROM `chamados` WHERE chamados.DtChamado<=data AND chamados.progresso="Concluido"$$

DROP PROCEDURE IF EXISTS `vChamado_aberto`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `vChamado_aberto` ()  NO SQL
BEGIN
SELECT * FROM chamados, user WHERE user.id_user=chamados.id_user AND chamados.progresso="Aberto" ORDER BY chamados.id_cha;
END$$

DROP PROCEDURE IF EXISTS `vChamado_analise`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `vChamado_analise` ()  NO SQL
SELECT * FROM chamados, user WHERE user.id_user=chamados.id_user AND chamados.progresso="Em Análise" ORDER BY chamados.id_cha$$

DROP PROCEDURE IF EXISTS `vChamado_concluido`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `vChamado_concluido` ()  NO SQL
SELECT * FROM chamados, user WHERE user.id_user=chamados.id_user AND chamados.progresso="Concluido" ORDER BY chamados.id_cha$$

DROP PROCEDURE IF EXISTS `vChamado_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `vChamado_user` (IN `id` INT(11))  NO SQL
SELECT * FROM chamados WHERE id_user=id ORDER BY id_cha$$

DROP PROCEDURE IF EXISTS `vFiltros`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `vFiltros` (IN `dep` VARCHAR(50) CHARSET utf8, IN `pro` VARCHAR(50) CHARSET utf8, IN `pri` VARCHAR(50) CHARSET utf8)  NO SQL
SELECT * FROM chamados, user WHERE user.id_user=chamados.id_user AND user.departamento LIKE dep AND chamados.progresso LIKE pro AND chamados.prioridade LIKE pri ORDER BY chamados.id_cha$$

DROP PROCEDURE IF EXISTS `vFiltro_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `vFiltro_id` (IN `id` INT(11))  NO SQL
SELECT * FROM chamados, user WHERE chamados.id_cha=id AND user.id_user=chamados.id_user ORDER BY id_cha$$

DROP PROCEDURE IF EXISTS `vPerfil_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `vPerfil_user` (IN `perfil` INT(11))  NO SQL
SELECT * FROM user WHERE id_user=perfil ORDER BY id_user$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chamados`
--

DROP TABLE IF EXISTS `chamados`;
CREATE TABLE IF NOT EXISTS `chamados` (
  `id_cha` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `DtChamado` date NOT NULL,
  `progresso` varchar(50) NOT NULL,
  `prioridade` varchar(50) DEFAULT NULL,
  `prazo` date DEFAULT NULL,
  PRIMARY KEY (`id_cha`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `chamados`
--

INSERT INTO `chamados` (`id_cha`, `id_user`, `titulo`, `descricao`, `DtChamado`, `progresso`, `prioridade`, `prazo`) VALUES
(1, 5, 'Meu Primeiro Chamado', 'Este é um teste de como a procedure se comporta, e se o sistema envia este chamado', '2020-07-08', 'Concluido', 'Média', '2020-07-11'),
(2, 5, 'Segundo Chamado', 'Teste 2', '2020-07-08', 'Em Análise', 'Média', '2020-07-13'),
(6, 5, 'mais um', 'ttt', '2020-07-08', 'Em Análise', 'Alta', '2020-07-21'),
(5, 5, 'Outro', 'Teste', '2020-07-08', 'Em Análise', 'Média', '2020-07-12'),
(7, 5, 'Teste', 'teste teste teste teste teste teste', '2020-07-09', 'Em Análise', 'Baixa', '2020-07-14'),
(11, 7, 'Ventilador', 'Ajuda aqui, o ventilador caiu na cabeça da Bernadete!', '2020-07-10', 'Aberto', 'N/A', NULL),
(12, 8, 'Relatório livro fiscal', 'Fazer com que o CFOP seja separado por Estado', '2020-07-12', 'Aberto', 'N/A', NULL),
(13, 5, 'Chamado', 'Teste', '2020-07-13', 'Aberto', 'N/A', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `conf_rel`
--

DROP TABLE IF EXISTS `conf_rel`;
CREATE TABLE IF NOT EXISTS `conf_rel` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `dia` int(3) NOT NULL,
  `ativo` int(3) NOT NULL,
  `ult_varre` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `conf_rel`
--

INSERT INTO `conf_rel` (`id`, `dia`, `ativo`, `ult_varre`) VALUES
(1, 30, 0, '2020-07-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha` varchar(120) NOT NULL,
  `DtCad` date NOT NULL,
  `departamento` varchar(120) NOT NULL,
  `permissao` int(5) NOT NULL,
  `Qtde_chamados` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id_user`, `nome`, `email`, `senha`, `DtCad`, `departamento`, `permissao`, `Qtde_chamados`) VALUES
(3, 'Guilherme', 'guiteste@gmail.com', '50b2a32251f2de41037bcc5d9bb5e61f', '2020-07-07', 'TI', 2, 0),
(5, 'Guilherme', 'teste2@gmail.com', '928577f6e5ff7f7e72d01abbd22c1280', '2020-07-08', 'TI', 1, 6),
(6, 'Teste', 'procedure@gmail.com', '928577f6e5ff7f7e72d01abbd22c1280', '2020-07-08', 'RH', 1, 0),
(7, 'gui', 'gui@gmail.com', '50b2a32251f2de41037bcc5d9bb5e61f', '2020-07-10', 'Marketing', 1, 1),
(8, 'Edmar Francisco Pires', 'epires@gmail.com', 'd6ee4e61af68a10f9bb9ee130313881f', '2020-07-12', 'Contabilidade', 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
