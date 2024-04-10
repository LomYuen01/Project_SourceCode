$(document).ready(function() {
    const formOpenBtn = $("#form-open"),
    home = $(".home"),
    formContainer = $(".form-container"),
    formCloseBtn = $(".form-close"),
    signupBtn = $("#signup"),
    loginBtn = $("#login"),
    pwShowHide = $(".pw-hide");

    formOpenBtn.click(function() {
        home.addClass("show");
    });

    formCloseBtn.click(function() {
        home.removeClass("show");
    });

    pwShowHide.each(function() {
        $(this).click(function() {
            let getPwInput = $(this).parent().find("input");
            if(getPwInput.attr("type") === "password"){
                getPwInput.attr("type", "text");
                $(this).removeClass("fa-eye-slash").addClass("fa-eye");
            } else{
                getPwInput.attr("type", "password");
                $(this).removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });
    });

    signupBtn.click(function(e) {
        e.preventDefault();
        formContainer.addClass("active");
    });

    loginBtn.click(function(e) {
        e.preventDefault();
        formContainer.removeClass("active");
    });
});