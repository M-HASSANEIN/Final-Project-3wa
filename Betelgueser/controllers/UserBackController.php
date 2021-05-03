<?php

class UserBackController extends SiteBaseController
{
    ///display page login 
    public function  display()
    {
      //display admin page
      $title="Users-Back";
      $template = 'UsersBackLogIN.phtml';
      include 'views/LayoutBackend.phtml';
    }
    //display page show all admin back
    public function  displayUserBack()
    {
      $title="Users-Back";
      $template = 'USER_BACK.phtml';
      include 'views/LayoutBackend.phtml';
    }
    //display ADD USER PAGE  back
    public function  displayAddUserBack()
    {
      $title="Add-Users-Back";
      $template = 'ADD_NEWUSER-BACK.phtml';
      include 'views/LayoutBackend.phtml';
    }
    // ADD USER 
    public function  AddUserBack()
    {
     if(isset($_POST["submit-user"]))
     {
       $id_role=$_POST["id_role"];
       $user_name= $_POST['user_name'];
       $firstname=   $_POST['firstname'];
       $lastname=  $_POST['lastname']; 
       $pwd= $_POST['password'] ;
       $repeatpwd= $_POST['passwordrepeat'];
       $email=  $_POST['email'];

         //Verifcation empty inputs
       if( (empty($user_name) || empty($firstname) || empty($lastname) 
           || empty($pwd)|| empty($repeatpwd) || empty($email))==true )
       {
        header("location:AddUserBack-error-You must complete all inputs");
        exit();
       }

          // User match
       if (!preg_match("/^[a-zA-Z0-9]*$/",$user_name)) 
       {
         header("location:AddUserBack-error-Invalid Username");
         exit();
       }
         // Email validation
       if (!filter_var($email,FILTER_VALIDATE_EMAIL)) ///if you want to put type text in input 
       {
         header("location:AddUserBack-error-Invalid Email");
         exit();
       }
         // Password match 
       if ($pwd != $repeatpwd) 
       {
        header("location:AddUserBack-error-Password don't match");
        exit();
       }
       // Password length  i must but special password
       if (strlen($pwd) <= 4)
       {
        header("location:AddUserBack-error-Choose a password longer then 4 character");
        exit();
       }
       // User exsits or not and email 
       $model=new UserBack();
       //user 
       $verfyuser= $model->getData($user_name,$user_name);
       //email 
        $verfyemail= $model->getData($email,$email);
       //test if user is exist in dbb
       if($verfyuser != false)
       {
         header("location:AddUserBack-error-UserName is exsits");
         exit(); 
         //test if email is exist in dbb
       }
       if($verfyemail != false)
       {
         header("location:AddUserBack-error-Email is exsits");
         exit(); 
       } 
        //if all the test is ok so create the account
        $pwd_hashed = password_hash($pwd, PASSWORD_ARGON2ID);
        $model=new UserBack();
        $model->AddUsertoDbase($id_role,$user_name,$firstname,$lastname, $pwd_hashed,$email);
        header("location:UserBack-error-New user has been  successfully added");
         exit();        
      }     
    }
    public function deleteuser()
    {
     $id=$_GET["USER"];
     $model=new UserBack();
     $model->DeleteUserDbase($id);
     header("location:UserBack-error- User has been  successfully deleted");
     exit();        
    } 
    ///SHOW 
    public function EditUserPage()
    {
     $id=$_GET["USER"];
     $model=new UserBack();
     $user=$model->CallUserbyId($id);
     $title="Add-Users-Back";
     $template = 'ADD_NEWUSER-BACK.phtml';
     include 'views/LayoutBackend.phtml';       
    } 
    public function ModifyUserInfo()
    {
     $id=$_GET["USERID"];
     $id_role=$_POST["id_role"];
     $user_name= $_POST['user_name'];
     $firstname=   $_POST['firstname'];
     $lastname=  $_POST['lastname']; 
     $email=  $_POST['email'];
     $model=new UserBack();
     $model->UpDateUSERDbase($id_role,$user_name,$firstname,$lastname,$email,$id);
     header("location:UserBack-error- User has been  successfully updated");
     exit();     
    } 

   ////connect user to the backend login
    public function connect()
    {
      //verify if the  user put a user and password
      if(isset($_POST['user']) && isset($_POST['password'])) 
      {
      //collect input data from form
      $user=$_POST["user"];
      $email=$_POST["user"];
      $password=$_POST["password"];
      //get  data from data base   
      $model= new UserBack();
      $verfyAdmin=$model-> getData($user,$email);
      //verify the input data and the password with hash function 
      if($verfyAdmin == false)
      {
      //if the pwd is in correct
      $title="ERROR";
      $template = 'error_backend.phtml';
      include 'views/LayoutBackend.phtml';
      }else{
            //if the admin put the correct pwd 
            //unhash pwd and verify the pwd 
            $hash = $verfyAdmin['pass_word'];
            if (password_verify($password, $hash))
            { 
             if ($verfyAdmin['role']=="superadmin") {
               //create  session admin
                $_SESSION['user'] = "admin";
             }else {
               //create session user  
                $_SESSION['user'] = "user";
             }    
             ///if the user and password is ok it will go to dashboard 
             $title="Dashboard";
             $template = 'dashboard_backend.phtml';
             include 'views/LayoutBackend.phtml';
            } else {
                //if the pwd dont match it will           
                $title="ERROR";
                $template = 'error_backend.phtml';
                include 'views/LayoutBackend.phtml';
              }
         }
    }
  }
      //if the admin click signout 
     public function destroy()
     {
        session_destroy();
        unset($_SESSION['user']);
        //call the method display 
        $this->display();
     }


}