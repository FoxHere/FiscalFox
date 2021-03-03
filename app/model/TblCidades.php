<?php

class TblCidades extends TRecord
{
    const TABLENAME  = 'tbl_cidades';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $uf;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cidades');
        parent::addAttribute('uf_id');
            
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
     * Method getTblLojass
     */
    public function getTblLojass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cidades_id', '=', $this->id));
        return TblLojas::getObjects( $criteria );
    }
    /**
     * Method getTblSenhasmunicipaiss
     */
    public function getTblSenhasmunicipaiss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cidades_id', '=', $this->id));
        return TblSenhasmunicipais::getObjects( $criteria );
    }

    
}

