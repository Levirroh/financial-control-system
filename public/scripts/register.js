const submitButton = document.querySelector('#submit');
const buttonValue = document.querySelector('#submit').name;

submitButton.addEventListener('click', () => {
    if (buttonValue === 'register'){
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 

        inputs.forEach(input => {

            input.name = toCamelCase(input.name);

            formData[input.name] = input.value;

        })
    }

})