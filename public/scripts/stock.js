const submitButton = document.querySelector('#submit');
const buttonValue = document.querySelector('#submit').value;

submitButton.addEventListener('click', (event) => {
    event.preventDefault(); // impede de recarregar a página antes de fazer todas as ações do JS.
    if (buttonValue === 'Adicionar Item'){
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 
        inputs.forEach(input => {
            formData[input.name] = input.value;
        })
        fetch(`auth/add_item`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify({
                id: formData.id,
                name: formData.name,
                category: formData.category,
                quantity: formData.quantity,
                price: formData.price,
                code: formData.code,
                sale: select
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
    if (buttonValue === 'Alterar'){
        let inputs = document.querySelectorAll('.input');
        let select = document.querySelector('#select').value;

        let formData = {}; 
        inputs.forEach(input => {
            formData[input.name] = input.value;
        })
        console.log(formData.id);
        fetch(`auth/update_item`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify({
                id: formData.id,
                name: formData.name,
                quantity: formData.quantity,
                category: formData.category,
                price: formData.price,
                code: formData.code,
                sale: select
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
    if (buttonValue === 'Fazer pedido'){
        let inputs = document.querySelectorAll('.input');

        let formData = {}; 
        inputs.forEach(input => {
            formData[input.name] = input.value;
        })
        fetch(`auth/request_item`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify({
                id: formData.id,
                name: formData.name,
                category: formData.category,
                code: formData.code,
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
    if (buttonValue === 'Comprar'){
        document.querySelectorAll(".buy_button").forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault();  
    
                let row = this.closest("tr"); 
                let formData = {
                    id_item: row.querySelector('input[name="id_item"]').value,
                    id_request: row.querySelector('input[name="id_request"]').value,
                    quantity: row.querySelector('input[name="buy_quantity"]').value,
                    item: row.querySelector('input[name="item"]').value,
                    price_item: row.querySelector('input[name="price"]').value

                };
    
                fetch("auth/buy_item", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location = data.redirect;
                    } else {
                        console.log(data.message);
                    }
                })
                .catch(error => {
                    console.log("Erro na requisição: ", error);
                });
            });
        });
    };
})