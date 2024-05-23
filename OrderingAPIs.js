document.addEventListener('DOMContentLoaded', function () {
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    let paymentMethod = document.getElementById('PaymentMethod');
    let CardContainer = document.getElementById('CardInfoContainer');
    const cardNumber = document.getElementById('CardNumber');
    const cardDate = document.getElementById('CardDate');
    paymentMethod.addEventListener('change', function(){
        let checkedMethod = document.querySelector('input[name="PaymentMethod"]:checked');
        if (checkedMethod.value == "CardPayment") {
            CardContainer.style.display = "grid";
        }
        else {
            CardContainer.style.display = 'none';
        }
    })
    phoneInputs.forEach(function (input) {
        Inputmask({ 
            mask: '+380(99) 999 99 99',
            placeholder: '+380(__) ___ __ __' 
        }).mask(input);
    });

    cardNumber.addEventListener('input', function (event) {
        console.log("cardNumberInput");
        Inputmask({ 
            mask: '9999-9999-9999-9999',
            placeholder: '____-____-____-____' 
        }).mask(event.target);
        let cardNumberValue = event.target.value.replace(/\D/g, '');
        let cardLogo = document.getElementById('CardLogo');
        if (cardNumberValue.length >= 1) {
            let firstDigit = cardNumberValue.charAt(0);
    
            if (firstDigit === '4') {
                console.log('Це VISA карта');
                cardLogo.src = "VISA-logo.png";
            } else if (firstDigit === '5') {
                console.log('Це Mastercard');
                cardLogo.src = "Mastercard-Logo.png";
            } else {
                console.log('Це інша карта');
                cardLogo.src = "credit-card.png";
            }
        } else {
            cardLogo.src = "credit-card.png";
        }
    });

    cardDate.addEventListener('input', function (event) {
        Inputmask({ 
            mask: '99/99',
            placeholder: 'MM/YY' 
        }).mask(event.target);
    });
    


        let citySelect = document.getElementById('TownPick');
        let datalistCities = document.getElementById('cities');
        let WarehouseSelect = document.getElementById('PostOfficePick');
        let datalistWH = document.getElementById('warehouses');
        let deliveryMethod = document.getElementById('pickDelivery');
        let novaPoshta = document.getElementById('NovaPoshta');
        let ukrPoshta = document.getElementById('UkrPoshta');
        let selfPickup = document.getElementById('SelfPickup');
        let deliveryAddress = document.getElementById('deliveryAddressSelection');
        
        const selectedDeliveryMethod = sessionStorage.getItem('deliveryMethod');
function deliveryChecking() {
        // Get the selected delivery method value
        let selectedDeliveryMethod = document.querySelector('input[name="deliveryMethod"]:checked');

        if (selectedDeliveryMethod) {
            // Set the cookie with the selected delivery method value
            sessionStorage.setItem('deliveryMethod', selectedDeliveryMethod.value);

            // Dynamically update data based on the selected delivery method
            if (selectedDeliveryMethod.value === 'NOVA') {
                // Code to update data for NOVA delivery method
                citySelect.placeholder = "Почніть вводити назву населеного пункту"
                deliveryAddress.style.display = 'block';
                citySelect.disabled = false;
                console.log('NOVA Delivery method selected.');
            } else if (selectedDeliveryMethod.value === 'Ukrposhta') {
                // Code to update data for Ukrposhta delivery method
                deliveryAddress.style.display = 'block';
                datalistCities.style.display = 'none';
                citySelect.disabled = true;
                citySelect.value = "";
                citySelect.placeholder = "Даний спосіб доставки тимчасово недоступний."
                console.log('Ukrposhta Delivery method selected.');
            } else if (selectedDeliveryMethod.value === 'SelfPickup') {
                deliveryAddress.style.display = 'none';
                console.log('Self pickup selected.');
            }
        } else {
            console.error('Please select a delivery method.');
        }
    }
        if (selectedDeliveryMethod) {
            const radioInput = document.querySelector(`input[value="${selectedDeliveryMethod}"]`);
            if (radioInput) {
                radioInput.checked = true;
                deliveryChecking();
            }
        }
        // Use the 'change' event on radio buttons
        deliveryMethod.addEventListener('change', deliveryChecking);
        citySelect.addEventListener('input', function() {
            let selectedDelivery = sessionStorage.getItem('deliveryMethod');
        let query = citySelect.value;
        if (selectedDelivery === "NOVA"){
            console.log('NOVA Delivery.');
            if (query.length >= 0) {
                datalistCities.style.display = 'flex';

                fetch('https://api.novaposhta.ua/v2.0/json/', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        modelName: 'Address',
                        calledMethod: 'getSettlements',
                        apiKey: '3f43b72d375111ab578536546f5b430d',
                        methodProperties: {
                            FindByString: query
                        }
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    datalistCities.innerHTML = "";

                    data.data.forEach(function(city) {
                        let option = document.createElement('a');
                        let cityName = city.Description + "/";
                        let areaName = city.AreaDescription;
                        let regionName;
                        if (city.RegionsDescription) {
                            regionName = city.RegionsDescription + "/";
                        }
                        else {
                            regionName = "";
                        }
                        option.setAttribute('data-ref', city.Description);
                        option.textContent = cityName + regionName + areaName;
                        option.href = "#";
                        datalistCities.appendChild(option);

                        option.addEventListener('click', function(e) {
                            e.preventDefault();
                            citySelect.value = option.textContent;
                            citySelect.setAttribute('data-ref', option.getAttribute('data-ref'));
                            datalistCities.style.display = 'none';
                            WarehouseSelect.addEventListener('input', function() {
                                let WHquery = WarehouseSelect.value;
                                if (WHquery.length >= 1){
                                    datalistWH.style.display = 'flex';
                                    let cityName = option.getAttribute('data-ref');
                                    console.log(cityName);
                                    fetch('https://api.novaposhta.ua/v2.0/json/', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            modelName: 'Address',
                                            calledMethod: 'getWarehouses',
                                            apiKey: '3f43b72d375111ab578536546f5b430d',
                                            methodProperties: {
                                                FindByString: WHquery,
                                                CityName: cityName
                                            }
                                        }),
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        datalistWH.innerHTML = "";

                                        if (data.success) {
                                            data.data.forEach(function(warehouse) {
                                                let warh = document.createElement('a');
                                                warh.href = "#";
                                                warh.style.minHeight = '30px';
                                                warh.textContent = warehouse.Description;
                                                warh.setAttribute('ref', warehouse.Ref);
                                                datalistWH.appendChild(warh);
                                                warh.addEventListener('click', function(o){ 
                                                    o.preventDefault();
                                                    WarehouseSelect.value = warh.textContent;
                                                    WarehouseSelect.setAttribute('data-ref', warehouse.Ref);
                                                    datalistWH.style.display = 'none';
                                                })
                                            });
                                        } else {
                                            console.error('Error:', data.errors[0]);
                                            // Тут ви можете вивести повідомлення про помилку або вжити інші заходи для обробки
                                        }
                                    })
                                    .catch(error => console.error('Error:', error));
                                } else {
                                    datalistWH.style.display = 'none';
                                }
                            })
                        });
                    });
                })
                .catch(error => console.error('Error:', error));
            }
            else if (selectedDelivery === "UkrPoshta") {
                citySelect.placeholder = "Перепрошуємо, даний спосіб доставки тимчасово недоступний."
            }
            else if (selectedDelivery == false || selectedDelivery !== "NOVA" && selectedDelivery !== "UkrPoshta") {
                console.log('NOTHING checked');
                citySelect.disabled = true;
            }
        } else {
            datalistCities.style.display = 'none';
            datalistWH.style.display = 'none';
        }
    });
    document.addEventListener('click', function(event) {
        // Перевіряємо, чи натискання відбулося поза citySelect та datalistCities
        if (!citySelect.contains(event.target) && !datalistCities.contains(event.target)) {
            datalistCities.style.display = 'none';
        }
    
        // Перевіряємо, чи натискання відбулося поза WarehouseSelect та datalistWH
        if (!WarehouseSelect.contains(event.target) && !datalistWH.contains(event.target)) {
            datalistWH.style.display = 'none';
        }
    });
});