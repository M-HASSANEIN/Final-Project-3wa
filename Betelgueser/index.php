<?php
/* error_reporting(0); */
///////session function///////////
session_start();

///////////autoload function//////

spl_autoload_register(function ($class) {

    if (stristr($class, "Controller")) {
        require "controllers/" . $class . ".php";
    } else {
        require "models/" . $class . ".php";
    }
});
///////////PHPMAILER-AUTOLOAD////////

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/////////loading pages //////////////////

if (!isset($_GET['page'])) {
    //loading home page
    $controller = new HomeController();
    $controller->display();
} else {
    switch ($_GET['page']) {
        //*************BACK-END***************//
        ///////////////USERS-BACK///////////////
        case 'admin':
            $controller = new UserBackController();
            $controller->display();
            break;
        case 'connectback':
            $controller = new UserBackController();
            $controller->connect();
            break;
        case 'logout':
            $controller = new UserBackController();
            $controller->destroy();
            break;
        case 'UserBack':
            $controller = new UserBackController();
            $controller->displayUserBack();
            break;
        case 'ADD-USER-BACK':
            $controller = new UserBackController();
            $controller->displayAddUserBack();
            break;
        case 'AddNewUser':
            $controller = new UserBackController();
            $controller->AddUserBack();
            break;
        case 'DELETEUSER-BACK':
            $controller = new UserBackController();
            $controller->deleteuser();
            break;
        case 'EDITUSER-PAGE':
            $controller = new UserBackController();
            $controller->EditUserPage();
            break;
        case 'ModifyUser':
            $controller = new UserBackController();
            $controller->ModifyUserInfo();
            break;
        case 'dashboard':
            $controller = new DashboardController();
            $controller->display();
            break;
        /////////////ABOUT-BACK///////////////////
        case 'aboutback':
            $controller = new AboutController();
            $controller->ShowAboutBack();
            break;
        case 'EDITE-ABOUT-BACK':
            $controller = new AboutController();
            $controller->ShowEditeAboutBack();
            break;
        case 'ModifyAbout':
            $controller = new AboutController();
            $controller->EditeAboutData();
            break;
        /////////////SITE-PHOTOS-BACK///////////
        case 'sitephotoback':
            $controller = new SitePhotosController();
            $controller->displaySitePhotos();
            break;
        case 'EDIT-SITE-PHOTOS':
            $controller = new SitePhotosController();
            $controller->ShowEditePhotoPage();
            break;
        case 'MODIFYSITEPHOTO':
            $controller = new SitePhotosController();
            $controller->EditeSitePHOTO();
            break;
        /////////////ALBUMES-BACK///////////////////
        case 'albumsback':
            $controller = new AlbumBackController();
            $controller->ShowAlbums_back();
            break;
        case 'ADD-ALBUMS-BACK':
            $controller = new AlbumBackController();
            $controller->ShowAddAlbumsBack();
            break;
        case 'UpLoadAlbum_BACK':
            $controller = new AlbumBackController();
            $controller->UpLoadAlbumBack();
            break;
        case 'deletealbum':
            $controller = new AlbumBackController();
            $controller->DeleteAlbumDbase();
            break;
        case 'ModifyAlbum':
            $controller = new AlbumBackController();
            $controller->ShowModifyAlbumPage();
            break;
        case 'ModifyAlbumInDataBase':
            $controller = new AlbumBackController();
            $controller->ModifyALbumDbase();
            break;
        /////////////////GALARY-BACK//////////////////
        case 'GALLERY-BACK':
            $controller = new GalleryBackController();
            $controller->ShowGallery_Back();
            break;
        case 'UpLoadGalleryBack':
            $controller = new GalleryBackController();
            $controller->UpLoadPhotoBackend();
            break;
        case 'deletePhoto':
            $controller = new GalleryBackController();
            $controller->deletePhoto();
            break;
        case 'ModifyPhoto':
            $controller = new GalleryBackController();
            $controller->GetPhotoInfoById();
            break;
        case 'ModifyphotoInDataBase':
            $controller = new GalleryBackController();
            $controller->UpDatePhotoInDBase();
            break;
        case 'CALLGALLERY':
            $controller = new GalleryBackController();
            $controller->ShowGallerBack();
            break;
        /////////////BOOKING-BACK///////////////////
        case 'bookingback':
            $controller = new Booking_backController();
            $controller->displayBookingBack();
            break;
        case 'DeleteBookingBack':
            $controller = new Booking_backController();
            $controller->deleteBookingBack();
            break;
        case 'AddBookingBack':
            $controller = new Booking_backController();
            $controller->ShowAddBookingBack();
            break;
        case 'EditBookingBack':
            $controller = new Booking_backController();
            $controller->ShowEditBookingBack();
            break;
        case 'ModifyBooking':
            $controller = new Booking_backController();
            $controller->EditBookingBackDBase();
            break;
        case 'makebookingback':
            $controller = new Booking_backController();
            $controller->addbookingfrombackDbase();
            break;
        /////////////ROOM-BACK///////////////////
        case 'RoomsBack':
            $controller = new RoomsController();
            $controller->ShowRoomBack();
            break;
        case 'ShowAddRoomPage':
            $controller = new RoomsController();
            $controller->ShowAddRoomPage();
            break;
        case 'AddRoomDbase':
            $controller = new RoomsController();
            $controller->AddRoom();
            break;
        case 'deleteRoom':
            $controller = new RoomsController();
            $controller->deleteRoom();
            break;
        case 'ModifyRoom':
            $controller = new RoomsController();
            $controller->GetRoomInfoById();
            break;
        case 'ModifyRoomInDataBase':
            $controller = new RoomsController();
            $controller->UpDateRoomInDBase();
            break;
        ///////////////CUSTOMER-BACK///////////////
        case 'CustomersBack':
            $controller = new CustomersBackController();
            $controller->ShowdataCustomers();
            break;
        case 'deleteCustomer':
            $controller = new CustomersBackController();
            $controller->DeleteCustomerData();
            break;
        case 'EditeCustomer':
            $controller = new CustomersBackController();
            $controller->ShoweditCustomerPage();
            break;
        case 'ModifyCustomerData':
            $controller = new CustomersBackController();
            $controller->ModifyCustomerDataBase();
            break;
        ///////////////////SITE-SETTING//////////////
        case 'SiteSetting':
            $controller = new SitesettingController();
            $controller->display();
            break;
        case 'ModifyBoatInfo':
            $controller = new SitesettingController();
            $controller->ChangeBoatInfo();
            break;
        ///*************FRONT-END***************////

        //login and reg//
        case 'Register':
            $controller = new CustomersController();
            $controller->display();
            break;
        case 'AddUser':
            $controller = new CustomersController();
            $controller->AddCustomer();
            break;
        case 'LogInUser':
            $controller = new CustomersController();
            $controller->LogInDisplay();
            break;
        case 'connect':
            $controller = new CustomersController();
            $controller->ConnectUser();
            break;
        case 'logoutuser':
            $controller = new CustomersController();
            $controller->Logout();
            break;
        case 'changepassword':
            $controller = new CustomersController();
            $controller->displayChangepwd();
            break;
        case 'UPdatePassword':
            $controller = new CustomersController();
            $controller->ChangePwd();
            break;
        case 'ForgotPassword':
            $controller = new ResetPwdController();
            $controller->displayResetpwd();
            break;
        case 'SendResetEmail':
            $controller = new ResetPwdController();
            $controller->SendResetEmail();
            break;
        case 'ResetPwd':
            $controller = new ResetPwdController();
            $controller->ResetPwdLink();
            break;
        case 'ResetNewPassword':
            $controller = new ResetPwdController();
            $controller->ResetpwdDatabase();
            break;
        //pages display and setting//
        case 'home':
            $controller = new HomeController();
            $controller->display();
            break;
        case 'albums':
            $controller = new AlbumController();
            $controller->ShowAlbums();
            break;
        case 'Addalbums':
            $controller = new AlbumController();
            $controller->ShowAddAlbums();
            break;
        case 'AddNewAlbum':
            $controller = new AlbumController();
            $controller->UpLoadAlbum();
            break;
        case 'Gallery':
            $controller = new GalleryController();
            $controller->ShowGallery();
            break;
        case 'UploadGallery':
            $controller = new GalleryController();
            $controller->UpLoadPhoto();
            break;
        case 'diving':
            $controller = new DivingController();
            $controller->display();
            break;
        case 'rooms':
            $controller = new RoomsController();
            $controller->display();
            break;
        case 'about':
            $controller = new AboutController();
            $controller->display();
            break;
        //booking//
        case 'booking':
            $controller = new BookingController();
            $controller->displayBooking();
            break;
        case 'Bookroom':
            $controller = new BookingController();
            $controller->AddBooking();
            break;
        case 'cancelbooking':
            $controller = new BookingController();
            $controller->deleteBooking();
            break;
        case 'editebooking': //to show edit page
            $controller = new BookingController();
            $controller->ShowEditBooking();
            break;
        case 'canceledit':
            $controller = new BookingController();
            $controller->CancelEdit();
            break;
        case 'EditBookingInfo': //to edit booking info
            $controller = new BookingController();
            $controller->EditBookingDBase();
            break;
        case 'Validebooking':
            $controller = new BookingController();
            $controller->ValidateBooking();
            break;
        case 'mybooking':
            $controller = new BookingController();
            $controller->showmybooking();
            break;
        //newletter//
        case 'newletter':
            $controller = new NewletterController();
            $controller->JoinNewletter();
            break;
        //cookie//
        case 'cookie':
            $controller = new CookiesController();
            $controller->showCookie();
            break;
    }
}
