let button;
let button2;

///////page deleteroom ////////
function deleteroom(event){

    let del = confirm("Are you sure you want to delete this Data ?");

    if (del == true) {
  
    } else {
      event.preventDefault();
    }
    return del;

}











document.addEventListener('DOMContentLoaded', function () {

    button=document.querySelectorAll(".delete");
    button2=document.querySelectorAll(".delete");
  
   
    for (let index = 0; index < button.length; index++) {
  
      button[index].addEventListener("click", deleteroom);
    }
    for (let index = 0; index < button2.length; index++) {
  
      button2[index].addEventListener("click", deleterayon);
    }
  
  
  
  });