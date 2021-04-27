<?php

class AboutController extends SiteBaseController
{
    //show about page front
    public function  display()
    {
        $title="ABOUT";
        $template = 'About_Front.phtml';
        include 'views/LayoutFrontend.phtml';
    }
    //show about page back
    public function  ShowAboutBack()
    {
        $title="ABOUT-BACK";
        $template = 'About_Back.phtml';
        include 'views/LayoutBackend.phtml';
    }
    //show edite about page
    public function  ShowEditeAboutBack()
    {
        $id_about=$_GET["ABOUT"];
        $model=new About;
        $about=$model->CallAboutById($id_about);

        $title="EDITE-ABOUT-BACK";
        $template = 'EDITE_ABOUT_BACK.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
    }
    public function EditeAboutData()
    {
        $name=$_POST["about_img_alt"];
        if ($name==="") {
          $name="Betelgueser";
        }
        $id_about=$_GET["ABOUT"];
        $srcOld=$_GET["SRC"];
        $content=$_POST["about_content"];

        if(isset($_POST["submit-about"]) && !empty($_FILES["image"]["name"]))
      {
        $errors="";
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $value_ext=explode('.', $file_name);
        $file_ext=strtolower(end($value_ext));
        //determine  the type of the file 
        $expensions= array("jpeg","jpg","png");
        //get file to stock image 
        $NewSrc ="assets/img/";
        $src=$NewSrc.$file_name;
        //
        if(in_array($file_ext,$expensions,$file_type)=== false)
        {
          $errors="extension not allowed, please choose a JPEG or PNG file.";
          $model=new About;
          $about=$model->CallAboutById($id_about);
          $title="EDITE-ABOUT-BACK";
          $template = 'EDITE_ABOUT_BACK.phtml';
          include 'views/LayoutBackend.phtml';
          exit();
        }
        //max size 10MB
        if($file_size > 10097152) ///must be modify
        {
          $errors='File size must be excately 10 MB';
          $model=new About;
          $about=$model->CallAboutById($id_about);
          $title="EDITE-ABOUT-BACK";
          $template = 'EDITE_ABOUT_BACK.phtml';
          include 'views/LayoutBackend.phtml';
          exit();
        }
        //if all is ok it will upload the photo 
        if (file_exists($NewSrc.$file_name))
        { 
          $errors="Photo name is already existe"; 
          $model=new About;
          $about=$model->CallAboutById($id_about);
          $title="EDITE-ABOUT-BACK";
          $template = 'EDITE_ABOUT_BACK.phtml';
          include 'views/LayoutBackend.phtml';
          exit();
        }
        if(empty($errors)==true)
        { 
          $model=new About();
          $model->UpDateAboutDbase($content,$src,$name,$id_about);
          move_uploaded_file($file_tmp,$NewSrc.$file_name);
          unlink($srcOld);
          header("location:index.php?page=aboutback&error=Your Data has been updated ");
          exit();
        }
      }else {
        $model=new About();
        $model->UpDateAboutWithoutPhotoDbase($content,$name,$id_about);
        header("location:index.php?page=aboutback&error=Your Data has been updated ");
        exit(); 
        }
    
    }
    
    
}