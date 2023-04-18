document.addEventListener('DOMContentLoaded', (event) => {


    // document
    // .querySelectorAll('ul.tags li')
    // .forEach((tag) => {
    //     addTagFormDeleteLink(tag)
    // })

    // document
    // .querySelectorAll('.add_item_link')
    // .forEach(btn => {
    // btn.addEventListener("click", addFormToCollection)
    // });

    

    const addFormToCollection = (e) => {
        const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
      
        const item = document.createElement('li');
      
        item.innerHTML = collectionHolder
          .dataset
          .prototype
          .replace(
            /__name__/g,
            collectionHolder.dataset.index
          );
      
        collectionHolder.appendChild(item);
      
        collectionHolder.dataset.index++;

        // add a delete link to the new form
        addTagFormDeleteLink(item);

    };


    const addTagFormDeleteLink = (item) => {
        const removeFormButton = document.createElement('button');
        removeFormButton.innerText = 'Supprimer';
    
        item.append(removeFormButton);
    
        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            // remove the li for the tag form
            item.remove();
        });
    }    

    document
    .querySelectorAll('ul.tags li')
    .forEach((tag) => {
        addTagFormDeleteLink(tag)
    })

    document
    .querySelectorAll('.add_item_link')
    .forEach(btn => {
    btn.addEventListener("click", addFormToCollection)
    });

    
})    
// const addBar = () => {
//     //const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);
//     const collectionHolder = document.querySelector(trick_videos);
//     //let index = parseInt(collectionHolder.dataset.index);
//     //const prototype = collectionHolder.dataset.prototype;

//     // collectionHolder.innerHTML += collectionHolder 
//     //     .dataset
//     //     .prototype
//     //     .replace(/__name__/g, collectionHolder.dataset.index
//     //     );

//     // collectionHolder.dataset.index++;
//     collectionHolder.innerHTML += collectionHolder.dataset.prototype;
//     console.log(collectionHolder.dataset.prototype);
// };


// document
//     .querySelector('#new-bar').addEventListener('click', addBar);
//     // .querySelectorAll('.btn-new')
//     // .forEach(btn => 
//     //     btn.addEventListener("click", newItem));

//})    



// //     let collection, boutonAjout, span;
    
// //     document.addEventListener("DOMContentLoaded", function() {
// //     //document.addEventListener('DOMContentLoaded', (event) => {

// //     // let collection, boutonAjout, span;
// //     // window.onload = () => {
// //     collection = document.querySelector("#videos");
// //     // console.log(collection)
// //     span = collection.querySelector("span");

// //     boutonAjout = document.createElement("button");
// //     boutonAjout.className = "ajout-video btn-secondary";
// //     boutonAjout.innerText = "Ajouter une video";

// //     let nouveauBouton = span.append(boutonAjout);

// //     collection.dataset.index = collection.querySelectorAll("input").lenght;

// //     boutonAjout.addEventListener("click", function(){
// //         addButton(collection, nouveauBouton);
// //     });
// //     })

// // function addButton(collection, nouveauBouton){
// //     let prototype = collection.dataset.prototype;

// //     let index = collection.dataset.index;

// //     prototype = prototype.replace(/__name__/g, index);

// //      let content = document.createElement("html");
// //     content.innerHTML = prototype;
// //     let newForm = content.querySelector("div");

// //     let boutonSupp = document.createElement("button");
// //     boutonSupp.type = "button";
// //     boutonSupp.className = "btn-secondary";
// //     boutonSupp.id = "delete-video-" + index;
// //     boutonSupp.innerText = "supprimer";

// //     newForm.append(boutonSupp);

// //     collection.dataset.index++;
    

// //     let boutonAjout = collection.querySelector(".ajout-video");

// //     span.insertBefore(newForm, boutonAjout);

// //     boutonSupp.addEventListener("click", function(){
// //         this.previousElementSibling.parentElement.remove();
// //     })

// // }