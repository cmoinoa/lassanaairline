// Fonction pour charger les données à partir du fichier JSON
function chargerVoyages() {
    fetch('trips.json')
        .then(response => response.json())
        .then(voyages => {
            // Stocke les voyages dans une variable globale
            window.voyages = voyages;
            afficherVoyages();  // Afficher les voyages au chargement
        })
        .catch(error => console.error("Erreur de chargement des voyages :", error));
}

// Fonction pour trier les voyages selon un critère spécifique
function trierVoyages(critere) {
    // On trie les voyages en fonction du critère
    window.voyages.sort((a, b) => {
        let valA, valB;

        // Tri par prix
        if (critere === "prix") {
            valA = a.total_price;
            valB = b.total_price;
        }
        // Tri par date de début
        else if (critere === "date") {
            valA = new Date(a.dates.start);
            valB = new Date(b.dates.start);
        }
        // Tri par nombre d'étapes
        else if (critere === "etapes") {
            valA = a.steps.length;
            valB = b.steps.length;
        }

        // Comparaison
        if (valA > valB) {
            return 1;
        } else if (valA < valB) {
            return -1;
        } else {
            return 0;
        }
    });

    afficherVoyages();  // Afficher les voyages triés
}

// Fonction pour afficher les voyages dans le DOM
function afficherVoyages() {
    const container = document.getElementById("liste-voyages");
    container.innerHTML = ""; // Vider l'affichage actuel

    window.voyages.forEach(voyage => {
        const div = document.createElement("div");
        div.classList.add("voyage");

        div.innerHTML = `
            <h3>${voyage.title}</h3>
            <img src="${voyage.banner}" alt="${voyage.title}" />
            <p><strong>Dates :</strong> ${voyage.dates.start} - ${voyage.dates.end}</p>
            <p><strong>Durée :</strong> ${voyage.dates.duration}</p>
            <p><strong>Étapes :</strong> ${voyage.steps.join(", ")}</p>
            <p><strong>Description :</strong> ${voyage.description}</p>
            <p><strong>Prix :</strong> ${voyage.total_price} €</p>
        `;

        container.appendChild(div);
    });
}

// Initialisation
document.addEventListener("DOMContentLoaded", () => {
    chargerVoyages();  // Charger les voyages au démarrage

    // Lorsque l'utilisateur change le critère de tri
    const select = document.getElementById("tri-select");
    if (select) {
        select.addEventListener("change", (e) => trierVoyages(e.target.value));
    }
});
