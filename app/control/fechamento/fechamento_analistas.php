<?php
class fechamento_analistas extends TPage{
    private $form;
    private $loaded;

    private static $database = 'db_fox_fiscal';
    private static $activerecord = 'TblFechamento';
    private static $primarykey = 'id';
    private static $formname  = 'fechamento_analistas';

Public function __construct(){

    parent::__construct();
    
    TTransaction::open(self::$database);
    $conn = TTransaction::get();

    $result = $conn->query("SELECT COUNT(tbl_fechamento_ERPxLivros_id) AS 'qtd' FROM tbl_fechamento");
    foreach($result as $row){
        $resultado = $row['qtd'];
    }
    TTransaction::close();

    $this->form = new BootstrapFormBuilder(self::$formname);
    $this->form->setFormTitle("Fechamento de lojas");

    $row1 = $this->form->addFields([new TLabel($resultado) ]);
    $row1->layout = ['col-sm-1'];

    

    parent::add($this->form);

}
public function onShow($param = null){}
public function show()
{
    parent::show();
}
}