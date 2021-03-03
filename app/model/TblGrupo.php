<?php

class TblGrupo extends TRecord
{
    const TABLENAME  = 'tbl_grupo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const grupo_apuradores = '1';
    const grupo_lideres = '2';
    const grupo_outros = '3';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('grupo');
            
    }

    /**
     * Method getTblResponsaveiss
     */
    public function getTblResponsaveiss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tbl_grupo_id', '=', $this->id));
        return TblResponsaveis::getObjects( $criteria );
    }

    
}

