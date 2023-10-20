<?php
include_once "./conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <title>SMS</title>
</head>

<body>
    <h2>Listar aniversariantes do dia</h2>

    <?php
    $query_usuarios = "SELECT id, nome, email, data_nascimento, celular
                    FROM usuarios
                    WHERE DAY (data_nascimento) = DAY (CURDATE())
                    AND MONTH (data_nascimento) = MONTH(CURDATE())
                    LIMIT 10";
$result_usuarios = $conn->prepare($query_usuarios);
$result_usuarios->execute();

if(($result_usuarios) and ($result_usuarios->rowCount() != 0)) {
    while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row_usuario);
        extract($row_usuario);
        echo "ID: $id <br>";
        echo "Nome: $nome <br>";
        echo "E-mail: $email <br>";
        echo "Data de Nascimento: " . date('d/m/Y', strtotime($data_nascimento)). " <br>";

        $mensagem = urlencode("$nome, PARABENS! A empresa deseja a voce um Feliz Aniversario, com muita alegria, sucesso e saude.");

        $url_api = "https://api.iagentesms.com.br/webservices/http.php?metodo=envio&usuario=seuemailcadastrado&senha=suasenhacadastrada&celular=$celular&mensagem={$mensagem}";

        // realiza a requisição http passando os parâmetros informados
        $api_http = file_get_contents($url_api);

        // imprime o resultado da requisição
        echo $api_http;

        echo "<hr>";
    }
} else {
    echo "<p style='color: #f00;'>Nenhum aniversariantes encontrado!</p>";
}

?>
    
</body>

</html>