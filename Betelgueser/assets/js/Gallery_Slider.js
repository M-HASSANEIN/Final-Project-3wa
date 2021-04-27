//GET ALL TAGS HTML 
let images=document.querySelectorAll(".images");
let closeimage=document.querySelector(".close");
let prevslide=document.querySelector(".prev");
let nextslide=document.querySelector(".next");
let modal = document.getElementById("myModal");
let modalImg = document.getElementById("img01");
let index =0;

// FUNCTION TO SHOW PHOTO WHEN CLICK OVER AN PHOTO
function ShowPhoto() {
    modal.style.display = "block";
    modalImg.src=this.src; 
}
//FUNCTION TO CLOSE MODEL OF SLIDER
function closemodel() {
    let modal = document.getElementById("myModal");
    modal.style.display = "none"; 
    
}

//FUNCTION TO CHANGE PHOTO IN SLIDER 
function showImg(direction) 
{  
        modalImg.removeAttribute('src');
        modalImg.setAttribute("src",images[index].src);
    
        if (direction == "left")
        {
          index--;
          
        }
        else
        {
          index++;
          index %= images.length;
        }
        
        if (index < 0)
        {
          index = images.length - 1;
        }
            
  } 
//FUNCTION UPLOAD AFTER PAGE LOADED
document.addEventListener("DOMContentLoaded" , function()
{ 
for (let index = 0; index < images.length; index++) {
    images[index].addEventListener("click",ShowPhoto); 
}
closeimage.addEventListener("click",closemodel);

nextslide.addEventListener("click",()=>{
    showImg("right")
  })
prevslide.addEventListener("click",()=>{
    showImg("left")
})


});    