$(document).ready(function() {
    // Coloque todo o código que manipula o DOM aqui dentro
    $('#cep').mask('00000-000');
    $('#cpf').mask('000.000.000-00');
    $('#cnpj').mask(`00.000.000/0000-00`);
    $('#telefone_pessoal').mask('(00) 00000-0000');
    $('#telefone_residencial').mask('(00) 00000-0000');
});

// let inputsInvalidos = [];

function validarCep(input){
    const cepLimpo = input.value.replace(/\D/g, ''); 
    if(cepLimpo.length == 8){ 
        BuscarCep(cepLimpo);
        input.classList.remove("is-invalid");
    }else{
        input.classList.add("is-invalid");
    }
}

async function BuscarCep(cep){
    try {
        const loading = document.getElementById('loading');
        loading.classList.remove('d-none');
 
        const resposta = await fetch("https://viacep.com.br/ws/"+cep+"/json/");
        const dados = await resposta.json();

        loading.classList.add('d-none');
        document.getElementById('endereco').value = dados.logradouro ? dados.logradouro : '';
        document.getElementById('bairro').value = dados.bairro ? dados.bairro : '';
        document.getElementById('cidade').value = dados.localidade ? dados.localidade : '';
        document.getElementById('sigla_estado').value = dados.uf ? dados.uf : '';
        if(dados.erro){
                
        }
        
        
    } catch (error) {
        console.error("Ocorreu um erro na busca:", error);
    }
}

function validarCpf(inputCpf){
    const cpf = inputCpf.value.replace(/\D/g, '');
    resultado = CalculoCpf(cpf);
    if(resultado){
        inputCpf.classList.remove("is-invalid");
        // if(inputsInvalidos.includes("cpf")) inputsInvalidos = inputsInvalidos.filter(item => !item.includes("cpf"));
        // console.log(inputsInvalidos);
    }
    else{
        inputCpf.classList.add("is-invalid");
        // if(!inputsInvalidos.includes("cpf")) inputsInvalidos.push("cpf");
        // console.log(inputsInvalidos);
    }
}

function CalculoCpf(strCPF) {
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

function validarEmail(inputEmail){
    const  regex  =  /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?)*$/;
    const email = inputEmail.value;
    if(regex.test(email)){
        inputEmail.classList.remove("is-invalid");
    }else{
        inputEmail.classList.add("is-invalid");
    }
}

function validarTelefone(inputTelefone){
    const telefone = inputTelefone.value.replace(/\D/g, '');
    if(telefone.length >= 10 && telefone.length <= 11){
        inputTelefone.classList.remove("is-invalid");
    }else{
        inputTelefone.classList.add("is-invalid");
    }
}