console.log("JavaScript is working");

function validate(event){
    var name=document.getElementById('name').value;
    var email=document.getElementById('email').value;
    var phone=document.getElementById('phone').value;
    var salary=document.getElementById('salary').value;
    var jd=document.getElementById('joiningDate').value;

    const regexName = /^[A-Za-z]+(?: [A-Za-z]+)*$/;
    const emailregex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9]{11}$/;

    if(name.length<3){
        document.getElementById('error').innerText="name Must contain atleast 3 character.";
        event.preventDefault();
        return ;
    }


    if(!regexName.test(name)){
        document.getElementById('error').innerText="name Must contain Only Uppercase or lower case letters.";
        event.preventDefault();
        return ;
    }

    
    if(!emailregex.test(email)){
        document.getElementById('error').innerText="Enter a valid Email.";
        event.preventDefault();
        return ;
    }

    if(!phoneRegex.test(phone)){
        document.getElementById('error').innerText="  Phone Number Must be valid\nand must contain 11 digits";
        event.preventDefault();
        return ;
    }

    if (salary === "") {

        document.getElementById('error').innerText = "Please enter the salary.";
        event.preventDefault();
        return;
    }

    if (jd === "") {

        document.getElementById('error').innerText = "Select a joining date.";
        event.preventDefault();
        return;
    }

    // document.getElementById('error').innerText="";
    
}

document.getElementById('managerForm').addEventListener("submit",validate);

