/*!
* Start Bootstrap - Agency v7.0.11 (https://startbootstrap.com/theme/agency)
* Copyright 2013-2022 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-agency/blob/master/LICENSE)
*/
//
// Scripts
// 

// add-collection-widget.js
jQuery(document).ready(function () {
    jQuery('.add-another-collection-widget').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list-selector'));
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') || list.children().length;

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
});


/////////////////////////////////////////////////////////////////////////////////
// document
//   .querySelectorAll('.add_item_link')
//   .forEach(btn => {
//       btn.addEventListener("click", addFormToCollection)
//   });

//   const addFormToCollection = (e) => {
//     const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
  
//     const item = document.createElement('li');
  
//     item.innerHTML = collectionHolder
//       .dataset
//       .prototype
//       .replace(
//         /__name__/g,
//         collectionHolder.dataset.index
//       );
  
//     collectionHolder.appendChild(item);
  
//     collectionHolder.dataset.index++;
//   };
///////////////////////////////////////////////////////////////////////////////////
// $(".btn-add").on("click", function() {
//     var $collectionHolder = $($(this).data("rel"));
//     var index = $collectionHolder.data("index");
//     var prototype = $collectionHolder.data("prototype");
//     $collectionHolder.append(prototype.replace(/__name__/g, index));
//     $collectionHolder.data("index", index+1);
// });

// $("body").on("click", ".btn-remove", function() {
//     $("."+$(this).data("rel")).remove();
// });