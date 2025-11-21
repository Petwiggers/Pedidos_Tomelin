<?php
    require_once 'Model/conexao.php';

    try {
        $coon = abrirconexao();
        $stmt = $coon->prepare("SELECT * FROM clientes ORDER BY nome ASC");
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'sucesso') {
                $mensagem = "Cliente cadastrado com sucesso!";
                $classeAlerta = "alert-success";
            } elseif ($_GET['status'] == 'erro') {
                $mensagem = "Ocorreu um erro ao cadastrar o cliente. Tente novamente.";
                $classeAlerta = "alert-danger";
            }
        }

    } catch (PDOException $e) {
        die("Erro ao buscar clientes: " . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons (para os botões de ação ) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Estilo para o corpo da página, similar ao fundo da imagem */
        body {
            background-color: #f8f9fa; /* Um cinza bem claro */
        }
        /* Container principal para centralizar o conteúdo */
        .main-container {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Alinha ao topo */
            padding-top: 50px;
            min-height: 100vh;
        }
        /* O card branco que envolve o conteúdo */
        .content-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1 );
            width: 100%;
            max-width: 900px; /* Largura máxima do card */
        }
        .card-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }
        /* Estilo para os botões de ação na tabela */
        .action-buttons .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="content-card">
        <?php
        if (isset($mensagem)) {
            echo "<div class='alert {$classeAlerta} alert-dismissible fade show' role='alert'>
                    {$mensagem}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
        ?>
        <h1 class="card-title">Clientes Cadastrados</h1>

        <div class="d-flex justify-content-end mb-4">
            <a href="clientes.php" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Cadastrar Novo Cliente
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Tipo</th>
                        <th scope="col" class="text-center">Quantidade de Pedidos</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($clientes) > 0): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                <td><?= (($cliente['tipo'] == 'J') ? 'Jurídica' : 'Física') ?></td>
                                <td class="text-center">0</td>
                                <td class="text-center action-buttons">
                                    <form action="clientes.php" method="POST">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id_cliente']) ?>">
                                        <input type="submit" value="Editar" class="btn btn-sm btn-outline-primary">
                                    </form>
                                    <form action="Model/Clientes/ExcluirCliente.php" method="POST">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id_cliente']) ?>">
                                        <input type="submit" value="Excluir" class="btn btn-sm btn-outline-danger mt-1" onclick="return confirm('Deseja Realmente Excluir o cliente <?= $cliente['nome']?>' )">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhum produto cadastrado ainda.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>