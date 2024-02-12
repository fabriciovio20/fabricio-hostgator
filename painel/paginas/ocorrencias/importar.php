<?php
$tabela = 'ocorrencias';
require_once("../../../conexao.php");

$arquivo = $_FILES["arquivo"]["tmp_name"];
$nome = $_FILES["arquivo"]["name"];

$ext = explode(".", $nome);
$extensao = end($ext);

if ($extensao != "csv") {
    echo "Extensao Invalida";
} else {
    $objeto = fopen($arquivo, 'r');

    $contadorLinha = 0; // Inicializa o contador de linha
    
    try {
        while (($dados = fgetcsv($objeto, 1000, ";")) !== FALSE) {
            $contadorLinha++;

            // Verifica se o contador de linha é maior que 1
            if ($contadorLinha > 1) {
                // Certifique-se de que há pelo menos 4 colunas (nome, sobrenome, filial, registro)
                if (count($dados) >= 1) {
                    $registro = intval($dados[0]);
                    $nome = utf8_encode($dados[1]);
                    $descricao = utf8_encode($dados[2]);
                    $data = utf8_encode($dados[3]);
                    $duracao = strval(utf8_encode($dados[4]));

                    
                    // Converta a data para o formato do banco de dados (YYYY-MM-DD)
                    $dataF = date('Y-m-d', strtotime(str_replace('/', '-', $data)));
                    
                    $query = $pdo->prepare("INSERT INTO $tabela SET registro = :registro, nome = :nome, descricao = :descricao, dataF = :dataF, duracao = :duracao");

                    $query->bindValue(":registro", $registro);
                    $query->bindValue(":nome", $nome);
                    $query->bindValue(":descricao", $descricao);
                    $query->bindValue(":dataF", $dataF);
                    $query->bindValue(":duracao", $duracao);
                    
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

echo 'Salvo com Sucesso';

?>
