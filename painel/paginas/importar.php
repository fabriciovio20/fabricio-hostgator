<?php
$tabela = 'usuarios';
require_once("../../conexao.php");

$arquivo = $_FILES["arquivo"]["tmp_name"];
$nome = $_FILES["arquivo"]["name"];

$ext = explode(".", $nome);
$extensao = end($ext);

if ($extensao != "csv") {
    echo "Extensao Invalida";
} else {
    $objeto = fopen($arquivo, 'r');

    $contadorLinha = 0; // Inicializa o contador de linha
    $senha = '123';
    $senha_crip = md5($senha);

    try {
        while (($dados = fgetcsv($objeto, 1000, ";")) !== FALSE) {
            $contadorLinha++;

            // Verifica se o contador de linha é maior que 1
            if ($contadorLinha > 1) {
                // Certifique-se de que há pelo menos 4 colunas (nome, sobrenome, filial, registro)
                if (count($dados) >= 4) {
                    $registro = intval($dados[0]);
                    $nome = utf8_encode($dados[1]);
                    $filial = utf8_encode($dados[2]);
                    $nivel = utf8_encode($dados[3]);
                    $telefone = formatarTelefone($dados[4]);
                    $cpf = formatarCPF($dados[5]);
                    $email = utf8_encode($dados[6]);

                    $query = $pdo->prepare("INSERT INTO $tabela SET registro = :registro, nome = :nome, filial = :filial, senha = :senha, senha_crip = :senha_crip, nivel = :nivel, ativo = 'Sim', telefone = :telefone, cpf = :cpf, foto = 'sem-foto.jpg', data = CURDATE(), email = :email");

                    $query->bindValue(":registro", $registro);
                    $query->bindValue(":nome", $nome);
                    $query->bindValue(":filial", $filial);
                    $query->bindValue(":senha", $senha);
                    $query->bindValue(":senha_crip", $senha_crip);
                    $query->bindValue(":nivel", $nivel);
                    $query->bindValue(":telefone", $telefone);
                    $query->bindValue(":cpf", $cpf);
                    $query->bindValue(":email", $email);

                    $query->execute();

                    if ($query->rowCount() > 0) {
                        echo 'Linha ' . $contadorLinha . ': Dados salvos com sucesso<br>';
                    } else {
                        echo 'Linha ' . $contadorLinha . ': Erro ao inserir os dados: ' . print_r($query->errorInfo(), true) . '<br>';
                    }
                } else {
                    echo 'Erro na linha ' . $contadorLinha . ': Não há dados suficientes na linha.<br>';
                }
            }
        }
    } catch (Exception $e) {
        echo 'Erro na linha ' . $contadorLinha . ': ' . $e->getMessage() . '<br>';
    } finally {
        fclose($objeto);
    }
}

echo 'Importação concluída com sucesso';

// Função para formatar o número de telefone
function formatarTelefone($numero) {
    // Remove caracteres não numéricos do número
    $numeroLimpo = preg_replace('/[^0-9]/', '', $numero);

    // Aplica a máscara "(00) 00000-0000"
    $telefoneFormatado = sprintf("(%s) %s-%s", substr($numeroLimpo, 0, 2), substr($numeroLimpo, 2, 5), substr($numeroLimpo, 7));

    return $telefoneFormatado;
}

function formatarCPF($numerocpf) {
    // Remove caracteres não numéricos do número
    $numeroLimpo = preg_replace('/[^0-9]/', '', $numerocpf);

    // Aplica a máscara "000.000.000-00"
    $cpfFormatado = sprintf("%s.%s.%s-%s", substr($numeroLimpo, 0, 3), substr($numeroLimpo, 3, 3), substr($numeroLimpo, 6, 3), substr($numeroLimpo, 9));

    return $cpfFormatado;
}

?>
