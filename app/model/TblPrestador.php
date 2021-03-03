<?php

class TblPrestador extends TRecord
{
    const TABLENAME  = 'tbl_prestador';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cod');
        parent::addAttribute('doc');
        parent::addAttribute('nome');
            
    }

    /**
     * Method getTblProtFinancs
     */
    public function getTblProtFinancs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('prestador_id', '=', $this->id));
        return TblProtFinanc::getObjects( $criteria );
    }

    
}

