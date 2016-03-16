(function(doc){
  'use strict';

  var dropDown =  doc.querySelector('.dropdown_menu');
  var btnDropdown = doc.querySelector('.btn_dropdown');
  if(dropDown){
    btnDropdown.addEventListener('click', function(e){
      e.stopPropagation();
      dropDown.classList.toggle('hidden');
    });
  };
  $( doc ).tooltip();
  $( "#tabs" ).tabs();
  $( "#accordion" ).accordion({
    collapsible: true
  });

})(document);
