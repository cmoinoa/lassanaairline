function chargerVoyages() {
    fetch('trips.json')
        .then(response => response.json())
        .then(voyages => {
          
            window.voyages = voyages;
            afficherVoyages(); 
        })
        .catch(error => console.error("Erreur de chargement des voyages :", error));
}


function trierVoyages(critere) {
  
    window.voyages.sort((a, b) => {
        let valA, valB;

     
        if (critere === "prix") {
            valA = a.total_price;
            valB = b.total_price;
        }
     
        else if (critere === "date") {
            valA = new Date(a.dates.start);
            valB = new Date(b.dates.start);
        }
     
        else if (critere === "etapes") {
            valA = a.steps.length;
            valB = b.steps.length;
        }

   
        if (valA > valB) {
            return 1;
        } else if (valA < valB) {
            return -1;
        } else {
            return 0;
        }
    });

    afficherVoyages();  /
}


function afficherVoyages() {
    const container = document.getElementById("liste-voyages");
    container.innerHTML = ""; 
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


document.addEventListener("DOMContentLoaded", () => {
    chargerVoyages();  // Charger les voyages au démarrage

    
    const select = document.getElementById("tri-select");
    if (select) {
        select.addEventListener("change", (e) => trierVoyages(e.target.value));
    }
});
