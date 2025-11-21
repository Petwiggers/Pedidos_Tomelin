<?php
    require_once '../conexao.php';
    $mensagem = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id'])) {
        $id = ($_POST["id"] );
        try {
            $conn = abrirconexao();
            $sql = "DELETE FROM clientes WHERE id_cliente = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            header("Location: ../../ListarClientes.php?status=sucesso");
            exit();
        } catch(PDOException $e) {
            error_log("Erro no banco de dados: " . $e->getMessage());
            header("Location: ../../ListarClientes.php?status=erro");
            exit();
        }
        $conn = null;
    }
?>