<?php

class TblEmpresa extends TRecord
{
    const TABLENAME  = 'tbl_empresa';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const vivara = '1';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('empresa');
            
    }

    /**
     * Method getTblLojass
     */
    public function getTblLojass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('empresa_id', '=', $this->id));
        return TblLojas::getObjects( $criteria );
    }

    
}

