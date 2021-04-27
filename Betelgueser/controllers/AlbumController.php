<?php 

class AlbumController extends SiteBaseController
{
 
  //show album page  photo front
  public function ShowAlbums()
  {
      //loading template
      $title="ALBUMS";
      $template = 'Albums_Front.phtml';
      include 'views/LayoutFrontend.phtml';
  }

  //show add album page  photo front
  public function ShowAddAlbums()
  {
      //loading template
      $title="ADD-ALBUM";
      $template = 'AddAlbums_Front.phtml';
      include 'views/LayoutFrontend.phtml';
  }
//upload new album 
  public function UpLoadAlbum()
  { 
    //if we click over addalbum 
    if(isset($_POST["submit-album"]))
    { 
      $error= ""; 
      $name=$_POST["name"];
      $date = date('Y-m-d H:i:s');
    
      //Verifcation empty inputs
      if( (empty($name)==true ))
      {
        $error="You must choose name for your album";
        $title="ADD-ALBUMS";
        $template = 'AddAlbums_Front.phtml';
        include 'views/LayoutFrontend.phtml';
        exit();
      }
       //test if the folder exists
      if (file_exists("assets/Albums/$name/")) 
      {
      $error="Album name is already existe";
      $title="ADD-ALBUMS";
      $template = 'AddAlbums_Front.phtml';
      include 'views/LayoutFrontend.phtml';
      exit();
      }
        
        $folder="assets/AlbumsCoverPhoto/";
        $file_name = $_FILES['image']['name'];
        if (empty( $file_name)) {
          $file_name="default-thumbnail.jpg";
        }
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $image=$folder.$file_name;
        $value_ext=explode('.', $file_name);
        $file_ext=strtolower(end($value_ext));
        //determine  the type of the file 
        $expensions= array("jpeg","jpg","png");
        //
        if(in_array($file_ext,$expensions,$file_type)=== false){
            $error="extension not allowed, please choose a JPEG or PNG file.";
            $title="ADD-ALBUMS";
            $template = 'AddAlbums_Front.phtml';
            include 'views/LayoutFrontend.phtml';
            exit();
        }
        //max size 2MB
        if($file_size > 10097152)
        {
         $errors='File size must be excately 10 MB';
         $title="ADD-ALBUMS";
         $template = 'AddAlbums_Front.phtml';
         include 'views/LayoutFrontend.phtml';
         exit();
        }
        //if all is ok it will create  the album 
       else { 
           //create folder name 
           mkdir("assets/Albums/$name/", 0777, true);
           //uploud cover photo
           move_uploaded_file($file_tmp,  $image);
           $model = new Albums();
           $model ->AddAlbumDbase($name,$image,$date);
           header("location:index.php?page=albums&error=ALbum is successfully created");
           exit();
         }
        
    }
         
  }
  

}