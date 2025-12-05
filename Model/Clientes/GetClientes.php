<?php
    require_once '../conexao.php';
    header('Content-Type: application/json; charset=utf-8');
    try {
        $parametro = "%%";
        $tipoBusca = "nome";
        $coon = abrirconexao();
        if (isset($_GET['parametro']) && ($_GET['tipoBusca'])) {
            $parametro = $_GET['parametro'];
            $tipoBusca = $_GET['tipoBusca'];

        }

        // $stmt = $coon->prepare("SELECT * FROM clientes Where ".$tipoBusca." LIKE :parametro ORDER BY nome ASC");
        // $stmt->bindParam(':parametro', $tipo);
        $stmt = $coon->prepare("SELECT * FROM clientes Where "."nome"." LIKE :parametro ORDER BY nome ASC");
        $stmt->bindParam(':parametro', $parametro);
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $json_output = json_encode($clientes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // 3. Imprimir o JSON
        echo $json_output;
        exit;

    } catch (PDOException $e) {
        error_log("Erro ao buscar clientes: " . $e->getMessage());
        throw new Exception($e->getMessage());
        
    }
?>