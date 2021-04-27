<?php 

class HomeController extends SiteBaseController
{
  public function display()
  {
    
       //loading template
      $title="HOME";
      $template = 'Home_Front.phtml';
      include 'views/LayoutFrontend.phtml';
  }
}