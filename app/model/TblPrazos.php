<?php

class TblPrazos extends TRecord
{
    const TABLENAME  = 'tbl_prazos';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $uf;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('uf_id');
        parent::addAttribute('data_icms');
        parent::addAttribute('data_iss');
        parent::addAttribute('data_fecop');
        parent::addAttribute('data_difal');
        parent::addAttribute('data_antecipado');
        parent::addAttribute('data_sped');
        parent::addAttribute('data_declaracao');
    
            
    }

    /**
     * Method set_tbl_uf
     * Sample of usage: $var->tbl_uf = $object;
     * @param $object Instance of TblUf
     */
    public function set_uf(TblUf $object)
    {
        $this->uf = $object;
        $this->uf_id = $object->id;
    }

    /**
     * Method get_uf
     * Sample of usage: $var->uf->attribute;
     * @returns TblUf instance
     */
    public function get_uf()
    {
    
        // loads the associated object
        if (empty($this->uf))
            $this->uf = new TblUf($this->uf_id);
    
        // returns the associated object
        return $this->uf;
    }

    
}

