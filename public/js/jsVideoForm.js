    document.addEventListener("DOMContentLoaded", function() {
    // document.addEventListener('DOMContentLoaded', (event) => {

    // let collection, boutonAjout, span;
    // window.onload = () => {
    collection = document.querySelector("#videos");
    // console.log(collection)
    span = collection.querySelector("span");

    boutonAjout = document.createElement("button");
    boutonAjout.className = "ajout-video btn-secondary";
    boutonAjout.innerText = "Ajouter une video";

    let nouveauBouton = span.append(boutonAjout);

    collection.dataset.index = collection.querySelectorAll("input").lenght;

    boutonAjout.addEventListener("click", function(){
        addButton(collection, nouveauBouton);
    });
    })

function addButton(collection, nouveauBouton){
    let prototype = collection.dataset.prototype;

    let index = collection.dataset.index;

    prototype = prototype.replace(/__name__/g, index);

    let content = document.createElement("html");
    content.innerHTML = prototype;
    let newForm = content.querySelector("div");

    let boutonSupp = document.createElement("button");
    boutonSupp.type = "button";
    boutonSupp.className = "btn-red";
    boutonSupp.id = "delete-video-" + index;
    boutonSupp.innerText = "supprimer cette video";

    newForm.append(boutonSupp);

    collection.dataset.index++;

    let boutonAjout = collection.querySelector(".ajout-video");

    span.insertBefore(newForm, boutonAjout);

    boutonSupp.addEventListener("click", function(){
        this.previousElementSibling.parentElement.remove();
    })

}