const fileInput = document.getElementById('image');
const errorMessage = document.getElementById('errorMessage');
const icon = document.getElementById('image_icon');

icon.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById('profileImage').src = e.target.result;
    };

    reader.readAsDataURL(file);
});

document.addEventListener('DOMContentLoaded', function () {
    validatePassword(document.getElementById('password'));
});

document.getElementById('password').addEventListener('input', function (e) {
    validatePassword(e.target);
});

function validatePassword(target) {
    // Check if password meets requirements
    var hasNumber = /\d/.test(target.value);
    var hasLetter = /[a-zA-Z]/.test(target.value);
    var minLength = target.value.length >= 8;

    var errors = [];

    if (!hasNumber) {
        errors.push('contain at least one number');
    }
    if (!hasLetter) {
        errors.push('contain at least one letter');
    }
    if (!minLength) {
        errors.push('be at least 8 characters long');
    }

    if (errors.length > 0) {
        target.setCustomValidity('Password must ' + errors.join(', '));
    } else {
        target.setCustomValidity('');
    }
}

document.getElementById('ic').addEventListener('input', function (e) {
    var target = e.target, position = target.selectionEnd, length = target.value.length;
    
    target.value = target.value.replace(/[^\d]/g, ''); // Remove non-digits
    if (target.value.length > 12) {
        target.value = target.value.slice(0, 12); // Limit to 12 digits
    }

    // Format as 'xxxxxx-xx-xxxx'
    target.value = target.value.replace(/(\d{6})(\d{2})(\d{4})/, "$1-$2-$3");

    // Check if IC number is exactly 14 characters long and consists of only numbers and dashes
    if ((target.value.length !== 14 || !/^[\d-]+$/.test(target.value)) && target.value !== '') {
        target.setCustomValidity('IC number invalid.');
    } else {
        target.setCustomValidity('');
    }
});

document.getElementById('email').addEventListener('input', function (e) {
    var target = e.target;
    
    if (!target.value.endsWith('@gmail.com') && target.value !== '') {
        target.setCustomValidity('Email must end with @gmail.com');
    } else {
        target.setCustomValidity('');
    }
});

document.getElementById('phone').addEventListener('input', function (e) {
    var target = e.target, position = target.selectionEnd, length = target.value.length;
    
    // Limit input to 12 characters
    if (target.value.length > 12) {
        target.value = target.value.slice(0, 12);
    } else {
        target.value = target.value.replace(/[^\d]/g, '').replace(/(.{3})/, '$1-').trim();
        target.selectionEnd = position += ((target.value.charAt(position - 1) === '-' && target.value.charAt(length - 1) !== '-') ? 1 : 0);
    }

    // Check for valid prefix
    var prefix = target.value.slice(0, 3);
    var validPrefixes = ['011', '012', '013', '014', '016', '017', '018', '019'];

    if (!validPrefixes.includes(prefix) && target.value !== '') {
        target.setCustomValidity('Phone number must start with a valid prefix (011, 012, 013, 014, 016, 017, 018, 019)');
    } else {
        target.setCustomValidity('');
    }
});

/*const fileInput = document.getElementById('image');
const errorMessage = document.getElementById('errorMessage');
const icon = document.getElementById('image_icon');

icon.addEventListener('click', () => {
fileInput.click();
});

fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    const image = new Image();

    image.onload = function() {
        if (this.width !== this.height) {
            Swal.fire('Error!', 'Please upload an image with equal width and height.', 'error');
        } else {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    };

    image.src = URL.createObjectURL(file);
});*/