var input_pesquisa_cliente = document.getElementById('parametro_cliente');

document.addEventListener('DOMContentLoaded', async function() {
    await carregarListagemClientes();
});

async function carregarListagemClientes(){
    let getClientes = "../Model/Clientes/GetClientes.php";
    try{
        const response = await fetch(getClientes)
        if(!response.ok){
            throw new Error(`Erro HTTP! Status: ${response.status}`);
        }
        const dadosClientes = await response.json();
        const tbody = document.getElementById("tbodyClientes");
        
        dadosClientes.forEach(cliente => {
            console.log(cliente);
            let tr = document.createElement(tr);
            let tdNome = document.createElement(td);
            let tdTipo = document.createElement(td);

            tdNome.textContent = cliente.nome;
            tdTipo.textContent = cliente.tipo;

            tr.appendChild(tdNome);
            tr.appendChild(tdTipo);
            tbody.appendChild(tr);
        });
        
    }catch(erro)
    {
        console.log(erro.message);
        throw new Exception("Erro ao buscar clientes !");
    }
} 