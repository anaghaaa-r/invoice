document.addEventListener('DOMContentLoaded', function () {

    const invoiceForm = document.getElementById('invoice-form');
    const submitMessage = document.getElementById('submit-message');

    const quantityInput = document.getElementById('quantity');
    const amountInput = document.getElementById('amount');
    const customerNameInput = document.getElementById('name');
    const invoiceDateInput = document.getElementById('invoice_date');
    const fileInput = document.getElementById('file');
    const customerEmailInput = document.getElementById('email');

    const quantityMessage = document.getElementById('quantity-validate');
    const amountMessage = document.getElementById('amount-validate');
    const customerNameMessage = document.getElementById('customer-name-validate');
    const invoiceDateMessage = document.getElementById('invoice-date-validate');
    const fileMessage = document.getElementById('file-validate');
    const customerEmailMessage = document.getElementById('customer-email-validate');

    quantityInput.addEventListener('input', function () {
        const quantityValue = quantityInput.value;
        if(isNaN(quantityValue))
        {
            quantityMessage.textContent = 'Quantity should be a valid digit.'
            return;
        }
        else
        {
            quantityMessage.textContent = '';
        }
    })

    amountInput.addEventListener('input', function () {
        const quantityValue = quantityInput.value;
        const amountValue = amountInput.value;
        
        if(!quantityValue)
        {
            quantityMessage.textContent = 'Field required.';
        }
        if(isNaN(amountValue))
        {
            amountMessage.textContent = 'Enter a valid amount.';
            return;
        }
        else
        {
            amountMessage.textContent = '';
        }
    })

    customerNameInput.addEventListener('input', function () {
        const customerNameValue = customerNameInput.value;
        if(!/^[A-Za-z ]+$/.test(customerNameValue) || !customerNameValue)
        {
            customerNameMessage.textContent = 'Enter a valid name.'
            return;
        }
        else
        {
            customerNameMessage.textContent = '';
        }
    })

    invoiceDateInput.addEventListener('input', function () {
        const customerNameValue = customerNameInput.value;
        const invoiceDateValue = invoiceDateInput.value;
        if(!customerNameValue)
        {
            customerNameMessage.textContent = 'Enter a valid name.'
        }
        if(!invoiceDateValue)
        {
            invoiceDateMessage.textContent = 'Enter a valid date.'
            return;
        }
        else
        {
            invoiceDateMessage.textContent = '';
        }
    })

    fileInput.addEventListener('input', function () {
        const customerNameValue = customerNameInput.value;
        const invoiceDateValue = invoiceDateInput.value;
        const fileValue = fileInput.value;
        if(!customerNameValue)
        {
            customerNameMessage.textContent = 'Enter a valid name.'
        }
        if(!invoiceDateValue)
        {
            invoiceDateMessage.textContent = 'Field required.'
        }
        if(!fileValue)
        {
            fileMessage.textContent = 'Please select a jpg, png or pdf file.'
            return;
        }
        else
        {
            fileMessage.textContent = '';
        }
    })

    customerEmailInput.addEventListener('input', function () {
        const customerNameValue = customerNameInput.value;
        const invoiceDateValue = invoiceDateInput.value;
        const fileValue = fileInput.value;
        const customerEmailValue = customerEmailInput.value;
        if(!customerNameValue)
        {
            customerNameMessage.textContent = 'Enter a valid name.'
        }
        if(!invoiceDateValue)
        {
            invoiceDateMessage.textContent = 'Field required.'
        }
        if(!fileValue)
        {
            fileMessage.textContent = 'Field required.';
        }
        if(!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{1,}$/.test(customerEmailValue) || !customerEmailValue)
        {
            customerEmailMessage.textContent = 'Enter a valid email.'
            return;
        }
        else
        {
            customerEmailMessage.textContent = '';
        }
    })

    invoiceForm.addEventListener('submit', function (event) {
        form = event.target;
        event.preventDefault();

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
            }
        })
        

            .then((response) => response.json())
            .then((data) => {
                if (data.status == true) {
                    alert(data.message);
                    form.reset();
                } else {
                    submitMessage.textContent = 'Error adding invoice. Please check the data and try again.';
                    console.log(data.error)
                }
            })
    })

})