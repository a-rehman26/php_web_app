const API = window.location.origin + "/freelance_projectsss/test_project_1/backend/api";

// LOGIN FUNCTION (GLOBAL)
function login() {
    fetch(`${API}/auth/login.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            username: document.getElementById("username").value.trim(),
            password: document.getElementById("password").value.trim()
        })
    })
        .then(r => r.json())
        .then(d => {
            if (d.status === "success") {
                location.href = "index.html";
            } else {
                document.getElementById("msg").innerText = d.message;
            }
        });
}

// SIGNUP FUNCTION
function signup() {
    fetch(`${API}/auth/signup.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            name: document.getElementById("name").value.trim(),
            username: document.getElementById("username").value.trim(),
            email: document.getElementById("email").value.trim(),
            password: document.getElementById("password").value.trim()
        })
    })
        .then(r => r.json())
        .then(d => {
            document.getElementById("msg").innerText = d.message;
        });
}
