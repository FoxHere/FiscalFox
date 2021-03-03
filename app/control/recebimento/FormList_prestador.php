<?php

class FormList_prestador extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblPrestador';
    private static $primaryKey = 'id';
    private static $formName = 'form_list_TblPrestador';

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
        $this->form->setFormTitle("Prestadores");


        $id = new TEntry('id');
        $cod = new TEntry('cod');
        $doc = new TEntry('doc');
        $nome = new TEntry('nome');

        $cod->addValidation("Cód. Prestador", new TRequiredValidator()); 
        $nome->addValidation("Nome", new TRequiredValidator()); 

        $id->setEditable(false);
        
        $id->setSize('93%');
        $cod->setSize('93%');
        $doc->setSize('63%');
        $nome->setSize('98%');

        $cod->autofocus = 'autofocus';
        $doc->autofocus = 'autofocus';
        $nome->autofocus = 'autofocus';

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[],[]);
        $row2 = $this->form->addFields([new TLabel("Cód. Prestador:", '', '14px', null)],[$cod],[new TLabel("CPF / CNPJ:", null, '14px', null)],[$doc]);
        $row2->layout = [' col-sm-2','col-sm-2',' col-sm-2','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Nome:", '', '14px', null)],[$nome]);
        $row3->layout = [' col-sm-2',' col-sm-8'];

        $buscaCod = new TDBUniqueSearch('buscaCod', 'db_fox_fiscal', 'TblPrestador', 'cod', 'cod','id desc');
        $buscaDoc = new TDBUniqueSearch('buscaDoc', 'db_fox_fiscal', 'TblPrestador', 'doc', 'doc','id desc');
        $buscaNome = new TDBUniqueSearch('buscaNome', 'db_fox_fiscal', 'TblPrestador', 'nome', 'nome','id desc');
        $buscaCod->setSize('90%');
        $buscaDoc->setSize('90%');
        $buscaNome->setSize('90%');
        $buscaCod->placeholder = "buscar pelo código";
        $buscaDoc->placeholder = "buscar pelo documento";
        $buscaNome->placeholder = "buscar pelo nome";

        $buscaCod->setMinLength(1);
        $buscaDoc->setMinLength(1);
        $buscaNome->setMinLength(1);

        $row6 = $this->form->addContent([new TFormSeparator("Filtros de busca","#333333","#eeeeee")]);
        $row6 = $this->form->addFields([], [$buscaCod],[$buscaDoc], [$buscaNome]);
        $row6->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-3'];
    
        $row8 = $this->form->addContent([new TFormSeparator("","#333333","#eeeeee")]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 
        $buttonBuscar = new TButton('button_tbutton');
        $buttonBuscar = $this->form->addAction("Procurar",new TAction([$this, 'onSearch']), 'fas:search #000000');
        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        //campo de busca na data grid------------------------------------------------------------------
        $inputSearch = new TEntry('input_search');
        $inputSearch->placeholder = ('Buscar prestador');
        $inputSearch->setSize('100%');
        $this->datagrid->enableSearch($inputSearch,'nome, cod, doc');
        //---------------------------------------------------------------------------------------------

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_cod = new TDataGridColumn('cod', "Cód. Prestador", 'center' , '150px');
        $column_doc = new TDataGridColumn('doc', "CPF / CNPJ", 'left' , '200px');
        $column_nome = new TDataGridColumn('nome', "Nome", 'left');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_cod);
        $this->datagrid->addColumn($column_doc);
        $this->datagrid->addColumn($column_nome);

        $action_group = new TDataGridActionGroup("", 'fas:cog');
        $action_group->addHeader('O que deseja fazer?');
        $action_onDelete = new TDataGridAction(array('FormList_prestador', 'onDelete'));
        $action_onDelete->setUseButton(true);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);
        $action_onEdit = new TDataGridAction(array('FormList_prestador', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);
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
        $panel->addHeaderWidget($inputSearch);
        $panel->addFooter($this->pageNavigation);

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);
        parent::add($panel);

        $style = new Tstyle('right-panel');
        $style->width = '70% !important';
        $style->show();

    }
    public function onSearch($param = NULL)
    {
    
       // get the search form data
       $data = $this->form->getData();
       $filters = [];

       TSession::setValue(__CLASS__.'_filter_data', NULL);
       TSession::setValue(__CLASS__.'_filters', NULL);

        /*
        $buscaCod->setSize('90%');
        $buscaDoc->setSize('90%');
        $buscaNome->setSize('90%');
        */

        if (isset($data->buscaCod) AND ( (is_scalar($data->buscaCod) AND $data->buscaCod !== '') OR (is_array($data->buscaCod) AND (!empty($data->buscaCod)) )) )
        {

            $filters[] = new TFilter('cod', '=', $data->buscaCod);// create the filter 
        }

        if (isset($data->buscaDoc) AND ( (is_scalar($data->buscaDoc) AND $data->buscaDoc !== '') OR (is_array($data->buscaDoc) AND (!empty($data->buscaDoc)) )) )
        {

            $filters[] = new TFilter('doc', '=', $data->buscaDoc);// create the filter 
        }

        if (isset($data->buscaNome) AND ( (is_scalar($data->buscaNome) AND $data->buscaNome !== '') OR (is_array($data->buscaNome) AND (!empty($data->buscaNome)) )) )
        {

            $filters[] = new TFilter('nome', '=', $data->buscaNome);// create the filter 
        }

        

       $param = array();
       $param['offset']     = 0;
       $param['first_page'] = 1;

       // fill the form with data again
       $this->form->setData($data);

       // keep the search data in the session
       TSession::setValue(__CLASS__.'_filter_data', $data);
       TSession::setValue(__CLASS__.'_filters', $filters);
       //$this->form->clear(true);
       $this->onReload($param);
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
                $object = new TblPrestador($key, FALSE); 

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

            $object = new TblPrestador(); // create an empty object 

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

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'db_fox_fiscal'
            TTransaction::open(self::$database);

            // creates a repository for TblProtFinanc
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
    public function onEdit($param = null) 
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new TblPrestador($key); // instantiates the Active Record 

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

