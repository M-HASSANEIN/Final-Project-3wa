<?php 

class RoomsController extends SiteBaseController
{
   //show room front 
  public function display()
  {
      //loading template
      $title="ROOMS";
      $template = 'Rooms_Front.phtml';
      include 'views/LayoutFrontend.phtml';
  }
  ////////////////////////backend///////////////////// 
  public function ShowRoomBack()
  {
     $title="ROOMS-BACK";
     $template = 'Rooms_backend.phtml';
     include 'views/LayoutBackend.phtml';
  }

  public function ShowAddRoomPage()
  {
     //loading template
     $title="AddRoom";
     $template = 'AddNewRoom.phtml';
     include 'views/LayoutBackend.phtml';
  }

  public function AddRoom()
  {
      if(isset($_POST["submit-room"]) && !empty($_FILES["image"]["name"]))
      {
        $status=$_POST["status"];
        $name=$_POST["room_name"];
        $number=$_POST["room_number"];
        $capacity=$_POST["capacity"];
        $price=$_POST["price_perday"];
        $tax=$_POST["tax"];
        $description=$_POST["descriptions"];
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
          $title="AddRoom";
          $template = 'AddNewRoom.phtml';
          include 'views/LayoutBackend.phtml';
        }
        //max size 10MB
        if($file_size > 10097152) ///must be modify
        {
          $errors='File size must be excately 10 MB';
          $title="AddRoom";
          $template = 'AddNewRoom.phtml';
          include 'views/LayoutBackend.phtml';
        }
         //get name of foldername
        
         $NewSrc ="assets/img/";
         $photo=$NewSrc. $file_name;
        //if all is ok it will upload the photo 
        if (file_exists($NewSrc.$file_name))
        { 
          $errors="photo name is already existe"; 
          $title="AddRoom";
          $template = 'AddNewRoom.phtml'; 
          include 'views/LayoutBackend.phtml';
        }
        if (empty($status)||empty($name)||empty($number)||empty($capacity)||
        empty($price)|| empty($tax)||empty($description))
        {
          $errors="please complete all inputs fields"; 
          $title="AddRoom";
          $template = 'AddNewRoom.phtml'; 
          include 'views/LayoutBackend.phtml';
        }

        if(empty($errors)==true)
        { //upload logo and remove old logo 
          $model=new Room();
          $model->AddRoomtoDbase($status,$name,$number,$capacity,$price,$tax,$description);
          //get last id room 
          $id = $model -> getLastId();
          $model=new PhotosRoom();
          $model->AddPhotoroom($photo,$name,$id);
          move_uploaded_file($file_tmp,$NewSrc.$file_name);
          /* unlink($srcOld); */
          header("location:index.php?page=RoomsBack&error=Room has been added");
        }
      } else{
          $errors="please add photo room"; 
          $title="AddRoom";
          $template = 'AddNewRoom.phtml'; 
          include 'views/LayoutBackend.phtml';
          }
  }

  public function deleteRoom()
  {
       $id=$_GET["ROOM"];
       $model=new Room();
       $model->DeleteRoomDbase($id);
       header("location:index.php?page=RoomsBack&error=Room has been deleted");
  }

  public function GetRoomInfoById()
  {
      $id=$_GET["ROOM"];
      $model=new Room();
      $room=$model->CallRoombyId($id);
      $title="AddRoom";
      $template = 'AddNewRoom.phtml';
      include 'views/LayoutBackend.phtml';
  }
  public function UpDateRoomInDBase()
  {
      $status=$_POST["status"];
      $name=$_POST["room_name"];
      $number=$_POST["room_number"];
      $capacity=$_POST["capacity"];
      $price=$_POST["price_perday"];
      $tax=$_POST["tax"];
      $description=$_POST["descriptions"];
      $id=$_GET["ROOM"];
      if(isset($_POST["submit-room"]) && !empty($_FILES["image"]["name"]))
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
          $model=new Room();
          $room=$model->CallRoombyId($id);
          $title="AddRoom";
          $template = 'AddNewRoom.phtml';
          include 'views/LayoutBackend.phtml';
  
        }
        //max size 10MB
        if($file_size > 10097152) ///must be modify
        {
          $errors='File size must be excately 10 MB';
          $model=new Room();
          $room=$model->CallRoombyId($id);
          $title="AddRoom";
          $template = 'AddNewRoom.phtml';
          include 'views/LayoutBackend.phtml';
        }
         //get name of foldername
        
         $NewSrc ="assets/img/";
         $photo=$NewSrc. $file_name;
        //if all is ok it will upload the photo 
        if (file_exists($NewSrc.$file_name))
        { 
          $errors="photo name is already existe"; 
          $model=new Room();
          $room=$model->CallRoombyId($id);
          $title="AddRoom";
          $template = 'AddNewRoom.phtml'; 
          include 'views/LayoutBackend.phtml';
        }
        if(empty($errors)==true)
        { //upload logo and remove old logo 
          $model=new Room();
          $model->UpDateRoomDbase($number,$name,$price,$tax,$description,$status,$capacity,$id);
          $model=new PhotosRoom();
          $model->UpDateRoomphotoDbase($photo,$name,$id);
          move_uploaded_file($file_tmp,$NewSrc.$file_name);
          /* unlink($srcOld); */
          $success="Roomphoto have been uploaded"; 
          $model=new Room();
          $room=$model->CallRoombyId($id);
          $title="AddRoom";
          $template = 'AddNewRoom.phtml'; 
          include 'views/LayoutBackend.phtml';
        }
      }else {
          //change room info without photo
         $model=new Room();
         $model-> UpDateRoomDbase($number,$name,$price,$tax,$description,$status,$capacity,$id);
         $room=$model->CallRoombyId($id);
         $success="Roomdata have been modified"; 
         $title="AddRoom";
         $template = 'AddNewRoom.phtml'; 
         include 'views/LayoutBackend.phtml';
         }
  }


}