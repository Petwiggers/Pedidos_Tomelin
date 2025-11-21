<?php
// --- PROCESSAMENTO DO FORMULÁRIO ---
require_once '../conexao.php';
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

            header("Location: ../../produtos.php?status=sucesso");
            exit();

        } catch(PDOException $e) {
            // Em caso de erro na conexão ou na query
            error_log("Erro no banco de dados: " . $e->getMessage());
            header("Location: ../../clientes.php?status=erro");
            exit();
        }
        // Fecha a conexão
        $conn = null;
    }
}
?>