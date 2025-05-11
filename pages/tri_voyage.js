function trierVoyages(critere) {
    const container = document.getElementById("liste-voyages");
    const voyagesHTML = Array.from(container.querySelectorAll(".voyage"));

    const voyagesTries = voyagesHTML.sort((a, b) => {
        let valA = a.dataset[critere];
        let valB = b.dataset[critere];

        // Convertir les types si nécessaire
        if (critere === "prix" || critere === "etapes") {
            valA = parseFloat(valA);
            valB = parseFloat(valB);
        } else if (critere === "date") {
            valA = new Date(valA);
            valB = new Date(valB);
        }

        return valA > valB ? 1 : -1;
    });

    // Réaffichage trié
    container.innerHTML = "";
    voyagesTries.forEach(v => container.appendChild(v));
}

// Initialisation
document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById("tri-select");
    if (select) {
        select.addEventListener("change", (e) => trierVoyages(e.target.value));
        trierVoyages(select.value); // tri initial
    }
});
