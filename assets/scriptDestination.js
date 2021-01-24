// Afficher le formulaire d'ajout ou de modification, selon le bouton - Destination
$('.buttonsDestination button').click(function(e) {
    let id = e.target.id;
    var displayForm = $("#form" + id);
    //console.log("#form" + id);

    if (displayForm.css("display") === "none") {
        displayForm.attr("style", "display:block");
    } else if (displayForm.css("display", "block")) {
        displayForm.css("display", "none");
    }
});

//dynamiser l'affichage des destinations , au clic, on va sonder dans la base de données, 
//toutes les destinations qui correspondent à la région cliquée


function transmissionRegion(region){
    console.log(region);
}

$('.map').ready(function(){
   $('.map a').click(function(e){
       let region = null;
        let url	= null;
        
        region = e.currentTarget.id;
        url	= 'ControllerAjaxDestination.php?region='+region;
        e.preventDefault();
       $.get(url, transmissionRegion(region)).done(function(data) {
           $('#textAjax').load(url);
           
       })
       
       .fail(function(){
           alert("error");
       })
       .always(function(){
           //alert ("finished");
       })
       
   })
})

