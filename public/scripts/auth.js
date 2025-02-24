const submitButton = document.querySelector('#submit');
const buttonValue = document.querySelector('#submit').value;

submitButton.addEventListener('click', (event) => {
    event.preventDefault(); // impede de recarregar a página antes de fazer todas as ações do JS.
    if (buttonValue === 'Cadastrar'){
        let inputs = document.querySelectorAll('.input');
        let selectAdmin = document.querySelector('#selectAdmin').value;
        let selectType = document.querySelector('#selectType').value;

        let formData = {}; 
        inputs.forEach(input => {
            formData[input.name] = input.value;            
        })

        if (formData.name === "" || formData.email === "" || formData.password === "" || formData.type === "") {
            document.querySelector('.errorAuth').innerHTML = "Preencha todos os campos";
            return;
        }
        if (formData.password.length < 6 || !/[!@#\$%\^&\*\(\)_\+]/.test(formData.password)) {
            document.querySelector('.errorAuth').innerHTML = "A senha deve conter pelo menos 1 caractere especial e ter no mínimo 6 caracteres";
            return;
        }
        if (!formData.email.includes('@')|| !formData.email
        .includes('.')) {
            document.querySelector('.errorAuth').innerHTML = "Email inválido, deve conter o domínio do email e o @";
            return;
        }

        fetch(`auth/create`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify({
                name: formData.name,
                email: formData.email,
                password: formData.password,
                type: selectType,
                admin: selectAdmin
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                window.location = data.redirect;
            } else {
                console.log(data.message);
            }
        })
        .catch(error => {
            document.querySelector('.errorAuth').innerHTML = "Email já cadastrado";
        })
        
    }
    if (buttonValue === 'Login') {
        let inputs = document.querySelectorAll('.input_login');

        let formData = {}; 
        inputs.forEach(input => {
            formData[input.name] = input.value;
        })

        fetch(`auth/enter`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify({
                name: formData.name,
                password: formData.password
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                window.location = data.redirect;
            } else{
                document.querySelector('.errorPass').innerHTML = data.message;
                document.querySelector('.errorUser').innerHTML = "";
            }
        })
        .catch(error => {
            document.querySelector('.errorUser').innerHTML = "Usuário não cadastrado";
            document.querySelector('.errorPass').innerHTML = "";
        })
    } 
    if (buttonValue == 'Cadastrar Funcionário'){
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 
        inputs.forEach(input => {
            formData[input.name] = input.value;
        })

        fetch(`auth/create_employee`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify({
                name: formData.name,
                email: formData.email,
                password: formData.password,
                function: formData.function,
                admin: select
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                window.location = data.redirect;
            } else {
                console.log(data.message);
            }
        })
        .catch(error => {
            console.log('Erro na requisição: ', error);
        })
    }
    if (buttonValue === 'Alterar') {
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 
        inputs.forEach(input => {
            formData[input.name] = input.value;
        })
        console.log(formData.id);
        fetch(`auth/update_employee`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify({
                id: formData.id,
                name: formData.name,
                email: formData.email,
                password: formData.password,
                function: formData.function,
                admin: select
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                window.location = data.redirect;
            } else {
                console.log(data.message);
            }
        })
        .catch(error => {
            console.log('Erro na requisição: ', error);
        })
        
    } 
})