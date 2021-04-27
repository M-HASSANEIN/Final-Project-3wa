let slides=document.querySelector('.slider-items').children;
let totalSlides=slides.length;
let index=0;
let time =10500;
/* console.log(slides) */


///FUNCTION CHANGE SLIDES
function changeImg(){

   let i;

   for(i=0;i<slides.length;i++)
   {
   slides[i].classList.remove("active");         
   }
   index++
   if (index > slides.length)
    {
     index = 1;
    }    
 
    slides[index-1].classList.add("active");
    setTimeout("changeImg()",time);

 }



//FUNCTION UPLOAD AFTER PAGE LOADED
document.addEventListener("DOMContentLoaded" , function()
{ 
        changeImg() 
       
});     