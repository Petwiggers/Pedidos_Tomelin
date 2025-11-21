<?php
    try{
        function abrirconeccao (){
            $servername='localhost';
            $username = "user_tomelin"; // seu usuário
            $password = "tomelin"; // sua senha
            $dbname = "db_tomelin"; // seu banco de dados

            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }

    }
    catch(PDOException $e){
        echo'<div class="alert alert-danger" role="alert">Alert: '.$e->getMessage().'</div>';
    }
?>
