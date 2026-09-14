console.log("Mahir");

function validate(event) {

    var username = document.getElementById('email').value.trim();
    var password = document.getElementById('pass').value.trim();

    if (username === "") {

        document.getElementById('error').innerText = "Please enter your username.";
        event.preventDefault();
        return;
    }

    if (password === "") {
        document.getElementById('error').innerText = "Please enter your password.";
        event.preventDefault();
        return;
    }

    // Everything is valid
    error.innerText = "";
}

document.getElementById('loginForm').addEventListener("submit", validate);