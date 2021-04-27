<?php
class NewletterController  extends SiteBaseController
{
  public function JoinNewletter()
  {
       //loading template
       $errornew="";

       if(isset($_POST["submit"]))
       {  
          $name=$_POST["name"];
          $email=$_POST["email"];
         
             //Verifcation empty inputs
         if( (empty($name) || empty($email) )== true )
           {
           $errornew=" Please complete all fields";
           $title="HOME";
           $template = 'Home_Front.phtml';
           include 'views/LayoutFrontend.phtml';;
           exit();
           }
           //verfiy email and name exits or not
           $model=new Newletter();
           $verfiy=$model->EmailandnameExists($name,$email);

           if ($verfiy == false) {
            $model=new Newletter();
            $model->JionNewletter($name,$email);
            $errornew=" Thanks for join our newsletter";
            $title="HOME";
            $template = 'Home_Front.phtml';
            include 'views/LayoutFrontend.phtml';;
            exit();    
           }else {
            
            $errornew=" You already joined us";
            $title="HOME";
            $template = 'Home_Front.phtml';
            include 'views/LayoutFrontend.phtml';;
            exit();    
           }
        }
        if(isset($_POST["stop"]))
        {  
           $name=$_POST["name"];
           $email=$_POST["email"];
          
              //Verifcation empty inputs
          if( (empty($name) || empty($email) )== true )
            {
            $errornew=" Please complete all fields";
            $title="HOME";
            $template = 'Home_Front.phtml';
            include 'views/LayoutFrontend.phtml';;
            exit();
            }
              //verfiy email and name exits or not
              $model=new Newletter();
              $verfiy=$model->EmailandnameExists($name,$email);
            if ($verfiy == false) 
            {
            $errornew="Name and Email doesn't exists";
            $title="HOME";
            $template = 'Home_Front.phtml';
            include 'views/LayoutFrontend.phtml';;
            exit();
            }else {
                //delete name and email from data base
                $model=new Newletter();
                $verfiy=$model->StopNewletter($name,$email);
                $errornew="Hope to see you again";
                $title="HOME";
                $template = 'Home_Front.phtml';
                include 'views/LayoutFrontend.phtml';;
                exit();    
               }
      

         }
  }
}

/* echo '<pre>';
var_dump($verfiy);

echo '</pre>'; */