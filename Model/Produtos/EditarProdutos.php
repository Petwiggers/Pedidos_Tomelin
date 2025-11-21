<?php
require_once '../conexao.php';
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id'])) {
    $id = ($_POST["id"] );
    $descricao = isset($_POST['descricao']) ? ($_POST['descricao']) : '';
    $preco = isset($_POST['preco']) ? $_POST['preco'] : '';
    $unidade = isset($_POST['unidade']) ? ($_POST['unidade']) : '';

    if (empty($descricao) || $preco === '') {
        $mensagem = '<div class="alert alert-danger" role="alert">Erro: Os campos "Descrição" e "Preço" são obrigatórios.</div>';
        throw new InvalidArgumentException("Descrição e preço obrigatórios !");
    } elseif (!is_numeric($preco) || $preco < 0) {
        $mensagem = '<div class="alert alert-danger" role="alert">Erro: O valor do preço é inválido.</div>';
        throw new InvalidArgumentException("Preço Inválido !");
    } else {
        try {
            $conn = abrirconexao();
            $sql = "UPDATE produtos SET descricao = :descricao, preco = :preco, unidade = :unidade WHERE id_produto = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':preco', $preco);
            if (empty($unidade)) {
                $unidade = null;
            }
            $stmt->bindParam(':unidade', $unidade);
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            header("Location: ../../ListarProdutos.php?status=sucesso");
            exit();
        } catch(PDOException $e) {
            error_log("Erro no banco de dados: " . $e->getMessage());
            header("Location: ../../ListarProdutos.php?status=erro");
            exit();
        }
        $conn = null;
    }
}
?>