document.addEventListener("DOMContentLoaded", function() {
  // Fonction pour mettre à jour le total
  function updateTotal() {
    const nbPersonnes = document.getElementById('nbPersonnes').value;
    let total = window.voyageData.total_price * nbPersonnes;

    // Calcul des options ajoutées
    const selectedOptions = document.querySelectorAll('.option-checkbox:checked');
    selectedOptions.forEach(option => {
      // Exemple : Ajouter un prix supplémentaire pour les options
      if (option.value === "Voyage écologique") total += 200; // Exemple de coût pour l'option
      if (option.value === "Observation des manchots") total += 100; // Exemple de coût pour l'option
    });

    // Mise à jour de l'affichage du prix
    document.getElementById('prixTotal').innerText = total + " €";
  }

  // Event listener pour les changements
  document.getElementById('nbPersonnes').addEventListener('input', updateTotal);
  document.querySelectorAll('.option-checkbox').forEach(option => {
    option.addEventListener('change', updateTotal);
  });

  // Calcul initial du total
  updateTotal();
});

