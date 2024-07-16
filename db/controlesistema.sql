-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 16-Jul-2024 às 15:34
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `controlesistema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `senha` varchar(255) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `nomeSistema` varchar(255) DEFAULT NULL,
  `permissao` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`id`, `senha`, `usuario`, `nomeSistema`, `permissao`) VALUES
(57, '', '', '', 0),
(41, '', '', NULL, 0),
(42, '', '', NULL, 0),
(79, 'surrw8', 'estag.rhian', NULL, 1),
(173, '456', 'estag.rhian5', NULL, 0),
(201, '', '', 'Wi-Fi', 0),
(200, '', '', 'hahaha', 0),
(188, '', '', 'Datafacil', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `desativados`
--

DROP TABLE IF EXISTS `desativados`;
CREATE TABLE IF NOT EXISTS `desativados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sistema` varchar(30) NOT NULL,
  `permissao` varchar(30) NOT NULL,
  `data_exclusao` datetime DEFAULT NULL,
  `nome_termo` varchar(255) DEFAULT NULL,
  `assinado` tinyint(1) DEFAULT '0',
  `grupo` varchar(30) DEFAULT NULL,
  `setor` varchar(200) DEFAULT NULL,
  `nomeSid` varchar(200) DEFAULT NULL,
  `valorSid` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=7353 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `desativados`
--

INSERT INTO `desativados` (`id`, `id_usuario`, `nome`, `email`, `sistema`, `permissao`, `data_exclusao`, `nome_termo`, `assinado`, `grupo`, `setor`, `nomeSid`, `valorSid`) VALUES
(7323, 5478, 'Rhian Felipe', 'estag.rhian@pge.pr.gov.br', '', '', '2024-04-01 15:53:52', NULL, 0, 'Procurador', 'Procuradoria Consultiva junto à Governadoria', NULL, NULL),
(7324, 5478, '', '', 'hahaha', '0', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(7325, 5478, '', '', 'Datafacil', '0', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(7326, 5478, '', '', '', '', NULL, 'Termo de Uso e Responsabilidade', 1, NULL, NULL, NULL, NULL),
(7327, 5478, '', '', '', '', NULL, 'Termo de Compromisso e Confidencialidade', 1, NULL, NULL, NULL, NULL),
(7328, 5478, '', '', '', '', NULL, 'Termo de Wi-Fi', 0, NULL, NULL, NULL, NULL),
(7329, 5478, '', '', '', '', NULL, 'Termo de VPN', 0, NULL, NULL, NULL, NULL),
(7330, 5478, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'VPN', ''),
(7331, 5478, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'Wi-Fi', ''),
(7332, 5478, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'TermoTcc', '67.876.867-8'),
(7333, 5478, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'TermoTur', '67.876.867-8'),
(7334, 5480, 'Rhian Felipe1', 'estag234.rhian@pge.pr.gov.br', '', '', '2024-04-12 15:00:26', NULL, 0, 'Servidor', 'CCP - Câmara de Conciliação de Precatórios', NULL, NULL),
(7335, 5480, '', '', '', '', NULL, 'Termo de Uso e Responsabilidade', 1, NULL, NULL, NULL, NULL),
(7336, 5480, '', '', '', '', NULL, 'Termo de Compromisso e Confidencialidade', 1, NULL, NULL, NULL, NULL),
(7337, 5480, '', '', '', '', NULL, 'Termo de Wi-Fi', 0, NULL, NULL, NULL, NULL),
(7338, 5480, '', '', '', '', NULL, 'Termo de VPN', 0, NULL, NULL, NULL, NULL),
(7339, 5480, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'VPN', ''),
(7340, 5480, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'Wi-Fi', ''),
(7341, 5480, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'TermoTcc', '23.434.324-2'),
(7342, 5480, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'TermoTur', '23.434.324-2'),
(7343, 5479, '', '', 'hahaha', '0', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(7344, 5479, '', '', 'Datafacil', '0', NULL, NULL, 0, NULL, NULL, NULL, NULL),
(7345, 5479, '', '', '', '', NULL, 'Termo de Uso e Responsabilidade', 1, NULL, NULL, NULL, NULL),
(7346, 5479, '', '', '', '', NULL, 'Termo de Compromisso e Confidencialidade', 1, NULL, NULL, NULL, NULL),
(7347, 5479, '', '', '', '', NULL, 'Termo de Wi-Fi', 0, NULL, NULL, NULL, NULL),
(7348, 5479, '', '', '', '', NULL, 'Termo de VPN', 0, NULL, NULL, NULL, NULL),
(7349, 5479, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'VPN', ''),
(7350, 5479, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'Wi-Fi', ''),
(7351, 5479, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'TermoTcc', '34.534.543-5'),
(7352, 5479, '', '', '', '', NULL, NULL, 0, NULL, NULL, 'TermoTur', '34.534.543-5');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logsusuarios`
--

