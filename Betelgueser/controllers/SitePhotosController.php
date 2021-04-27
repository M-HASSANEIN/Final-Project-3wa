<?php
class SitePhotosController extends SiteBaseController
{
    ///display page  
    public function  displaySitePhotos()
    {
      //display  page
      $title="Site-Photo-Back";
      $template = 'SitePhotos_BACK.phtml';
      include 'views/LayoutBackend.phtml';
      exit();
    }
   ///display edite page  
   public function  ShowEditePhotoPage()
   {
     $id_PHOTO=$_GET["PHOTO"];
     $model=new SitePhotos;
     $PHOTO=$model->CallPhotoSiteById($id_PHOTO); 
     $title="Edite-Site-Photo-Back";
     $template = 'EDITE_SitPhotos_BACK.phtml';
     include 'views/LayoutBackend.phtml';
     exit();
   }
   public function EditeSitePHOTO()
   {
       $name=$_POST["alt"];
       if ($name==="") {
         $name="Betelgueser";
       }
       $id_PHOTO=$_GET["PHOTO"];
       $srcOld=$_GET["SRC"];
       $date = date('Y-m-d H:i:s');

       if(isset($_POST["submit-photo"]) && !empty($_FILES["image"]["name"]))
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
         $model=new SitePhotos;
         $PHOTO=$model->CallPhotoSiteById($id_PHOTO); 
         $title="Edite-Site-Photo-Back";
         $template = 'EDITE_SitPhotos_BACK.phtml';
         include 'views/LayoutBackend.phtml';
         exit();
       }
       //max size 10MB
       if($file_size > 10097152) ///must be modify
       {
         $errors='File size must be excately 10 MB';
         $model=new SitePhotos;
         $PHOTO=$model->CallPhotoSiteById($id_PHOTO); 
         $title="Edite-Site-Photo-Back";
         $template = 'EDITE_SitPhotos_BACK.phtml';
         include 'views/LayoutBackend.phtml';
         exit();
       }
         

       //if all is ok it will upload the photo 
       if (file_exists($NewSrc.$file_name))
       { 
         $errors="Photo name is already existe"; 
         $model=new SitePhotos;
         $PHOTO=$model->CallPhotoSiteById($id_PHOTO); 
         $title="Edite-Site-Photo-Back";
         $template = 'EDITE_SitPhotos_BACK.phtml';
         include 'views/LayoutBackend.phtml';
         exit();
       }
       if(empty($errors)==true)
       { 
         $model=new SitePhotos;
         $model->UpDateSitePhotoDbase($src,$name,$date,$id_PHOTO);
         move_uploaded_file($file_tmp,$NewSrc.$file_name);
         unlink($srcOld);
         header("location:index.php?page=sitephotoback&error=Your Data has been updated ");
         exit();
       }
     }else {
        $errors="please select photo"; 
        $model=new SitePhotos;
        $PHOTO=$model->CallPhotoSiteById($id_PHOTO); 
        $title="Edite-Site-Photo-Back";
        $template = 'EDITE_SitPhotos_BACK.phtml';
        include 'views/LayoutBackend.phtml';
        exit(); 
       }
   
   }

}