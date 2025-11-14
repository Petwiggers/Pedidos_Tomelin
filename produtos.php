<?php
// --- PROCESSAMENTO DO FORMULÁRIO ---
require_once 'conexao.php';
$mensagem = ""; // Variável para feedback ao usuário

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Coleta e sanitiza os dados do formulário
    $descricao = isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : '';
    $preco = isset($_POST['preco']) ? $_POST['preco'] : ''; // Preço é número, trataremos de forma diferente
    $unidade = isset($_POST['unidade']) ? htmlspecialchars($_POST['unidade']) : '';

    // 2. Validação dos dados
    // Verifica se os campos obrigatórios (descricao e preco) não estão vazios
    if (empty($descricao) || $preco === '') {
        $mensagem = '<div class="alert alert-danger" role="alert">Erro: Os campos "Descrição" e "Preço" são obrigatórios.</div>';
    } elseif (!is_numeric($preco) || $preco < 0) {
        // Valida se o preço é um número válido
        $mensagem = '<div class="alert alert-danger" role="alert">Erro: O valor do preço é inválido.</div>';
    } else {
        try {
            // Conexão via PDO para maior segurança
            $conn = abrirconeccao();

            // Query SQL com prepared statements para evitar SQL Injection
            $sql = "INSERT INTO produtos (descricao, preco, unidade) VALUES (:descricao, :preco, :unidade)";
            
            $stmt = $conn->prepare($sql);

            // Associa os valores aos parâmetros da query
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':preco', $preco);
            
            // Para o campo 'unidade', que pode ser nulo, tratamos de forma especial
            if (empty($unidade)) {
                $unidade = null;
            }
            $stmt->bindParam(':unidade', $unidade);
            
            // Executa a query
            $stmt->execute();

            $mensagem = '<div class="alert alert-success" role="alert">Produto cadastrado com sucesso!</div>';

        } catch(PDOException $e) {
            $mensagem = '<div class="alert alert-danger" role="alert">Erro ao cadastrar produto: ' . $e->getMessage() . '</div>';
        }
        // Fecha a conexão
        $conn = null;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <!-- Link para o CSS do Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px; /* Um container um pouco menor para formulários simples */
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1 );
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Cadastro de Produtos</h2>

    <!-- Exibe a mensagem de sucesso ou erro -->
    <?php if (!empty($mensagem)) echo $mensagem; ?>

    <form action="cadastro_produto.php" method="POST">
        
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição do Produto*</label>
            <input type="text" class="form-control" id="descricao" name="descricao" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="preco" class="form-label">Preço (R$)*</label>
                <input type="number" class="form-control" id="preco" name="preco" step="0.01" min="0" placeholder="Ex: 19.99" required>
            </div>
            <div class="col-md-6">
                <label for="unidade" class="form-label">Unidade</label>
                <select class="form-select" id="unidade" name="unidade">
                    <option value="" selected>Nenhuma</option>
                    <option value="UN">UN (Unidade)</option>
                    <option value="PC">PC (Peça)</option>
                    <option value="KG">KG (Quilograma)</option>
                    <option value="M">M (Metro)</option>
                    <option value="L">L (Litro)</option>
                    <!-- Adicione outras unidades conforme necessário -->
                </select>
            </div>
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Cadastrar Produto</button>
        </div>

    </form>
</div>

<!-- Script do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>