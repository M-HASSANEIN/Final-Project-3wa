<?php 

class SitesettingController extends SiteBaseController
{
    public function display()
    {
       //loading template
      $title="SITE-SETTING";
      $template = 'Site_Setting_Back.phtml';
      include 'views/LayoutBackend.phtml';
    }
  
    public function ChangeBoatInfo()
    {
      $id=$_POST["id-boat"];
      $boat_name=$_POST["name"];
      $company_name=$_POST["company_name"];
      $address=$_POST["address"];
      $email=$_POST["email"];
      $phone=$_POST["phone"];
      $srcOld=$_POST["image"];
      if(isset($_POST["submit-info"]) && !empty($_FILES["image"]["name"]))
      {
        $errors= "";
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $value_ext=explode('.', $file_name);
        $file_ext=strtolower(end($value_ext));
        //determine  the type of the file 
        $expensions= array("jpeg","jpg","png");
        //
        if(in_array($file_ext,$expensions,$file_type)=== false)
        {
          header("location:index.php?page=SiteSetting&error=extension not allowed, please choose a JPEG or PNG file.");
          exit();
        }
        //max size 10MB
        if($file_size < 10097152) ///must be modify
        {
          header("location:index.php?page=SiteSetting&error=File size must be excately 10 MB");
          exit();
        }
         //get name of foldername
        
         $NewSrc ="assets/img/";
         $logo=$NewSrc. $file_name;
        //if all is ok it will upload the photo 
        if (file_exists($NewSrc.$file_name))
        { 
          header("location:index.php?page=SiteSetting&error=logo name is already existe");
          exit();
        }
        if(empty($errors)==true)
        { //upload logo and remove old logo 
          $model=new boats();
          $model->UpDateBoatDbase($boat_name,$company_name,$address,$email,$phone,$logo,$id);
          move_uploaded_file($file_tmp,$NewSrc.$file_name);
          unlink($srcOld);
          header("location:index.php?page=SiteSetting&error=logo has been uploaded");
          exit();
        }
      }else {
        
        //change boat info in data base
        $model=new Boats();
        $model->UpDateThisBoatDbase($boat_name,$company_name,$address,$email,$phone,$id);
        //loading template
        header("location:index.php?page=SiteSetting&error=Data has been updated");
        exit();
        }
    }
}