<?php

class cad_fechamento extends TPage
{
    private $form; // forma
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblFechamento';
    private static $primaryKey = 'id';
    private static $formName = 'form_list_TblFechamento';

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
        $this->form->setFormTitle("Protocolo Fechamento");


        $id = new TEntry('id');

        //$tbl_lojas_id = new TDBCombo('tbl_lojas_id', 'db_fox_fiscal', 'Tbllojas', 'id', 'loja','loja asc'  );
        //$tbl_lojas_id = new TDBUniqueSearch('tbl_lojas_id', 'db_fox_fiscal', 'Tblfechamento', 'id', '{tbl_lojas_id}','id asc'  );
        //--------------------------------Data de referência----------------------
        $dtrefini = new TDate('dtrefini');
        $dtreffim = new TDate('dtreffim');
        $btn_refSave = new TButton('button_savlvar_referencia');

        $dtrefini->setMask('dd/mm/yyyy');
        $dtreffim->setMask('dd/mm/yyyy');

        $dtrefini->setDatabaseMask('yyyy-mm-dd');
        $dtreffim->setDatabaseMask('yyyy-mm-dd');
        $dtrefini->setSize('100%');
        $dtreffim->setSize('100%');
        //--------------------------------campos de Inserção------------------------
        $lojas = new TEntry('tbl_lojas_id');
        $legenda = new TDBCombo('tbl_Fechamento_Leg_id', 'db_fox_fiscal', 'TblFechamentoLegenda', 'id', '{legenda}','id asc'  );
        $status = new TEntry('status');
        $observacao = new TDBCombo('tbl_fechamento_obs_id', 'db_fox_fiscal', 'TblFechamentoObs', 'id', '{observacoes}','id asc'  );
        $ERPxLivros = new TDBCombo('tbl_fechamento_ERPxLivros_id', 'db_fox_fiscal', 'TblFechamentoErpxlivros', 'id', '{erpxlivros}','id asc'  );
        $legenda->setChangeAction( new TAction( array($this, 'statusChange')));
        $observacao->setChangeAction( new TAction( array($this, 'statusChange')));

        $id->setSize(100);
        $status->setSize('100%');
        $lojas->setSize('100%');
        $legenda->setSize('100%');
        $observacao->setSize('100%');
        $ERPxLivros->setSize('100%');

        $status->setMaxLength(100);
        $id->setEditable(false);
        $status->setEditable(false);
        $lojas->setEditable(false);
        $ERPxLivros->setEditable(false);
        $lojas->setMask('{loja}');
 
        $lojas->addValidation("de <b>Lojas<b>", new TRequiredValidator());
        $ERPxLivros->addValidation("de <b>ERPxLivros<b>", new TRequiredValidator());

        $row1 = $this->form->addFields([new TLabel("Id", '#000000', '14px', 'B','100%'), $id],[new TLabel("Loja", '#000000', '14px', 'B', '100%'),$lojas],[new TLabel("Legenda:", '#000000', '14px', 'B','100%'),$legenda],[new TLabel("Status:", '#000000', '14px', 'B','100%'),$status],[new TLabel("Observação:", '#000000', '14px', 'B','100%'),$observacao],[new TLabel("ERPxLivros:", '#000000', '14px','B','100%'),$ERPxLivros]);
        $row1->layout = [' col-sm-1',' col-sm-1',' col-sm-2','col-sm-2',' col-sm-4',' col-sm-1'];

        //--------------------------------campos de busca------------------------
        $criteria_responsavel = new TCriteria();
        $responsavelVar = tblgrupo::grupo_apuradores;
        $criteria_responsavel->add(new TFilter('tbl_grupo_id', 'like', "%{$responsavelVar}%"));

        $buscaLojas = new TDBUniqueSearch('buscaLoja', 'db_fox_fiscal', 'Tblfechamento', 'id', 'tbl_lojas_id','id asc'  );
        $buscaLegenda = new TDBCombo('buscaLegenda', 'db_fox_fiscal', 'TblFechamentoLegenda', 'id', '{legenda}','id asc'  );
        $buscaStatus = new TCombo('buscaStatus');
        $buscaObservacao = new TDBCombo('buscaObservacao', 'db_fox_fiscal', 'TblFechamentoObs', 'id', '{observacoes}','id asc'  );
        $buscaERP = new TDBCombo('buscaERP', 'db_fox_fiscal', 'TblFechamentoErpxlivros', 'id', '{erpxlivros}','id asc'  );
        $buscaResp = new TDBCombo('buscaResp', 'db_fox_fiscal', 'TblResponsaveis', 'id', '{responsavel}', 'id asc',$criteria_responsavel);
        $buscaUF = new TDBCombo('buscaUF', 'db_fox_fiscal', 'TblUf', 'id', '{uf}', 'id asc');

        $buscaLojas->setMinLength(1);
        
        $optionsBuscaStatus = ['Aguardando análise'=>'Aguardando análise','Erro'=>'Erro','Fechar'=>'Fechar', 'Fechado'=>'Fechado'];
        $buscaStatus->addItems($optionsBuscaStatus);

