document.getElementById("registerForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    fetch("register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        const registerMessage = document.getElementById("registerMessage");
        registerMessage.textContent = data.message;
        registerMessage.style.color = data.success ? "green" : "red";
    })
    .catch(error => {
        console.error("Error:", error);
    });
});
