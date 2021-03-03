<?php

class TblProtFinanc extends TRecord
{
    const TABLENAME  = 'tbl_prot_financ';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $prestador;
    private $categoria;
    private $departamento;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('vencimento');
        parent::addAttribute('num_pedido');
        parent::addAttribute('valor');
        parent::addAttribute('departamento_id');
        parent::addAttribute('envio');
        parent::addAttribute('prestador_id');
        parent::addAttribute('categoria_id');
            
    }

    /**
     * Method set_tbl_prestador
     * Sample of usage: $var->tbl_prestador = $object;
     * @param $object Instance of TblPrestador
     */
    public function set_prestador(TblPrestador $object)
    {
        $this->prestador = $object;
        $this->prestador_id = $object->id;
    }

    /**
     * Method get_prestador
     * Sample of usage: $var->prestador->attribute;
     * @returns TblPrestador instance
     */
    public function get_prestador()
    {
    
        // loads the associated object
        if (empty($this->prestador))
            $this->prestador = new TblPrestador($this->prestador_id);
    
        // returns the associated object
        return $this->prestador;
    }
    /**
     * Method set_tbl_categoria
     * Sample of usage: $var->tbl_categoria = $object;
     * @param $object Instance of TblCategoria
     */
    public function set_categoria(TblCategoria $object)
    {
        $this->categoria = $object;
        $this->categoria_id = $object->id;
    }

    /**
     * Method get_categoria
     * Sample of usage: $var->categoria->attribute;
     * @returns TblCategoria instance
     */
    public function get_categoria()
    {
    
        // loads the associated object
        if (empty($this->categoria))
            $this->categoria = new TblCategoria($this->categoria_id);
    
        // returns the associated object
        return $this->categoria;
    }
    /**
     * Method set_tbl_departamento
     * Sample of usage: $var->tbl_departamento = $object;
     * @param $object Instance of TblDepartamento
     */
    public function set_departamento(TblDepartamento $object)
    {
        $this->departamento = $object;
        $this->departamento_id = $object->id;
    }

    /**
     * Method get_departamento
     * Sample of usage: $var->departamento->attribute;
     * @returns TblDepartamento instance
     */
    public function get_departamento()
    {
    
        // loads the associated object
        if (empty($this->departamento))
            $this->departamento = new TblDepartamento($this->departamento_id);
    
        // returns the associated object
        return $this->departamento;
    }

    
}

