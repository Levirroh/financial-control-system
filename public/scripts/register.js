const submitButton = document.querySelector('#submit');
const buttonValue = document.querySelector('#submit').value;

submitButton.addEventListener('click', () => {
    if (buttonValue === 'Cadastrar'){
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 

        inputs.forEach(input => {
            formData[input.name] = input.value;

        })
    }

})