<?php 
$tabela = 'ferias';
require_once("../../../conexao.php");
session_start();
date_default_timezone_set('America/Sao_Paulo');

$usuario_modi = $_SESSION['id'];
$_SESSION['email_ferias'] = $email_ferias;
$_SESSION['email'] = $email_sistema;
$data_modi = date('y/m/d H:i:s');
$_SESSION['email_rh1'] = $email_rh1;
$_SESSION['email_rh2'] = $email_rh2;
$_SESSION['email_rh3'] = $email_rh3;
$_SESSION['email_ferias1'] = $email_ferias1;
$_SESSION['email_ferias2'] = $email_ferias2;
$_SESSION['email_ferias3'] = $email_ferias3;


$funcionario = $_POST['funcionario'];
$data_ini = $_POST['data_ini'];
$qntd_dias = $_POST['qntd_dias'];
$qntd_dias1 = $qntd_dias - 1;
$data_agd = date('y/m/d 01:51:s', strtotime("-5 days",strtotime($data_ini)));
$data_fim = date('y/m/d', strtotime("+".$qntd_dias1." days",strtotime($data_ini)));
$data_ret = date('y/m/d', strtotime("+".$qntd_dias." days",strtotime($data_ini)));
$status1 = $_POST['status1'];
$id = $_POST['id'];
$hash = '';
$data_iniF = implode('/', array_reverse(explode('-', $data_ini)));



$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
@$res = $query->fetchAll(PDO::FETCH_ASSOC);
	@$data_ini2 = $res[0]['data_ini']; 
	@$qntd_dias2 = $res[0]['qntd_dias'];
    @$data_agd2 = $res[0]['data_agd'];
    @$hash2 = $res[0]['hash'];



$query1 = $pdo->query("SELECT * FROM pacientes where id = '$funcionario'");
@$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
@$funcionario2 = $res1[0]['id'];


