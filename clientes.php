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
    <title>Cadastro de Clientes</title>
    <!-- Link para o CSS do Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            box-shadow: 0 0 15px rgba(0,0,0,0.1 );
        }
    </style>

    <!-- Script do Bootstrap (opcional, para componentes interativos) -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

    <form action="Model/Clientes/CadastroClientes.php" method="POST">
        
        <!-- Seção de Dados Pessoais -->
        <h4 class="mb-3 border-bottom pb-2">Dados Pessoais</h4>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tipo" class="form-label">Tipo de Cliente*</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="" selected disabled>Selecione...</option>
                    <option value="fisica">Pessoa Física</option>
                    <option value="juridica">Pessoa Jurídica</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome Completo / Razão Social*</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00">
            </div>
            <div class="col-md-6">
                <label for="cnpj" class="form-label">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="00.000.000/0001-00">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="seu@email.com">
            </div>
            <div class="col-md-4">
                <label for="telefone_pessoal" class="form-label">Telefone Pessoal</label>
                <input type="tel" class="form-control" id="telefone_pessoal" name="telefone_pessoal" placeholder="(00) 90000-0000">
            </div>
            <div class="col-md-4">
                <label for="telefone_residencial" class="form-label">Telefone Residencial</label>
                <input type="tel" class="form-control" id="telefone_residencial" name="telefone_residencial" placeholder="(00) 0000-0000">
            </div>
        </div>

        <!-- Seção de Endereço -->
        <h4 class="mb-3 border-bottom pb-2">Endereço</h4>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="cep" class="form-label">CEP*</label>
                <input type="text" class="form-control" id="cep" name="cep" required>
            </div>
            <div class="col-md-8">
                <label for="endereco" class="form-label">Endereço (Rua, Av.)*</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="numero_end" class="form-label">Número*</label>
                <input type="text" class="form-control" id="numero_end" name="numero_end" required>
            </div>
            <div class="col-md-5">
                <label for="bairro" class="form-label">Bairro*</label>
                <input type="text" class="form-control" id="bairro" name="bairro" required>
            </div>
            <div class="col-md-4">
                <label for="sigla_estado" class="form-label">Estado (UF)*</label>
                <input type="text" class="form-control" id="sigla_estado" name="sigla_estado" maxlength="2" required placeholder="Ex: SP">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <label for="proximidade" class="form-label">Ponto de Referência / Proximidade</label>
                <input type="text" class="form-control" id="proximidade" name="proximidade">
            </div>
        </div>

        <!-- Botão de Envio -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Cadastrar Cliente</button>
        </div>

    </form>
</div>
</body>
</html>
