document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-profile");
  const feedback = document.getElementById("profil-feedback");

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
