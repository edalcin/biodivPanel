<?php

function get_mongo_connection() {
    $connection_string = "mongodb:/?authSource=admin&authMechanism=DEFAULT";
    $db_name = "dwc2json";

    try {
        $client = new MongoDB\Client($connection_string);
        $db = $client->selectDatabase($db_name);
        return $db;
    } catch (MongoDB\Driver\Exception\Exception $e) {
        // Em um ambiente de produção, você pode querer logar o erro em vez de exibi-lo.
        error_log("Erro ao conectar ao MongoDB: " . $e->getMessage());
        // Para este projeto, vamos exibir o erro, pois é um resumo para visualização.
        die("Erro ao conectar ao MongoDB: " . $e->getMessage());
    }
}

?>
