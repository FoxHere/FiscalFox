<?php

class Form_FinanceiroDocument extends TPage
{
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblProtFinanc';
    private static $primaryKey = 'id';
    private static $htmlFile = 'app/documents/Form_FinanceiroDocumentTemplate.html';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {

    }

    public static function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $class = self::$activeRecord;
            $object = new $class($param['key']);

            $html = new AdiantiHTMLDocumentParser(self::$htmlFile);
            $html->setMaster($object);

            $html->process();

            $document = 'tmp/'.uniqid().'.pdf'; 
            $html->saveAsPDF($document, 'A4', 'portrait');

            TTransaction::close();

            if(empty($param['returnFile']))
            {
                parent::openFile($document);

                new TMessage('info', _t('Document successfully generated'));    
            }
            else
            {
                return $document;
            }
        } 
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }

}

