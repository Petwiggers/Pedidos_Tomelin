<?php
    require_once '../htdocs/Model/conexao.php';
    try {
        $parametro = "";
        $tipoBusca = "nome";
        $coon = abrirconexao();
        if (isset($_GET['parametro']) && ($_GET['tipoBusca'])) {
            $parametro = $_GET['parametro'];
            $tipoBusca = $_GET['tipoBusca'];

        }

        $stmt = $coon->prepare("SELECT * FROM clientes Where ".$tipoBusca." LIKE :parametro ORDER BY nome ASC");
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erro ao buscar clientes: " . $e->getMessage());
    }
?>