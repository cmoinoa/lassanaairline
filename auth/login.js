// login.js

document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const loginInput = document.querySelector("#login");
  const passwordInput = document.querySelector("#password");
  const errorBox = document.querySelector("#error-message");

  // Ajout d'un compteur de caractères si le champ login est limité
  const loginCounter = document.createElement("span");
  loginCounter.id = "login-counter";
  loginInput.after(loginCounter);

  loginInput.addEventListener("input", () => {
    loginCounter.textContent = `${loginInput.value.length} caractères`;
  });

  // Icône œil pour afficher/masquer le mot de passe
  const eyeIcon = document.createElement("span");
  eyeIcon.innerHTML = "👁️";
  eyeIcon.style.cursor = "pointer";
  passwordInput.after(eyeIcon);

  eyeIcon.addEventListener("click", () => {
    const type = passwordInput.getAttribute("type");
    passwordInput.setAttribute("type", type === "password" ? "text" : "password");
  });

  // Validation du formulaire
  form.addEventListener("submit", (e) => {
    errorBox.textContent = "";
    if (!loginInput.value.trim() || !passwordInput.value.trim()) {
      e.preventDefault();
      errorBox.textContent = "Veuillez remplir tous les champs.";
    }
  });
});
