<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Lassana Airlines</title>
    <link rel="stylesheet" href="css/lassana airlines.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        .profile-box, .search-box {
            position: absolute;
            top: 20px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }
        .profile-box {
            right: 20px;
        }
        .search-box {
            left: 20px;
        }
        .profile-link, .search-box input {
            color: #ffcc70;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s, transform 0.2s;
        }
        .profile-link:hover {
            color: #ffb347;
            transform: scale(1.1);
        }
        .search-box input {
            background: transparent;
            border: none;
            outline: none;
            color: #ffcc70;
            font-size: 1rem;
        }
        .search-box input::placeholder {
            color: #ffcc70;
        }
        header {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <div class="search-box">
            <input type="text" placeholder="Rechercher...">
        </div>
        <h1>Mon Profil</h1>
        <p style="text-align: center; display: block; width: 100%;">Gérez vos informations personnelles</p>
        <div class="profile-box">
            <a href="#" class="profile-link"><i class="fas fa-user"></i> Mon Profil</a>
        </div>
    </header>
    <main>
        <section class="profile-container">
            <div class="profile-header">
                <img src="profile.jpg" alt="Photo de profil" class="profile-pic">
                <button class="edit-btn"><i class="fas fa-camera"></i></button>
            </div>
            <div class="profile-info">
                <label>Nom :</label>
                <p id="nom">Dupont <button class="edit-btn" onclick="editField('nom')"><i class="fas fa-pencil-alt"></i></button></p>
                
                <label>Prénom :</label>
                <p id="prenom">Jean <button class="edit-btn" onclick="editField('prenom')"><i class="fas fa-pencil-alt"></i></button></p>

                <label>Email :</label>
                <p id="email">jean.dupont@example.com <button class="edit-btn" onclick="editField('email')"><i class="fas fa-pencil-alt"></i></button></p>

                <label>Mot de passe :</label>
                <p>******** <button class="edit-btn"><i class="fas fa-pencil-alt"></i></button></p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Lassana Airlines - Tous droits réservés</p>
    </footer>

    <script>
        function editField(fieldId) {
            let field = document.getElementById(fieldId);
            let currentValue = field.innerText;
            let newValue = prompt("Modifier " + fieldId + " :", currentValue);
            if (newValue !== null && newValue !== "") {
                field.innerHTML = newValue + ' <button class="edit-btn" onclick="editField(\'' + fieldId + '\')"><i class="fas fa-pencil-alt"></i></button>';
            }
        }
    </script>
</body>
</html>
