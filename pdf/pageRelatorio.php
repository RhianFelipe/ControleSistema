<?php

include "../db/conexao.php";
include "../db/consulta.php";

$pageTitle = "Gerenciar Relatórios";
include_once "../view/src/verificarPermissao.php";
session_start();
verificarPermissao();

// Verifica se a variável de sessão está definida
if (!isset($_SESSION['user'])) {
    // Redireciona o usuário para o painel de login
    header("Location: ../index.php");
    exit();
}

require '../dompdf/autoload.inc.php';

// Usa o namespace do Dompdf
use Dompdf\Dompdf;

// Cria uma instância do Dompdf
$dompdf = new Dompdf();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lógica para gerar o relatório com base no tipo selecionado
    $reportType = $_POST['report_type'];
    $htmlContent = '';

    switch ($reportType) {
        case 'tipo1':
            // Conexão ao banco de dados
            $sql = "
                SELECT 
                    u.nome,
                    u.email,
                    s.valorSid AS sid_wifi
                FROM usuarios u
                INNER JOIN termos_assinados t ON u.id = t.id_usuario
                INNER JOIN permissoes p ON u.id = p.id_usuario
                INNER JOIN sid s ON u.id = s.id_usuario
                WHERE 
                    t.nome_termo = 'Termo de Wi-Fi' AND 
                    t.assinado = 1 AND 
                    p.sistemas = 'Wi-Fi' AND 
                    p.permissao = 1 AND 
                    s.nomeSid = 'Wi-Fi'
            ";

            $result = $mysqli->query($sql);

            // Conta a quantidade de usuários
            $userCount = $result->num_rows;

            if ($userCount > 0) {
                $htmlContent = "
                    <h1>Relatório de Usuários com Wi-Fi Ativado</h1>
                    <p>Total de usuários: $userCount</p>
                    <table border='1' cellspacing='0' cellpadding='10'>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>SID do Wi-Fi</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                while ($row = $result->fetch_assoc()) {
                    $htmlContent .= "
                        <tr>
                            <td>{$row['nome']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['sid_wifi']}</td>
                        </tr>
                    ";
                }

                $htmlContent .= "
                        </tbody>
                    </table>
                ";
            } else {
                $htmlContent = '<p>Nenhum resultado encontrado.</p>';
            }

            $mysqli->close();
            break;

        // Outros casos
        default:
            $htmlContent = '<h1>Relatório Padrão</h1><p>Conteúdo do relatório padrão...</p>';
    }

    // Verifica se o conteúdo HTML não está vazio
    if (!empty($htmlContent)) {
        // Configura o conteúdo HTML para o Dompdf
        $dompdf->loadHtml($htmlContent);

        // (Opcional) Define o tamanho do papel e a orientação
        $dompdf->setPaper('A4', 'portrait');

        // Renderiza o PDF
        $dompdf->render();

        // Envia o PDF gerado para o navegador
        $dompdf->stream('relatorio.pdf', array("Attachment" => false));
        exit();
    } else {
        echo "Erro: O conteúdo do relatório está vazio.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importar folhas de estilo -->
    <link rel="stylesheet" href="../public/main.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="../script/utils.js"></script>
    <script src="../js/sweetalert2.js"></script>
    <title>Gerenciar Relatórios</title>
    <link rel="icon" href="../public/assets/img/icon-govpr.png" type="image/x-icon">
</head>

<!-- Criação do Header para logo e navegação-->
<?php include '../public/header.php'; ?>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Gerenciar Relatórios</h1>
        <form method="POST" action="">
            <div class="row mb-3">
                <label for="report_type" class="form-label">Escolha o tipo de relatório:</label>
                <div class="col-md-12">
                    <select id="report_type" name="report_type" class="form-select">
                        <option value="tipo1">Usuários com Wi-Fi</option>
                        <option value="tipo2">Relatório Tipo 2</option>
                        <option value="tipo3">Relatório Tipo 3</option>
                    </select>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-lg">Gerar Relatório</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Relatório Gerado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Seu relatório foi gerado com sucesso.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script src="../script/formatarSid.js"></script>
<script src="../script/utils.js"></script>
<script src="../script/cadastrarUser.js"></script>
<script src="../script/sistemaModalEdit.js"></script>
<?php include '../include/modals.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>