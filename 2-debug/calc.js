(function() {
    const inputs = document.querySelectorAll('input');
    const result = document.querySelector('p');
    const button = document.querySelector('button');

    function onClick() {
        if (inputsAreEmpty()) {
            result.textContent = 'Error: inputs cannot be empty.';
            return;
        }
        updateLabel();
    }
    
    function inputsAreEmpty() {
        return getNumber1() === '' || getNumber2() === '';
    }

    function updateLabel() {
        const num1 = getNumber1();
        const num2 = getNumber2();
        const sum = num1 + num2;
        result.textContent = num1 + ' + ' + num2 + ' = ' + sum;
    }

    function getNumber1() {
        return inputs[0].value;
    }

    function getNumber2() {
        return inputs[1].value;
    }
    
    button.addEventListener('click', onClick);
})();