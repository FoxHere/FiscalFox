<?php

class TblFechamento extends TRecord
{
    const TABLENAME  = 'tbl_fechamento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $tbl_lojas;
    private $tbl_Fechamento_Leg;
    private $tbl_fechamento_obs;
    private $tbl_fechamento_ERPxLivros;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('tbl_lojas_id');
        parent::addAttribute('tbl_Fechamento_Leg_id');
        parent::addAttribute('status');
        parent::addAttribute('tbl_fechamento_obs_id');
        parent::addAttribute('tbl_fechamento_ERPxLivros_id');
            
    }

    /**
     * Method set_tbl_lojas
     * Sample of usage: $var->tbl_lojas = $object;
     * @param $object Instance of TblLojas
     */
    public function set_tbl_lojas(TblLojas $object)
    {
        $this->tbl_lojas = $object;
        $this->tbl_lojas_id = $object->id;
    }

    /**
     * Method get_tbl_lojas
     * Sample of usage: $var->tbl_lojas->attribute;
     * @returns TblLojas instance
     */
    public function get_tbl_lojas()
    {
    
        // loads the associated object
        if (empty($this->tbl_lojas))
            $this->tbl_lojas = new TblLojas($this->id);
            $valueUFid = $this->tbl_lojas->uf_id;
        // returns the associated object
        return $this->tbl_lojas;
    }
    /**
     * Method set_tbl_Fechamento_Legenda
     * Sample of usage: $var->tbl_Fechamento_Legenda = $object;
     * @param $object Instance of TblFechamentoLegenda
     */
    public function set_tbl_Fechamento_Leg(TblFechamentoLegenda $object)
    {
        $this->tbl_Fechamento_Leg = $object;
        $this->tbl_Fechamento_Leg_id = $object->id;
    }

    /**
     * Method get_tbl_Fechamento_Leg
     * Sample of usage: $var->tbl_Fechamento_Leg->attribute;
     * @returns TblFechamentoLegenda instance
     */
    public function get_tbl_Fechamento_Leg()
    {
    
        // loads the associated object
        if (empty($this->tbl_Fechamento_Leg))
            $this->tbl_Fechamento_Leg = new TblFechamentoLegenda($this->tbl_Fechamento_Leg_id);
    
        // returns the associated object
        return $this->tbl_Fechamento_Leg;
    }
    /**
     * Method set_tbl_fechamento_obs
     * Sample of usage: $var->tbl_fechamento_obs = $object;
     * @param $object Instance of TblFechamentoObs
     */
    public function set_tbl_fechamento_obs(TblFechamentoObs $object)
    {
        $this->tbl_fechamento_obs = $object;
        $this->tbl_fechamento_obs_id = $object->id;
    }

    /**
     * Method get_tbl_fechamento_obs
     * Sample of usage: $var->tbl_fechamento_obs->attribute;
     * @returns TblFechamentoObs instance
     */
    public function get_tbl_fechamento_obs()
    {
    
        // loads the associated object
        if (empty($this->tbl_fechamento_obs))
            $this->tbl_fechamento_obs = new TblFechamentoObs($this->tbl_fechamento_obs_id);
    
        // returns the associated object
        return $this->tbl_fechamento_obs;
    }
    /**
     * Method set_tbl_fechamento_ERPxLivros
     * Sample of usage: $var->tbl_fechamento_ERPxLivros = $object;
     * @param $object Instance of TblFechamentoErpxlivros
     */
    public function set_tbl_fechamento_ERPxLivros(TblFechamentoErpxlivros $object)
    {
        $this->tbl_fechamento_ERPxLivros = $object;
        $this->tbl_fechamento_ERPxLivros_id = $object->id;
    }

    /**
     * Method get_tbl_fechamento_ERPxLivros
     * Sample of usage: $var->tbl_fechamento_ERPxLivros->attribute;
     * @returns TblFechamentoErpxlivros instance
     */
    public function get_tbl_fechamento_ERPxLivros()
    {
    
        // loads the associated object
        if (empty($this->tbl_fechamento_ERPxLivros))
            $this->tbl_fechamento_ERPxLivros = new TblFechamentoErpxlivros($this->tbl_fechamento_ERPxLivros_id);
    
        // returns the associated object
        return $this->tbl_fechamento_ERPxLivros;
    }

    public function set_loja(TblLojas $object)
    {
        $this->loja = $object;
        $this->id = $object->id;
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
            $this->loja = new TblLojas($this->id);
    
        // returns the associated object
        return $this->loja;
    }
}

