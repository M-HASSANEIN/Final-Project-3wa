<?php

class DivingController extends SiteBaseController
{

    public function  display()
    {
        $title="DIVING";
        $template = 'Diving.phtml';
        include 'views/LayoutFrontend.phtml';
    }
}