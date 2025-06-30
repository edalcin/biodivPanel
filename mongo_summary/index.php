<?php
require_once 'db.php';

// Tenta obter a conexão com o MongoDB
$db = get_mongo_connection();

// Verifica se a conexão foi bem-sucedida (get_mongo_connection() chama die() em caso de erro)
// Então, se chegarmos aqui, a conexão foi um sucesso.

$collections_to_summarize = [
    'taxa',
    'ocorrencias',
    'cncflora2022',
    'faunaAmeacada',
    'invasoras'
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo das Coleções MongoDB</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Resumo das Coleções do Banco de Dados "dwc2json"</h1>

        <div class="cards-container">
            <?php
            if ($db) {
                foreach ($collections_to_summarize as $collectionName) {
                    try {
                        $collection = $db->selectCollection($collectionName);
                        $count = $collection->countDocuments();
                        echo "<div class='card'>";
                        echo "<h2>" . htmlspecialchars(ucfirst($collectionName)) . "</h2>";
                        echo "<p>Total de documentos: " . htmlspecialchars($count) . "</p>";
                        echo "</div>";
                    } catch (MongoDB\Driver\Exception\Exception $e) {
                        echo "<div class='card error-card'>";
                        echo "<h2>" . htmlspecialchars(ucfirst($collectionName)) . "</h2>";
                        echo "<p class='error'>Erro ao acessar coleção: " . htmlspecialchars($e->getMessage()) . "</p>";
                        echo "</div>";
                    }
                }
            } else {
                // Esta mensagem não deve ser exibida se get_mongo_connection() chamar die() em caso de falha.
                // Mas é uma boa prática ter um fallback.
                echo "<p class='error'>Não foi possível conectar ao banco de dados.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
