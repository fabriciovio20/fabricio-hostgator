<?php 
require_once("conexao.php");
$email = $_POST['email'];

$query = $pdo->prepare("SELECT * from usuarios where email = :email");
$query->bindValue(":email", "$email");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
    $senha = $res[0]['senha'];
    //ENVIAR O EMAIL COM A SENHA
    $destinatario = $email;
    $assunto = $nome_sistema . ' - Recuperação de Senha';

    // Construir a mensagem HTML com a tabela
    $mensagem = '<html><body>';
    $mensagem .= '<table style="width: 30%; border-collapse: collapse;">';
    $mensagem .= '<tr>';
    $mensagem .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Email</th>';
    $mensagem .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px;">Senha</th>';
    $mensagem .= '</tr>';
    $mensagem .= '<tr>';
    $mensagem .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$destinatario.'</td>';
    $mensagem .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$senha.'</td>';
    $mensagem .= '</tr>';
    $mensagem .= '</table>';
    $mensagem .= '</body></html>';

    // Definir cabeçalhos para e-mail HTML
    $cabecalhos = "From: ".$email_sistema."\r\n";
    $cabecalhos .= "Content-type: text/html; charset=UTF-8\r\n";

    @mail($destinatario, $assunto, $mensagem, $cabecalhos);
    echo 'Recuperado';
} else {
    echo 'Email não Cadastrado!';
}
?>

