<?php

class TblCategoria extends TRecord
{
    const TABLENAME  = 'tbl_categoria';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('categoria');
            
    }

    /**
     * Method getTblProtFinancs
     */
    public function getTblProtFinancs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categoria_id', '=', $this->id));
        return TblProtFinanc::getObjects( $criteria );
    }

    
}

