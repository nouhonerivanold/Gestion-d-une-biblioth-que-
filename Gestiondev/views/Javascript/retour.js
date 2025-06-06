
    // }
function ChangerListeEmprunt(){
    let id_adh = document.getElementById('adherent').value;
    window.location.href = `./retour.php?id=${encodeURIComponent(id_adh)}`;
}

let emprunts = [];
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const empruntId = parseInt(this.value);
        const empruntItem = this.closest('.emprunt-item');
        
        if (this.checked) {
            emprunts.push(empruntId);
            empruntItem.style.backgroundColor = '#f0f8ff';
        } else {
            const index = emprunts.indexOf(empruntId);
            if (index > -1) {
                emprunts.splice(index, 1);
            }
            empruntItem.style.backgroundColor = '';
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const formulaire = document.getElementById('monFormulaire');
    
    formulaire.addEventListener('submit', function(e) {
        e.preventDefault();
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'tableauEmprunts';

        hiddenInput.value = JSON.stringify(emprunts);
        console.log(hiddenInput.value);
        // Ajout du champ au formulaire
        formulaire.appendChild(hiddenInput);
        // Empêche l'envoi normal
        formulaire.submit();
        // Envoi via Fetch API (méthode moderne)
        fetch(formulaire.action, {
            method: 'POST',
            body: new FormData(formulaire)
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    });
});


// document.getElementById("soumission").addEventListener('submit', (event)=>{
//     event.preventDefault();
//     let form = document.getElementsByName("form");
//     form.item = 'input'
//     window.location.href = `../controller/controllerRetour.php?tableauEmprunts=${encodeURIComponent(emprunts)}`;

// });