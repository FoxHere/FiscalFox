<?php

class List_Lojas extends TPage
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
        $this->form->setFormTitle("Consulta Lojas");
        $criteria_responsavel_id = new TCriteria();
        $responsavelVar = tblgrupo::grupo_apuradores;
        $criteria_responsavel_id->add(new TFilter('tbl_grupo_id', '=', $responsavelVar));



        $status_id = new TDBCombo('status_id', 'db_fox_fiscal', 'TblStatus', 'id', '{status}','status asc'  );
        $loja = new TDBUniqueSearch('loja', 'db_fox_fiscal', 'TblLojas', 'loja', 'loja','loja asc'  );
        $uf_id = new TDBCombo('uf_id', 'db_fox_fiscal', 'TblUf', 'id', '{uf}','uf asc'  );
        $cidades_id = new TDBUniqueSearch('cidades_id', 'db_fox_fiscal', 'TblCidades', 'id', 'cidades','cidades asc'  );
        $cnpj = new TDBUniqueSearch('cnpj', 'db_fox_fiscal', 'TblLojas', 'cnpj', 'cnpj','loja asc'  );
        $inscEstadual = new TDBUniqueSearch('inscEstadual', 'db_fox_fiscal', 'TblLojas', 'inscEstadual', 'inscEstadual','loja asc'  );
        $inscMunicipal = new TDBUniqueSearch('inscMunicipal', 'db_fox_fiscal', 'TblLojas', 'inscMunicipal', 'inscMunicipal','inscMunicipal asc'  );
        $responsavel_id = new TDBCombo('responsavel_id', 'db_fox_fiscal', 'TblResponsaveis', 'id', '{responsavel} - {tbl_grupo->grupo}','responsavel asc' ,$criteria_responsavel_id );

        //$cnpj->setValue('1');

        $cnpj->setMask('{cnpj} - {loja} ');
        $loja->setMask('{loja} - {uf->uf} ');
        $cidades_id->setMask('{cidades} - {uf->uf} ');
        $inscEstadual->setMask('{inscEstadual} - {loja} ');
        $inscMunicipal->setMask(' {inscMunicipal} - {loja} ');


        $loja->setMinLength(1);
        $cnpj->setMinLength(1);
        $cidades_id->setMinLength(1);
        $inscEstadual->setMinLength(1);
        $inscMunicipal->setMinLength(1);

        $loja->setSize('100%', 30);
        $cnpj->setSize('100%');
        $uf_id->setSize('100%');
        $status_id->setSize('100%');
        $cidades_id->setSize('100%');
        $inscEstadual->setSize('100%');
        $inscMunicipal->setSize('100%');
        $responsavel_id->setSize('100%');

        $row1 = $this->form->addContent([new TFormSeparator("<b>Escolha um dos filtros abaixo</b>", '#007bff', '18', '#eeeeee')]);
        $row2 = $this->form->addFields([new TLabel("Status", '#007bff', '14px', 'B'), $status_id],[new TLabel("Loja", '#007bff', '14px', 'B'),$loja],[new TLabel("UF", '#007bff', '16px', 'B'),$uf_id],[new TLabel("CNPJ", '#007bff', '14px', 'B'),$cnpj],[new TLabel("Insc.Estadual", '#007bff', '14px', 'B'),$inscEstadual],[new TLabel("Insc.Municípal:", '#007bff', '14px', 'B'),$inscMunicipal],[new TLabel("Cidade Brasileira", '#007bff', '14px', 'B'),$cidades_id],[new TLabel("Responsável", '#007bff', '14px', 'B'),$responsavel_id]);
        $row2->layout = [' col-sm-1',' col-sm-1',' col-sm-1','col-sm-2',' col-sm-2 ',' col-sm-1 ',' col-sm-3 ',' col-sm-1 '];

        //$row3 = $this->form->addFields();
        //$row3->layout = [' col-sm-1 control-label','col-sm-3',' col-sm-1 control-label',' col-sm-3',' col-sm-1 control-label',' col-sm-3'];
        /*
        $iframe = new TElement('iframe');
        $iframe->id = "iframe_external";
        $iframe->src = "http://www.fazenda.mg.gov.br/";
        $iframe->frameborder = "0";
        $iframe->scrolling = "yes";
        $iframe->width = "100%";
        $iframe->height = "700px";
        
        parent::add($iframe);
        */

        //$row4 = $this->form->addFields([new TLabel("Cidade:", null, '14px', null)],[$cidades_id]);
        //$row4->layout = [' col-sm-1',' col-sm-4'];
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onexportcsv = $this->form->addAction("Exportar como CSV", new TAction([$this, 'onExportCsv']), 'far:file-alt #000000');




        
        
        //$this->setOrderCommand('city->name', '(select name from city where city_id = id)');

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;
        $this->datagrid->style = 'min-width: 1900px;max-width: 1900px';
        $this->datagrid->datatable = 'true';
  
        //$this->datagrid->enablePopover("Endereço - shopping", '{endereco} - {shopping}');
        
        
        
        //$this->datagrid->class='tdatagrid_table customized-table';
        //parent::include_css('ap/resources/custom-table.css');

        
        //$this->datagrid->style = 'position:right';
        //text-align:$align
        //display:inline-table
        //text-align:$align
        //$this->datagrid->setHeight(320);
        //$this->datagrid->setactionwidth(900);

        
        

        $column_id = new  TDataGridColumn('id',"Id",'center');
        $column_empresa_empresa = new TDataGridColumn('empresa->empresa', "Empresa", 'center');
        $column_status_status = new TDataGridColumn('status->status',   "Status", 'center');
        $column_numCapta = new TDataGridColumn('numCapta', "Nº", 'left');
        $column_loja = new TDataGridColumn('loja', "Loja", 'left');
        $column_uf_uf = new TDataGridColumn('uf->uf', "UF", 'left');
        $column_endereco = new TDataGridColumn('{endereco} - {shopping} - {cep}', "Endereço", 'center');
        $column_cidades_cidades = new TDataGridColumn('cidades->cidades', "Cidade", 'left');
        $column_cep = new TDataGridColumn('cep', "CEP", 'left');
        $column_shopping = new TDataGridColumn('shopping', "Shopping", 'center');
        $column_cnpj = new TDataGridColumn('cnpj', "CNPJ", 'left');
        $column_inscEstadual = new TDataGridColumn('inscEstadual', "I.E", 'center');
        $column_inscMunicipal = new TDataGridColumn('inscMunicipal', "I.M", 'center');
        $column_nire = new TDataGridColumn('nire', "NIRE", 'left');
        $column_responsavel_responsavel = new TDataGridColumn('responsavel->responsavel', "Responsável", 'left');
        $column_dataAbertura = new TDataGridColumn('dataAbertura', "Data Abertura", 'left');
        $column_dataEncerramento = new TDataGridColumn('dataEncerramento', "Data Encerramento", 'left');

        $column_id->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);
        //$column_empresa_empresa->setAction(new TAction([$this, 'onReload']), ['order' => 'empresa']);
        //$column_status_status->setAction(new TAction([$this, 'onReload']), ['order' => 'status']);
        $column_numCapta->setAction(new TAction([$this, 'onReload']), ['order' => 'numCapta']);
        $column_loja->setAction(new TAction([$this, 'onReload']), ['order' => 'loja']);
       // $column_uf_uf->setAction(new TAction([$this, 'onReload']), ['order' => 'uf->uf']);
        $column_cidades_cidades->setAction(new TAction([$this, 'onReload']), ['order' => '{cidades->cidades}']);
        $column_cep->setAction(new TAction([$this, 'onReload']), ['order' => 'cep']);
        //$column_shopping->setAction(new TAction([$this, 'onReload']), ['order' => 'shopping']);
        $column_cnpj->setAction(new TAction([$this, 'onReload']), ['order' => 'cnpj']);
        $column_inscEstadual->setAction(new TAction([$this, 'onReload']), ['order' => 'inscEstadual']);
        $column_inscMunicipal->setAction(new TAction([$this, 'onReload']), ['order' => 'inscMunicipal']);
        $column_nire->setAction(new TAction([$this, 'onReload']), ['order' => 'nire']);
        //$column_responsavel_responsavel->setAction(new TAction([$this, 'onReload']), ['order' => 'responsavel']);
        //$column_endereco->setAction(new TAction([$this, 'onReload']), ['order' => 'endereco']);
        $column_dataAbertura->setAction(new TAction([$this, 'onReload']), ['order' => 'dataAbertura']);
        $column_dataEncerramento->setAction(new TAction([$this, 'onReload']), ['order' => 'dataEncerramento']);


        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);
        $column_dataAbertura->setTransformer(array($this, 'formatDate1'));
        $column_dataEncerramento->setTransformer(array($this, 'formatDate2'));
        /*
        $column_cnpj->setTransformer(function($value, $object, $row) 
        {
            if(!$value)
            {
                $value = 0;
            }
            if(is_numeric($value))
            {
                return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $value);
            }
            else
            {
                return $value;
            }
        });*/



        $this->datagrid->addColumn($column_id);
        
        $this->datagrid->addColumn($column_status_status);
        $this->datagrid->addColumn($column_numCapta);
        $this->datagrid->addColumn($column_loja);
        $this->datagrid->addColumn($column_uf_uf);
        $this->datagrid->addColumn($column_cidades_cidades);
        
        
        $this->datagrid->addColumn($column_cnpj);
        $this->datagrid->addColumn($column_inscEstadual);
        $this->datagrid->addColumn($column_inscMunicipal);
        $this->datagrid->addColumn($column_nire);
        $this->datagrid->addColumn($column_responsavel_responsavel);
        
        $this->datagrid->addColumn($column_cep);
        $this->datagrid->addColumn($column_dataAbertura);
        $this->datagrid->addColumn($column_dataEncerramento);

        $this->datagrid->addColumn($column_empresa_empresa);
        $this->datagrid->addColumn($column_endereco);
        $this->datagrid->addColumn($column_shopping);
        // create the datagrid model
        $this->datagrid->createModel();

        

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel1 = new TPanelGroup;
        $panel2 = new TPanelGroup;
        
        
        //$panel->getbody()->class .=' table-responsive';
        $panel2->addFooter($this->pageNavigation);
        
        $scroll = new TScroll;
        $scroll->setSize('100%',400);
        
        $scroll->add($this->datagrid);
        $panel1->add($scroll);
        $panel1->getBody()->style = "overflow-x:auto;";
                
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Consultas","Consulta Lojas"]));
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

        if (isset($data->cidades_id) AND ( (is_scalar($data->cidades_id) AND $data->cidades_id !== '') OR (is_array($data->cidades_id) AND (!empty($data->cidades_id)) )) )
        {

            $filters[] = new TFilter('cidades_id', '=', $data->cidades_id);// create the filter 
        }

        if (isset($data->cnpj) AND ( (is_scalar($data->cnpj) AND $data->cnpj !== '') OR (is_array($data->cnpj) AND (!empty($data->cnpj)) )) )
        {

            $filters[] = new TFilter('cnpj', 'like', "%{$data->cnpj}%");// create the filter 
        }

        if (isset($data->inscEstadual) AND ( (is_scalar($data->inscEstadual) AND $data->inscEstadual !== '') OR (is_array($data->inscEstadual) AND (!empty($data->inscEstadual)) )) )
        {

            $filters[] = new TFilter('inscEstadual', 'like', "%{$data->inscEstadual}%");// create the filter 
        }

        if (isset($data->inscMunicipal) AND ( (is_scalar($data->inscMunicipal) AND $data->inscMunicipal !== '') OR (is_array($data->inscMunicipal) AND (!empty($data->inscMunicipal)) )) )
        {

            $filters[] = new TFilter('inscMunicipal', 'like', "%{$data->inscMunicipal}%");// create the filter 
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
            TTransaction::open('db_fox_fiscal');

            // creates a repository for TblLojas
            $repository = new TRepository('TblLojas');
            $limit = 100;

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