        $buscaResp->setSize(100);
        $buscaStatus->setSize('100%');
        $buscaLojas->setSize('100%');
        $buscaLegenda->setSize('100%');
        $buscaObservacao->setSize('100%');
        $buscaERP->setSize('100%');
        $buscaUF->setSize('100%');

        $row2 = $this->form->addFields([new TLabel("UF", '#0069d9', '14px', 'B','100%'),$buscaUF],[new TLabel("Lojas", '#0069d9', '14px', 'B','100%'), $buscaLojas],[new TLabel("Legenda", '#0069d9', '14px', 'B', '100%'),$buscaLegenda],[new TLabel("Status", '#0069d9', '14px', 'B','100%'),$buscaStatus],[new TLabel("Observação", '#0069d9', '14px', 'B','100%'),$buscaObservacao],[new TLabel("ERPxLivros", '#0069d9', '14px', 'B','100%'),$buscaERP],[new TLabel("Responsável", '#0069d9', '14px', 'B','100%'), $buscaResp]);
        $row2->layout = [' col-sm-1',' col-sm-1',' col-sm-2',' col-sm-2','col-sm-4',' col-sm-1','col-sm-1'];
        //-----------------------------------------------------------------------       

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        //--------------------------------Botões---------------------------------
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-success'); 

        $btn_onSearch = $this->form->addAction("Procurar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $btn_onSearch->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        //----------------------------------------------------------------------- 
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '20px');
        $column_loja_loja = new TDataGridColumn('{tbl_lojas_id}', "Lojas", 'left');
        $column_loja_cnpj = new TDataGridColumn('{tbl_lojas_id}', "CNPJ", 'left'); 
        $column_loja_uf = new TDataGridColumn('{tbl_lojas_id}', "UF", 'left');
        $column_loja_Status = new TDataGridColumn('{tbl_lojas_id}', "Status Loja", 'center');
        $column_loja_resp = new TDataGridColumn('{tbl_lojas_id}', "Responsável", 'center');
        $column_legenda = new TDataGridColumn('tbl_Fechamento_Leg->legenda', "Legenda", 'left');
        $column_status = new TDataGridColumn('status', "Status", 'center');
        $column_observacoes = new TDataGridColumn('tbl_fechamento_obs->observacoes', "Observações", 'left');
        $column_ERPxLivros = new TDataGridColumn('tbl_fechamento_ERPxLivros->erpxlivros', "ERP x Livros", 'left');
        $column_loja_resp->setTransformer(function($value, $object, $row)
        {
            if(!$value)
            {
                $value = 0;
            }

            if($value)
            {
                TTransaction::open(self::$database);
                $dbLojaResp = $object->tbl_lojas->responsavel_id;
                $dbresponsavel = new TblResponsaveis($dbLojaResp);
                TTransaction::close();
                return $dbresponsavel->responsavel;
            } 
        });
        
        $column_loja_cnpj->setTransformer(function($value, $object, $row)
        {
            if(!$value)
            {
                $value = 0;
            }

            if($value)
            {
                TTransaction::open(self::$database);
                $dbLoja = $object->tbl_lojas->uf_id;
                $dbUf = new TblUf($dbLoja);
                TTransaction::close();
                return substr($object->tbl_lojas->cnpj,8,4). '-' .substr($object->tbl_lojas->cnpj,10,2);
            } 
        });
        $column_loja_loja->setTransformer(function($value, $object, $row)
        {
            if(!$value)
            {
                $value = 0;
            }

            if($value)
            {
                TTransaction::open(self::$database);
                $dbLoja = $object->tbl_lojas->status_id;
                $dbStatus = new TblStatus($dbLoja);
                TTransaction::close();
                return $dbStatus->status. ' - ' .$object->tbl_lojas->loja;
            } 
        });
        $column_loja_uf->setTransformer(function($value, $object, $row)
        {
            if(!$value)
            {
                $value = 0;
            }

            if($value)
            {
                TTransaction::open(self::$database);
                $dbLoja = $object->tbl_lojas->uf_id;
                $dbUf = new TblUf($dbLoja);
                TTransaction::close();
                return $dbUf->uf;
            } 
        });
        
        
        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $order_loja = new TAction(array($this,'onreload'));
        $order_loja->setParameter('order', 'id');

        
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addcolumn($column_loja_resp);
        $this->datagrid->addColumn($column_loja_loja);
        $this->datagrid->addColumn($column_loja_uf);
        $this->datagrid->addColumn($column_loja_cnpj);
        $this->datagrid->addColumn($column_legenda);
        $this->datagrid->addColumn($column_status);
        $this->datagrid->addColumn($column_observacoes);
        $this->datagrid->addColumn($column_ERPxLivros);

