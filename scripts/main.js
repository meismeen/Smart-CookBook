// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}

// Form validations
document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.getElementById("registerForm");
    const loginForm = document.getElementById("loginForm");

    if (registerForm) {
        registerForm.addEventListener("submit", function (e) {
            const password = document.getElementById("password").value;
            const confirm = document.getElementById("confirm_password").value;

            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                e.preventDefault();
            }

            if (password !== confirm) {
                alert("Passwords do not match.");
                e.preventDefault();
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            const password = document.getElementById("password").value;

            if (password.trim() === "") {
                alert("Please enter your password.");
                e.preventDefault();
            }
        });
    }
});

// Recipe search filter
function filterRecipes() {
    const input = document.getElementById('recipeSearch').value.toLowerCase();
    const items = document.querySelectorAll('.recipe-item');

    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(input) ? '' : 'none';
    });
}
