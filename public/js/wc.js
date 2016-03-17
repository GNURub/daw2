(function(doc) {
  var isCompatibleWC = ('registerElement' in doc
  && 'createShadowRoot' in HTMLElement.prototype
  && 'import' in doc.createElement('link')
  && 'content' in doc.createElement('template'));

  if(!isCompatibleWC){
    doc.write("<script src='https://cdnjs.cloudflare.com/ajax/libs/webcomponentsjs/0.7.21/webcomponents.min.js'></script>");
  }
})(document);
