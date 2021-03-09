<?php

class FormList_SenhaMun extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblSenhasmunicipais';
    private static $primaryKey = 'id';
    private static $formName = 'form_list_TblSenhasmunicipais';
    private $showMethods = ['onReload', 'procuraLoja'];
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
        $this->form->setFormTitle("Cadastro de Senhas - Municipais");
        

        $id = new TEntry('id');
        $loja_id = new TDBUniqueSearch('loja_id', 'db_fox_fiscal', 'TblLojas', 'id', 'loja','loja asc'  );
        $uf_id = new TDBCombo('uf_id', 'db_fox_fiscal', 'TblUf', 'id', '{uf}','uf asc'  );
        $cidades_id = new TDBUniqueSearch('cidades_id', 'db_fox_fiscal', 'TblCidades', 'id', 'cidades','cidades asc'  );
        $login = new TEntry('login');
        $senha = new TEntry('senha');
        $local = new TEntry('local');
        $buscaLoja = new TDBUniqueSearch('buscaLoja', 'db_fox_fiscal', 'TblLojas', 'id', 'loja','loja asc'  );
        $buscaCidade = new TDBUniqueSearch('buscaCidade', 'db_fox_fiscal', 'TblCidades', 'id', 'cidades','cidades asc'  );
        $buscaUF = new TDBCombo('buscaUF', 'db_fox_fiscal', 'TblUf', 'id', '{uf}','uf asc'  );

        $loja_id->addValidation("Loja", new TRequiredValidator()); 
        $login->addValidation("Login", new TRequiredValidator()); 
        $senha->addValidation("Senha", new TRequiredValidator()); 
        $local->addValidation("Local de declaração", new TRequiredValidator()); 

        $id->setEditable(false);
        $local->setTip("Link da internet ou caminho do programa na rede");

        $loja_id->setMinLength(1);
        $cidades_id->setMinLength(2);
        $buscaLoja->setMinLength(1);
        $buscaCidade->setMinLength(1);

        $loja_id->setMask('{loja}  - {uf->uf} ');
        $cidades_id->setMask('{cidades} - {uf->uf} ');
        $buscaLoja->setMask('{loja} - {uf->uf} ');
        $buscaCidade->setMask('{cidades} - {uf->uf} ');

        $login->setMaxLength(50);
        $senha->setMaxLength(80);
        $local->setMaxLength(250);

        $id->setSize(100);
        $uf_id->setSize('70%');
        $login->setSize('97%');
        $senha->setSize('100%');
        $local->setSize('100%');
        $loja_id->setSize('98%');
        $buscaUF->setSize('70%');
        $buscaLoja->setSize('98%');
        $cidades_id->setSize('96%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row1->layout = [' col-sm-1 control-label',' col-sm-2'];

        $row2 = $this->form->addFields([new TLabel("Loja:", '#ff0000', '14px', null)],[$loja_id],[new TLabel("UF:", null, '14px', null)],[$uf_id],[new TLabel("Login:", '#ff0000', '14px', null)],[$login],[new TLabel("Senha:", '#ff0000', '14px', null)],[$senha]);
        $row2->layout = [' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label','col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("Município:", null, '14px', null)],[$cidades_id],[new TLabel("Local de declaração:", '#ff0000', '14px', null)],[$local]);
        $row3->layout = [' col-sm-1 control-label','col-sm-3',' col-sm-2 control-label',' col-sm-6'];

        $row4 = $this->form->addContent([new TFormSeparator("Filtro de pesquisa", '#333333', '18', '#eeeeee')]);
        $row5 = $this->form->addFields([new TLabel("Loja:", null, '14px', null)],[$buscaLoja],[new TLabel("Cidade:", null, '14px', null)],[$buscaCidade],[new TLabel("UF", null, '14px', null)],[$buscaUF]);
        $row5->layout = [' col-sm-1',' col-sm-2',' col-sm-1',' col-sm-4',' col-sm-1','col-sm-2'];
        

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $btn_procurar = $this->form->addAction("Procurar", new TAction([$this, 'procuraLoja']),'fas:search #ffffff');
        $btn_procurar->addStyleClass('btn-success');

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_loja_loja = new TDataGridColumn('loja->loja', "Loja", 'left');
        $column_uf_uf = new TDataGridColumn('uf->uf', "UF", 'left');
        $column_cidades_cidades = new TDataGridColumn('cidades->cidades', "Município", 'left');
        $column_login = new TDataGridColumn('login', "Login", 'left');
        $column_senha = new TDataGridColumn('senha', "Senha", 'left');
        $column_local = new TDataGridColumn('local', "Local de declaração", 'left');
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
                //$value = str_replace([' ','-','(',')'],['','','',''], $value);
                $icon  = "<i class='fas fa-globe-americas' style='color:#a9b0ac' aria-hidden='true'></i>";
                return "{$icon} <a>{$value}</a>";
            }
            return $value;
        });
        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_loja_loja);
        $this->datagrid->addColumn($column_uf_uf);
        $this->datagrid->addColumn($column_cidades_cidades);
        $this->datagrid->addColumn($column_login);
        $this->datagrid->addColumn($column_senha);
        $this->datagrid->addColumn($column_local);

        $action_onEdit = new TDataGridAction(array('FormList_SenhaMun', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('FormList_SenhaMun', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

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
        $container->add(TBreadCrumb::create(["Controle de cadastros","Municipais"]));
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }
    public function procuraLoja($param = NULL)
    {
        //get the search data
        $data = $this->form->getdata();
        $filters = [];

        Tsession::setValue(__CLASS__.'_filter_data',NULL);
        Tsession::setValue(__CLASS__.'_filters', NULL);
        
        if (isset($data->buscaLoja) AND ((is_scalar($data->buscaLoja) AND $data->buscaLoja !=='') OR (is_array($data->buscaLoja) AND (!empty($data->buscaLoja)) )) )
        {
            $filters[] = new Tfilter('loja_id','like', "{$data->buscaLoja}");
        }
        if (isset($data->buscaUF) AND ((is_scalar($data->buscaUF) AND $data->buscaUF !=='') OR (is_array($data->buscaUF) AND (!empty($data->buscaUF)) )) )
        {
            $filters[] = new Tfilter('uf_id','like', "{$data->buscaUF}");
        }
        if (isset($data->buscaCidade) AND ((is_scalar($data->buscaCidade) AND $data->buscaCidade !=='') OR (is_array($data->buscaCidade) AND (!empty($data->buscaCidade)) )) )
        {
            $filters[] = new Tfilter('cidades_id','like', "{$data->buscaCidade}");
        }
        $param = array();
        $param['offset'] = 0;
        $param['first_page'] = 1;

        $this->form->setData($data);

        Tsession::setValue(__class__.'_filter_data',$data);
        Tsession::setValue(__CLASS__.'_filters',$filters);
        
            $this->form->clear(true);
            
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

                $object = new TblSenhasmunicipais($key); // instantiates the Active Record 

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
                $object = new TblSenhasmunicipais($key, FALSE); 

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

            $messageAction = $this->form->Clear(NULL);

            $this->form->validate(); // validate form data

            $object = new TblSenhasmunicipais(); // create an empty object 

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

            // creates a repository for TblSenhasmunicipais
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
            if ($filters = Tsession::getValue(__CLASS__.'_filters'))
            {
                foreach($filters as $filter);
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
        if(!empty($param)){
        $this->form->clear(true);
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

