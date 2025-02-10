const submitButton = document.querySelector('#submit');
const buttonValue = document.querySelector('#submit').value;

submitButton.addEventListener('click', (event) => {
    event.preventDefault(); // impede de recarregar a página antes de fazer todas as ações do JS.
    if (buttonValue === 'Cadastrar'){
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 
        inputs.forEach(input => {
            formData[input.name] = input.value;            
        })

        fetch(`auth/create`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
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

})