<?php

class TblSexo extends TRecord
{
    const TABLENAME  = 'tbl_Sexo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const sexo_masculino = '1';
    const sexo_feminino = '2';
    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('sexo');
            
    }

    /**
     * Method getTblResponsaveiss
     */
    public function getTblResponsaveiss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('id', '=', $this->id));
        return TblResponsaveis::getObjects( $criteria );
    }

    
}