<?php
try {
    $cliente = [
        'id_cliente' => '',
        'nome' => '',
        'tipo' => '',
        'cpf' => '',
        'cnpj' => '',
        'email' => '',
        'telefone_pessoal' => '',
        'telefone_residencial' => '',
        'cep' => '',
        'endereco' => '',
        'cidade' => '',
        'numero_end' => '',
        'bairro' => '',
        'sigla_estado' => '',
        'proximidade' => '',
    ];

    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'sucesso') {
            $mensagem = "Cliente cadastrado/editado com sucesso!";
            $classeAlerta = "alert-success";
        } elseif ($_GET['status'] == 'erro') {
            $mensagem = "Ocorreu um erro ao cadastrar/editar o cliente. Tente novamente.";
            $classeAlerta = "alert-danger";
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id'])) {
        require_once 'Model/conexao.php';
        $id_cliente = $_POST['id'];
        $conn = abrirconexao();
        $sql = 'SELECT * FROM clientes WHERE id_cliente = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_cliente);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $cliente = $resultado;
        } else {
            $mensagem = "Cliente não encontrado !";
            $classeAlerta = "alert-warning";
        }
    }
} catch (PDOException $e) {
    // Em caso de erro na conexão ou na query
    error_log("Erro no banco de dados: " . $e->getMessage());
    header("Location: ../../clientes.php?status=erro");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <!-- Link para o CSS do Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="CSS/clientes.css" rel="stylesheet">
    <style>
        /* Estilo para dar um espaçamento melhor */
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- Script do Bootstrap (opcional, para componentes interativos) -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Biblioteca para utilização de Mascaras -->
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script defer src="JS/clientes.js"></script>
</head>

<body>
    <div class="container mt-5">
        <?php
        // Se a variável $mensagem foi definida, exibe o alerta do Bootstrap
        if (isset($mensagem)) {
            echo "<div class='alert {$classeAlerta} alert-dismissible fade show' role='alert'>
                    {$mensagem}
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
        ?>
        <a href="ListarClientes.php" type="button" class="btn btn-success">Voltar</a>
        <h2 class="mb-4 text-center">Cadastro de Clientes</h2>

        <form action="Model/Clientes/<?= (empty($cliente['id_cliente'])) ? 'CadastroCliente.php' : 'EditarCliente.php' ?>" method="POST">

            <!-- Seção de Dados Pessoais -->
            <h4 class="mb-3 border-bottom pb-2">Dados Pessoais</h4>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tipo" class="form-label">Tipo de Cliente*</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="" <?= ($cliente['tipo'] == '') ? 'selected' : '' ?> disabled>Selecione...</option>
                        <option value="F" <?= ($cliente['tipo'] == 'F') ? 'selected' : '' ?>>Pessoa Física</option>
                        <option value="J" <?= ($cliente['tipo'] == 'J') ? 'selected' : '' ?>>Pessoa Jurídica</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome Completo / Razão Social*</label>
                    <input type="text" class="form-control" id="nome" name="nome" required value="<?= htmlspecialchars($cliente['nome']); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" value="<?= htmlspecialchars($cliente['cpf']); ?>" onblur="validarCpf(this)">
                    <div class="invalid-feedback">CPF inválido</div>
                </div>
                <div class="col-md-6">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="00.000.000/0001-00" value="<?= htmlspecialchars($cliente['cnpj']); ?>">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com" value="<?= htmlspecialchars($cliente['email']); ?>" onblur="validarEmail(this)">
                    <div class="invalid-feedback">E-mail inválido !</div>
                </div>
                <div class="col-md-4">
                    <label for="telefone_pessoal" class="form-label">Telefone Pessoal</label>
                    <input type="tel" class="form-control" id="telefone_pessoal" name="telefone_pessoal" placeholder="(00) 0000-0000" value="<?= htmlspecialchars($cliente['telefone_pessoal']); ?>" onblur="validarTelefone(this)">
                    <div class="invalid-feedback">Telefone inválido !</div>
                </div>
                <div class="col-md-4">
                    <label for="telefone_residencial" class="form-label">Telefone Residencial</label>
                    <input type="tel" class="form-control" id="telefone_residencial" name="telefone_residencial" placeholder="(00) 0000-0000" value="<?= htmlspecialchars($cliente['telefone_residencial']); ?>" onblur="validarTelefone(this)">
                    <div class="invalid-feedback">Telefone inválido !</div>
                </div>
            </div>
            <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
            </div>
            <!-- Seção de Endereço -->
            <h4 class="mb-3 border-bottom pb-2">Endereço</h4>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="cep" class="form-label">CEP*</label>
                    <input type="text" class="form-control" id="cep" name="cep" required value="<?= htmlspecialchars($cliente['cep']); ?>" onblur="validarCep(this)">
                    <div class="invalid-feedback">CEP Inválido</div>
                </div>
                <div class="col-md-8">
                    <label for="endereco" class="form-label">Endereço (Rua, Av.)*</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" required value="<?= htmlspecialchars($cliente['endereco']); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="numero_end" class="form-label">Número*</label>
                    <input type="text" class="form-control" id="numero_end" name="numero_end" required value="<?= htmlspecialchars($cliente['numero_end']); ?>">
                </div>
                <div class="col-md-5">
                    <label for="bairro" class="form-label">Bairro*</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" required value="<?= htmlspecialchars($cliente['bairro']); ?>">
                </div>
                <div class="col-md-4">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" require value="<?= htmlspecialchars($cliente['cidade']); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="sigla_estado" class="form-label">Estado (UF)*</label>
                    <input type="text" class="form-control" id="sigla_estado" name="sigla_estado" maxlength="2" required placeholder="Ex: SP" value="<?= htmlspecialchars($cliente['sigla_estado']); ?>">
                </div>
                <div class="col-md-10">
                    <label for="proximidade" class="form-label">Ponto de Referência / Proximidade</label>
                    <input type="text" class="form-control" id="proximidade" name="proximidade" value="<?= htmlspecialchars($cliente['proximidade']); ?>">
                </div>
            </div>

            <!-- Botão de Envio -->
            <div class="d-grid">
                <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id_cliente']) ?>">
                <button type="submit" class="btn btn-primary btn-lg"><?= (empty($cliente['id_cliente'])) ? 'Cadastrar Cliente' : 'Editar Cliente' ?></button>
            </div>

        </form>
    </div>
</body>

</html>