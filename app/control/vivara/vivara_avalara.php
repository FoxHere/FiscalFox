<?php
/**
 * WelcomeView
 *
 * @version    1.0
 * @package    control
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class vivara_avalara extends TPage
{
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
                
        $link_web = "https://portal.avalarabrasil.com.br";
        $webFrame = new TElement('iframe');
        $webFrame->id = "iframe_external";
        $webFrame->src = $link_web;
        $webFrame->frameborder = "0";
        $webFrame->scrolling = "yes";
        $webFrame->width = "100%";
        $webFrame->height = "800px";

        $vbox = TVBox::pack($webFrame);
        $vbox->style = 'display:block; width: 100%;';
        
        // add the template to the page
        parent::add( $vbox );
    }
}
