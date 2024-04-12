// OEIL SUR CHAMPS INPUT
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




// AUTO COMPLETION INPUT CATEGORY
function showHint(str) {
    if (str.length == 0) {
        document.getElementById("suggestions").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var categories = JSON.parse(this.responseText);
                var suggestionsHTML = "<ul>";
                categories.forEach(function (category) {
                    suggestionsHTML += "<li onclick='selectCategory(\"" + category.name_category + "\")'>" + category.name_category + "</li>";
                });
                suggestionsHTML += "</ul>";
                document.getElementById("suggestions").innerHTML = suggestionsHTML;
            }
        };
        xmlhttp.open("GET", "getCategoryHint?q=" + str, true);
        xmlhttp.send();
    }
}
// mettre à jour le champ de saisie lorsque l'utilisateur sélectionne une option dans le menu déroulant
function selectCategory(category) {
    document.getElementById("category_gift").value = category;
    document.getElementById("suggestions").innerHTML = ""; // Effacer les suggestions après la sélection
}


// DELETE CONFIRMATION
function deleteConfirm() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var message = "<p>Tu es sur de vouloir supprimer?</p>"
            message += "<form action='deleteUser'>"
            message += "<button type='submit' name='deleteUser' class='button-paper' role='button'>Oui</button>"
            message += "<button class='button-paper' onclick='cancelDelete()'>Non</button>"
            message += "</form>"
            document.getElementById("deleteConfirm").innerHTML = message;
        }
    };
    xmlhttp.open("GET", "profileUser", true);
    xmlhttp.send();
}
function cancelDelete() {
    document.getElementById("deleteConfirm").innerHTML = ""; // Efface le message de confirmation
}

// COUNTDOWN
// Set the date we're counting down to
var countDownDate = new Date("Dec 24, 2024 22:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function () {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    document.getElementById("countDown").innerHTML = days + "jours " + hours + "h "
        + minutes + "m " + seconds + "s avant Noël";

    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countDown").innerHTML = "EXPIRED";
    }
}, 1000);