
function validarCep(cep){
    console.log("Executou com valor:", cep);
    
    const cepLimpo = cep.replace(/\D/g, ''); 

    if(cepLimpo.length == 8){ 
        BuscarCep(cepLimpo); 
    }else{
        let telaCadastros = document.getElementsByClassName('container');
        html = '<div class="alert alert-danger" role="alert">Cep Inválido !</div>';
        telaCadastros.insertAdjacentHTML('afterbegin', html);
        console.error("CEP inválido. Deve ter 8 dígitos.");
    }
}

async function BuscarCep(cep){
    try {
        const resposta = await fetch("https://viacep.com.br/ws/"+cep+"/json/");
        if (!resposta.ok) {
        throw new Error(`Erro HTTP! Status: ${resposta.status}`);
        }
        const dados = await resposta.json();
        document.getElementById('endereco').value = dados.logradouro ? dados.logradouro : '';
        document.getElementById('bairro').value = dados.bairro ? dados.bairro : '';
        document.getElementById('cidade').value = dados.localidade ? dados.localidade : '';
        document.getElementById('sigla_estado').value = dados.uf ? dados.uf : '';

    } catch (error) {
        console.error("Ocorreu um erro na busca:", error);
    }
}

function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}
var strCPF = "12345678909";
alert(TestaCPF(strCPF));