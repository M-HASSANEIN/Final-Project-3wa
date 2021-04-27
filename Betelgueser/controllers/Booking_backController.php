<?php
class Booking_backController extends SiteBaseController
{
    //SHOW BOOKING BACK-ENG
    public function displayBookingBack()
    {
        //loading template
        $title = "BOOKING-BACK";
        $template = 'Booking_back.phtml';
        include 'views/LayoutBackend.phtml';
    }
    ///if we click on delete  BOOKING BACK-ENG
    public function deleteBookingBack()
    {
        $id_booking = $_GET["Book"];
        $model = new Booking();
        $model->DeleteBookingDbASE($id_booking);
        //loading template
        header("location:bookingback-error-Your booking has been deleted");
    }
    ///show ADD-BOOKING-BACK PAGE
    public function ShowAddBookingBack()
    {
        //loading template
        $title = "Add-Booking-back";
        $template = 'ADD_BOOKING_BACK.phtml';
        include 'views/LayoutBackend.phtml';
    }
    ///show edit booking page
    public function ShowEditBookingBack()
    {
        $id_booking = $_GET["Book"];
        $model = new Booking();
        $booking = $model->CallBookingById($id_booking);

        //loading template
        $title = "Edit-Booking-back";
        $template = 'ADD_BOOKING_BACK.phtml';
        include 'views/LayoutBackend.phtml';
    }
    ///edit booking in data basee BOOKING BACK-ENG
    public function EditBookingBackDBase()
    {

        $id_booking = $_GET["Book"];
        $id_room = $_POST["id_room"];
        $from = $_POST["from_date"];
        $to = $_POST["to_date"];
        $origin = date_create($from);
        $target = date_create($to);
        $interval = date_diff($origin, $target);
        $period_of_stay = $interval->format(' %d ');
        $comments = $_POST["comments"];
        $date = date('Y-m-d H:i:s');
        //update total amount of the booking by getting price of the new room
        $model = new Room();
        $room = $model->CallRoombyId($id_room);
        $price = $room["price_perday"];
        $total = $period_of_stay * $price;
        $model = new Booking();
        $model->UpDateBookingbackInfo($comments, $date, $from, $to, $period_of_stay, $total, $id_room, $id_booking);
        //
        header("location:EditBookingBack-error-Booking has been updated-Book-" . $id_booking);
    }

    public function addbookingfrombackDbase()
    {
        if (isset($_POST["submit-booking"])) {
            $id_client = $_POST["id_client"];
            $comments = $_POST["comments"];
            $date = date('Y-m-d H:i:s');
            $from = $_POST["from_date"];
            $to = $_POST["to_date"];
            $origin = date_create($from);
            $target = date_create($to);
            $interval = date_diff($origin, $target);
            $period_of_stay = $interval->format(' %d ');
            $id_room = $_POST["id_room"];
            $model = new Room();
            $room = $model->CallRoombyId($id_room);
            $price = $room["price_perday"];
            $total = $period_of_stay * $price;

            //test if input of id client and room is empty
            if ((empty($id_client) || empty($id_room)) == true) {
                header("location:AddBookingBack-error-please select customer and room ");
                exit();
            }

            //if all input is fill up
            $model = new Booking();
            $model->CreateBookingtoDbase($id_client, $date, $from, $to, $period_of_stay, $comments, $id_room, $total);
            //get booking by id bu getting last autoinctremented id
            $id_booking = $model->getLastId();
            //getting all booking info to send the email to customer
            $model = new Booking();
            $booking = $model->CallBookingById($id_booking);
            //prepare the email
            //email subject
            $subject = "Booking-Details-Betelgueser ";
            //email cancel
            $url = "http://" . $_SERVER["HTTP_HOST"] . str_replace('\\', '/', dirname($_SERVER["PHP_SELF"]))
                . "/cancelbooking-booking-" . $id_booking;
            //body of the eamil
            $body = "<h1>Thanks " . $booking['user_name'] . " Your booking in Betelgueser is confirmed. </h1>
             <h2>BOOKING-DETAILS</h2>
             <p>Room Name : " . $booking['room_name'] . " </p>
             <p>Room price : " . $price . " euro </p>
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
            $email = $booking['email'];
            $model = new EmailManager($email, $subject, $body);
            header("location:bookingback-error-Booking details have been sent to customer email");
            exit();
        }

    }
}
