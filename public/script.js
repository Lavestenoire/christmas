
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
//                CONFIRMATION SUPPRESSION USER
// ############################################################
function deleteConfirmUser() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var message = "<p>Tu es sur de vouloir supprimer?</p>"
            message += "<form action='deleteUser'>"
            message += "<button type='submit' name='deleteUser' class='button-paper lutinBtn deleteOui' role='button'>Oui</button>"
            message += "<button class='button-paper lutinBtn deleteNon' onclick='cancelDeleteUser()'>Non</button>"
            message += "</form>"
            document.getElementById("deleteConfirmUser").innerHTML = message;
        }
    };
    xmlhttp.open("GET", "profileUser", true);
    xmlhttp.send();
}
function cancelDeleteUser() {
    document.getElementById("deleteConfirmUser").innerHTML = ""; // Efface le message de confirmation
}

// ############################################################
//                CONFIRMATION SUPPRESSION ACCOUNT
// ############################################################
function deleteConfirmAccount() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var message = "<p>Tu es sur de vouloir supprimer?</p>"
            message += "<form action='deleteAccount'>"
            message += "<button type='submit' name='deleteAccount' class='button-paper lutinBtn deleteOui' role='button'>Oui</button>"
            message += "<button class='button-paper lutinBtn deleteNon' onclick='cancelDeleteAccount()'>Non</button>"
            message += "</form>"
            document.getElementById("deleteConfirmAccount").innerHTML = message;
        }
    };
    xmlhttp.open("GET", "profileAccount", true);
    xmlhttp.send();
}
function cancelDeleteAccount() {
    document.getElementById("deleteConfirmAccount").innerHTML = ""; // Efface le message de confirmation
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

function cancelEditProfileUser() {
    var editForm = document.querySelector(".editUser");
    editForm.style.display = "none";
}

// ########################################
//           EDIT PROFILE ACCOUNT
// ########################################
function editProfileAccount() {
    var editForm = document.querySelector(".editAccount");
    editForm.style.display = "block";
}

function confirmEditProfileAccount() {
    var editForm = document.querySelector(".editAccount");
    editForm.style.display = "none";
}

function cancelEditProfileAccount() {
    var editForm = document.querySelector(".editAccount");
    editForm.style.display = "none";
}
// function editAccountForm() {
//     var editAccountForm = document.querySelector('.editAccountForm');
//     editAccountForm.style.display = "block";
// }

// function cancelEditAccount() {
//     var cancelBtn = document.querySelector('.editAccountForm');
//     cancelBtn.style.display = "none";
// }

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
        // Remplacer l'icône "edit" par l'icône "save"
        editIcon.replaceWith(saveIcon);

        saveIcon.addEventListener('click', () => {
            console.log('L\'icône "save" a été cliquée !');
            // Récupérer les valeurs des champs input
            const inputValues = {};
            inputFields.forEach(input => {
                inputValues[input.name] = input.value;
            });

            const formData = new FormData();
            formData.append('id_gift', inputValues['id_gift']);
            formData.append('name_gift', inputValues['name_gift']);
            formData.append('description_gift', inputValues['description_gift']);
            formData.append('name_category', inputValues['name_category']);
            formData.append('id_category', inputValues['id_category']);

            const xhr = new XMLHttpRequest(); // create a new XMLHttpRequest object
            xhr.open("UPDATE", "index.php?controller=Gift&action=editGift/" + giftId);
            xhr.send(formData);

            xhr.onload = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log("La requête AJAX a réussi !");
                    // Masquer les champs input et afficher les divs d'origine
                    inputFields.forEach(input => {
                        input.style.display = 'none';
                        input.previousElementSibling.style.display = 'block';
                    });
                    // Remplacer l'icône "save" par l'icône "edit"
                    giftRow.querySelector('.save-button').replaceWith(editIcon);
                    // Appeler la fonction traitement() avec les valeurs mises à jour
                    traitement(inputValues['id_gift'], inputValues['description_gift'], inputValues['name_category'], inputValues['id_category']);
                } else {
                    console.error("La requête AJAX a échoué avec le statut " + xhr.status);
                }
            };
            function traitement(id_gift, name_gift, description_gift, name_category, id_category) {
                // effectuer toute action nécessaire après la mise à jour réussie du cadeau
                console.log('Le cadeau a été mis à jour avec succès : ', id_gift, name_gift, description_gift, name_category, id_category);
            }

            xhr.onerror = function () {
                console.error("La requête AJAX a échoué");
            };

        });
    });
});

// ############################################################
//                      DELETE GIFT
// ############################################################

const deleteButtons = document.querySelectorAll('.deleteGiftBtn');
deleteButtons.forEach(button => {
    button.addEventListener('click', event => {
        // Lire le corps de la requête
        $input = file_get_contents('php://input');

        // Parse les données en utilisant parse_str
        parse_str($input, $data);

        // Accéder aux données
        $name_gift = $data['name_gift'];
        $description_gift = $data['description_gift'];
        $name_category = $data['name_category'];
        $id_category = $data['id_category'];

        const giftId = event.target.dataset.id;

        const xhr = new XMLHttpRequest();
        xhr.open("DELETE", "index.php?controller=Gift&action=deleteGift/" + giftId);
        xhr.send();

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Supprimer la ligne correspondante dans le tableau HTML
                const row = event.target.closest('tr');
                row.parentNode.removeChild(row);
            } else {
                console.error('La suppression du cadeau a échoué.');
            }
        };
    });
});





