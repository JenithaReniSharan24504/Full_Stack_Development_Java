function login() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const message = document.getElementById("message");

    // Validation
    if (username === "" || password === "") {
        message.innerText = "Please fill all fields";
        return;
    }

    fetch("login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ username, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            message.style.color = "green";
            message.innerText = "Login Successful!";
        } else {
            message.style.color = "red";
            message.innerText = data.message;
        }
    })
    .catch(() => {
        message.innerText = "Server error";
    });
}