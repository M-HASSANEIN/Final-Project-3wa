<?php

class CustomersController extends SiteBaseController
{

    public function  display()
    {
        $title="Register";
        $template = 'Register.phtml';
        include 'views/LayoutFrontend.phtml';
    }

    public function AddCustomer()
    {
      $error="";
      if(isset($_POST["submit"]))
      {
       $user_name= $_POST['user_name'];
       $firstname=   $_POST['firstname'];
       $lastname=  $_POST['lastname']; 
       $pwd= $_POST['password'] ;
       $repeatpwd= $_POST['passwordrepeat'];
       $email=  $_POST['email'];
       $address=  $_POST['address'];
       $zipcode=  $_POST['zipcode'];
       $country=  $_POST['country'];
       $phone=  $_POST['phone'];

              //Verifcation empty inputs
       if( (empty($user_name) || empty($firstname) || empty($lastname) 
           || empty($pwd)|| empty($repeatpwd) || empty($email) 
           || empty($address) || empty($zipcode) || empty($country)
           || empty($phone))==true )
         {
         $error=" Please complete all fields";
         $title="Register";
         $template = 'Register.phtml';
         include 'views/LayoutFrontend.phtml';
         exit();
         }

          // User match
         if (!preg_match("/^[a-zA-Z0-9]*$/",$user_name)) 
         {
         $error="Invalid Username";
         $title="Register";
         $template = 'Register.phtml';
         include 'views/LayoutFrontend.phtml';
         exit();
         }
         // Email validation
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) ///if you want to put type text in input 
        {
        $error="Invalid Email";
        $title="Register";
        $template = 'Register.phtml';
        include 'views/LayoutFrontend.phtml';
        exit();
        }
          // Password match 
        if ($pwd != $repeatpwd) 
        {
        $error="Password don't match";
        $title="Register";
        $template = 'Register.phtml';
        include 'views/LayoutFrontend.phtml';
        exit();
        }
        // Password length  i must but special password
        if (strlen($pwd) <= 4)
        {
        $error = "Choose a password longer then 4 character";
        $title="Register";
        $template = 'Register.phtml';
        include 'views/LayoutFrontend.phtml';
        exit(); 
        }
        // User exsits or not and email 
        $model=new Customers();
        //user 
        $row_UserName= $model->UserNameExists($user_name);
        //email
        $row_email=$model->EmailExists($email); 
        $count_UserName=count($row_UserName);
        $count_email=count($row_email);  
        //test if user is exist in dbb
        if($count_UserName != 0){
          $error = "UserName is exsits ";
          $title="Register";
          $template = 'Register.phtml';
          include 'views/LayoutFrontend.phtml';
          exit(); 
          //test if email is exist in dbb
        }elseif ($count_email != 0) {
                $error = "Email is exsits ";
                $title="Register";
                $template = 'Register.phtml';
                include 'views/LayoutFrontend.phtml';
                exit(); 
        }else {
                //if all the test is ok so create the account
               $error = "Your account is successfully created";
               $pwd_hashed = password_hash($pwd, PASSWORD_ARGON2ID);
               $model=new Customers();
               $model->RegisterCustomerDbase($user_name,$firstname,$lastname,$pwd_hashed,$email,$address,$zipcode,$country,$phone);
               $title="LogIn";
               $template = "CustomerLogIn.phtml";
               include 'views/LayoutFrontend.phtml';
               exit(); 
               }
        }  
    }
      // show customer loginpage
    public function  LogInDisplay()
    {
      $title="LogIn";
      $template = 'CustomerLogIn.phtml';
      include 'views/LayoutFrontend.phtml';
    }
    //connect user to the site
    public function  ConnectUser()
    {
      $error="";

      if(isset($_POST["submit"]))
      {  
         $user=$_POST["userid"];
         $pwd=$_POST["password"];
        
            //Verifcation empty inputs
          if( (empty($user) || empty($pwd) )== true )
          {
          $error=" Please complete all fields";
          $title="LogIn";
          $template = 'CustomerLogIn.phtml';
          include 'views/LayoutFrontend.phtml';
          exit();
          }
            //test if user is exist or not 
            $model=new Customers();
            $verfiy_User=$model->checkLogIn($user,$user);
            
          if ($verfiy_User == false) 
          {
          $error=" Username is incorrect";
          $title="LogIn";
          $template = 'CustomerLogIn.phtml';
          include 'views/LayoutFrontend.phtml';
          exit();
          }//verfiy the password
          else {
            $hash = $verfiy_User['password'];
            if (password_verify($pwd, $hash))
            {
            //create session
           /*  $_SESSION['customer'] =  $user=$_POST["userid"]; */
            $_SESSION['customer'] =  $verfiy_User["user_name"];
            $_SESSION['email'] =  $verfiy_User["email"];
            $_SESSION['id_client'] =  $verfiy_User["id_client"];
             //call the tamp
            $title="HOME";
            $template = 'Home_Front.phtml';
            include 'views/LayoutFrontend.phtml';
            //if the password is not same 
            }else {
              $error=" Incorrect password";
              $title="LogIn";
              $template = 'CustomerLogIn.phtml';
              include 'views/LayoutFrontend.phtml';
              exit();
            }
          }
  
      }  

    }
    //log out user
    public function Logout()
    {
      //if the system log out 
       session_destroy();
       unset($_SESSION['customer']);
     
      $error=" See you next time";
      $title="LogIn";
      $template = 'CustomerLogIn.phtml';
      include 'views/LayoutFrontend.phtml';
      exit();
    }
     //show change pwd page 
    public function  displayChangepwd()
    {
        //show change pwd page
        $title="ChangePWD";
        $template = 'ChangePassword.phtml';
        include 'views/LayoutFrontend.phtml';
    }
    public function  ChangePwd()
    {  //change pwd of the customer
      $error="";
      if(isset($_POST["submit"]))
      {  
         $oldpwd=$_POST["oldpassword"];
         $newpwd=$_POST["newpassword"];
         $rptnewpwt= $_POST['rptpassword'];
            //Verifcation empty inputs
        if( (empty($oldpwd) || empty($newpwd) ) || empty($rptnewpwt)== true )
          {
          $error=" Please complete all fields";
          $title="ChangePWD";
          $template = 'ChangePassword.phtml';
          include 'views/LayoutFrontend.phtml';
          exit();
          }  
            
               // Password match 
        if ($newpwd != $rptnewpwt) 
        {
        $error="New password don't match";
        $title="ChangePWD";
        $template = 'ChangePassword.phtml';
        include 'views/LayoutFrontend.phtml';
        exit();
        }
        
              //new Password match  old Password
        if ($oldpwd == $rptnewpwt ||$oldpwd == $newpwd) 
        {
        $error="You must choose new password";
        $title="ChangePWD";
        $template = 'ChangePassword.phtml';
        include 'views/LayoutFrontend.phtml';
        exit();
        }  
        //get data user from data base
          $user= $_SESSION["customer"];
          $model=new Customers();
          $verfiy_User=$model->checkLogIn($user,$user);
          $hash = $verfiy_User['password'];
           //verfiy pwdfrom data user from data base
          if (password_verify($oldpwd, $hash))
          { 
          $error = "Your password successfully changed";
          //hash and up date passwordto data base
          $pwd_hashed = password_hash($newpwd, PASSWORD_ARGON2ID);
          $model=new Customers();
          $model->UpDatePWD($pwd_hashed,$user,$user);
          session_destroy();
          unset($_SESSION['customer']);
          unset($_SESSION['email']);
          unset($_SESSION['id']);
          $title="LogIn";
          $template = 'CustomerLogIn.phtml';
          include 'views/LayoutFrontend.phtml';
          exit(); 

          }else {
           //if the old pwd not equal to data base pwd
             $error="Old password don't match";
             $title="ChangePWD";
             $template = 'ChangePassword.phtml';
             include 'views/LayoutFrontend.phtml';
             exit(); 
           }    
       }
    }
  
}