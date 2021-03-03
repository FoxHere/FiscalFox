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
        $this->form->setFormTitle("Edição da loja");

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

        $empresa_id->addValidation("Empresa", new TRequiredValidator()); 
        $status_id->addValidation("Status", new TRequiredValidator()); 
        $numCapta->addValidation("Nº", new TRequiredValidator()); 
        $uf_id->addValidation("UF", new TRequiredValidator()); 
        $cidades_id->addValidation("Cidade", new TRequiredValidator()); 
        $cnpj->addValidation("CNPJ", new TRequiredValidator()); 
        $responsavel_id->addValidation("Responsável", new TRequiredValidator()); 

        
        $id->setEditable(false);

        $nire->placeholder = "Sem pontuação";

        $numCapta->setMask('0000');
        $cep->setMask('00000-000');
        $cnpj->setMask('00000000000000');
        $cidades_id->setMask('{cidades} - {uf->uf}');
        $cidades_id->setMinLength(2);
        
       

        $inscMunicipal->setTip("Sem pontuação");
        $cep->setTip("Não precisa de pontuação");
        $cnpj->setTip("não precisa de pontuação");
        $numCapta->setTip("Numero encontrado na tabela de cadastro do capta");

        $loja->setMaxLength(4);
        $cep->setMaxLength(20);
        $cnpj->setMaxLength(30);
        $nire->setMaxLength(150);
        $endereco->setMaxLength(60);
        $shopping->setMaxLength(30);
        $inscEstadual->setMaxLength(30);
        $inscMunicipal->setMaxLength(30);

        $id->setSize(30);
        $cep->setSize('98%');
        $nire->setSize('99%');
        $loja->setSize('100%');
        $uf_id->setSize('94%');
        $cnpj->setSize('100%');
        $numCapta->setSize('98%');
        $shopping->setSize('98%');
        $status_id->setSize('99%');
        $endereco->setSize('100%');
        $empresa_id->setSize('99%');
        $cidades_id->setSize('97%');
        $inscEstadual->setSize('100%');
        $inscMunicipal->setSize('100%');
        $responsavel_id->setSize('100%');

        $row1 = $this->form->addContent([new TFormSeparator("Dados Principais", '#333333', '18', '#eeeeee')]);
        $row2 = $this->form->addFields([new TLabel("Id:", null, '12px', null)],[$id],[new TLabel("Loja:", '#ff0000', '12px', null)],[$loja],[new TLabel("Status:", '#ff0000', '12px', null)],[$status_id],[new TLabel("Empresa:", '#ff0000', '12px', null)],[$empresa_id],[new TLabel("Nº do Capta:", '#ff0000', '12px', null)],[$numCapta]);
        $row2->layout = [' col-sm-1 control-label',' col-sm-1',' col-sm-1 control-label',' col-sm-1',' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label',' col-sm-1',' col-sm-1','col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("Responsável:", '#ff0000', '12px', null)],[$responsavel_id]);
        $row3->layout = [' col-sm-1',' col-sm-11'];

        $row4 = $this->form->addContent([new TFormSeparator("Localização", '#333333', '18', '#eeeeee')]);
        $row5 = $this->form->addFields([new TLabel("Endereço", '#ff0000', '12px', null)],[$endereco]);
        $row5->layout = [' col-sm-1',' col-sm-11'];

        $row6 = $this->form->addFields([new TLabel("Cidade:", '#ff0000', '12px', null)],[$cidades_id],[new TLabel("UF:", '#ff0000', '12px', null)],[$uf_id],[new TLabel("CEP:", '#ff0000', '12px', null)],[$cep],[new TLabel("Shopping:", '#ff0000', '12px', null)],[$shopping]);
        $row6->layout = [' col-sm-1',' col-sm-3',' col-sm-1',' col-sm-1',' col-sm-1','col-sm-2',' col-sm-1','col-sm-2'];

        $row7 = $this->form->addContent([new TFormSeparator("Documentos legais", '#333333', '18', '#eeeeee')]);
        $row8 = $this->form->addFields([new TLabel("CNPJ:", '#ff0000', '12px', null)],[$cnpj],[new TLabel("I.E:", '#ff0000', '12px', null)],[$inscEstadual],[new TLabel("I.M:", null, '12px', null)],[$inscMunicipal],[new TLabel("NIRE:", null, '12px', null)],[$nire]);
        $row8->layout = [' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label','col-sm-2'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:15px;';
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

