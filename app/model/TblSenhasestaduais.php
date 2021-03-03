<?php

class TblSenhasestaduais extends TRecord
{
    const TABLENAME  = 'tbl_senhasEstaduais';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $loja;
    private $uf;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('loja_id');
        parent::addAttribute('uf_id');
        parent::addAttribute('login');
        parent::addAttribute('senha');
        parent::addAttribute('local');
            
    }

    /**
     * Method set_tbl_lojas
     * Sample of usage: $var->tbl_lojas = $object;
     * @param $object Instance of TblLojas
     */
    public function set_loja(TblLojas $object)
    {
        $this->loja = $object;
        $this->loja_id = $object->id;
    }

    /**
     * Method get_loja
     * Sample of usage: $var->loja->attribute;
     * @returns TblLojas instance
     */
    public function get_loja()
    {
    
        // loads the associated object
        if (empty($this->loja))
            $this->loja = new TblLojas($this->loja_id);
    
        // returns the associated object
        return $this->loja;
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