DROP TABLE IF EXISTS `logsusuarios`;
CREATE TABLE IF NOT EXISTS `logsusuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `tipo_operacao` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `data_operacao` datetime NOT NULL,
  `nome_usuario` varchar(255) DEFAULT NULL,
  `email_usuario` varchar(255) DEFAULT NULL,
  `grupo_usuario` varchar(255) DEFAULT NULL,
  `nome_admin` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=1464 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

DROP TABLE IF EXISTS `permissoes`;
CREATE TABLE IF NOT EXISTS `permissoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int UNSIGNED NOT NULL,
  `sistemas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `permissao` tinyint(1) NOT NULL DEFAULT '0',
  `data_altere` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=8268183 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores`
--

DROP TABLE IF EXISTS `setores`;
CREATE TABLE IF NOT EXISTS `setores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomeSetor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `setores`
--

INSERT INTO `setores` (`id`, `nomeSetor`) VALUES
(5, 'aa'),
(64, 'CGTI - Coordenadoria de Gestão Estratégica e Tecnologia da Informação'),
(11, 'GP - Gabinete da Procuradora-Geral do Estado'),
(12, 'NAS - Núcleo Administrativo Setorial'),
(13, 'NCS - Núcleo de Comunicação Social'),
(14, 'NII - Núcleo de Informática e Informações'),
(15, 'NICS - Núcleo de Integridade e Compliance Setorial'),
(16, 'NPS - Núcleo de Planejamento Setorial'),
(17, 'NRHS - Núcleo de Recursos Humanos Setorial'),
(18, 'NFS - Núcleo Fazendário Setorial'),
(20, 'PAM - Procuradoria Ambiental'),
(21, 'PRC - Procuradoria Consultiva de Aquisições e Serviços'),
(22, 'PCP - Procuradoria Consultiva de Concessões, Convênios e Parcerias'),
(23, 'PCO - Procuradoria Consultiva de Obras e Serviços de Engenharia'),
(24, 'PCRH - Procuradoria Consultiva de Recursos Humanos'),
(25, 'PCG - Procuradoria Consultiva junto à Governadoria'),
(26, 'PDA - Procuradoria da Dívida Ativa'),
(27, 'PAC - Procuradoria de Ações Coletivas'),
(28, 'PRE - Procuradoria de Execuções, Precatórios e Cálculos'),
(29, 'PHG - Procuradoria de Honorários da Gratuidade da Justiça'),
(30, 'PRS - Procuradoria de Saúde'),
(31, 'PSU - Procuradoria de Sucessões'),
(32, 'Procuradoria do Contecioso Fiscal'),
(33, 'PRP - Procuradoria do Patrimônio'),
(34, 'PRF - Procuradoria Funcional'),
(35, 'PPF - Procuradoria Previdenciária Funcional'),
(36, 'Procuradoria Brasíla'),
(37, 'Procuradoria Regional de Apucarana'),
(38, 'CMOU - Procuradoria Regional de Campo Mourão'),
(39, 'CSC - Procuradoria Regional de Cascavel'),
(40, 'CPC - Procuradoria Regional de Cornélio Procópio'),
(41, 'FOZ - Procuradoria Regional de Foz do Iguaçu'),
(42, 'FBEL - Procuradoria Regional de Francisco Beltrão'),
(43, 'GRP - Procuradoria Regional de Guarapuava'),
(44, 'JAC - Procuradoria Regional de Jacarezinho'),
(45, 'LON - Procuradoria Regional de Londrina'),
(46, 'MGA - Procuradoria Regional de Maringá'),
(47, 'Procuradoria Regional de Paranaguá'),
(48, 'PNV - Procuradoria Regional de Paranavaí'),
(49, 'PBC - Procuradoria Regional de Pato Branco'),
(50, 'PGO - Procuradoria Regional de Ponta Grossa'),
(51, 'UMU - Procuradoria Regional de Umuarama');

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores_map`
--

