<?php

class TblFechamentoErpxlivros extends TRecord
{
    const TABLENAME  = 'tbl_fechamento_erpxlivros';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('erpxlivros');
            
    }

    /**
     * Method getTblFechamentos
     */
    public function getTblFechamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tbl_fechamento_ERPxLivros_id', '=', $this->id));
        return TblFechamento::getObjects( $criteria );
    }

    
}

