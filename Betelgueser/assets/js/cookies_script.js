//get all tag from html 
let cookies =document.querySelector(".cookies");    
let modal = document.getElementById("mycookies");
let button=document.querySelector(".cookies-accept");
let betelguser;
//show cookie after time 
function display()
{
 cookies.style.display="block";
 modal.style.display="block";
}
//accept cookie 
function acceptcookie() 
{
 cookies.style.display="none";
 modal.style.display="none";
 clearTimeout(betelguser);
 let url = `index.php?page=cookie`;
 //send url 
     fetch(url)
    .then(function (response) {
        return response.text();
    })    
}
//function  onload page 
document.addEventListener("DOMContentLoaded" , function()
{ 
    if (cookies!=null & button!=null) 
    {
     betelguser=setTimeout(display, 10000);
     button.addEventListener("click",acceptcookie)  
    }
    
});