DROP TABLE IF EXISTS `setores_map`;
CREATE TABLE IF NOT EXISTS `setores_map` (
  `setor_antigo` varchar(255) NOT NULL,
  `setor_novo` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `setores_map`
--

INSERT INTO `setores_map` (`setor_antigo`, `setor_novo`) VALUES
('Assessoria Técnica do Juridica', 'ATJ - Assessoria Técnica do Juridica'),
('Câmara de Conciliação de Precatórios', 'CCP - Câmara de Conciliação de Precatórios'),
('Coordenadoria de Assuntos Fiscais', 'CAF - Coordenadoria de Assuntos Fiscais'),
('Coordenadoria de Estudos Jurídicos', 'CEJ - Coordenadoria de Estudos Jurídicos'),
('Coordenadoria de Gestão Estratégica e Tecnologia da Informação', 'CGTI - Coordenadoria de Gestão Estratégica e Tecnologia da Informação'),
('Coordenadoria de Recursos e Ações Rescisórias', 'CRR - Coordenadoria de Recursos e Ações Rescisórias'),
('Coordenadoria do Consultivo', 'CCON - Coordenadoria do Consultivo'),
('Coordenadoria do Passivo', 'CPAS - Coordenadoria do Passivo'),
('Coordenadoria Judicial', 'CJUD - Coordenadoria Judicial'),
('Diretoria Geral', 'DG - Diretoria Geral'),
('Gabinete da Procuradora-Geral do Estado', 'GP - Gabinete da Procuradora-Geral do Estado'),
('Núcleo Administrativo Setorial', 'NAS - Núcleo Administrativo Setorial'),
('Núcleo de Comunicação Social', 'NCS - Núcleo de Comunicação Social'),
('Núcleo de Informática e Informações', 'NII - Núcleo de Informática e Informações'),
('Núcleo de Integridade e Compliance Setorial', 'NICS - Núcleo de Integridade e Compliance Setorial'),
('Núcleo de Planejamento Setorial', 'NPS - Núcleo de Planejamento Setorial'),
('Núcleo de Recursos Humanos Setorial', 'NRHS - Núcleo de Recursos Humanos Setorial'),
('Núcleo Fazendário Setorial', 'NFS - Núcleo Fazendário Setorial'),
('Procuradoria Ambiental', 'PAM - Procuradoria Ambiental'),
('Procuradoria Consultiva de Aquisições e Serviços', 'PRC - Procuradoria Consultiva de Aquisições e Serviços'),
('Procuradoria Consultiva de Concessões, Convênios e Parcerias', 'PCP - Procuradoria Consultiva de Concessões, Convênios e Parcerias'),
('Procuradoria Consultiva de Obras e Serviços de Engenharia', 'PCO - Procuradoria Consultiva de Obras e Serviços de Engenharia'),
('Procuradoria Consultiva de Recursos Humanos', 'PCRH - Procuradoria Consultiva de Recursos Humanos'),
('Procuradoria Consultiva junto à Governadoria', 'PCG - Procuradoria Consultiva junto à Governadoria'),
('Procuradoria da Dívida Ativa', 'PDA - Procuradoria da Dívida Ativa'),
('Procuradoria de Ações Coletivas', 'PAC - Procuradoria de Ações Coletivas'),
('Procuradoria de Execuções, Precatórios e Cálculos', 'PRE - Procuradoria de Execuções, Precatórios e Cálculos'),
('Procuradoria de Honorários da Gratuidade da Justiça', 'PHG - Procuradoria de Honorários da Gratuidade da Justiça'),
('Procuradoria de Saúde', 'PRS - Procuradoria de Saúde'),
('Procuradoria de Sucessões', 'PSU - Procuradoria de Sucessões'),
('Procuradoria do Contencioso Fiscal', 'PCF - Procuradoria do Contencioso Fiscal'),
('Procuradoria do Patrimônio', 'PRP - Procuradoria do Patrimônio'),
('Procuradoria Funcional', 'PRF - Procuradoria Funcional'),
('Procuradoria Previdenciária Funcional', 'PPF - Procuradoria Previdenciária Funcional'),
('Procuradoria Brasília', 'BSB - Procuradoria Brasília'),
('Procuradoria Regional de Apucarana', 'APU - Procuradoria Regional de Apucarana'),
('Procuradoria Regional de Campo Mourão', 'CMOU - Procuradoria Regional de Campo Mourão'),
('Procuradoria Regional de Cascavel', 'CSC - Procuradoria Regional de Cascavel'),
('Procuradoria Regional de Cornélio Procópio', 'CPC - Procuradoria Regional de Cornélio Procópio'),
('Procuradoria Regional de Foz do Iguaçu', 'FOZ - Procuradoria Regional de Foz do Iguaçu'),
('Procuradoria Regional de Francisco Beltrão', 'FBEL - Procuradoria Regional de Francisco Beltrão'),
('Procuradoria Regional de Guarapuava', 'GRP - Procuradoria Regional de Guarapuava'),
('Procuradoria Regional de Jacarezinho', 'JAC - Procuradoria Regional de Jacarezinho'),
('Procuradoria Regional de Londrina', 'LON - Procuradoria Regional de Londrina'),
('Procuradoria Regional de Maringá', 'MGA - Procuradoria Regional de Maringá'),
('Procuradoria Regional de Paranavaí', 'PNV - Procuradoria Regional de Paranavaí'),
('Procuradoria Regional de Pato Branco', 'PBC - Procuradoria Regional de Pato Branco'),
('Procuradoria Regional de Ponta Grossa', 'PGO - Procuradoria Regional de Ponta Grossa'),
('Procuradoria Regional de União da Vitória', 'UVA - Procuradoria Regional de União da Vitória'),
('Procuradoria Regional de Umuarama', 'UMU - Procuradoria Regional de Umuarama'),
('Procuradoria Trabalhista', 'PRT - Procuradoria Trabalhista'),
('Secretaria', 'SEC - Secretaria'),
('Externo', 'EXT - Externo'),
('Corregedoria-Geral', 'CG - Corregedoria-Geral'),
('Procuradoria Consultiva', 'PRC - Procuradoria Consultiva'),
('Consultivo Autarquias', 'ADV - Consultivo Autarquias');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sid`
--

DROP TABLE IF EXISTS `sid`;
CREATE TABLE IF NOT EXISTS `sid` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `nomeSid` varchar(255) DEFAULT NULL,
  `valorSid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=438 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `termos_assinados`
--

DROP TABLE IF EXISTS `termos_assinados`;
CREATE TABLE IF NOT EXISTS `termos_assinados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nome_termo` varchar(255) DEFAULT NULL,
  `assinado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_UsuarioTermo` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `grupo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `data_create` datetime DEFAULT NULL,
  `setor` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5503 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `termos_assinados`
--
ALTER TABLE `termos_assinados`
  ADD CONSTRAINT `FK_UsuarioTermo` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
