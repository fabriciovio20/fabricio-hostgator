<?php
$tabela = 'funcionarios';
require_once("../../../conexao.php");

$arquivo = $_FILES["arq_inat"]["tmp_name"];
$nome = $_FILES["arq_inat"]["name"];

$ext = explode(".", $nome);
$extensao = end($ext);

if ($extensao != "csv") {
    echo "Extensao Invalida";
} else {
    $objeto = fopen($arquivo, 'r');

    $contadorLinha = 0; // Inicializa o contador de linha
    $ativo = 'Não';
    try {
        while (($dados = fgetcsv($objeto, 1000, ";")) !== FALSE) {
            $contadorLinha++;

            // Verifica se o contador de linha é maior que 1
            if ($contadorLinha > 1) {
                // Certifique-se de que há pelo menos 4 colunas (nome, sobrenome, filial, registro)
                if (count($dados) >= 1) {
                    $registro = intval($dados[0]);

                    $query = $pdo->prepare("UPDATE $tabela SET ativo = :ativo where registro = '$registro'");

                    $query->bindValue(":ativo", $ativo);
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

?>
