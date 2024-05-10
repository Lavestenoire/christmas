
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

// It takes a string str as input.
// If the input string is empty, it clears the suggestions element and returns.
// It makes a fetch request to a server-side endpoint getCategoryHint with a query parameter q set to the first character of the input string (lowercased).
// It parses the response as JSON and filters the categories to only include those that start with the input string (case-insensitive).
// It generates an HTML string to display the filtered categories as a list, with each list item having an onclick event handler that calls the selectCategory function when clicked.
// It sets the innerHTML of the suggestions element to the generated HTML string.
function autoCompletion(str) {
    if (str.length === 0) {
        document.getElementById("suggestions").innerHTML = "";
        return;
    }
    // on envoie grâce ) l'api fetch une requete au serveur en ajoutant une chaine de requête
    fetch(`getCategoryHint?search=${str.toLowerCase().charAt(0)}`)
        // Le serveur renvoie une réponse au format JSON, qui est ensuite convertie en un objet JavaScript grâce à la méthode json().
        .then(response => response.json())
        .then(categories => {
            // La méthode filter() est une méthode d'array (tableau) en JavaScript qui permet de créer un nouveau tableau contenant uniquement les éléments qui remplissent une certaine condition.
            const filteredCategories = categories.filter(category => category.name_category.toLowerCase().startsWith(str.toLowerCase()));
            const suggestionsHTML = `
            <ul>
            ${filteredCategories.map(category => `
                <li onclick="selectCategory('${category.name_category}')">
                ${category.name_category}
                </li>
            `).join('')}
            </ul>
        `;
            // La méthode map() est utilisée pour créer une chaîne de caractères suggestionsHTML contenant une liste HTML représentant chaque catégorie du tableau filteredCategories.
            // la méthode join est appelée sur le tableau envoyé par la méthode map, et sert à concaténer les chaines de caractère en une seule.
            // si on ne fait pas ça, alors un tableau est renvoyé

            // Set the innerHTML of the suggestions element to the generated HTML string
            document.getElementById("suggestions").innerHTML = suggestionsHTML;
        })
        .catch(error => console.error('Error fetching categories:', error));
}

function selectCategory(category) {
    document.getElementById("category_gift").value = category;
    document.getElementById("suggestions").innerHTML = "";
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


// ########################################
//           EDIT GIFT
// ########################################

const editButtons = document.querySelectorAll('.edit-button');
// ajouter un écouteur d'événement au clic sur les boutons
editButtons.forEach(button => {
    button.addEventListener('click', async event => {
        // récupérer le plus proche élément parent avec la classe editGift
        const giftRow = event.target.closest('.idGift');


        const inputFields = giftRow.querySelectorAll('.edit-input');
        // const divFields = giftRow.querySelectorAll('.gift-name, .gift-description, .gift-category');


        // pour chaque input, s'il y a un élément avant, passer cet élément en none et l'input en block
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

        // remplacer l'icone edit par l'icone save
        editIcon.replaceWith(saveIcon);

        // écouteur d'événement au clic: pour chaque input, récupérer sa valeur
        saveIcon.addEventListener('click', async () => {
            const inputValues = {};
            inputFields.forEach(input => {
                inputValues[input.name] = input.value;
            });

            // créer un objet formData pour envoyer les données des input en POST via une requête ajax
            const formData = new FormData();
            console.log(inputValues);
            formData.append('id_gift', giftRow.dataset.id_gift);
            formData.append('name_gift', inputValues['name_gift']);
            formData.append('description_gift', inputValues['description_gift']);
            formData.append('name_category', inputValues['name_category']);
            formData.append('id_category', giftRow.dataset.id_category);

            try {
                // envoyer une requête ajax pour update le cadeau
                const response = await fetch('editGift', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                // const data = await response.text();

                // envoyer une requête ajax pour récupérer le cadeau mis à jour
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