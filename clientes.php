<?php
// --- PROCESSAMENTO DO FORMULÁRIO ---
require_once 'conexao.php';

// Esta variável guardará a mensagem de feedback (sucesso ou erro)
$mensagem = "";

// Verifica se o formulário foi enviado (se o método da requisição é POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. COLETAR E SANITIZAR OS DADOS DO FORMULÁRIO
    // A função htmlspecialchars() é uma medida de segurança básica para evitar ataques XSS.
    $tipo = isset($_POST['tipo']) ? htmlspecialchars($_POST['tipo']) : '';
    $nome = isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '';
    $cpf = isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : '';
    $cnpj = isset($_POST['cnpj']) ? htmlspecialchars($_POST['cnpj']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $telefone_pessoal = isset($_POST['telefone_pessoal']) ? htmlspecialchars($_POST['telefone_pessoal']) : '';
    $telefone_residencial = isset($_POST['telefone_residencial']) ? htmlspecialchars($_POST['telefone_residencial']) : '';
    
    $cep = isset($_POST['cep']) ? htmlspecialchars($_POST['cep']) : '';
    $endereco = isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : '';
    $numero_end = isset($_POST['numero_end']) ? htmlspecialchars($_POST['numero_end']) : '';
    $bairro = isset($_POST['bairro']) ? htmlspecialchars($_POST['bairro']) : '';
    $sigla_estado = isset($_POST['sigla_estado']) ? htmlspecialchars($_POST['sigla_estado']) : '';
    $proximidade = isset($_POST['proximidade']) ? htmlspecialchars($_POST['proximidade']) : '';

    // 2. VALIDAÇÃO BÁSICA (exemplo)
    // Verificamos se os campos obrigatórios (baseado na imagem, que não são NULL) foram preenchidos.
    if (empty($tipo) || empty($nome) || empty($cep) || empty($endereco) || empty($numero_end) || empty($bairro) || empty($sigla_estado)) {
        $mensagem = '<div class="alert alert-danger" role="alert">Erro: Por favor, preencha todos os campos obrigatórios de Dados Pessoais e Endereço.</div>';
    } else {
        try {
            $conn = abrirconeccao();

            // Preparar a query SQL para evitar SQL Injection
            $sql = "INSERT INTO clientes (tipo, nome, cpf, cnpj, email, telefone_pessoal, telefone_residencial, cep, endereco, numero_end, bairro, sigla_estado, proximidade) 
                    VALUES (:tipo, :nome, :cpf, :cnpj, :email, :telefone_pessoal, :telefone_residencial, :cep, :endereco, :numero_end, :bairro, :sigla_estado, :proximidade)";
            
            $stmt = $conn->prepare($sql);

            // Associar os valores do formulário aos parâmetros da query
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefone_pessoal', $telefone_pessoal);
            $stmt->bindParam(':telefone_residencial', $telefone_residencial);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':numero_end', $numero_end);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':sigla_estado', $sigla_estado);
            $stmt->bindParam(':proximidade', $proximidade);
            
            // Executar a query
            $stmt->execute();

            $mensagem = '<div class="alert alert-success" role="alert">Cliente cadastrado com sucesso!</div>';

        } catch(PDOException $e) {
            // Em caso de erro na conexão ou na query
            $mensagem = '<div class="alert alert-danger" role="alert">Erro ao cadastrar cliente: ' . $e->getMessage() . '</div>';
        }

        // Fechar a conexão
        $conn = null;
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
    <h2 class="mb-4 text-center">Cadastro de Clientes</h2>

    <!-- Exibe a mensagem de sucesso ou erro aqui -->
    <?php if (!empty($mensagem)) echo $mensagem; ?>

    <form action="clientes.php" method="POST">
        
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