        $action_onEdit = new TDataGridAction(array('cad_fechamento', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

         // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        //creates panel -> para adicionar a datagrid e o footer
        

        

        //creates scroll
        $scroll = new TScroll;
        $scroll->setSize('100%',350);
        $scroll->add($this->datagrid);

        $panel1 = new TPanelGroup;
        $panel1->add($scroll);

        $panel2 = new TPanelGroup;
        $panel2->addFooter($this->pageNavigation);
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Fechamento","Protocolo Fechamento"]));
        $container->add($this->form);
        $container->add($panel1);
        $container->add($panel2);

        parent::add($container);

    }

    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);
        
        if (isset($data->buscaLoja) AND ( (is_scalar($data->buscaLoja) AND $data->buscaLoja !== '') OR (is_array($data->buscaLoja) AND (!empty($data->buscaLoja)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->buscaLoja);// create the filter 
        }
        if (isset($data->buscaLegenda) AND ( (is_scalar($data->buscaLegenda) AND $data->buscaLegenda !== '') OR (is_array($data->buscaLegenda) AND (!empty($data->buscaLegenda)) )) )
        {

            $filters[] = new TFilter('tbl_Fechamento_Leg_id', '=', $data->buscaLegenda);// create the filter 
        }
        if (isset($data->buscaObservacao) AND ( (is_scalar($data->buscaObservacao) AND $data->buscaObservacao !== '') OR (is_array($data->buscaObservacao) AND (!empty($data->buscaObservacao)) )) )
        {

            $filters[] = new TFilter('tbl_fechamento_obs_id', '=', $data->buscaObservacao);// create the filter 
        }
        if (isset($data->buscaERP) AND ( (is_scalar($data->buscaERP) AND $data->buscaERP !== '') OR (is_array($data->buscaERP) AND (!empty($data->buscaERP)) )) )
        {

            $filters[] = new TFilter('tbl_fechamento_ERPxLivros_id', '=', $data->buscaERP);// create the filter 
        }

        if (isset($data->buscaStatus) AND ( (is_scalar($data->buscaStatus) AND $data->buscaStatus !== '') OR (is_array($data->buscaStatus) AND (!empty($data->buscaStatus)) )) )
        {
            $filters[] = new TFilter('status', 'in', "(SELECT status FROM tbl_fechamento WHERE status = '{$data->buscaStatus}')");// create the filter 
        }
        if (isset($data->buscaUF) AND ( (is_scalar($data->buscaUF) AND $data->buscaUF !== '') OR (is_array($data->buscaUF) AND (!empty($data->buscaUF)) )) )
        {
            $filters[] = new TFilter('tbl_lojas_id', 'in', "(SELECT loja FROM tbl_lojas WHERE uf_id = '{$data->buscaUF}')");// create the filter 
        }
        if (isset($data->buscaResp) AND ( (is_scalar($data->buscaResp) AND $data->buscaResp !== '') OR (is_array($data->buscaResp) AND (!empty($data->buscaResp)) )) )
        {
            $filters[] = new TFilter('tbl_lojas_id', 'in', "(SELECT loja FROM tbl_lojas WHERE responsavel_id = '{$data->buscaResp}')");// create the filter 
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
    
    public static function idChangeUnblockAll($param = null)
    {
        if($id != null){
        TDBUniqueSearch::disableField(self::$formName, 'tbl_lojas_id');
        TDBCombo::disableField(self::$formName, 'tbl_Fechamento_Leg_id');
        TDBCombo::disableField(self::$formName, 'tbl_fechamento_obs_id');
        TDBCombo::disableField(self::$formName, 'tbl_fechamento_ERPxLivros_id');
        }else
        {
        TDBUniqueSearch::enableField(self::$formName, 'tbl_lojas_id');
        TDBCombo::enableField(self::$formName, 'tbl_Fechamento_Leg_id');
        TDBCombo::enableField(self::$formName, 'tbl_fechamento_obs_id');
        TDBCombo::enableField(self::$formName, 'tbl_fechamento_ERPxLivros_id');
        }
    }

    static function statusChange($param = null)
    {
        
        if ($param['tbl_Fechamento_Leg_id'] == 1 )
        {
            if ($param['tbl_fechamento_obs_id'] == 29 or empty($param['tbl_fechamento_obs_id']))
            {
                $object = new stdClass;
                $object->status = "Fechar";
            }
            else
            {
                $object = new stdclass;
                $object->status = "Fechar";
            }  
        }   
        
        else
        {
            $object = new stdClass;
            $object->status = "Erro";
        }
        if (empty($param['tbl_Fechamento_Leg_id']) and empty($param['tbl_fechamento_obs_id']))
        {
            $object = new stdclass;
            $object->status = 'Aguardando análise';

        } 
        TForm::sendData(self::$formName, $object);
    }

    public function onEdit($param = null) 
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new TblFechamento($key); // instantiates the Active Record 

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
                $object = new TblFechamento($key, FALSE); 

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

            $object = new TblFechamento(); // create an empty object 

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

            new TMessage('info', "Registro salvo", $messageAction); 
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
            // open a transaction with database 'db_fox'
            TTransaction::open(self::$database);

            // creates a repository for TblFechamento
            $repository = new TRepository(self::$activeRecord);
            $limit = 50;
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

