document.addEventListener("DOMContentLoaded", function() {
 
  function updateTotal() {
    const nbPersonnes = document.getElementById('nbPersonnes').value;
    let total = window.voyageData.total_price * nbPersonnes;
    
    const selectedOptions = document.querySelectorAll('.option-checkbox:checked');
    selectedOptions.forEach(option => {
      if (option.value === "Voyage écologique") total += 200; // Exemple de coût pour l'option
      if (option.value === "Observation des manchots") total += 100; // Exemple de coût pour l'option
    });
    document.getElementById('prixTotal').innerText = total + " €";
  }
  document.getElementById('nbPersonnes').addEventListener('input', updateTotal);
  document.querySelectorAll('.option-checkbox').forEach(option => {
    option.addEventListener('change', updateTotal);
  });
  updateTotal();
});

