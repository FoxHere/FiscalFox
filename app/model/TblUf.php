<?php

class TblUf extends TRecord
{
    const TABLENAME  = 'tbl_uf';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const brasil_AL = '1';
    const brasil_AM = '2';
    const brasil_AP = '3';
    const brasil_BA = '4';
    const brasil_CE = '5';
    const brasil_DF = '6';
    const brasil_ES = '7';
    const brasil_GO = '8';
    const brasil_MA = '9';
    const brasil_MG = '10';
    const brasil_MS = '11';
    const brasil_MT = '12';
    const brasil_PA = '13';
    const brasil_PB = '14';
    const brasil_PE = '15';
    const brasil_PI = '16';
    const brasil_PR = '17';
    const brasil_RN = '18';
    const brasil_RO = '19';
    const brasil_RS = '20';
    const brasil_SC = '21';
    const brasil_SE = '22';
    const brasil_SP = '23';
    const brasil_TO = '24';

    private $pais;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('uf');
        parent::addAttribute('pais_id');
            
    }

    /**
     * Method set_tbl_pais
     * Sample of usage: $var->tbl_pais = $object;
     * @param $object Instance of TblPais
     */
    public function set_pais(TblPais $object)
    {
        $this->pais = $object;
        $this->pais_id = $object->id;
    }

    /**
     * Method get_pais
     * Sample of usage: $var->pais->attribute;
     * @returns TblPais instance
     */
    public function get_pais()
    {
    
        // loads the associated object
        if (empty($this->pais))
            $this->pais = new TblPais($this->pais_id);
    
        // returns the associated object
        return $this->pais;
    }

    /**
     * Method getTblCidadess
     */
    public function getTblCidadess()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('uf_id', '=', $this->id));
        return TblCidades::getObjects( $criteria );
    }
    /**
     * Method getTblLojass
     */
    public function getTblLojass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('uf_id', '=', $this->id));
        return TblLojas::getObjects( $criteria );
    }
    /**
     * Method getTblPrazoss
     */
    public function getTblPrazoss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('uf_id', '=', $this->id));
        return TblPrazos::getObjects( $criteria );
    }
    /**
     * Method getTblSenhasmunicipaiss
     */
    public function getTblSenhasmunicipaiss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('uf_id', '=', $this->id));
        return TblSenhasmunicipais::getObjects( $criteria );
    }
    /**
     * Method getTblSenhasestaduaiss
     */
    public function getTblSenhasestaduaiss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('uf_id', '=', $this->id));
        return TblSenhasestaduais::getObjects( $criteria );
    }
    public function getTblPagamentoss()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('uf_destino_id', '=', $this->uf));
        return Tblpagamentos::getObjects( $criteria );
    }
    
    
}

