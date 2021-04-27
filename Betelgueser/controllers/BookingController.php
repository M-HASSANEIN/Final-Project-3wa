<?php

class BookingController extends SiteBaseController
{
    //////////booking front/////////
    public function displayBooking()
    {
        $id = $_GET["room"];
        $model = new Room();
        $room = $model->CallRoombyId($id);

        //loading template
        $title = "Booking";
        $template = 'Booking1_front.phtml';
        include 'views/LayoutFrontend.phtml';
    }

    public function AddBooking()
    {
        $id_client = $_SESSION['id_client'];
        $from = $_POST["from_date"];
        $to = $_POST["to_date"];
        $id_room = $_POST["id_room"];
        $origin = date_create($from);
        $target = date_create($to);
        $interval = date_diff($origin, $target);
        $period_of_stay = $interval->format(' %d ');
        $comments = $_POST["comments"];
        $date = date('Y-m-d H:i:s');
        $dateverify = date('Y-m-d');
        $price = $_POST["price"];
        $total = $period_of_stay * $price;
        if ($from < $dateverify) {
            header("location:booking-error-You must choose valide date-room-" . $id_room);
            exit();
        } else {
            $model = new Booking();
            $model->CreateBookingtoDbase($id_client, $date, $from, $to, $period_of_stay, $comments, $id_room, $total);
            //get booking by id bu getting last autoinctremented id
            $id = $model->getLastId();
            //call booking by id
            $model = new Booking();
            $booking = $model->CallBookingById($id);
            $model = new Room();
            $room = $model->CallRoombyId($booking["id_room"]);
            $title = "Booking";
            $template = 'Validate_Booking.phtml';
            include 'views/LayoutFrontend.phtml';
        }

    }
    ///CANCEL  edit booking page
    public function CancelEdit()
    {
        $id_booking = $_GET["booking"];
        //call booking by id
        $model = new Booking();
        $booking = $model->CallBookingById($id_booking);
        $model = new Room();
        $room = $model->CallRoombyId($booking["id_room"]);
        $title = "Booking";
        $template = 'Validate_Booking.phtml';
        include 'views/LayoutFrontend.phtml';
    }
    ///show edit booking page
    public function ShowEditBooking()
    {
        $id_booking = $_GET["booking"];
        $model = new Booking();
        $booking = $model->CallBookingById($id_booking);
        $model = new Room();
        $room = $model->CallRoombyId($booking["id_room"]);
        //loading template
        $title = "Edit-Booking";
        $template = 'Edit_booking.phtml';
        include 'views/LayoutFrontend.phtml';
    }
    ///edit booking in data basee
    public function EditBookingDBase()
    {
        $id_booking = $_GET["booking"];
        $from = $_POST["from_date"];
        $to = $_POST["to_date"];
        $origin = date_create($from);
        $target = date_create($to);
        $interval = date_diff($origin, $target);
        $period_of_stay = $interval->format(' %d ');
        $comments = $_POST["comments"];
        $date = date('Y-m-d H:i:s');
        //update total amount of the booking
        $price = $_POST["price"];
        $total = $period_of_stay * $price;
        $model = new Booking();
        $model->UpDateBookingInfo($comments, $date, $from, $to, $period_of_stay, $total, $id_booking);
        //call booking by id
        $model = new Booking();
        $booking = $model->CallBookingById($id_booking);
        $model = new Room();
        $room = $model->CallRoombyId($booking["id_room"]);
        $title = "Booking";
        $template = 'Validate_Booking.phtml';
        include 'views/LayoutFrontend.phtml';

    }
    ///if we click on cancel booking page
    public function deleteBooking()
    {
        $id_booking = $_GET["booking"];
        $model = new Booking();
        $model->DeleteBookingDbASE($id_booking);
        //loading template
        $success = 'Your booking has been canceled ';
        $model = new Room();
        $rooms = $model->GetRoomInfo();
        $title = "ROOMS";
        $template = 'Rooms_Front.phtml';
        include 'views/LayoutFrontend.phtml';
    }
    ///validate booking and send an email to customer
    public function ValidateBooking()
    {
        $id_booking = $_GET["booking"];
        $model = new Booking();
        $booking = $model->CallBookingById($id_booking);
        $id_room = $booking["id_room"];
        $model = new Room();
        $room = $model->CallRoombyId($id_room);
        $roomname = $room["room_name"];
        //prepare the email
        //email subject
        $subject = "Booking-Details-Betelgueser ";
        //email cancel
        $url = "http://" . $_SERVER["HTTP_HOST"] . str_replace('\\', '/', dirname($_SERVER["PHP_SELF"]))
            . "/cancelbooking-booking-" . $id_booking;
        //body of the eamil
        $body = "<h1>Thanks " . $_SESSION['customer'] . " Your booking in Betelgueser is confirmed. </h1>
            <h2>BOOKING-DETAILS</h2>
            <p>Room Name : " . $roomname . " </p>
            <p>Room price : " . $room["price_perday"] . " euro </p>
            <p>Booking ref : " . $id_booking . " </p>
            <p>Comments : " . $booking["comments"] . ". </p>
            <p>Date of the booking : " . $booking["date"] . " </p>
            <p>Check in :" . $booking["from_date"] . " </p>
            <p>Check out : " . $booking["to_date"] . " </p>
            <p>Period of stay : " . $booking["period_of_stay"] . ". days  </p>
            <p>Total amount ( Price * Days ):" . $booking["total_amount"] . " euros</p>
            if you want to cancel your booking
            please click this link to cancal <a href=" . $url . ">this link</a>  ";
        //send email to the user
        $email = $_SESSION['email'];
        $model = new EmailManager($email, $subject, $body);
        $success = 'Booking-Details has been sent to your email';
        $model = new Room();
        $rooms = $model->GetRoomInfo();
        $title = "ROOMS";
        $template = 'Rooms_Front.phtml';
        include 'views/LayoutFrontend.phtml';
        exit();
    }
    public function showmybooking()
    {
        $title = "MY-BOOKING";
        $template = 'Mybooking.phtml';
        include 'views/LayoutFrontend.phtml';
        exit();
    }

}
