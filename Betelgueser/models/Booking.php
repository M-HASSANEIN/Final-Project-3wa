<?php
class Booking extends ModelManager
{    ///get all booking
    public function GetBookingInfo()
    {
        $req =
             "SELECT *FROM booking
              INNER JOIN clients ON clients.id_client = booking.id_client
              INNER JOIN rooms ON rooms.id_room = booking.id_room
              ORDER by id_booking ASC"  ;
              return $this -> queryFetchAll($req);
    }
    ///create new booking
    public function CreateBookingtoDbase($id_client ,$date,$from_date,$to_date ,$period_of_stay ,$comments, $id_room,$total)
    {
        $req=
              "INSERT INTO booking(`id_client` ,`date`,`from_date`,`to_date` ,`period_of_stay`,`comments`,`id_room`,`total_amount`) VALUES (?,?,?,?,?,?,?,?)";
               $this -> query($req,[$id_client ,$date,$from_date,$to_date ,$period_of_stay ,$comments, $id_room,$total]);
    }
    ///call booking by id 
    public function CallBookingById($id)
    {
        $req = 
              " SELECT *FROM booking
                INNER JOIN clients ON clients.id_client = booking.id_client
                INNER JOIN rooms ON rooms.id_room = booking.id_room
                WHERE id_booking=?";
                return $this -> queryFetch($req,[$id]);
    
    }
    ///delete booking from data base by id
    public function DeleteBookingDbASE($id)
    {
        $req =
              "DELETE FROM booking WHERE id_booking=?";
               $this -> query($req,[$id]);
    }

    ///update booking info 
    public function  UpDateBookingInfo($comments,$date,$from_date,$to_date ,$period_of_stay ,$total, $id_booking)
    {
        $req =
              "UPDATE booking SET comments=?,`date`=?,`from_date`=?,`to_date`=?,`period_of_stay`=?,`total_amount`=? WHERE id_booking=?";
               return  $this -> query($req,[$comments,$date,$from_date,$to_date ,$period_of_stay ,$total,$id_booking]);
    }
    ///update booking with id room back 
    public function  UpDateBookingbackInfo($comments,$date,$from_date,$to_date ,$period_of_stay ,$total,$id_room, $id_booking)
    {
        $req =
              "UPDATE booking SET comments=?,`date`=?,`from_date`=?,`to_date`=?,`period_of_stay`=?,`total_amount`=?,`id_room`=? WHERE id_booking=?";
               return  $this -> query($req,[$comments,$date,$from_date,$to_date ,$period_of_stay ,$total,$id_room,$id_booking]);
    }



}