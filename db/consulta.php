<?php
include "../db/conexao.php";
//Função que faz consultar para verificar se existe algum atributo no Banco de Dados
function verificarExistencia($mysqli, $valor, $tabela, $variavel)
{
    $verificar = "SELECT $valor FROM $tabela WHERE $valor='$variavel'";
    $resultVerificacao = $mysqli->query($verificar) or die($mysqli->error);
    return $resultVerificacao;
}
//BUSCAS TABELA USUÁRIOS



//BUSCA TABELA PERMISSOES
$buscaSistemas = "SELECT sistemas FROM permissoes";
$queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);


//BUSCA TABELA LOGS



//BUSCA TABELA SID

// Consulta os grupos de cada funcionario(procuradores, estags, servidores...)
$buscaGrupo = "SELECT grupo FROM usuarios";
$queryBuscaGrupo = $mysqli->query($buscaGrupo) or die($mysqli->error);

$setores = array(
    "Assessoria Técnica do Gabinete",
    "Coordenadoria de Assuntos Fiscais",
    "Coordenadoria de Estudos Jurídicos",
    "Coordenadoria de Gestão Estratégica e Tecnologia da Informação",
    "Coordenadoria de Recursos",
    "Coordenadoria do Consultivo",
    "Coordenadoria do Passivo",
    "Coordenadoria Judicial",
    "Diretoria Geral",
    "Gabinete da Procuradora-Geral do Estado",
    "Núcleo Administrativo Setorial",
    "Núcleo de Comunicação Social",
    "Núcleo de Informática e Informação",
    "Núcleo de Integridade e Compliance Setorial",
    "Núcleo de Planejamento Setorial",
    "Núcleo de Recursos Humanos Setorial",
    "Núcleo Fazendário Setorial",
    "Procuradoria  Regional de Pato Branco",
    "Procuradoria Administrativa",
    "Procuradoria Ambiental",
    "Procuradoria Consultiva de Aquisições e Serviços",
    "Procuradoria Consultiva de Obras e Serviços de Engenharia",
    "Procuradoria Consultiva de Recursos Humanos",
    "Procuradoria Consultiva junto à Governadoria",
    "Procuradoria da Dívida Ativa",
    "Procuradoria de Ações Coletivas",
    "Procuradoria de Execuções,Precatórios e Cálculos",
    "Procuradoria de Honorários da Gratuidade da Justiça",
    "Procuradoria de Saúde",
    "Procuradoria de Sucessões",
    "Procuradoria do Contecioso Fiscal",
    "Procuradoria do Patrimônio",
    "Procuradoria Funcional",
    "Procuradoria Previdenciária Funcional",
    "Procuradoria Regional de Apucarana",
    "Procuradoria Brasíla",
    "Procuradoria Regional de Campo Mourão",
    "Procuradoria Regional de Cascavel",
    "Procuradoria Regional de Cornélio Procópio",
    "Procuradoria Regional de Foz do Iguaçu",
    "Procuradoria Regional de Francisco Beltrão",
    "Procuradoria Regional de Guarapuava",
    "Procuradoria Regional de Jacarezinho",
    "Procuradoria Regional de Londrina",
    "Procuradoria Regional de Maringá",
    "Procuradoria Regional de Paranaguá",
    "Procuradoria Regional de Paranavaí",
    "Procuradoria Regional de Ponta Grossa",
    "Procuradoria Regional de Umuarama",
    "Procuradoria Regional de União da Vitória",
    "Procuradoria Trabalhista",
    "Secretaria",
    "Externo"
);