document.addEventListener("DOMContentLoaded" , function()
{ 
    /* console.log(temp); */
    /* hurgadaid=361291 */
    //get id city and key api
    let key ="19387881c61552f872588f0a77355093";
    let city ="Hurghada";
    //url from apiopen weather with units =metric
    let url=`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${key}&units=metric`; 
            
     //fetch data to show in html 

    fetch(url)
    .then(response=>{
        return response.json();
    })
    .then(data=>{
        //select ememnts in html
        let dis=document.querySelector(".dis");
        let temp= document.getElementById('temp') ;
        let Water= document.getElementById('Water') ;
        let Humidity= document.getElementById('Humidity') ;
        let iconElement = document.querySelector(".weather-icon");
         //show data in html
        dis.innerHTML=data.weather[0].description;
        temp.innerHTML= Math.round(data.main.temp); 
        Water.innerHTML= Math.round(data.main.temp)-5;     
        Humidity.innerHTML= data.main.humidity;
        let iconId=data.weather[0].icon;
        iconElement.innerHTML = `<img class="img" src="assets/icons/${iconId}.png"/>`
       
})


});