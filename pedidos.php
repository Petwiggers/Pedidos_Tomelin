<?php

require_once 'conexao.php';
try{
        // Conexão via PDO
    $conn = abrirconeccao();

    // --- LÓGICA PARA BUSCAR CLIENTES PARA O DROPDOWN ---
    $stmt_clientes = $conn->prepare("SELECT id_cliente, nome FROM clientes ORDER BY nome ASC");
    $stmt_clientes->execute();
    $clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);


    // --- LÓGICA PARA PROCESSAR O CADASTRO DO PEDIDO ---
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Coleta e valida o ID do cliente
        $cliente_id = isset($_POST['cliente_id']) ? (int)$_POST['cliente_id'] : 0;

        if (empty($cliente_id)) {
            $mensagem = '<div class="alert alert-danger" role="alert">Erro: Por favor, selecione um cliente.</div>';
        } else {
            // 2. Prepara e executa a inserção no banco
            // Note que não precisamos passar as datas, o banco de dados cuidará disso.
            $sql = "INSERT INTO pedidos (cliente_id) VALUES (:cliente_id)";
            $stmt_pedido = $conn->prepare($sql);
            $stmt_pedido->bindParam(':cliente_id', $cliente_id);
            
            $stmt_pedido->execute();

            // Pega o ID do pedido que acabamos de inserir para exibir na mensagem
            $ultimo_id = $conn->lastInsertId();

            $mensagem = '<div class="alert alert-success" role="alert">Pedido nº ' . $ultimo_id . ' cadastrado com sucesso!</div>';
        }
    }
}

catch(PDOException $e) {
    // Captura erros de conexão ou de query
    $mensagem = '<div class="alert alert-danger" role="alert">Erro: ' . $e->getMessage() . '</div>';
}

// Fecha a conexão ao final do script
// $conn = null; // Descomente se não for redirecionar ou se o script terminar aqui.
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedidos</title>
    <!-- Link para o CSS do Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="JS/pedidos.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1 );
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Registrar Novo Pedido</h2>

    <!-- Exibe a mensagem de sucesso ou erro -->
    <?php if (!empty($mensagem)) echo $mensagem; ?>

    <form action="pedidos.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Pesquisar Cliente</label> <!-- Adicionei um label para acessibilidade -->
            <div class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Digite o nome do cliente..." aria-label="Pesquisar Cliente" id="parametro_cliente"/>
                <button class="btn btn-outline-success" type="button">Pesquisar</button> <!-- Mudei para type="button" -->
            </div>
        </div>
        

        <div class="alert alert-info mt-3">
            <strong>Nota:</strong> A data e a hora do pedido serão registradas automaticamente pelo sistema no momento do cadastro.
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Registrar Pedido</button>
        </div>

    </form>
</div>

<!-- Script do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