$query = $pdo->query("SELECT * FROM pacientes where id = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
@$func_nome = $res[0]['nome'];
@$telefone = $res[0]['telefone'];
@$registro = $res[0]['registro'];


if($id == ""){

    $query2 = $pdo->prepare("INSERT INTO $tabela SET funcionario = :funcionario, data_ini = :data_ini, qntd_dias = :qntd_dias, data_fim = :data_fim, data_ret = :data_ret, status1 = 'Pendente', usuario_alt = :usuario_modi, data_alt = :data_modi, data_agd = :data_agd");

$query2->bindValue(":funcionario", $funcionario);
$query2->bindValue(":data_ini", $data_ini);
$query2->bindValue(":qntd_dias", $qntd_dias);
$query2->bindValue(":data_fim", $data_fim);
$query2->bindValue(":data_ret", $data_ret);
$query2->bindValue(":usuario_modi", $usuario_modi);
$query2->bindValue(":data_modi", $data_modi);
$query2->bindValue(":data_agd", $data_agd);

$query2->execute();

} elseif($data_ini != $data_ini2 || $qntd_dias != $qntd_dias2 || $funcionario != $funcionario2 || $status1 =='Pendente'){
    $query4 = $pdo->prepare("UPDATE $tabela SET funcionario = :funcionario, data_ini = :data_ini, qntd_dias = :qntd_dias, data_fim = :data_fim, status1 = 'Pendente', data_ret = :data_ret, usuario_alt = :usuario_modi, data_alt = :data_modi, data_agd = :data_agd WHERE id = :id");

$query4->bindValue(":funcionario", $funcionario);
$query4->bindValue(":data_ini", $data_ini);
$query4->bindValue(":qntd_dias", $qntd_dias);
$query4->bindValue(":data_fim", $data_fim);
$query4->bindValue(":data_ret", $data_ret);
$query4->bindValue(":id", $id);
$query4->bindValue(":usuario_modi", $usuario_modi);
$query4->bindValue(":data_modi", $data_modi);
$query4->bindValue(":data_agd", $data_agd);
$query4->execute();

} elseif($status1 == 'Reprovado'){
    $query4 = $pdo->prepare("UPDATE $tabela SET funcionario = :funcionario, data_ini = :data_ini, qntd_dias = :qntd_dias, data_fim = :data_fim, status1 = 'Reprovado', data_ret = :data_ret, usuario_alt = :usuario_modi, data_alt = :data_modi, data_agd = :data_agd WHERE id = :id");

$query4->bindValue(":funcionario", $funcionario);
$query4->bindValue(":data_ini", $data_ini);
$query4->bindValue(":qntd_dias", $qntd_dias);
$query4->bindValue(":data_fim", $data_fim);
$query4->bindValue(":data_ret", $data_ret);
$query4->bindValue(":id", $id);
$query4->bindValue(":usuario_modi", $usuario_modi);
$query4->bindValue(":data_modi", $data_modi);
$query4->bindValue(":data_agd", $data_agd);
$query4->execute();
        
}else{
    $query = $pdo->prepare("UPDATE $tabela SET funcionario = :funcionario, data_ini = :data_ini, qntd_dias = :qntd_dias, data_fim = :data_fim, status1 = :status1, data_ret = :data_ret, usuario_alt = :usuario_modi, data_alt = :data_modi, data_agd = :data_agd WHERE id = :id");

$query->bindValue(":funcionario", $funcionario);
$query->bindValue(":data_ini", $data_ini);
$query->bindValue(":qntd_dias", $qntd_dias);
$query->bindValue(":data_fim", $data_fim);
$query->bindValue(":data_ret", $data_ret);
$query->bindValue(":status1", $status1);
$query->bindValue(":id", $id);
$query->bindValue(":usuario_modi", $usuario_modi);
$query->bindValue(":data_modi", $data_modi);
$query->bindValue(":data_agd", $data_agd);
$query->execute();



if($token != ""){

    $query5 = $pdo->query("SELECT * FROM $tabela where id = '$id'");
    @$res5 = $query5->fetchAll(PDO::FETCH_ASSOC);
    @$data_fim2 = $res5[0]['data_fim'];
    @$data_ret2 = $res5[0]['data_ret'];
    $data_fimF = implode('/', array_reverse(explode('-', $data_fim2)));
    $data_retF = implode('/', array_reverse(explode('-', $data_ret2)));

    $telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
    
    $mensagem = "Prezado(a) ".$func_nome." suas férias foram programadas para a data abaixo: \n\nData Inicio: ".$data_iniF."\nData Fim: ".$data_fimF."\nQuantidade de dias: ".$qntd_dias."\nRetorno Empresa: ".$data_retF."\n\nQualquer duvida, procurar seu gestor imediato!\n\nAtt,\nRecursos Humanos";
    
    require("../../apis/texto.php");

    $telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
    $mensagem = "Prezado(a) ".$func_nome." suas férias esta confirmada para o dia ".$data_iniF.". Favor comparecer ao RH no dia de hoje para assinatura do aviso e recibo de suas férias.\n\nQualquer duvida, estamos a disposição!!\n\nAtt,\nRecursos Humanos!";
    require("../../apis/agendar.php");       


    
    }

    if($email_sistema != "" || $email_rh1 != "" || $email_ferias1 != ""){

    $destinatarios = array($email_ferias1, $email_ferias2, $email_ferias3);
    $cc = array($email_rh1, $email_rh2, $email_rh3);

    $destinatario = implode(", ", $destinatarios);
    $assunto = 'ALTERAÇÃO FÉRIAS - '.$registro.' - '.$func_nome;

    // Construir a mensagem HTML com a tabela
    $mensagem = '<html><body>';
    $mensagem .='Prezados,'.'<br><br>'.'Poderiam realizar alteração das férias do colaborador(a) abaixo:';
    $mensagem .= '<tr>';
    $mensagem .= '<table style="width: 60%; border-collapse: collapse;">';
    $mensagem .= '</tr>';
    $mensagem .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px; background: #ccc;">Registro</th>';
    $mensagem .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px; background: #ccc; width: 40%;">Nome</th>';
    $mensagem .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px; background: #ccc;">Data Inicio</th>';
    $mensagem .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px; background: #ccc;">Qntd Dias</th>';
    $mensagem .= '<th style="border: 1px solid #dddddd; text-align: left; padding: 8px; background: #ccc;">Data Fim</th>';
    $mensagem .= '</tr>';
    $mensagem .= '<tr>';
    $mensagem .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$registro.'</td>';
    $mensagem .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$func_nome.'</td>';
    $mensagem .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$data_iniF.'</td>';
    $mensagem .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$qntd_dias.'</td>';
    $mensagem .= '<td style="border: 1px solid #dddddd; text-align: left; padding: 8px;">'.$data_fimF.'</td>';
    $mensagem .= '</tr>';
    $mensagem .= '</table>';
    $mensagem .='<br>';
    $mensagem .='<p style="background: yellow; width: 50%">Obs.: Favor responder e-mail com todos que se encontram em cópia;</p>'.'<br><br>';
    $mensagem .='Qualquer duvida, estamos a disposição!!';
    $mensagem .='<br><br>';
    $mensagem .='Muito Obrigado!!';
    $mensagem .= '</body></html>';

    // Definir cabeçalhos para e-mail HTML
    $cabecalhos = "From: ".$email_sistema."\r\n";
    $cabecalhos .= "Content-type: text/html; charset=UTF-8\r\n";

    if (!empty($cc)) {
        $cabecalhos .= "Cc: " . implode(", ", $cc) . "\r\n";
    }

    @mail($destinatario, $assunto, $mensagem, $cabecalhos);
    }
}

echo 'Salvo com Sucesso';

//pegar nome do cliente


?>
