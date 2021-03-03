<?php

class TblResponsaveis extends TRecord
{
    const TABLENAME  = 'tbl_responsaveis';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const vitor_oliveira = '1';
    const marcia_teixeira = '2';
    const tamires_alves = '3';
    const luciana_tiago = '4';

    private $tbl_grupo;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('responsavel');
        parent::addAttribute('re');
        parent::addAttribute('tbl_grupo_id'); 
        parent::addAttribute('sexo_id');   
    }

    /**
     * Method set_tbl_grupo
     * Sample of usage: $var->tbl_grupo = $object;
     * @param $object Instance of TblGrupo
     */
    public function set_tbl_grupo(TblGrupo $object)
    {
        $this->tbl_grupo = $object;
        $this->tbl_grupo_id = $object->id;
    }

    /**
     * Method get_tbl_grupo
     * Sample of usage: $var->tbl_grupo->attribute;
     * @returns TblGrupo instance
     */
    public function get_tbl_grupo()
    {
    
        // loads the associated object
        if (empty($this->tbl_grupo))
            $this->tbl_grupo = new TblGrupo($this->tbl_grupo_id);
    
        // returns the associated object
        return $this->tbl_grupo;
    }
    public function set_tbl_sexo(TblSexo $object)
    {
        $this->tbl_sexo = $object;
        $this->sexo_id = $object->id;
    }
    public function get_tbl_sexo()
    {
        if (empty($this->tbl_sexo))
        $this->tbl_sexo = new TblSexo($this->sexo_id);
        return $this->tbl_sexo;
    }
    /**
     * Method getTblLojass
     */
    public function getTblLojass()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('responsavel_id', '=', $this->id));
        return TblLojas::getObjects( $criteria );
    }

    
}

