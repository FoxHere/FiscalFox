<?php

class TblDepartamento extends TRecord
{
    const TABLENAME  = 'tbl_departamento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('departamento');
            
    }

    /**
     * Method getTblProtFinancs
     */
    public function getTblProtFinancs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('departamento_id', '=', $this->id));
        return TblProtFinanc::getObjects( $criteria );
    }

    
}

