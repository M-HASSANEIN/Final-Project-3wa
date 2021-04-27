<?php

class CustomersBackController extends SiteBaseController
{
  // show customer backend
  public function ShowdataCustomers()
  {
    $title="Customers-Back";
    $template = 'Customers_back.phtml';
    include 'views/LayoutBackend.phtml';
    exit();
  }
   // delete  customer backend
  public function DeleteCustomerData()
  {
   $id_customer=$_GET["CUSTOMER"];
   $model=new Customers();
   $model-> DeleteCustomer($id_customer);
   header("location:index.php?page=CustomersBack&error=customer data has been deleted");
   exit();
  }
  // SHOW edit  customer backend
  public function ShoweditCustomerPage()
  {
   $id_customer=$_GET["CUSTOMER"];
   $model=new Customers();
   $customer=$model->GetCustomersDataByID($id_customer);
   $title="Customers-Edite";
   $template = 'Edite_Customer_BACK.phtml';
   include 'views/LayoutBackend.phtml';
   exit();
  }
  //edit custmer address
  public function ModifyCustomerDataBase()
  {
    if (isset($_POST["submit-customer"]))
    {
      $id_customer=$_GET["CUSTOMER"];
      $address=$_POST["address"];
      $zipcode=$_POST["zipcode"];
      $country=$_POST["country"];
      $phone=$_POST["phone"];
      $model=new Customers();
      $model-> EditeCustomerData($address,$zipcode,$country,$phone,$id_customer);
      header("location:index.php?page=CustomersBack&error=customer data has been updated");
      exit();
    }
    
  }

}