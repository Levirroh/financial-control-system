const submitButton = document.querySelector('#submit');
const buttonValue = document.querySelector('#submit').value;

submitButton.addEventListener('click', () => {
    if (buttonValue === 'Cadastrar'){
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 

        inputs.forEach(input => {
            formData[input.name] = input.value;            
            console.log(input.value);
        })
        console.log(select);

        fetch (`Auth/create`, {
            method: "POST",
            headers: {
                'Content-type': 'application/json',
            },
            body: JSON.stringify({
                name: formData.name,
                email: formData.email,
                password: formData.password,
                admin: formData.admin,
                func: formData.function,
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