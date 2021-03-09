<?php

class FormList_LojaCad2 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblLojas';
    private static $primaryKey = 'id';
    private static $formName = 'form_TblLojas';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("<b>Edição da loja</b>");

        $criteria_responsavel_id = new TCriteria();

        $filterVar = 1;
        $criteria_responsavel_id->add(new TFilter('tbl_grupo_id', '=', $filterVar)); 

        $id = new TEntry('id');
        $loja = new TEntry('loja');
        $status_id = new TDBCombo('status_id', 'db_fox_fiscal', 'TblStatus', 'id', '{status}','status asc'  );
        $empresa_id = new TDBCombo('empresa_id', 'db_fox_fiscal', 'TblEmpresa', 'id', '{empresa}','empresa asc'  );
        $numCapta = new TEntry('numCapta');
        $endereco = new TEntry('endereco');
        $cidades_id = new TDBUniqueSearch('cidades_id', 'db_fox_fiscal', 'TblCidades', 'id', 'cidades','cidades asc'  );
        $uf_id = new TDBCombo('uf_id', 'db_fox_fiscal', 'TblUf', 'id', '{uf}','uf asc'  );
        $cep = new TEntry('cep');
        $shopping = new TEntry('shopping');
        $cnpj = new TEntry('cnpj');
        $inscEstadual = new TEntry('inscEstadual');
        $inscMunicipal = new TEntry('inscMunicipal');
        $nire = new TEntry('nire');
        $responsavel_id = new TDBCombo('responsavel_id', 'db_fox_fiscal', 'TblResponsaveis', 'id', '{responsavel} - {tbl_grupo->grupo}','responsavel asc' , $criteria_responsavel_id );
        $dataAbertura = new TDate('dataAbertura');
        $dataEncerramento = new TDate('dataEncerramento');

        $empresa_id->addValidation("de <b>Empresa</b>", new TRequiredValidator()); 
        $status_id->addValidation("de <b>Status</b>", new TRequiredValidator()); 
        $numCapta->addValidation("de <b>Nº</b>", new TRequiredValidator()); 
        $uf_id->addValidation("de <b>UF</b>", new TRequiredValidator()); 
        $cidades_id->addValidation("de <b>Cidade</b>", new TRequiredValidator()); 
        $cnpj->addValidation("de <b>CNPJ</b>", new TRequiredValidator()); 
        $responsavel_id->addValidation("de <b>Responsável</b>", new TRequiredValidator()); 

        
        $id->setEditable(false);

        $nire->placeholder = "Sem pontuação";
        $numCapta->setMask('0000');
        $cep->setMask('00000-000');
        $dataAbertura->setDatabaseMask('yyyy-mm-dd');
        $dataEncerramento->setDatabaseMask('yyyy-mm-dd');
        $cidades_id->setMask('{cidades} - {uf->uf}');
        $cidades_id->setMinLength(1);

        $dataAbertura->setMask('dd/mm/yyyy');
        $dataEncerramento->setMask('dd/mm/yyyy');
        
        $inscEstadual->setTip("Sem pontuação");
        $inscMunicipal->setTip("Sem pontuação");
        $cep->setTip("Sem pontuação");
        $cnpj->setTip("Sem pontuação");
        $numCapta->setTip("Numero encontrado na tabela de cadastro do capta");
        /*
        $loja->setMaxLength(10);
        $cep->setMaxLength(20);
        $cnpj->setMaxLength(30);
        $nire->setMaxLength(150);
        $endereco->setMaxLength(60);
        $shopping->setMaxLength(30);
        $inscEstadual->setMaxLength(30);
        $inscMunicipal->setMaxLength(30);
        */
        $id->setSize('100%');
        $cep->setSize('100%');
        $nire->setSize('100%');
        $loja->setSize('100%');
        $uf_id->setSize('100%');
        $cnpj->setSize('100%');
        $numCapta->setSize('100%');
        $shopping->setSize('100%');
        $status_id->setSize('100%');
        $endereco->setSize('100%');
        $empresa_id->setSize('100%');
        $cidades_id->setSize('100%');
        $inscEstadual->setSize('100%');
        $inscMunicipal->setSize('100%');
        $responsavel_id->setSize('100%');
        //Dados pricipais-------------------------------------------------------------------------------------
        $row1 = $this->form->addContent([new TFormSeparator("<b>Dados Principais</b>", '#fc9668', '18px', '#000000')]);
        
        $row2 = $this->form->addFields([new TLabel("Id:", null, '14px', 'B')],[$id],[new TLabel("Loja:", null, '14px', 'B')],[$loja],[new TLabel("Status:", null, '14px', 'B')],[$status_id],[new TLabel("Empresa:", null, '14px', 'B')],[$empresa_id],[new TLabel("Nº do Capta:", null, '14px', 'B')],[$numCapta]);
        $row2->layout = [' col-sm-1 control-label',' col-sm-1',' col-sm-1 control-label',' col-sm-1',' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label',' col-sm-1',' col-sm-1','col-sm-2'];
        
        $row3 = $this->form->addFields([new TLabel("Responsável:", null, '14px', 'B')],[$responsavel_id]);
        $row3->layout = [' col-sm-1 control-label',' col-sm-11'];
        //----------------------------------------------------------------------------------------------------          
        //Localização-----------------------------------------------------------------------------------------
        $row4 = $this->form->addContent([new TFormSeparator("<b>Localização</b>", '#fc9668', '14px', '#000000')]);

        $row5 = $this->form->addFields([new TLabel("Endereço:", null, '14px', 'B')],[$endereco]);
        $row5->layout = [' col-sm-1 control-label',' col-sm-11'];

        $row6 = $this->form->addFields([new TLabel("Cidade:", null, '14px', 'B')],[$cidades_id],[new TLabel("UF:", null, '14px', 'B')],[$uf_id],[new TLabel("CEP:", null, '14px', 'B')],[$cep],[new TLabel("Shopping:", null, '14px', 'B')],[$shopping]);
        $row6->layout = [' col-sm-1 control-label',' col-sm-3',' col-sm-1 control-label',' col-sm-1',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label','col-sm-2'];
        //----------------------------------------------------------------------------------------------------  
        //Documentos legais-----------------------------------------------------------------------------------
        $row7 = $this->form->addContent([new TFormSeparator("<b>Documentação legal</b>", '#fc9668', '14px', '#000000')]);

        $row8 = $this->form->addFields([new TLabel("CNPJ:", null, '14px', 'B')],[$cnpj],[new TLabel("I.E:", null, '14px', 'B')],[$inscEstadual],[new TLabel("I.M:", null, '14px', 'B')],[$inscMunicipal],[new TLabel("NIRE:", null, '14px', 'B')],[$nire]);
        $row8->layout = [' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label','col-sm-2'];
        //----------------------------------------------------------------------------------------------------  
        //Datas-----------------------------------------------------------------------------------------------
        $row9 = $this->form->addFields([new TLabel("Data Abertura:", null, '14px', 'B')],[$dataAbertura],[new TLabel("Data Encerramento:", null, '14px', 'B')],[$dataEncerramento]);
        $row9->layout = [' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label',' col-sm-2'];
        



        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:18px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);
        $style = new TStyle('right-panel');
        $style->width = '60% !important';   
        $style->show();

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new TblLojas(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'), $messageAction);

                TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new TblLojas($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

}

