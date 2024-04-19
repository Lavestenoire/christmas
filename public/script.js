
// ############################################################
//                OEIL SUR CHAMPS INPUT
// ############################################################
const togglePasswords = document.querySelectorAll(".fa-eye");

togglePasswords.forEach(function (togglePassword) {
    togglePassword.addEventListener("click", function () {
        const passwordField = togglePassword.closest('.mdp').querySelector('.loginPassword');

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
});





// ############################################################
//                AUTO COMPLETION INPUT CATEGORY
// ############################################################
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


// ############################################################
//                CONFIRMATION SUPPRESION PROFIL
// ############################################################
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



// ########################################
//           EDIT PROFILE USER
// ########################################
function editProfileUser() {
    var editForm = document.querySelector(".editUser");
    editForm.style.display = "block";
}

function confirmEditProfileUser() {
    var editForm = document.querySelector(".editUser");
    editForm.style.display = "none";
}

// ########################################
//           EDIT GIFT
// ########################################
// Sélectionner tous les boutons "edit"
const editButtons = document.querySelectorAll('.edit-button');

// Ajouter un écouteur d'événement de clic à chaque bouton "edit"
editButtons.forEach(button => {
    button.addEventListener('click', event => {
        // Récupérer l'ID du cadeau à modifier à partir de l'attribut data-id du bouton "edit"
        const giftId = event.target.dataset.id;

        // Sélectionner la ligne correspondante dans le tableau
        const giftRow = event.target.closest('.idGift');

        // Sélectionner tous les champs input cachés dans la ligne
        const inputFields = giftRow.querySelectorAll('.edit-input');

        // Afficher les champs input en remplaçant les divs correspondants
        inputFields.forEach(input => {
            // Sélectionner le div correspondant à remplacer
            const divToReplace = input.previousElementSibling;

            // Remplacer le div par le champ input
            divToReplace.style.display = 'none';
            input.style.display = 'block';
        });

        // Remplacer l'icône "edit" par l'icône "save"
        const editIcon = giftRow.querySelector('.edit-button');
        const saveIcon = document.createElement('i');
        saveIcon.className = 'fa-regular fa-floppy-disk save-button';
        saveIcon.addEventListener('click', () => {
            // Récupérer les valeurs des champs input
            const inputValues = {};
            inputFields.forEach(input => {
                inputValues[input.name] = input.value;
            });

            // Envoyer les valeurs au serveur pour mise à jour dans la base de données
            // ...

            // Masquer les champs input et afficher les divs d'origine
            inputFields.forEach(input => {
                input.style.display = 'none';
                input.previousElementSibling.style.display = 'block';
            });

            // Remplacer l'icône "save" par l'icône "edit"
            giftRow.querySelector('.save-button').replaceWith(editIcon);
        });

        // Remplacer l'icône "edit" par l'icône "save"
        editIcon.replaceWith(saveIcon);
    });
});
