(function(doc){
  var dropDown =  doc.querySelector('.dropdown_menu');
  var btnDropdown = doc.querySelector('.btn_dropdown');
  if(dropDown){  
    btnDropdown.addEventListener('click', function(e){
      e.stopPropagation();
      console.log("e " + e)
      dropDown.classList.toggle('hidden');
    });
  }
})(document);
