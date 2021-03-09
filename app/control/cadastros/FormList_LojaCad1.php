<?php

class FormList_LojaCad1 extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblLojas';
    private static $primaryKey = 'id';
    private static $formName = 'formList_TblLojas';
    private $showMethods = ['onReload', 'onSearch'];
    
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
        $this->form->setFormTitle("Cadastro de Lojas");
        
        $criteria_responsavel_id = new TCriteria();
        
        $responsavelVar = tblgrupo::grupo_apuradores;
        $criteria_responsavel_id->add(new TFilter('tbl_grupo_id', '=', $responsavelVar));

        
        $status_id = new TDBCombo('status_id', 'db_fox_fiscal', 'TblStatus', 'id', '{status}','status asc'  );
        $loja = new TDBUniqueSearch('loja', 'db_fox_fiscal', 'TblLojas', 'loja', 'loja','loja asc'  );
        $uf_id = new TDBCombo('uf_id', 'db_fox_fiscal', 'TblUf', 'id', '{uf}','uf asc'  );
        $responsavel_id = new TDBCombo('responsavel_id', 'db_fox_fiscal', 'TblResponsaveis', 'id', '{responsavel} - {tbl_grupo->grupo} ','responsavel asc' , $criteria_responsavel_id );

        $loja->setMask('{loja} - {uf->uf} ');
        $loja->setMinLength(1);

        $loja->setSize('100%');
        $uf_id->setSize('100%');
        $status_id->setSize('100%');
        $responsavel_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Status:", '#0069d9', '16px', 'B')],[$status_id],[new TLabel("Loja:", '#0069d9', '16px', 'B')],[$loja],[new TLabel("UF:", '#0069d9', '16px', 'B')],[$uf_id],[new TLabel("Responsável:", '#0069d9', '16px', 'B')],[$responsavel_id]);
        $row1->layout = [' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label',' col-sm-1',' col-sm-1 control-label',' col-sm-3'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        //------------------------------------Buttons----------------------------------------------------------------
        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 
        $btn_onshow = $this->form->addAction("Cadastrar", new TAction(['FormList_LojaCad2', 'onShow']), 'fas:plus #ffffff');
        $btn_onshow->addStyleClass('btn-warning'); 
        //$btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'far:file-alt #000000');
        //----------------------------------------------------------------------------------------------------------
        
        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;
       
        
        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        $this->datagrid->datatable = 'true'; 

        $column_id = new TDataGridColumn('id', "Id", 'center');
        $column_empresa_empresa = new TDataGridColumn('empresa->empresa', "Empresa", 'left');
        $column_status_status = new TDataGridColumn('status->status', "Status", 'left');
        $column_numCapta = new TDataGridColumn('numCapta', "NºCapta", 'center');
        $column_loja = new TDataGridColumn('loja', "Loja", 'left');
        $column_uf_uf = new TDataGridColumn('uf->uf', "UF", 'left');
        $column_endereco = new TDataGridColumn('endereco', "Endereço", 'left','200px');
        $column_cidades_cidades = new TDataGridColumn('cidades->cidades', "Cidade", 'left');
        $column_cep = new TDataGridColumn('cep', "CEP", 'left');
        $column_shopping = new TDataGridColumn('shopping', "Shopping", 'left');
        $column_cnpj = new TDataGridColumn('cnpj', "CNPJ", 'left');
        $column_inscEstadual = new TDataGridColumn('inscEstadual', "I.E", 'left');
        $column_inscMunicipal = new TDataGridColumn('inscMunicipal', "I.M", 'left');
        $column_nire = new TDataGridColumn('nire', "NIRE", 'left');
        $column_responsavel_responsavel = new TDataGridColumn('responsavel->responsavel', "Responsável", 'left');
        $column_dataAbertura = new TDataGridColumn('dataAbertura', "Data Abertura", 'Center');
        $column_dataEncerramento = new TDataGridColumn('dataEncerramento', "Data Encerramento", 'Center');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);


        //$this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_status_status);
        $this->datagrid->addColumn($column_loja);
        $this->datagrid->addColumn($column_uf_uf);
        $this->datagrid->addColumn($column_cnpj);
        $this->datagrid->addColumn($column_inscEstadual);
        $this->datagrid->addColumn($column_inscMunicipal);
        $this->datagrid->addColumn($column_numCapta);
        $this->datagrid->addColumn($column_empresa_empresa);
        $this->datagrid->addColumn($column_responsavel_responsavel);
        $this->datagrid->addColumn($column_nire);
        $this->datagrid->addColumn($column_shopping);
        $this->datagrid->addColumn($column_cep);
        $this->datagrid->addColumn($column_cidades_cidades);
        $this->datagrid->addColumn($column_dataAbertura);
        $this->datagrid->addColumn($column_dataEncerramento);
        $this->datagrid->addColumn($column_endereco);

        $column_dataAbertura->setTransformer(array($this, 'formatDate1'));
        $column_dataEncerramento->setTransformer(array($this, 'formatDate2'));

        $action_group = new TDataGridActionGroup("", 'fas:cog');
        $action_group->addHeader('');

        $action_onEdit = new TDataGridAction(array('FormList_LojaCad2', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('FormList_LojaCad1', 'onDelete'));
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
        
        $this->datagrid->disableDefaultClick();



        $panel1 = new TPanelGroup;
        $panel1->add($this->datagrid);

        $panel2 = new TPanelGroup;
        $panel2->addFooter($this->pageNavigation);//

        $scroll = new TScroll;
        $scroll->setSize('100%',400);
        $scroll->add($panel1);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Controle de cadastros","Cadastro de Lojas"]));
        $container->add($this->form);
        $container->add($scroll);
        $container->add($panel2);

        parent::add($container);

    }

    public function formatDate1($column_dataAbertura, $object)
    {
        $date = new DateTime($object->dataAbertura);
        return $date->format('d/m/Y');
    }
    public function formatDate2($column_dataEncerramento, $object)
    {
        if (!empty($object->dataEncerramento)){
        $date = new DateTime($object->dataEncerramento);
            return $date->format('d/m/Y');
        }   
    }

    public function onExportCsv($param = null) 
    {
        try
        {
            $this->onSearch();

            TTransaction::open(self::$database); // open a transaction
            $repository = new TRepository(self::$activeRecord); // creates a repository for Customer
            $criteria = $this->filter_criteria;

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            $records = $repository->load($criteria); // load the objects according to criteria
            if ($records)
            {
                $file = 'tmp/'.uniqid().'.csv';
                $handle = fopen($file, 'w');
                $columns = $this->datagrid->getColumns();

                $csvColumns = [];
                foreach($columns as $column)
                {
                    $csvColumns[] = $column->getLabel();
                }
                fputcsv($handle, $csvColumns, ';');

                foreach ($records as $record)
                {
                    $csvColumns = [];
                    foreach($columns as $column)
                    {
                        $name = $column->getName();
                        $csvColumns[] = $record->{$name};
                    }
                    fputcsv($handle, $csvColumns, ';');
                }
                fclose($handle);

                TPage::openFile($file);
            }
            else
            {
                new TMessage('info', _t('No records found'));       
            }

            TTransaction::close(); // close the transaction
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
                $object = new TblLojas($key, FALSE); 

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

    /**
     * Register the filter in the session
     */
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->status_id) AND ( (is_scalar($data->status_id) AND $data->status_id !== '') OR (is_array($data->status_id) AND (!empty($data->status_id)) )) )
        {

            $filters[] = new TFilter('status_id', '=', $data->status_id);// create the filter 
        }

        if (isset($data->loja) AND ( (is_scalar($data->loja) AND $data->loja !== '') OR (is_array($data->loja) AND (!empty($data->loja)) )) )
        {

            $filters[] = new TFilter('loja', 'like', "%{$data->loja}%");// create the filter 
        }

        if (isset($data->uf_id) AND ( (is_scalar($data->uf_id) AND $data->uf_id !== '') OR (is_array($data->uf_id) AND (!empty($data->uf_id)) )) )
        {

            $filters[] = new TFilter('uf_id', '=', $data->uf_id);// create the filter 
        }

        if (isset($data->responsavel_id) AND ( (is_scalar($data->responsavel_id) AND $data->responsavel_id !== '') OR (is_array($data->responsavel_id) AND (!empty($data->responsavel_id)) )) )
        {

            $filters[] = new TFilter('responsavel_id', '=', $data->responsavel_id);// create the filter 
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

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'db_fox_fiscal'
            TTransaction::open(self::$database);

            // creates a repository for TblLojas
            $repository = new TRepository(self::$activeRecord);
            $limit = 20;

            $criteria = clone $this->filter_criteria;

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
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
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

