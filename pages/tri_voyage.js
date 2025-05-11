const voyages = [
    { titre: "Croisière Arctique", prix: 1500, date: "2025-07-01", etapes: 4 },
    { titre: "Trek Himalaya", prix: 1200, date: "2025-06-15", etapes: 6 },
    { titre: "Safari Kenya", prix: 1800, date: "2025-08-05", etapes: 5 }
];

// Fonction de tri
function trierVoyages(critere) {
    const listeTriee = [...voyages];

    switch (critere) {
        case "prix":
            listeTriee.sort((a, b) => a.prix - b.prix);
            break;
        case "date":
            listeTriee.sort((a, b) => new Date(a.date) - new Date(b.date));
            break;
        case "etapes":
            listeTriee.sort((a, b) => a.etapes - b.etapes);
            break;
        default:
            break;
    }

    afficherVoyages(listeTriee);
}

// Fonction d'affichage dans le DOM
function afficherVoyages(liste) {
    const container = document.getElementById("liste-voyages");
    container.innerHTML = ""; // Efface le contenu précédent

    liste.forEach(voyage => {
        const div = document.createElement("div");
        div.className = "voyage";
        div.innerHTML = `
            <h3>${voyage.titre}</h3>
            <p>Départ : ${voyage.date}</p>
            <p>Prix : ${voyage.prix} €</p>
            <p>Étapes : ${voyage.etapes}</p>
        `;
        container.appendChild(div);
    });
}

// Initialisation
document.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById("tri-select");
    select.addEventListener("change", (e) => trierVoyages(e.target.value));

    // Tri par défaut
    trierVoyages("prix");
});
