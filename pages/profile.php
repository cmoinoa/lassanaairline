<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dark">

<!-- Bouton de thème -->
<button id="toggle-theme" style="position: fixed; top: 10px; right: 10px;">Changer de thème</button>

<div class="container">
    <h1>Mon profil</h1>

    <form id="form-profile">
        <div data-editable>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="Jean" disabled>
            <button type="button" class="edit-btn">✏️</button>
            <button type="button" class="save-btn" style="display: none;">✅</button>
            <button type="button" class="cancel-btn" style="display: none;">❌</button>
        </div>

        <div data-editable>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="jean@example.com" disabled>
            <button type="button" class="edit-btn">✏️</button>
            <button type="button" class="save-btn" style="display: none;">✅</button>
            <button type="button" class="cancel-btn" style="display: none;">❌</button>
        </div>

        <button id="submit-profile" type="submit" style="display: none;">Soumettre</button>
        <div id="profil-feedback" style="margin-top:10px;"></div>
    </form>
</div>

<!-- JS: thème + profil -->
<script src="js/theme.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-profile");
  const feedback = document.getElementById("profil-feedback");

  document.querySelectorAll("[data-editable]").forEach(field => {
    const input = field.querySelector("input");
    const originalValue = input.value;
    const editBtn = field.querySelector(".edit-btn");
    const saveBtn = field.querySelector(".save-btn");
    const cancelBtn = field.querySelector(".cancel-btn");

    input.disabled = true;

    editBtn.addEventListener("click", () => {
      input.disabled = false;
      editBtn.style.display = "none";
      saveBtn.style.display = "inline-block";
      cancelBtn.style.display = "inline-block";
    });

    cancelBtn.addEventListener("click", () => {
      input.value = originalValue;
      input.disabled = true;
      saveBtn.style.display = "none";
      cancelBtn.style.display = "none";
      editBtn.style.display = "inline-block";
    });

    saveBtn.addEventListener("click", () => {
      input.disabled = true;
      saveBtn.style.display = "none";
      cancelBtn.style.display = "none";
      editBtn.style.display = "inline-block";
      document.getElementById("submit-profile").style.display = "block";
    });
  });

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    fetch("update_profil.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        feedback.textContent = "Profil mis à jour avec succès.";
        feedback.style.color = "green";
        document.getElementById("submit-profile").style.display = "none";
      } else {
        feedback.textContent = "Erreur : " + data.message;
        feedback.style.color = "red";
      }
    })
    .catch(() => {
      feedback.textContent = "Erreur réseau.";
      feedback.style.color = "red";
    });
  });
});
</script>
</body>
</html>
