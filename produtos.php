<?php
    $produto = [
        'id_produto' => '',
        'descricao' => '',
        'preco' => '',
        'unidade' => ''
    ];

    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'sucesso') {
            $mensagem = "Produto cadastrado/atualizado com sucesso!";
            $classeAlerta = "alert-success"; 
        } elseif ($_GET['status'] == 'erro') {
            $mensagem = "Ocorreu um erro ao cadastrar/atualizar o produto. Tente novamente.";
            $classeAlerta = "alert-danger";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id'])) {
        require_once 'Model/conexao.php';
        $id_produto = $_POST['id'];
        
        $conn = abrirconexao();
        $sql = 'SELECT * FROM produtos WHERE id_produto = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_produto);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $produto = $resultado;
        } else {
            $mensagem = "Produto não encontrado.";
            $classeAlerta = "alert-warning";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <a href="ListarProdutos.php" type="button" class="btn btn-success">Voltar</a>
    <h2 class="mb-4 text-center">Cadastro de Produtos</h2>

    <?php
    if (isset($mensagem)) {
        echo "<div class='alert {$classeAlerta} alert-dismissible fade show' role='alert'>
                {$mensagem}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
    ?>

    <form action="Model/Produtos/<?= (empty($produto['id_produto'])) ? 'CadastroProdutos.php' : 'EditarProdutos.php' ?>" method="POST">
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição do Produto*</label>
            <input type="text" class="form-control" id="descricao" name="descricao" required value="<?= htmlspecialchars($produto['descricao']) ?> ">
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="preco" class="form-label">Preço (R$)*</label>
                <input type="number" class="form-control" id="preco" name="preco" step="0.01" min="0" placeholder="Ex: 19.99" required value="<?= htmlspecialchars($produto['preco']); ?>">
            </div>
            <div class="col-md-6">
                <label for="unidade" class="form-label">Unidade</label>
                <select class="form-select" id="unidade" name="unidade">
                    <option value="" <?= ($produto['unidade'] == '') ? 'selected' : '' ?>>Nenhuma</option>
                    <option value="UN"<?= ($produto['unidade'] == 'UN') ? 'selected' : '' ?>>UN (Unidade)</option>
                    <option value="PC"<?= ($produto['unidade'] == 'PC') ? 'selected' : '' ?>>PC (Peça)</option>
                    <option value="KG"<?= ($produto['unidade'] == 'KG') ? 'selected' : '' ?>>KG (Quilograma)</option>
                    <option value="M"<?= ($produto['unidade'] == 'M') ? 'selected' : '' ?>>M (Metro)</option>
                    <option value="M²"<?= ($produto['unidade'] == 'M²') ? 'selected' : '' ?>>M (Metro)</option>
                    <option value="CM"<?= ($produto['unidade'] == 'CM') ? 'selected' : '' ?>>M (Metro)</option>
                </select>
            </div>
        </div>

        <div class="d-grid mt-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id_produto']) ?>">
            <button type="submit" class="btn btn-primary btn-lg"><?= (empty($produto['id_produto'])) ? 'Cadastrar Produto' : 'Editar Protudo' ?></button>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>