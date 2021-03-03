<?php

class List_SenhaMun extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblSenhasmunicipais';
    private static $primaryKey = 'id';
    private static $formName = 'formList_TblSenhasmunicipais';
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
        $this->form->setFormTitle("Consulta de senhas municipais");
        
        $criteria_responsavel_id = new TCriteria();
        $responsavelVar = 1; //tblgrupo::grupo_apuradores;
        $criteria_responsavel_id->add(new TFilter('tbl_grupo_id', 'like', "%{$responsavelVar}%"));

        //$id = new TEntry('id');
        $loja_id = new TDBUniqueSearch('loja_id', 'db_fox_fiscal', 'TblLojas', 'id', 'loja','loja asc'  );
        $uf_id = new TDBCombo('uf_id', 'db_fox_fiscal', 'TblUf', 'id', '{uf} - {pais->pais}','uf asc'  );
        $cidades_id = new TDBUniqueSearch('cidades_id', 'db_fox_fiscal', 'TblCidades', 'id', 'cidades','cidades asc'  );
        $responsavel_id = new TDBCombo('responsavel_id', 'db_fox_fiscal', 'TblResponsaveis', 'id', '{responsavel} - {tbl_grupo->grupo}','responsavel asc' ,$criteria_responsavel_id );

        $cidades_id->setMask('{cidades} - {uf->uf} ');
        $loja_id->setMask('{loja} - {uf->uf}');
        $cidades_id->setMinLength(1);
        $loja_id->setMinLength(1);
        
        //$id->setSize(100);
        $uf_id->setSize('50%');
        $loja_id->setSize('80%');
        $cidades_id->setSize('100%');

        //$row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[],[]);
        //$row2 = $this->form->addFields([new TLabel("Loja:", null, '14px', null)],[$loja_id],[],[]);
        $row1 = $this->form->addFields([new TLabel("Loja:", null, '16px', 'B')],[$loja_id],[new TLabel("UF:", null, '16px', 'B')],[$uf_id],[new TLabel("Município:", null, '16px', 'B')],[$cidades_id]);
        $row1->layout =[' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label',' col-sm-3'];
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'far:file-alt #000000');

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;
        //filtro para trazer somente as lojas Ativas da tabela de Tbl_lojas->status_id
        $filterVar = TblStatus::status_ativa;
        $this->filter_criteria->add(new TFilter('Loja_id', 'in', "(SELECT id FROM tbl_lojas WHERE status_id = '{$filterVar}')"));


        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_loja_loja = new TDataGridColumn('loja->loja', "Loja", 'left');
        //$column_uf_uf = new TDataGridColumn('uf->uf', "UF", 'left');
        $columniscrMun = new TDataGridColumn('{loja->inscMunicipal}', "I.Municipal", 'left');
        $column_cidades_cidades = new TDataGridColumn('{uf->uf} - {cidades->cidades}', "Município", 'left','200px');
        $column_login = new TDataGridColumn('login', "Login", 'left');
        $column_senha = new TDataGridColumn('senha', "Senha", 'left');
        $column_local = new TDataGridColumn('local', "Local de declaração", 'left');
        //$column_resp = new TDataGridColumn('{loja->responsavel->responsavel}',"Responáveis", 'left');
        $column_login->setTransformer( function ($value) {
            if ($value)
            {
                
                $icon  = "<i class='fas fa-user' style='color:#a9b0ac' aria-hidden='true'></i>";
                return "<a>{$icon}   {$value}</a>";
            }
            return $value;
        }); 
        $column_senha->setTransformer( function ($value) {
            if ($value)
            {
                
                $icon  = "<i class='fas fa-key' style='color:#a9b0ac' aria-hidden='true'></i>";
                return "<a>{$icon}  {$value}</a>";
            }
            return $value;
        });

        $column_local->setTransformer( function ($value) {
            if ($value)
            {
                
                $icon  = "<i class='fas fa-globe-americas' style='color:#a9b0ac' aria-hidden='true'></i>";
                if(substr($value, 0, 4) !== 'http'){
                    return "{$icon} <a>$value</a>";
                }else{
                    $value = str_replace([' ','-','(',')'],['','','',''], $value);
                    return "{$icon} <a target='newwindow' href='{$value}'> Link site direto</a>";
                }
            }
            return $value;
        });
        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_loja_loja);
        //$this->datagrid->addColumn($column_uf_uf);
        $this->datagrid->addColumn($columniscrMun);
        $this->datagrid->addColumn($column_cidades_cidades);
        //$this->datagrid->addColumn($column_resp);
        $this->datagrid->addColumn($column_login);
        $this->datagrid->addColumn($column_senha);
        $this->datagrid->addColumn($column_local);
        

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Consultas","Municipais"]));
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

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

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }
        if (isset($data->responsavel_id) AND ( (is_scalar($data->responsavel_id) AND $data->responsavel_id !== '') OR (is_array($data->responsavel_id) AND (!empty($data->responsavel_id)) )) )
        {

            $filters[] = new TFilter('responsavel', '=', $data->responsavel_id);// create the filter 
        }
        if (isset($data->loja_id) AND ( (is_scalar($data->loja_id) AND $data->loja_id !== '') OR (is_array($data->loja_id) AND (!empty($data->loja_id)) )) )
        {

            $filters[] = new TFilter('loja_id', 'like', "{$data->loja_id}");// create the filter 
        }

        if (isset($data->uf_id) AND ( (is_scalar($data->uf_id) AND $data->uf_id !== '') OR (is_array($data->uf_id) AND (!empty($data->uf_id)) )) )
        {

            $filters[] = new TFilter('uf_id', 'like', $data->uf_id);// create the filter 
        }

        if (isset($data->cidades_id) AND ( (is_scalar($data->cidades_id) AND $data->cidades_id !== '') OR (is_array($data->cidades_id) AND (!empty($data->cidades_id)) )) )
        {

            $filters[] = new TFilter('cidades_id', '=', $data->cidades_id);// create the filter 
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

            // creates a repository for TblSenhasmunicipais
            $repository = new TRepository(self::$activeRecord);
            $limit = 100;

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'asc';
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

