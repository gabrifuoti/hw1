function showPassword(){
    const passForm = document.querySelector("#password");

    if(passForm.type == "password"){
        document.querySelector("#showPassword").classList.add('hidden'); 
        document.querySelector("#hiddenPassword").classList.remove('hidden'); 
        passForm.type="text";
    }
    else if(passForm.type == "text"){
        document.querySelector("#hiddenPassword").classList.add('hidden'); 
        document.querySelector("#showPassword").classList.remove('hidden');     
        passForm.type="password";
    }    
}

document.querySelector("#showPassword").addEventListener("click", showPassword);
document.querySelector("#hiddenPassword").addEventListener("click", showPassword);