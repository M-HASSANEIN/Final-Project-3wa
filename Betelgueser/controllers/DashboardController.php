<?php 

class DashboardController extends SiteBaseController
{
  public function display()
  {
       //loading template
      $title="Dashboard";
      $template = 'dashboard_backend.phtml';
      include 'views/LayoutBackend.phtml';
  }
}