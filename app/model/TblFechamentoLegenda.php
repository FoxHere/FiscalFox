<?php

class TblFechamentoLegenda extends TRecord
{
    const TABLENAME  = 'tbl_fechamento_legenda';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('legenda');
            
    }

    /**
     * Method getTblFechamentos
     */
    public function getTblFechamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tbl_Fechamento_Leg_id', '=', $this->id));
        return TblFechamento::getObjects( $criteria );
    }

    
}

