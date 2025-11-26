<?php 
    require_once '../conexao.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. COLETAR E SANITIZAR OS DADOS DO FORMULÁRIO
    // A função htmlspecialchars() é uma medida de segurança básica para evitar ataques XSS.
    $id = isset($_POST['id']) ? ($_POST['id']) : '';
    $tipo = isset($_POST['tipo']) ? ($_POST['tipo']) : '';
    $nome = isset($_POST['nome']) ? ($_POST['nome']) : '';
    $cpf = isset($_POST['cpf']) ? ($_POST['cpf']) : '';
    $cnpj = isset($_POST['cnpj']) ? ($_POST['cnpj']) : '';
    $email = isset($_POST['email']) ? ($_POST['email']) : '';
    $telefone_pessoal = isset($_POST['telefone_pessoal']) ? ($_POST['telefone_pessoal']) : '';
    $telefone_residencial = isset($_POST['telefone_residencial']) ? ($_POST['telefone_residencial']) : '';
    
    $cep = isset($_POST['cep']) ? ($_POST['cep']) : '';
    $endereco = isset($_POST['endereco']) ? ($_POST['endereco']) : '';
    $numero_end = isset($_POST['numero_end']) ? ($_POST['numero_end']) : '';
    $bairro = isset($_POST['bairro']) ? ($_POST['bairro']) : '';
    $sigla_estado = isset($_POST['sigla_estado']) ? ($_POST['sigla_estado']) : '';
    $proximidade = isset($_POST['proximidade']) ? ($_POST['proximidade']) : '';

    // 2. VALIDAÇÃO BÁSICA (exemplo)
    // Verificamos se os campos obrigatórios (baseado na imagem, que não são NULL) foram preenchidos.
    if (empty($tipo) || empty($nome) || empty($cep) || empty($endereco) || empty($numero_end) || empty($bairro) || empty($sigla_estado)) {
        $mensagem = '<div class="alert alert-danger" role="alert">Erro: Por favor, preencha todos os campos obrigatórios de Dados Pessoais e Endereço.</div>';
    } else {
        try {
            $conn = abrirconexao();

            // Preparar a query SQL para evitar SQL Injection
            $sql = "UPDATE clientes SET tipo = :tipo,  nome = :nome, cpf = :cpf, cnpj = :cnpj, email = :email, telefone_pessoal = :telefone_pessoal, 
            telefone_residencial = :telefone_residencial, cep = :cep, endereco = :endereco, numero_end = :numero_end, bairro = :bairro, sigla_estado = :sigla_estado, proximidade = :proximidade
                WHERE id_cliente = :id";
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
            $stmt->bindParam(':id', $id);
            
            // Executar a query
            if($stmt->execute()){
                echo "Executou";
            }
            header("Location: ../../ListarClientes.php?status=sucesso");
            exit();

        } catch(PDOException $e) {
            // Em caso de erro na conexão ou na query
            error_log("Erro no banco de dados: " . $e->getMessage());
            header("Location: ../../ListarClientes.php?status=erro");
            exit();
        }

        // Fechar a conexão
        $conn = null;
        echo $mensagem;
    }
}
?>

