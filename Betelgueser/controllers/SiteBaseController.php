<?php 

class SiteBaseController
{
    protected $rooms;
    protected $photos;
    protected $boat;
    protected $bookings;
    protected $customers;
    protected $users;
    protected $roles;
    protected $albums;
    protected $abouts;
    protected $sitephotos;


    public function __construct()
    {
    //call all info room 
    $model=new Room();
    $this->rooms=$model-> GetRoomInfo();

    //call all photo room 
    $model=new PhotosRoom();
    $this->photos=$model->GetPhotos();

    //call all boat info show 
    $model=new Boats();
    $this->boat=$model->GetBoat();

     //call all booking info 
    $model=new Booking();
    $this->bookings=$model->GetBookingInfo();

    //call all customers info 
    $model=new Customers();
    $this->customers=$model->GetCustomersData();

    //call all users info 
    $model=new UserBack();
    $this->users=$model->GetALLUsers();

    //call all ROLE info 
    $model=new Role();
    $this->roles=$model->GetALLRole();

    //call all albums  
    $model=new Albums (); 
    $this->albums=$model->GetAlbums();

    //call all about  
    $model=new About (); 
    $this->abouts=$model->GetALLAbout();

     //call all sitephotos  
     $model=new Sitephotos (); 
     $this->sitephotos=$model->GetALLSitePhotos();

    }

}