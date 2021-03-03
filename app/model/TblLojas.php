<?php

class TblLojas extends TRecord
{
    const TABLENAME  = 'tbl_lojas';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $status;
    private $cidades;
    private $empresa;
    private $responsavel;
    private $uf;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('empresa_id');
        parent::addAttribute('status_id');
        parent::addAttribute('numCapta');
        parent::addAttribute('loja');
        parent::addAttribute('uf_id');
        parent::addAttribute('endereco');
        parent::addAttribute('cidades_id');
        parent::addAttribute('cep');
        parent::addAttribute('shopping');
        parent::addAttribute('cnpj');
        parent::addAttribute('inscEstadual');
        parent::addAttribute('inscMunicipal');
        parent::addAttribute('nire');
        parent::addAttribute('responsavel_id');
        parent::addAttribute('dataAbertura');
        parent::addAttribute('dataEncerramento');
            
    }

    /**
     * Method set_tbl_status
     * Sample of usage: $var->tbl_status = $object;
     * @param $object Instance of TblStatus
     */
    public function set_status(TblStatus $object)
    {
        $this->status = $object;
        $this->status_id = $object->id;
    }

    /**
     * Method get_status
     * Sample of usage: $var->status->attribute;
     * @returns TblStatus instance
     */
    public function get_status()
    {
    
        // loads the associated object
        if (empty($this->status))
            $this->status = new TblStatus($this->status_id);
    
        // returns the associated object
        return $this->status;
    }
    /**
     * Method set_tbl_cidades
     * Sample of usage: $var->tbl_cidades = $object;
     * @param $object Instance of TblCidades
     */
    public function set_cidades(TblCidades $object)
    {
        $this->cidades = $object;
        $this->cidades_id = $object->id;
    }

    /**
     * Method get_cidades
     * Sample of usage: $var->cidades->attribute;
     * @returns TblCidades instance
     */
    public function get_cidades()
    {
    
        // loads the associated object
        if (empty($this->cidades))
            $this->cidades = new TblCidades($this->cidades_id);
    
        // returns the associated object
        return $this->cidades;
    }
    /**
     * Method set_tbl_empresa
     * Sample of usage: $var->tbl_empresa = $object;
     * @param $object Instance of TblEmpresa
     */
    public function set_empresa(TblEmpresa $object)
    {
        $this->empresa = $object;
        $this->empresa_id = $object->id;
    }

    /**
     * Method get_empresa
     * Sample of usage: $var->empresa->attribute;
     * @returns TblEmpresa instance
     */
    public function get_empresa()
    {
    
        // loads the associated object
        if (empty($this->empresa))
            $this->empresa = new TblEmpresa($this->empresa_id);
    
        // returns the associated object
        return $this->empresa;
    }
    /**
     * Method set_tbl_responsaveis
     * Sample of usage: $var->tbl_responsaveis = $object;
     * @param $object Instance of TblResponsaveis
     */
    public function set_responsavel(TblResponsaveis $object)
    {
        $this->responsavel = $object;
        $this->responsavel_id = $object->id;
    }

    /**
     * Method get_responsavel
     * Sample of usage: $var->responsavel->attribute;
     * @returns TblResponsaveis instance
     */
    public function get_responsavel()
    {
    
        // loads the associated object
        if (empty($this->responsavel))
            $this->responsavel = new TblResponsaveis($this->responsavel_id);
    
        // returns the associated object
        return $this->responsavel;
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

    /**
     * Method getTblSenhasmunicipaiss
     */
    public function getTblSenhasmunicipaiss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('loja_id', '=', $this->id));
        return TblSenhasmunicipais::getObjects( $criteria );
    }
    /**
     * Method getTblSenhasestaduaiss
     */
    public function getTblSenhasestaduaiss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('loja_id', '=', $this->id));
        return TblSenhasestaduais::getObjects( $criteria );
    }
    public function getTblFechamentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('id', '=', $this->id));
        return TblFechamento::getObjects( $criteria );
    }

    
}

