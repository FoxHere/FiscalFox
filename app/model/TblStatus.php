<?php

class TblStatus extends TRecord
{
    const TABLENAME  = 'tbl_status';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const status_ativa = '1';
    const status_baixada = '2';
    const status_baixando = '3';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('status');
            
    }

    /**
     * Method getTblLojass
     */
    public function getTblLojass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('id', '=', $this->id));
        return TblLojas::getObjects( $criteria );
    }

    
}

