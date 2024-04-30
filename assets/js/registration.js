document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = document.getElementById('registrationForm');
    const successDiv = document.getElementById('successDiv');
    const errorDiv = document.getElementById('errorDiv');

    // Function to hide success and error messages
    function hideMessages() {
        if (successDiv) successDiv.style.display = 'none';
        if (errorDiv) errorDiv.style.display = 'none';
    }

    // Hide success and error messages when user starts typing
    registrationForm.addEventListener('input', hideMessages);

    // Function to clear input fields
    function clearFields() {
        const inputFields = registrationForm.querySelectorAll('input');
        inputFields.forEach(field => field.value = '');
        const selectField = registrationForm.querySelector('select');
        if (selectField) selectField.value = '';
    }

    // Clear input fields when success message appears
    if (successDiv && successDiv.style.display !== 'none') {
        clearFields();
    }

    // Hide success and error messages when user selects a location
    const selectElements = registrationForm.querySelectorAll('select');
    selectElements.forEach(selectElement => {
        selectElement.addEventListener('change', hideMessages);
    });
});
