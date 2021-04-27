<?php
class CookiesController {
    
    public function showCookie () 
    {
        //setcookie
    setcookie('betelguser','client',time() + 365 * 24 * 60 * 60 ,null,null,false,true);

    }
}