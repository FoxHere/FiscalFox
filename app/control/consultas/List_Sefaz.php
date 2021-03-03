<?php

class List_Sefaz extends TPage
{
    private $form; // form
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblSefaz';
    private static $formName = 'formList_TblSefaz';
    

    public function __construct($param){
        parent::__construct();
        /*
        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setFormTitle('Consulta Sefaz');

        $apelido = new TDBCombo('apelido','db_fox_fiscal', 'TblSefaz', 'id', '{apelido}','id asc');
        $apelido->setChangeAction( new TAction([$this, 'bringSefaz']));
        $link = new TEntry('link');
        $link->setEditable(false);
        
        if(isset($param['link']))
        {
        $link_web = $param['link'];
        }else
        {
            $link_web = null;
        } 
        $webFrame = new TElement('iframe');
        $webFrame->id = "iframe_external";
        $webFrame->src = $link_web;
        $webFrame->frameborder = "0";
        $webFrame->scrolling = "yes";
        $webFrame->width = "100%";
        $webFrame->height = "600px";
        
        $row1 = $this->form->addFields([$apelido], [$link]);
        $row2 = $this->form->addFields([$webFrame]);

        
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($this->form);
        parent::add($container);
        */
        $link_web = "http://easy.vivara.com.br/foxpaginasinternas/";
        $webFrame = new TElement('iframe');
        $webFrame->id = "iframe_external";
        $webFrame->src = $link_web;
        $webFrame->frameborder = "0";
        $webFrame->scrolling = "yes";
        $webFrame->width = "100%";
        $webFrame->height = "1000px";

        $vbox = TVBox::pack($webFrame);
        $vbox->style = 'display:block; width: 100%; ';
        parent::add( $vbox );
    }
    /*
    }

        public static function bringSefaz($param)
        {

            TTransaction::open(self::$database);
                $dbLink = new TblSefaz($param['apelido']);
            TTransaction::close();

            $pageParam = ['link' => $dbLink->link]; // ex.: = ['key' => 10]

            TApplication::loadPage('List_Sefaz', 'onEdit', $pageParam);

        }

        public function onEdit( $param )//</ini>
    {
        try
        {
            if (isset($param['link']))
            {
                $obj = new stdClass();
                $obj->link = $param['link'];
                $this->form->setData($obj); // fill the form //</blockLine>
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }//</end>
    */





}