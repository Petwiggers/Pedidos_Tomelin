<?php
// Verifica se existe um parâmetro 'status' na URL
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'sucesso') {
        $mensagem = "Cliente cadastrado com sucesso!";
        $classeAlerta = "alert-success"; // Classe do Bootstrap para sucesso (verde)
    } elseif ($_GET['status'] == 'erro') {
        $mensagem = "Ocorreu um erro ao cadastrar o cliente. Tente novamente.";
        $classeAlerta = "alert-danger"; // Classe do Bootstrap para erro (vermelho)
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

    <?php
    // Se a variável $mensagem foi definida, exibe o alerta do Bootstrap
    if (isset($mensagem)) {
        echo "<div class='alert {$classeAlerta} alert-dismissible fade show' role='alert'>
                {$mensagem}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
    ?>

    <form action="Model/Produtos/CadastroProdutos.php" method="POST">
        
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