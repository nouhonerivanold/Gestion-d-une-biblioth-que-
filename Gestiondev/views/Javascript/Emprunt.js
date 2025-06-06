let panier = [];

document.addEventListener('DOMContentLoaded', function() {
    // Ajouter au panier
    document.getElementById('ajouterPanier').addEventListener('click', function(e) {
        e.preventDefault();
        
        const livreId = document.getElementById('livre').value;
        const livreTitre = document.getElementById('livre').options[document.getElementById('livre').selectedIndex].text;
        const qte = parseInt(document.getElementById('qte').value);
        const date = document.getElementById('date').value;
        const adherentId = document.getElementById('adherent').value;

        // if (!livreId || !qte || !date || !adherentId) {
        //     alert('Veuillez remplir tous les champs');
        //     return;
        // }

        // Vérifier si le livre est déjà dans le panier
        const index = panier.findIndex(item => item.livreId === livreId);
        if (index > -1) {
            panier[index].qte += qte;
        } else {
            panier.push({
                livreId,
                livreTitre,
                qte,
                date,
                adherentId
            });
        }

        mettreAJourPanier();
    });

    // Soumission finale
    document.getElementById('soumissionFinale').addEventListener('click', function(e) {
        e.preventDefault();
        
        if (panier.length === 0) {
            alert('Le panier est vide');
            return;
        }

        // Créer un champ caché avec les données du panier
        const inputCache = document.createElement('input');
        inputCache.type = 'hidden';
        inputCache.name = 'panier';
        inputCache.value = JSON.stringify(panier);
        document.querySelector('form').appendChild(inputCache);

        // Soumettre le formulaire
        document.querySelector('form').submit();
    });
});

function mettreAJourPanier() {
    const panierElement = document.querySelector('.panier ul');
    panierElement.innerHTML = '';

    panier.forEach((item, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            ${item.livreTitre} - Quantité: ${item.qte} - Date: ${item.date}
            <button class="modifier" data-index="${index}">Modifier</button>
            <button class="supprimer" data-index="${index}">Supprimer</button>
        `;
        panierElement.appendChild(li);
    });

    // Gestion des boutons supprimer
    document.querySelectorAll('.supprimer').forEach(btn => {
        btn.addEventListener('click', function() {
            panier.splice(parseInt(this.dataset.index), 1);
            mettreAJourPanier();
        });
    });

    // Gestion des boutons modifier
    document.querySelectorAll('.modifier').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = panier[parseInt(this.dataset.index)];
            document.getElementById('livre').value = item.livreId;
            document.getElementById('qte').value = item.qte;
            document.getElementById('date').value = item.date;
            panier.splice(parseInt(this.dataset.index), 1);
            mettreAJourPanier();
        });
    });
}