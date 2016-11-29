var btnAddAll = document.querySelectorAll('.btnAdd');

for(i=0; i<btnAddAll.length; i++) {
  btnAddAll[i].addEventListener('click',btnAddFunction);
  console.log(i);
}

  function btnAddFunction(){
  console.log('Leo ');
}
