const submitButton = document.querySelector('#submit');
const buttonValue = document.querySelector('#submit').value;

submitButton.addEventListener('click', () => {
    if (buttonValue === 'Cadastrar'){
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 

        inputs.forEach(input => {
            formData[input.name] = input.value;

            fetch('auth/Register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name_user: formData.name,
                    email_user: formData.email,
                    password_user: formData.password,
                    function: formData.function,
                    admin: select
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    window.location = data.redirect;
                } else {
                    console.log(data.message);
                }
            })
            .catch(error => {
                console.log('Erro na requisição: ', error);
            });
        })
    }

})