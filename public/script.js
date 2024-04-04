const passwordField = document.getElementById("loginPassword");
const togglePassword = document.querySelector(".fa-eye");

togglePassword.addEventListener("click", function () {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
    }
});

const banner = document.querySelector('#banner');
const icon = '<i class="fa-solid fa-socks"></i>';
const maxWidth = 1000; // largeur maximale de la banderole en pixels
const iconWidth = 50; // largeur d'une icône en pixels
const iconMargin = 10; // marge entre les icônes en pixels

let currentWidth = 0;

while (currentWidth < maxWidth) {
    banner.innerHTML += icon;
    currentWidth += iconWidth + iconMargin;
}
