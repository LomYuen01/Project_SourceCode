const pwShowHide = document.querySelectorAll(".pw-hide");
        
pwShowHide.forEach(icon => {
    icon.addEventListener("click", () => {
        console.log('Icon clicked');
    let getPwInput = icon.parentElement.querySelector("input");
    if(getPwInput.type === "password"){
        getPwInput.type = "text";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    } else{
        getPwInput.type = "password";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    }
});
});