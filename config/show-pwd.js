// JavaScript for showing password
// Currently not in use

/*document.getElementById('show-password').addEventListener('change', function() {
    var passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(function(input) {
        if (this.checked) {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }, this);
});*/

window.onload = function() {
    document.getElementById('show-password').addEventListener('change', function() {
        var passwordInputs = document.querySelectorAll('input[type="password"]');
        passwordInputs.forEach(function(input) {
            if (this.checked) {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }, this);
    });
};