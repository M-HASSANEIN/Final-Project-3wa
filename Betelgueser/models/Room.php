<?php
class Room extends ModelManager
{
    public function GetRoomInfo()
    {
        $req =
        
             "SELECT id_room,room_number,room_name,price_perday,tax,descriptions,status
             FROM rooms
             ORDER by id_room ASC"  ;
             return $this -> queryFetchAll($req);
    }

    public function AddRoomtoDbase($status,$name,$number,$capacity,$price,$tax,$description)
    {
        $req=
        
              "INSERT INTO rooms(status,room_name,room_number,capacity,price_perday,tax,descriptions) VALUES (?,?,?,?,?,?,?)";
              $this -> query($req,[$status,$name,$number,$capacity,$price,$tax,$description]);
       
    }

    public function DeleteRoomDbase($id)
    {
        $req =
                "DELETE FROM rooms WHERE id_room = ?";
                
                $this -> query($req,[$id]);
    }

    public function CallRoombyId($id)
    {
        $req = 
                 " SELECT *
                   FROM rooms
                   INNER JOIN photosrooms ON photosrooms.id_room = rooms.id_room
                   WHERE rooms.id_room=?";
                  
          return  $this -> queryFetch($req,[$id]);

    }
     //UPdate room with out photo
    public function UpDateRoomDbase($number,$name,$price,$tax,$description,$status,$capacity,$id_room)
    {
        $req =
                "UPDATE rooms SET room_number=?,room_name=?,price_perday=?,tax=?,descriptions=?,status=?,capacity =? WHERE id_room = ?";
                
         return  $this -> query($req,[$number,$name,$price,$tax,$description,$status,$capacity,$id_room]);
    }
 
}