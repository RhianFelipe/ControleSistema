<?php
include "../db/conexao.php";
//Função que faz consultar para verificar se existe algum atributo no Banco de Dados
function verificarExistencia($mysqli, $valor, $tabela, $variavel)
{
    $verificar = "SELECT $valor FROM $tabela WHERE $valor='$variavel'";
    $resultVerificacao = $mysqli->query($verificar) or die($mysqli->error);
    return $resultVerificacao;
}
// Consulta os sistemas e as permissões disponíveis no banco de dados
$buscaSistemas = "SELECT sistemas FROM permissoes";
$queryBuscaSistemas =  $mysqli->query($buscaSistemas) or die($mysqli->error);


// Consulta os grupos de cada funcionario(procuradores, estags, servidores...)
$buscaGrupo = "SELECT grupo FROM usuarios";
$queryBuscaGrupo = $mysqli->query($buscaGrupo) or die($mysqli->error);

$setores = array(
    "Assessoria Técnica do Gabinete",
    "Coordenadoria de Assuntos Fiscais",
    "Procuradoria do Contencioso Fiscal",
    "Procuradoria da Dívida Ativa",
    "Procuradoria de Sucessões",
    "Coordenadoria do Consultivo",
    "Procuradoria Consultiva junto à Governadoria",
    "Procuradoria Consultiva de Obras e Serviços de Engenharia",
    "Procuradoria Consultiva de Matéria Residual",
    "Procuradoria Consultiva de Recursos Humanos",
    "Procuradoria Consultiva de Aquisições e Serviços",
    "Coordenadoria de Estudos Jurídicos",
    "Coordenadoria de Gestão Estratégica e Tecnologia da Informação",
    "Núcleo de Informática e Informação",
    "Coordenadoria Judicial",
    "Procuradoria de Ações Coletivas",
    "Procuradoria Ambiental",
    "Procuradoria Previdenciária Funcional",
    "Procuradoria Administrativa",
    "Procuradoria Funcional",
    "Procuradoria do Patrimônio",
    "Procuradoria de Saúde",
    "Procuradoria Trabalhista",
    "Coordenadoria do Passivo",
    "Procuradoria de Honorários da Gratuidade da Justiça",
    "Procuradoria de Execuções, Precatórios e Cálculos",
    "Coordenadoria de Recursos",
    "Diretoria Geral",
    "Núcleo Administrativo Setorial",
    "Núcleo Orçamentário e Financeiro Setorial",
    "Gabinete da Procuradora-Geral do Estado",
    "Núcleo de Recursos Humanos Setorial",
    "Núcleo de Integridade e Compliance Setorial",
    "Núcleo Jurídicos Avançados",
    "Núcleo de Planejamento Setorial",
    "Procuradoria Regional de Apucarana",
    "Procuradoria Regional de Francisco Beltrão",
    "Procuradoria Regional de Brasília",
    "Procuradoria Regional de Cascavel",
    "Procuradoria Regional de Campo Mourão",
    "Procuradoria Regional de Cornélio Procópio",
    "Procuradoria Regional de Foz do Iguaçu",
    "Procuradoria Regional de Guarapuava",
    "Procuradoria Regional de Jacarezinho",
    "Procuradoria Regional de Londrina",
    "Procuradoria Regional de Maringá",
    "Procuradoria Regional de Pato Branco",
    "Procuradoria Regional de Ponta Grossa",
    "Procuradoria Regional de Paranaguá",
    "Procuradoria Regional de Paranavaí",
    "Procuradoria Regional de Umuarama",
    "Procuradoria Regional de União da Vitória",
    "Secretaria",
    "Externo"
  );
