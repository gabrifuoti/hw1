function checkEmail(event){
    if(document.querySelector('.form-email .already-exist-div').classList != 'already-exist-div hidden'){
        document.querySelector('.form-email .already-exist-div').classList.add('hidden');    
    }

    const emailInput = event.target;
    const emailValue = emailInput.value.trim().toLowerCase();

    const btn_submit = document.querySelector('input[name="submit-email"]');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const errorDiv = document.querySelector("#error-email");

    if(emailPattern.test(emailValue) && emailValue.length < 50){
        emailInput.style.borderColor = 'white';
        errorDiv.classList.add('hidden'); 
        btn_submit.disabled = false;
    }
    else{
        emailInput.style.borderColor = 'red';
        errorDiv.classList.remove('hidden');
        btn_submit.disabled = true; 
    }
}

function dbCheckEmail(json) {
    if (json.exists) {
      document.querySelector('.form-email .already-exist-div').classList.remove('hidden');
      document.querySelector('input[name="submit-email"]').disabled = true;
    }
    else{
        if(document.querySelector('.form-email .already-exist-div').classList != 'already-exist-div hidden'){
            document.querySelector('.form-email .already-exist-div').classList.add('hidden');    
        }
        document.querySelector('input[name="submit-email"]').disabled = false;
        document.querySelector(".step1").classList.add('hidden'); 
        document.querySelector(".step2").classList.remove('hidden'); 
    }
}

function fetchResponse(response) {
    if (!response) return null;
    return response.json();
}

function showFormPassword(event){
    event.preventDefault();
    let emailValue = document.querySelector('input[name="email"]').value.trim();
    emailValue = emailValue.toLowerCase();
    fetch("./server/checkEmail.php?q="+encodeURIComponent(emailValue)).then(fetchResponse).then(dbCheckEmail);
}

function backtoFormEmail(){
    document.querySelector(".step1").classList.remove('hidden');
    document.querySelector(".step2").classList.add('hidden');
}

