//Première version
//+version avec date
//Pensez à rajoutez ce code dans DisclaimerGestionTable
//<label for="start">Veuillez entrez votre date de naissance:</label>
//<input type="date" id="start" name="trip-start"><br>
// $("#monModal").modal({
//     escapeClose: false,
//     clickClose: false,
//     showClose: false
//  });

//  $("#start").keyup(function(e){
//     //e.preventDefault();
//     var date = $("start").attr('value');
//     if (e.keyCode == "13")
//     {
//         var now = new Date();


//         var inputDate = new Date ($("#start").val());

//         var diff = new Date(now.getTime() - inputDate.getTime());

//         var age = Math.abs(diff.getUTCFullYear() - 1970);

//         if (age >= 18)
//         {
//             $("#monModal").html(`<p>Bonne visite sur notre site.</p><a href="" type="button" rel="modal:close" class="btn-green" id="actionDisclaimer">Oui</a>`);

//         }

//         else
//         {
//             $("#monModal").html("Vous n'avez pas l'âge requis, nous allons vous rediriger vers $lien_redirection");
//             console.log("Vous avez "+age+" ans. Vous n'avez pas l'âge requis, nous allons vous rediriger vers http://google.com");
//             // document.location.href="http://google.com";
//             // console.log("Année:.....(" +now.getFullYear()+")");
//             // console.log("Valeur variable now.....(" +now+ ")");
//             // console.log(now.getUTCFullYear());
//             // console.log("Valeur variable inputDate.....(" +inputDate+ ")");
//             // console.log("Valeur variable diff.....(" +diff+ ")");
//             // console.log("Valeur variable age.....(" +age+ ")");
//             // document.location.href="http://google.com";
//         }

        
//     }
    
//  })

//Version livrable
jQuery(document).ready(function($)
{//Affiche le modal si la valeur du cookie est différente
    if(lireUnCookie('eu-disclaimer-vapobar') !="ejD86j7ZXF3x")
    {
        $("#monModal").modal({
        escapeClose: false,
        clickClose: false,
        showClose: false
     });
    }
});

function creerUnCookie(nomCookie, valeurCookie, dureeJours)
{
     // Si le nombre de jours est spécifié
     if(dureeJours)
     {
        var date = new Date();
        // Converti le nombre de jours spécifiés en millisecondes
        date.setTime(date.getTime()+(dureeJours * 24*60*60*1000));
        var expire = "; expire="+date.toGMTString();
     }
     // Si aucune valeur de jour n'est spécifiée
     else
     {
        var expire = "";
   
     }

     document.cookie = nomCookie + "=" + valeurCookie +  expire + "; path=/";

}
    
    function lireUnCookie(nomCookie)
    {
        // Ajoute le signe égale virgule au nom pour la recherche dans le tableau conteant tous les cookies
        var nomFormate = nomCookie + "=";

        // tableau contenant tous les cookies
        var tableauCookies = document.cookie.split(';');

        // Recherche dans le tableau le cookie en question

        for(var i=0; i < tableauCookies.length; i++) 
        {
            var cookieTrouve = tableauCookies[i];
            // Tant que l'on trouve un espace on le supprime
            while (cookieTrouve.charAt(0) == ' ') 
            {
                cookieTrouve = cookieTrouve.substring(1, cookieTrouve.length);
            }

            if(cookieTrouve.indexOf(nomFormate) == 0)
            {
                return cookieTrouve.substring(nomFormate.length, cookieTrouve.length);
            }
        }

        // On retourne une valeur null dans le cas où aucun cookie n'est trouvé
        return null;
    }

    document.getElementById("actionDisclaimer").addEventListener("click", accepterLeDisclaimer); 
    // Création d'une fonction que l'on va associer au bouton Oui de notre modal par le biais de onclick.

    function accepterLeDisclaimer()
    {
        creerUnCookie('eu-disclaimer-vapobar', "ejD86j7ZXF3x", 1);
        var cookie = lireUnCookie('eu-disclaimer-vapobar');
        alert(cookie);
        console.log("Valeur du cookie.....(" +cookie+ ")");

    }