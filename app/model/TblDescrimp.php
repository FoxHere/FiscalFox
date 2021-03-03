<?php

class TblDescrimp extends TRecord
{
    const TABLENAME  = 'tbl_descrImp';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
            
    }

    /**
     * Method getTblPagamentos
     */
    public function getTblPagamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('descricaoImp_id', '=', $this->id));
        return TblPagamento::getObjects( $criteria );
    }

    
}

