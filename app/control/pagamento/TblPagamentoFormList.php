<?php

class TblPagamentoFormList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblPagamento';
    private static $primaryKey = 'id';
    private static $formName = 'form_list_TblPagamento';

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Protocolo pagamento");


        $id = new TEntry('id');
        $loja_id = new TDBUniqueSearch('loja_id', 'db_fox_fiscal', 'TblLojas', 'id', 'loja','loja asc');
        $descricaoImp_id = new TDBCombo('descricaoImp_id', 'db_fox_fiscal', 'TblDescrimp', 'id', '{descricao}','id asc');
        $valor = new TEntry('valor');
        $datavenc = new TDate('datavenc');
        $saldo_credor = new TEntry('saldo_credor');
        $ufDestino = new TDBCombo('uf_destino_id', 'db_fox_fiscal', 'TblUf', 'uf', '{uf}','id asc');
        $codReceita = new TEntry('codReceita');
        $userName = new TEntry('usuario');
        
        $loja_id->addValidation("de <b>loja</b>", new TRequiredValidator()); 
        $valor->addValidation("de <b>valor</b>", new TRequiredValidator()); 
        $descricaoImp_id->addValidation("de <b>descrição do Imposto</b>", new TRequiredValidator()); 
        $datavenc->addValidation("de <b>data de vencimento</b>", new TRequiredValidator()); 
        //$codReceita->addValidation("de <b>código de Receita da guia</b>", new TRequiredValidator()); 
        //-----------------------------------------------------------------------------------------------------------------------
        $filtro_Loja_id = new TDBUniqueSearch('filtro_loja_id', 'db_fox_fiscal', 'TblLojas', 'id', 'loja','loja asc');
        $filtro_descricao_id = new TDBCombo('filtro_descricaoImp_id', 'db_fox_fiscal', 'TblDescrimp', 'id', '{descricao}','id asc');
        $filtro_uf = new TDBCombo('filtro_uf_id', 'db_fox_fiscal', 'TblUf', 'id', '{uf}','id asc');
        $filtro_valor = new TEntry('filtro_valor');
        $filtro_dataVenc = new TDate('filtro_datavenc');
        $filtro_saldoCredor = new TEntry('filtro_saldo_credor');
        $filtro_ufDestino = new TDBCombo('filtro_uf_destino_id', 'db_fox_fiscal', 'TblUf', 'uf', '{uf}','id asc');
        

        //$filtro_user = new TEntry('User');
        //$nomeUsuario = TSession::getValue('userid');
        //-----------------------------------------------------------------------------------------------------------------------
        $id->setEditable(false);
        $userName->setEditable(false);
        $loja_id->setMinLength(1);
        $valor->setMaxLength(50);
        $datavenc->setDatabaseMask('yyyy-mm-dd');
        $filtro_dataVenc->setDatabaseMask('yyyy-mm-dd');
        $saldo_credor->setTip("Crie um lançamento unico se tiver saldo credor");
        $ufDestino->setTip("Somente preencha em caso de imposto ICMS-ST ou Difal/FECP 87/2015");

        //$valor->setMask('0.000,00');
        $datavenc->setMask('dd/mm/yyyy');
        $filtro_dataVenc->setMask('dd/mm/yyyy');
        $loja_id->setMask('{loja} - {uf->uf} ');
        $filtro_Loja_id->setMask('{loja} - {uf->uf} ');
        $id->setSize(70);
        $filtro_valor->setSize('100%');
        $filtro_dataVenc->setSize('100%');
        $filtro_Loja_id->setSize('100%');
        $filtro_saldoCredor->setSize('100%');
        $filtro_descricao_id->setSize('100%');
        $filtro_ufDestino->setSize('100%');
        $filtro_uf->setSize('100%');
        //----------------------------------------------------------------------------------------
        
        $valor->setSize('100%');
        $datavenc->setSize('100%');
        $loja_id->setSize('100%');
        $saldo_credor->setSize('100%');
        $descricaoImp_id->setSize('100%');
        $ufDestino->setSize('100%');
        //$saldo_credor->setValue("0,00");
        

        $descricaoImp_id->setChangeAction( new TAction( array($this, 'saldoCredorChange')));
        //$filtro_descricao_id->setChangeAction( new TAction( array($this, 'onSearch')));
        /*/$filtro_Loja_id->setExitAction( new TAction( array($this, 'onSearch')));
        
        $filtro_uf->setChangeAction( new TAction( array($this, 'onSearch')));
        $filtro_valor->setExitAction( new TAction( array($this, 'onSearch')));
        $filtro_dataVenc->setChangeAction( new TAction( array($this, 'onSearch')));
        $filtro_saldoCredor->setExitAction( new TAction( array($this, 'onSearch')));
        $filtro_ufDestino->setChangeAction( new TAction( array($this, 'onSearch')));
        */  
        $valor->setNumericMask(2,',','.',true);
        $saldo_credor->setNumericMask(2,',','.',true);
        $valor->placeHolder = "0,00";
        $saldo_credor->placeHolder = "0,00";
        $datavenc->placeHolder = "00/00/0000"; //date("d/m/yy");
        
        $row1 = $this->form->addFields([new TLabel("Id", '#000000', '14px', 'B','100%'), $id],[new TLabel("Loja", '#000000', '14px', 'B', '100%'),$loja_id],[new TLabel("Descricao Imposto", '#000000', '14px', 'B', '100%'),$descricaoImp_id],[new TLabel("Cód Receita", '#000000', '14px', 'B'), $codReceita],[new TLabel("Valor", '#000000', '14px', 'B', '100%'),$valor],[new TLabel("Data de vencimento", '#000000', '14px', 'B', '100%'),$datavenc],[new TLabel("Saldo credor", '#000000', '14px', 'B'),$saldo_credor], [new TLabel("UF Destino", '#000000', '14px', 'B'), $ufDestino]);
        $row1->layout = [' col-sm-1',' col-sm-1',' col-sm-4','col-sm-1',' col-sm-1',' col-sm-2','col-sm-1','col-sm-1'];
        //$row2 = $this->form->addFields([new TFormSeparator("", '#333333', '18', '#eeeeee')]);
        //$row3 = $this->form->addFields([new TFormSeparator("Filtros de busca abaixo", '#333333', '18', '#eeeeee')]);
        $row4 = $this->form->addFields([new TLabel("Usuário", '#000000', '14px', 'B', '100%'),$userName],[new TLabel("Procurar loja", '#007bff', '14px', 'B', '100%'),$filtro_Loja_id],[new TLabel("Procurar por descricao Imposto", '#007bff', '14px', 'B', '100%'),$filtro_descricao_id],[new TLabel("Procurar UF", '#007bff', '14px', 'B', '100%'), $filtro_uf],[new TLabel("Procurar valor", '#007bff', '14px', 'B', '100%'),$filtro_valor],[new TLabel("Procurar por vencimento", '#007bff', '14px', 'B', '100%'),$filtro_dataVenc],[new TLabel("Buscar SdCredor", '#007bff', '14px', 'B'),$filtro_saldoCredor], [new TLabel("Buscar UF Dest", '#007bff', '14px', 'B'), $filtro_ufDestino]);
        $row4->layout = [' col-sm-1',' col-sm-1',' col-sm-4',' col-sm-1',' col-sm-1',' col-sm-2','col-sm-1','col-sm-1'];
        //$row5 = $this->form->addFields([],[new TLabel("Usuário", '#007bff', '14px', 'B', '100%'),$userName]);
        //$row5->layout = [' col-sm-1',' col-sm-1',' col-sm-1'];
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-success'); 
        $btn_onshow = $this->form->addAction("Nova descrição", new TAction(['TblDescrimpFormList', 'onShow']), 'fas:plus #ffffff');
        $btn_onshow->addStyleClass('btn-secondary');
        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #ffffff');
        $btn_onclear->addStyleClass('btn-secondary');
        //$btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'far:file-alt #ffffff');
        //$btn_onexportcsv->addStyleClass('btn-secondary');
        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary');
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->datatable = 'true';
        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        //$username = TSession::getValue('userid');
        
        //$username = TSession::getValue('username');
        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_loja_loja = new TDataGridColumn('{loja->loja} - {loja->uf->uf}', "Loja", 'left');
        $column_descricaoImp_id = new TDataGridColumn('descricaoimp->descricao', "Descricao Imposto", 'left');
        $column_valor_transformed = new TDataGridColumn('valor', "Valor", 'right');
        $column_datavenc_transformed = new TDataGridColumn('datavenc', "Data de vencimento", 'center');
        $column_saldo_credor = new TDataGridColumn('saldo_credor', "Saldo Credor", 'center');
        $column_ufDestino = new TDataGridColumn('uf_destino_id', "UF Destino", 'center');
        $column_codReceita = new TDataGridColumn('codReceita', "Cód Receita", 'center');
        $column_username = new TDataGridColumn('usuario', "Usuário", 'center');
        
        $column_id->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);
        $column_loja_loja->setAction(new TAction([$this, 'onReload']), ['order' => 'loja_id']);
        $column_descricaoImp_id->setAction(new TAction([$this, 'onReload']), ['order' => 'descricaoImp_id']);
        $column_valor_transformed->setAction(new TAction([$this, 'onReload']), ['order' => 'valor']);
        $column_datavenc_transformed->setAction(new TAction([$this, 'onReload']), ['order' => 'datavenc']);
        $column_saldo_credor->setAction(new TAction([$this, 'onReload']), ['order' => 'saldo_credor']);
        $column_ufDestino->setAction(new TAction([$this, 'onReload']), ['order' => 'uf_destino_id']);
        $column_codReceita->setAction(new TAction([$this, 'onReload']), ['order' => 'codReceita']);
        //$column_username->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);
        //$column_username = new TDataGridColumn('username', 'Quem', 'center');


        $column_valor_transformed->setTransformer(function($value, $object, $row) 
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format ($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });
        $column_saldo_credor->setTransformer(function($value, $object, $row) 
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });


        $column_datavenc_transformed->setTransformer(function($value, $object, $row) 
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });        

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);
        
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_loja_loja);
        $this->datagrid->addColumn($column_descricaoImp_id);
        $this->datagrid->addColumn($column_codReceita);
        $this->datagrid->addColumn($column_valor_transformed);
        $this->datagrid->addColumn($column_datavenc_transformed);
        $this->datagrid->addColumn($column_saldo_credor);
        $this->datagrid->addColumn($column_ufDestino);
        $this->datagrid->addColumn($column_username);
        //$login = $this->datagrid->addQuickColumn(_t('Login'), 'login', 'center');
       
        //$this->datagrid->addColumn($column_username);

        $action_group = new TDataGridActionGroup("", 'fas:cog');
        $action_group->addHeader('');

        $action_onEdit = new TDataGridAction(array('TblPagamentoFormList', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('TblPagamentoFormList', 'onDelete'));
        $action_onDelete->setUseButton(TRUE);
        $action_onDelete->setButtonClass('btn btn-default');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $action_group->addAction($action_onDelete);

        $this->datagrid->addActionGroup($action_group);    

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Pagamento","Protocolo pagamento"]));
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }
    
    public static function saldoCredorChange($param = null)
    {
        TTransaction::open(self::$database);
        $dbLoja = new TblLojas($param['loja_id']);
        $dbUf = new TblUf($dbLoja->uf_id);
        TTransaction::close();
        $pageParam = ['codReceita' => $dbUf->uf]; // ex.: = ['key' => 10]
        $userNames = ['usuario' => TSession::getValue('username')];
        
        //$userName = TSession::getValue('userid');
        if ($param['descricaoImp_id'] == 25) {
            $object = new stdClass;
            $object->datavenc = date("d/m/yy");
            $object->valor = "0,00";
            $object->saldo_credor = null;
            $object->usuario = $userNames;
            //$object->codReceita = $pageParam;
            TForm::sendData(self::$formName, $object);
            TEntry::disableField(self::$formName, 'valor');
            TEntry::disableField(self::$formName, 'codReceita');
            TDate::disableField(self::$formName, 'datavenc');
            TEntry::enableField(self::$formName, 'saldo_credor');

        }else{
            $object = new stdClass;
            $object->datavenc = null;
            $object->saldo_credor = "0,00";
            $object->codReceita = null;
            $object->valor = null;
            $object->usuario = $userNames;
            TForm::sendData(self::$formName, $object);
            TEntry::enableField(self::$formName, 'valor');
            TDate::enableField(self::$formName, 'datavenc');
            TEntry::disableField(self::$formName, 'codReceita');
            TEntry::disableField(self::$formName, 'saldo_credor'); 
        }
        
        if ($param['descricaoImp_id'] == 6 or $param['descricaoImp_id'] == 7 or $param['descricaoImp_id'] == 29)
        {
            TDBCombo::enableField(self::$formName, 'uf_destino_id');
            TEntry::disableField(self::$formName, 'codReceita');
        }else{  
            TDBCombo::disableField(self::$formName, 'uf_destino_id');
            TEntry::disableField(self::$formName, 'codReceita');
        }
        if ($param['descricaoImp_id'] == 27) { //regra para sem movimento
            $object = new stdClass;
            $object->datavenc = date("d/m/yy");
            $object->valor = "0,00";
            $object->saldo_credor = "0,00";
            $object->usuario = $userNames;
            //$object->saldo_credor = null;
            $object->codReceita = "00000";
            TForm::sendData(self::$formName, $object);
            TEntry::disableField(self::$formName, 'valor');
            TEntry::disableField(self::$formName, 'codReceita');
            TDate::disableField(self::$formName, 'datavenc');
            TEntry::disableField(self::$formName, 'saldo_credor'); 
            TEntry::disableField(self::$formName, 'uf_destino_id');   
         }
    }
    
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData(   );
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);
        
        if (isset($data->filtro_uf_id) AND ( (is_scalar($data->filtro_uf_id) AND $data->filtro_uf_id !== '') OR (is_array($data->filtro_uf_id) AND (!empty($data->filtro_uf_id)) )) )
        {
            $filters[] = new TFilter('loja_id', 'in', "(SELECT id FROM tbl_lojas WHERE uf_id = '{$data->filtro_uf_id}')");// create the filter 
        }
        if (isset($data->filtro_loja_id) AND ( (is_scalar($data->filtro_loja_id) AND $data->filtro_loja_id !== '') OR (is_array($data->filtro_loja_id) AND (!empty($data->filtro_loja_id)) )) )
        {

            $filters[] = new TFilter('loja_id', '=', $data->filtro_loja_id);// create the filter 
        }

        if (isset($data->filtro_descricaoImp_id) AND ( (is_scalar($data->filtro_descricaoImp_id) AND $data->filtro_descricaoImp_id !== '') OR (is_array($data->filtro_descricaoImp_id) AND (!empty($data->filtro_descricaoImp_id)) )) )
        {

            $filters[] = new TFilter('descricaoImp_id', '=', $data->filtro_descricaoImp_id);// create the filter 
        }

        if (isset($data->filtro_valor) AND ( (is_scalar($data->filtro_valor) AND $data->filtro_valor !== '') OR (is_array($data->filtro_valor) AND (!empty($data->filtro_valor)) )) )
        {

            $filters[] = new TFilter('valor', 'like', "%{$data->filtro_valor}%");// create the filter 
        }

        if (isset($data->filtro_datavenc) AND ( (is_scalar($data->filtro_datavenc) AND $data->filtro_datavenc !== '') OR (is_array($data->filtro_datavenc) AND (!empty($data->filtro_datavenc)) )) )
        {

            $filters[] = new TFilter('dataVenc', '=', $data->filtro_datavenc);// create the filter 
        }

        if (isset($data->filtro_saldo_Credor) AND ( (is_scalar($data->filtro_saldo_Credor) AND $data->filtro_saldo_Credor !== '') OR (is_array($data->filtro_saldo_Credor) AND (!empty($data->filtro_saldo_Credor)) )) )
        {

            $filters[] = new TFilter('saldoCredor', '=', $data->filtro_saldo_Credor);// create the filter 
        }

        if (isset($data->filtro_uf_destino_id) AND ( (is_scalar($data->filtro_uf_destino_id) AND $data->filtro_uf_destino_id !== '') OR (is_array($data->filtro_uf_destino_id) AND (!empty($data->filtro_uf_destino_id)) )) )
        {

            $filters[] = new TFilter('ufDestino', '=', $data->filtro_uf_destino_id);// create the filter 
        }
       
        $param = array();
        $param['offset']     = 0;
        $param['first_page'] = 1;

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload($param);
    }
    public function onEdit($param = null) 
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new TblPagamento($key); // instantiates the Active Record 

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
    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new TblPagamento($key, FALSE); 

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
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

            $object = new TblPagamento(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->system_user_id = TSession::getValue('userid');
            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', "Registro salvo", $messageAction); 
            $this->form->clear(TRUE);
            $this->onReload();

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'db_fox_fiscal'
            TTransaction::open(self::$database);

            // creates a repository for TblPagamento
            $repository = new TRepository(self::$activeRecord);
            $limit = 100;
            // creates a criteria
            $criteria = new TCriteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
           
            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }
            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid

                    $this->datagrid->addItem($object);

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload')))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

}

