<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script defer src="./JS/pedidos.js"></script>
</head>
<style>
    /* Estilo para o corpo da página, similar ao fundo da imagem */
    body {
        background-color: #f8f9fa;
        /* Um cinza bem claro */
    }

    /* Container principal para centralizar o conteúdo */
    .main-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        /* Alinha ao topo */
        padding-top: 50px;
        min-height: 100vh;
    }

    /* O card branco que envolve o conteúdo */
    .content-card {
        background-color: #fff;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 900px;
        /* Largura máxima do card */
    }

    .card-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 30px;
        color: #333;
    }

    /* Estilo para os botões de ação na tabela */
    .action-buttons .btn {
        margin-right: 5px;
    }

    .scrollable{
        max-height: 500px;
        overflow: auto;
    }
</style>

<body>
    <div class="main-container">
        <div class="content-card">
            <label for="inputPesquisa" class="form-label">Parâmetro de Pesquisa</label>
            <input
                type="text"
                class="form-control mb-3"
                placeholder="Pesquisar Produto..."
                id="inputPesquisa">
            <div class="scrollable">

            </div>
            <div class="table-responsive">
                <caption>Selecione um Cliente</caption>
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Tipo</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyClientes">
                        <tr>
                            <td>Nome Clientes</td>
                            <td>Jurídica</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>

    </div>

    </div>

</body>

</html>