function checkPassword(event){
    const passInput = event.target;
    const passValue = passInput.value;
    
    const check1 = document.querySelector("#check-password1");
    const check2 = document.querySelector("#check-password2");
    const check3 = document.querySelector("#check-password3");
    const parent_check1 = check1.parentNode;
    const parent_check2 = check2.parentNode;
    const parent_check3 = check3.parentNode;

    if(/[a-zA-Z]/.test(passValue)){
        parent_check1.style.color = 'white';
        check1.style.backgroundColor = "#1ed760";
    }
    else{
        check1.style.backgroundColor = "transparent";
        passInput.style.borderColor = 'red';
        parent_check1.style.color = '#f15e6c';
    }

    if(/[0-9#?!&]/.test(passValue)){
        check2.style.backgroundColor = "#1ed760";
        parent_check2.style.color = 'white';
    }
    else{
        check2.style.backgroundColor = "transparent";
        passInput.style.borderColor = 'red';
        parent_check2.style.color = '#f15e6c';
    }
 
    if(passValue.length >= 10 && passValue.length < 20){
        check3.style.backgroundColor = "#1ed760";
        parent_check3.style.color = 'white';
    }
    else{
        check3.style.backgroundColor = "transparent";
        passInput.style.borderColor = 'red';
        parent_check3.style.color = '#f15e6c';
    }
    
    if(/[a-zA-Z]/.test(passValue) && /[0-9#?!&]/.test(passValue) && passValue.length >= 10 && passValue.length < 20){
        passInput.style.borderColor = 'white';
        document.querySelector('input[name="submit-password"]').disabled = false;
    }
    else{
        document.querySelector('input[name="submit-password"]').disabled = true;
    }
}

function showFormAboutYou(event){
    event.preventDefault();
    document.querySelector(".step2").classList.add('hidden'); 
    document.querySelector(".step3").classList.remove('hidden'); 
}

function backtoFormPassword(){
    document.querySelector(".step2").classList.remove('hidden'); 
    document.querySelector(".step3").classList.add('hidden'); 
}

var checkData = false;
var checkUser = false;
var checkGender = false;

function checkUsername(){
    if(document.querySelector('.form-aboutyou .already-exist-div').classList != '.already-exist-div hidden'){
        document.querySelector('.form-aboutyou .already-exist-div').classList.add('hidden');    
    }

    const input = document.querySelector('input[name="username"]');
    const input_text = input.value;
    
    if(input_text.length >2){
        input.style.borderColor = 'white';
        document.querySelector("#error-name").classList.add('hidden'); 
        checkUser = true;
    }
    else{
        input.style.borderColor = 'red';
        document.querySelector("#error-name").classList.remove('hidden'); 
        checkUser = false;
    }

    if(!checkData || !checkGender || !checkUser){
        document.querySelector('input[name="submit-aboutyou"]').style.cursor = "not allowed";
    }
    else{
        document.querySelector('input[name="submit-aboutyou"]').style.cursor = "pointer";
        document.querySelector('input[name="submit-aboutyou"]').disabled = false;
    }
}

var checkDay, checkMonth, checkYear;

function checkDate(){
    const day = document.querySelector('input[name="day"]');
    const month = document.querySelector('select[name="month"]');
    const year = document.querySelector('input[name="year"]');    

    if(day.value <= 0 || day.value >31){
        day.style.borderColor = 'red';
        document.querySelector("#error-day").classList.remove('hidden');
        checkDay = false;
    } else if(document.querySelector("#error-day").classList != 'hidden'){
        day.style.borderColor = 'white';
        document.querySelector("#error-day").classList.add('hidden');
        checkDay = true;
    }
    
    if(month.value == 'Month'){
        month.style.borderColor = 'red';
        document.querySelector("#error-month").classList.remove('hidden');
        checkMonth = false;
    }else if(document.querySelector("#error-month").classList != 'hidden'){
        month.style.borderColor = 'white';
        document.querySelector("#error-month").classList.add('hidden');
        checkMonth = true;
    }

    if(year.value < 1900 ){
        year.style.borderColor = 'red';
        document.querySelector("#error-year").classList.remove('hidden');
        checkYear = false;
    }else if(document.querySelector("#error-year").classList != 'hidden'){
        year.style.borderColor = 'white';
        document.querySelector("#error-year").classList.add('hidden');
        checkYear = true;
    }

    if(year.value > 2012 && year.value < 2025 ){
        document.querySelector("#error-minor").classList.remove('hidden');
        checkYear = false;
    }else if(document.querySelector("#error-minor").classList != 'hidden'){
        document.querySelector("#error-minor").classList.add('hidden');
        checkYear = true;
    }

    if(checkYear && checkMonth && checkDay){
        checkData = true;
    }

    const giorniNelMese = new Date(year.value, month.value, 0).getDate();

    if(!checkData || year.value >=2025){
        document.querySelector("#error-date").classList.remove('hidden');
    }else if (day.value > giorniNelMese) {
        document.querySelector("#error-date").classList.remove('hidden');
        checkDay = false;
    }else if(document.querySelector("#error-date").classList != 'hidden'){
        document.querySelector("#error-date").classList.add('hidden');
        checkData = true;
    }

    if(!checkData || !checkGender || !checkUser){
        document.querySelector('input[name="submit-aboutyou"]').style.cursor = "not allowed";
    }
    else{
        document.querySelector('input[name="submit-aboutyou"]').style.cursor = "pointer";
        document.querySelector('input[name="submit-aboutyou"]').disabled = false;
    }
}

function dbCheckUsername(json) {
    if (json.exists) {
      document.querySelector('.form-aboutyou .already-exist-div').classList.remove('hidden');
      document.querySelector('input[name="submit-aboutyou"]').disabled = true;
    }
    else{
        if(document.querySelector('.form-aboutyou .already-exist-div').classList != '.already-exist-div hidden'){
            document.querySelector('.form-aboutyou .already-exist-div').classList.add('hidden');    
        }

        if(checkData && checkGender && checkUser){
            document.querySelector('form').submit();
        }
        else{
            document.querySelector('input[name="submit-aboutyou"]').style.cursor = "not allowed";        
            document.querySelector('input[name="submit-aboutyou"]').disabled = true;
            if(!checkGender){
                document.querySelector("#error-gender").classList.remove('hidden');
            }
            if(!checkData){
                checkDate();
            }
            if(!checkUser){
                checkUsername();
            }
        }
    }
}

function checkSignup(event){
    const username = document.querySelector('input[name="username"]').value;
    fetch("./server/checkUsername.php?q="+encodeURIComponent(username)).then(fetchResponse).then(dbCheckUsername);
    event.preventDefault();
}

document.querySelector('input[name="email"]').addEventListener('input', checkEmail);
document.querySelector('input[name="submit-email"]').addEventListener('click', showFormPassword);
document.querySelector('#arrow-step1').addEventListener('click', backtoFormEmail);
document.querySelector('input[name="password"]').addEventListener('input', checkPassword);
document.querySelector('#arrow-step2').addEventListener('click', backtoFormPassword);
document.querySelector('input[name="submit-password"]').addEventListener('click', showFormAboutYou);
document.querySelector('input[name="username"]').addEventListener('input', checkUsername);
document.querySelector('input[name="day"]').addEventListener('input', checkDate);
document.querySelector('select[name="month"]').addEventListener('change', checkDate);
document.querySelector('input[name="year"]').addEventListener('input', checkDate);
document.querySelector('input[name="submit-aboutyou"]').addEventListener('click', checkSignup);

const allSvg = document.querySelectorAll('.insert-gender svg');
allSvg.forEach(svgElement => {
    svgElement.addEventListener('click', () => {
        allSvg.forEach(otherSvg => {
            if (otherSvg !== svgElement) {
                otherSvg.childNodes[1].className = '';
                otherSvg.childNodes[1].classList.add('hidden');
            }
        });
        svgElement.childNodes[1].classList.remove('hidden');
        if(document.querySelector("#error-gender").classList != 'hidden'){
            document.querySelector("#error-gender").classList.add('hidden');
        }
        checkGender = true;
        if(!checkData || !checkGender || !checkUser){
            document.querySelector('input[name="submit-aboutyou"]').style.cursor = "not allowed";
        }
        else{
            document.querySelector('input[name="submit-aboutyou"]').style.cursor = "pointer";
            document.querySelector('input[name="submit-aboutyou"]').disabled = false;
        }
    });
});