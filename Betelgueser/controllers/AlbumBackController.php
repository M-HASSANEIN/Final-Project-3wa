<?php 

class AlbumBackController extends SiteBaseController
{
 
  //show album page  photo back
  public function ShowAlbums_back()
  {
     
      //loading template
      $title="ALBUMS-BACK";
      $template = 'ALBUMS_BACK.phtml';
      include 'views/LayoutBackend.phtml';
  }

  //show add album page back
  public function ShowAddAlbumsBack()
  {
      //loading template
      $title="ADD-ALBUMS-BACK";
      $template = 'ADD_ALBUMS_BACK.phtml';
      include 'views/LayoutBackend.phtml';
  }
//upload new album back
  public function UpLoadAlbumBack()
  {
     
    //if we click over addalbum back
    if(isset($_POST["submit-album"]))
    { 
      $errors= ""; 
      $name=$_POST["name"];
      $date = date('Y-m-d H:i:s');
    
      //Verifcation empty inputs
      if( (empty($name)==true ))
      {
        $errors="You must choose name for your album";
        $title="ADD-ALBUMS-BACK";
        $template = 'ADD_ALBUMS_BACK.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }
       //test if the folder exists
      if (file_exists("assets/Albums/$name/")) 
      {
        $errors="Album name is already existe";
        $title="ADD-ALBUMS";
        $template = 'ADD_ALBUMS_BACK.phtml';
        include 'views/LayoutBackend.phtml';
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
      if(in_array($file_ext,$expensions,$file_type)=== false)
      {
        $errors="extension not allowed, please choose a JPEG or PNG file.";
        $title="ADD-ALBUMS-BACK";
        $template = 'ADD_ALBUMS_BACK.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }
      //max size 2MB
      if($file_size > 10097152)
      {
        $errors='File size must be excately 10 MB';
        $title="ADD-ALBUMS-BACK";
        $template = 'ADD_ALBUMS_BACK.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }
        //if all is ok it will create  the album 
       else { 
           mkdir("assets/Albums/$name/", 0777, true);
           move_uploaded_file($file_tmp,$image);
           $model = new Albums();
           $model ->AddAlbumDbase($name,$image,$date);
           $albums=$model->GetAlbums();
           header("location:index.php?page=albumsback&error=ALbum is successfully created");
           exit();
        }
        
    }         
  }
  
   
   //delete album from data base
  public function DeleteAlbumDbase()
  {
    //get id and name of ambum
    $id=$_GET["ALBUM"];
    $directory=$_GET["NAME"];
    $coverphoto=$_GET["IMAGE"];
    $model=new Albums();
    $model->DeleteAlbumfromDbase($id);
    //delete folder of the album server
    $path = "assets/Albums/$directory";
    array_map('unlink', glob("assets/Albums/$directory/*.*"));
    rmdir($path);
    //delete cover photo from 
    if ($coverphoto!="assets/AlbumsCoverPhoto/default-thumbnail.jpg") {
      unlink($coverphoto);
    }
     header("location:index.php?page=albumsback&error=ALbum is successfully deleted");
     exit();
  } 
  // show modify album  page
   public function ShowModifyAlbumPage()
   {//get id of the album
     $id=$_GET["ALBUM"];
     $model=new Albums();
     $album=$model->CallAlbumbyId($id);
     $title="ADD-ALBUMS-BACK";
     $template = 'ADD_ALBUMS_BACK.phtml';
     include 'views/LayoutBackend.phtml';
     exit();
   }

  public function ModifyALbumDbase()
  {

    $date = date('Y-m-d H:i:s');
    $id=$_GET["ALBUM"];
    $OldName=$_GET["Name"];
    $NewName=$_POST["name"];
    $folder="assets/AlbumsCoverPhoto/";
    $oldimage=$_POST["image"];
    if(isset($_POST["submit-album"]) && !empty($_FILES["image"]["name"]))
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
        $errors="extension not allowed, please choose a JPEG or PNG file.";
        $model=new Albums();
        $album=$model->CallAlbumbyId($id);
        $title="ADD-ALBUMS-BACK";
        $template = 'ADD_ALBUMS_BACK.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }
      if (file_exists("assets/Albums/$NewName")) 
      {
        if ($NewName=!$OldName) {
          $errors="Album name is already existe";
          $model=new Albums();
          $album=$model->CallAlbumbyId($id);
          $title="ADD-ALBUMS-BACK";
          $template = 'ADD_ALBUMS_BACK.phtml';
          include 'views/LayoutBackend.phtml';
          exit();
        }else {
           $NewName=$_POST["name"];
        }
        
      }
      //max size 2MB
      if($file_size > 10097152) 
      {
        $errors='File size must be excately 10 MB';
        $model=new Albums();
        $album=$model->CallAlbumbyId($id);
        $title="ADD-ALBUMS-BACK";
        $template = 'ADD_ALBUMS_BACK.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }
      //if all is ok it will upload the photo 
      if(empty($errors)==true)
      { 
        $model=new Albums();
        $album=$model->CallAlbumbyId($id);
        $oldimage=$album["image"];
        move_uploaded_file($file_tmp,$folder.$file_name);
        if ($oldimage!="assets/AlbumsCoverPhoto/default-thumbnail.jpg") {
          unlink($oldimage);
        }
        //change folder name
        $oldname= "assets/Albums/$OldName/";
        $newname="assets/Albums/$NewName/";
        rename ($oldname,$newname);
        $model = new Albums();
        $model ->UpDateAlbumDbase($NewName,$folder.$file_name ,$date,$id);
        $model= new Gallery();
        $model-> UpDateAbumNameGalleryDbase($oldname,$newname,$date,$id);
        header("location:index.php?page=albumsback&error=The Album has been updated");
        exit();
      }
    }else {
      //change folder name
      $oldname= "assets/Albums/$OldName/";
      $newname="assets/Albums/$NewName/";
       if (file_exists("assets/Albums/$NewName")) 
      {
        $errors="Album name is already existe";
        $model=new Albums();
        $album=$model->CallAlbumbyId($id);
        $title="ADD-ALBUMS-BACK";
        $template = 'ADD_ALBUMS_BACK.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }else {
        rename ($oldname,$newname);
        $model = new Albums();
        $model ->UpDateAlbumNameDbase($NewName,$date,$id);
        $model= new Gallery();
        $model-> UpDateAbumNameGalleryDbase($oldname,$newname,$date,$id);
        header("location:index.php?page=albumsback&error=The Album has been updated");
        exit();
      }
     
      } 
  }
  
}