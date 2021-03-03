<?php

class TblPagamento extends TRecord
{
    const TABLENAME  = 'tbl_pagamento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $loja;
    private $descricaoImp;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('valor');
        parent::addAttribute('datavenc');
        parent::addAttribute('loja_id');
        
        parent::addAttribute('descricaoImp_id');
        parent::addAttribute('saldo_credor');
        parent::addAttribute('uf_destino_id');
        parent::addAttribute('codReceita');
        parent::addAttribute('usuario');
            
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
     * Method set_tbl_descrImp
     * Sample of usage: $var->tbl_descrImp = $object;
     * @param $object Instance of TblDescrimp
     */
    public function set_descricaoImp(TblDescrimp $object)
    {
        $this->descricaoImp = $object;
        $this->descricaoImp_id = $object->id;
    
    }

    /**
     * Method get_descricaoImp
     * Sample of usage: $var->descricaoImp->attribute;
     * @returns TblDescrimp instance
     */
    public function get_descricaoImp()
    {
    
        // loads the associated object
        if (empty($this->descricaoImp))
            $this->descricaoImp = new TblDescrimp($this->descricaoImp_id);
    
        // returns the associated object
        return $this->descricaoImp;
    }

    public function get_ufDestino()
    {
        if (empty($this->ufDestino))
            $this->ufDestino = new TblUf($this->uf_destino_id);

         return $this->ufDestino;   
    }
    public function set_ufDestino(TblUf $object)
    {
        $this->ufDestino = $object;
        $this->uf_destino_id = $object->id;
    }
}

