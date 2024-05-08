
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

editButtons.forEach(button => {
    button.addEventListener('click', async event => {
        const giftRow = event.target.closest('.idGift');

        const inputFields = giftRow.querySelectorAll('.edit-input');
        const divFields = giftRow.querySelectorAll('.gift-name, .gift-description, .gift-category');

        inputFields.forEach(input => {
            const divToReplace = input.previousElementSibling;
            if (divToReplace) {
                divToReplace.style.display = 'none';
                input.style.display = 'block';
            }
        });

        const editIcon = giftRow.querySelector('.edit-button');
        const saveIcon = document.createElement('i');
        saveIcon.className = 'fa-regular fa-floppy-disk save-button';

        editIcon.replaceWith(saveIcon);

        saveIcon.addEventListener('click', async () => {
            const inputValues = {};
            inputFields.forEach(input => {
                inputValues[input.name] = input.value;
            });

            const formData = new FormData();
            console.log(inputValues);
            formData.append('id_gift', giftRow.dataset.id_gift);
            formData.append('name_gift', inputValues['name_gift']);
            formData.append('description_gift', inputValues['description_gift']);
            formData.append('name_category', inputValues['name_category']);
            formData.append('id_category', giftRow.dataset.id_category);

            try {
                const response = await fetch('editGift', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.text();

                // Send an AJAX request to fetch the updated gift data
                const updatedGiftResponse = await fetch('getUpdatedGift', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        id_gift: giftRow.dataset.id_gift,
                        id_category: giftRow.dataset.id_category
                    })
                });

                if (!updatedGiftResponse.ok) {
                    throw new Error(`HTTP error! status: ${updatedGiftResponse.status}`);
                }

                // Get the updated gift data from the AJAX response
                const updatedGiftData = await updatedGiftResponse.json();

                // Update the corresponding HTML elements in the DOM with the updated gift data
                const giftNameDiv = giftRow.querySelector('.gift-name');
                giftNameDiv.textContent = updatedGiftData.name_gift;

                const giftDescriptionDiv = giftRow.querySelector('.gift-description');
                giftDescriptionDiv.textContent = updatedGiftData.description_gift;

                const giftCategoryDiv = giftRow.querySelector('.gift-category');
                giftCategoryDiv.textContent = updatedGiftData.name_category;

                // Hide the input fields and display the div elements
                inputFields.forEach(input => {
                    const divToReplace = input.previousElementSibling;
                    if (divToReplace) {
                        divToReplace.style.display = 'block';
                        input.style.display = 'none';
                    }
                });

                const saveIcon = giftRow.querySelector('.save-button');
                const editIcon = document.createElement('i');
                editIcon.className = 'fa-regular fa-pen-to-square edit-button';

                saveIcon.replaceWith(editIcon);


            } catch (error) {
                console.error("The AJAX request failed:", error);
            }
        });
    });
});

function traitement(name_gift, description_gift, name_category) {
    // effectuer toute action nécessaire après la mise à jour réussie du cadeau
    console.log('Le cadeau a été mis à jour avec succès : ', name_gift, description_gift, name_category);
}

for (const editButton of editButtons) {
    editButton.addEventListener('click', async event => {
        const parentElement = event.target.closest('.idGift');
        if (parentElement) {
            parentElement.classList.toggle('editing');
        }
    });
}



// ############################################################
//                      DELETE GIFT
// ############################################################

const deleteButtons = document.querySelectorAll('.deleteGiftBtn');
deleteButtons.forEach(button => {
    button.addEventListener('click', event => {
        const row = event.target.closest('tr'); // récupérer la balise <tr> parent
        const giftId = row.dataset.id_gift; // récupérer l'ID du cadeau à partir de l'attribut data-id

        const xhr = new XMLHttpRequest();
        xhr.open("DELETE", "index.php?controller=Gift&action=deleteGift&id_gift=" + giftId, true);
        xhr.send();

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Supprimer la ligne correspondante dans le tableau HTML
                row.parentNode.removeChild(row);
            } else {
                console.error('La suppression du cadeau a échoué.');
            }
        };
    });
});