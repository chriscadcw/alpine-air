/**
 * The app javascript file
 */

 var password = document.getElementById("password");
 var confirm_password = document.getElementById("confirm_password");
 var register_button = document.getElementById("btn_register");

function validatePassword(){    
    if( password.value != confirm_password.value){
        confirm_password.setCustomValidity("Passwords Don't Match");        
        register_button.setAttribute("disabled", "disabled");
        return false;
    } else {
        confirm_password.setCustomValidity("");
        register_button.removeAttribute("disabled")
        return true;
    }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;