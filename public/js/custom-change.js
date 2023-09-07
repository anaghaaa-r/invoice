document.addEventListener('DOMContentLoaded', function () {
    const invoiceEditForm = document.getElementById('invoice-edit-form');
    const invoiceDeleteForm = document.getElementById('invoice-delete-form');

    const submitMessage = document.getElementById('submit-message');
    const deleteMessage = document.getElementById('delete-message');

    const quantityInput = document.getElementById('quantity');
    const amountInput = document.getElementById('amount');
    const customerNameInput = document.getElementById('name');
    const customerEmailInput = document.getElementById('email');

    const quantityMessage = document.getElementById('quantity-validate');
    const amountMessage = document.getElementById('amount-validate');
    const customerNameMessage = document.getElementById('customer-name-validate');
    const customerEmailMessage = document.getElementById('customer-email-validate');

    quantityInput.addEventListener('input', function () {
        const quantityValue = quantityInput.value;
        if(isNaN(quantityValue))
        {
            quantityMessage.textContent = 'Quantity should be a valid digit.';
            return;
        }
        else
        {
            quantityMessage.textContent = '';
        }
    })

    amountInput.addEventListener('input', function () {
        const amountValue = amountInput.value;
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
        if(!/^[a-zA-Z ]+$/.test(customerNameValue))
        {
            customerNameMessage.textContent = 'Enter a valid name.';
            return;
        }
        else
        {
            customerNameMessage.textContent = '';
        }
    })

    customerEmailInput.addEventListener('input', function () {
        const customerEmailValue = customerEmailInput.value;
        if(!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{1,}$/.test(customerEmailValue))
        {
            customerEmailMessage.textContent = 'Enter a valid email.';
            return;
        }
        else
        {
            customerEmailMessage.textContent = '';
        }
    })

    invoiceEditForm.addEventListener('submit', function (event) {
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
                
                if (data.status == true)
                {
                    submitMessage.textContent = data.message;
                    location.reload();
                }
                else
                {
                    submitMessage.textContent = data.message;
                }
            })
    })

    invoiceDeleteForm.addEventListener('submit', function (event) {
        form = event.target;
        event.preventDefault();

        fetch(form.action, {
            method: 'DELETE',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
            }
        })

        .then((response) => response.json())
        .then((data) => {
            if (data.status == true)
            {
                deleteMessage.textContent = data.message;
                location.reload();
            }
            else
            {
                deleteMessage.textContent = data.message;
                console.log(data.error);
            }
        })
    })
});