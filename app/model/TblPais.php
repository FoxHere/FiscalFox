<?php

class TblPais extends TRecord
{
    const TABLENAME  = 'tbl_pais';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const pais_brasil = '1';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pais');
            
    }

    /**
     * Method getTblUfs
     */
    public function getTblUfs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pais_id', '=', $this->id));
        return TblUf::getObjects( $criteria );
    }

    
}

