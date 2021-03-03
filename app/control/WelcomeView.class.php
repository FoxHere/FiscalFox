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
class WelcomeView extends TPage
{
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
        
        //$html1 = new THtmlRenderer('app/resources/system_welcome_en.html');
        //$html2 = new THtmlRenderer('app/resources/system_welcome_pt.html');
        //$html3 = new THtmlRenderer('app/resources/system_welcome_es.html');

        // replace the main section variables
        //$html1->enableSection('main', array());
        //$html2->enableSection('main', array());
        //$html3->enableSection('main', array());
        
        //$panel1 = new TPanelGroup('Welcome!');
        //$panel1->add($html1);
        
        //$panel2 = new TPanelGroup('Bem-vindo!');
        //$panel2->add($html2);
		
        //$panel3 = new TPanelGroup('Bienvenido!');
        //$panel3->add($html3);
        
        $link_web = "http://easy.vivara.com.br/foxPaginasInternas/";
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
