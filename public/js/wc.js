var isCompatibleWC = ('registerElement' in document
      && 'createShadowRoot' in HTMLElement.prototype
      && 'import' in document.createElement('link')
      && 'content' in document.createElement('template'));

if(!isCompatibleWC){
  document.write("<script src='https://cdnjs.cloudflare.com/ajax/libs/webcomponentsjs/0.7.18/webcomponents.min.js'></script>");
}
