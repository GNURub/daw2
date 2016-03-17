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
    collapsible: true,
  });

  var form, dialog;
  function updateProduct(){
    document.forms.namedItem("dialogproduct").submit();
    // var oData = new FormData();
    // window.fetch('/api/product', {
    // 	method: 'POST',
    //   credentials: 'include',
    //   body: oData
    // }).then(function(response) {
    //   return response.text();
    // }).then(function(doc) {
    //   console.log(doc)
    // })
  }

  dialog = $( "#dialog-item" ).dialog({
    autoOpen: false,
    height: 600,
    width: 550,
    modal: true,
    buttons: {
      Editar: updateProduct,
      Cancelar: function() {
        dialog.dialog( "close" );
      }
    },
    close: function() {
      form[0].reset();
    }
  });

  var form = dialog.find( "form" ).on( "submit", function( event ) {
   event.preventDefault();
   updateProduct();
 });

  $('x-item').on('edit', function(e){
    var id = Number($(e.target).attr('num'));
    window.fetch('/api/product/'+id).then(function(response){
      return response.json();
    }).then(function(r){
      console.log(r);
      dialog.find('input[name="titulo"]').val(r.titulo);
      dialog.find('input[name="marca"]').val(r.marca);
      // dialog.find('input[name="stock"]').val();
      dialog.find('input[name="precio"]').val(r.precio);
      dialog.find('input[name="gastoenvio"]').val(r.gatosdeenvio);
      dialog.find('input[name="descripcion"]').val(r.descripcion);
      dialog.find('#id-product').val(id);
    })
    dialog.dialog( "open" );
  })
})(document);
