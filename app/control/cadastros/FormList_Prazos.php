<?php

class FormList_Prazos extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblPrazos';
    private static $primaryKey = 'id';
    private static $formName = 'form_list_TblPrazos';

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
        $this->form->setFormTitle("Cadastro de prazos e obrigações");


        $id = new TEntry('id');
        $uf_id = new TDBCombo('uf_id', 'db_fox_fiscal', 'TblUf', 'id', '{uf}  - {pais->pais} ','uf asc'  );
        $data_icms = new TEntry('data_icms');
        $data_difal = new TEntry('data_difal');
        $data_fecop = new TEntry('data_fecop');
        $data_sped = new TEntry('data_sped');
        $data_antecipado = new TEntry('data_antecipado');
        $data_iss = new TEntry('data_iss');
        $data_declaracao = new TEntry('data_declaracao');

        $uf_id->addValidation("Estados id", new TRequiredValidator()); 
        $data_icms->addValidation("Data ICMS", new TRequiredValidator()); 
        $data_iss->addValidation("Data ISS", new TRequiredValidator()); 
        $data_declaracao->addValidation("Data declaração", new TRequiredValidator()); 

        $id->setEditable(false);
        $data_iss->setValue('10 |');

        $data_iss->setMask('00 |');
        $data_icms->setMask('00 |');
        $data_sped->setMask('00 |');
        $data_difal->setMask('00 |');
        $data_fecop->setMask('00 |');
        $data_antecipado->setMask('00 |');
        $data_declaracao->setMask('00 |');

        $data_iss->setMaxLength(20);
        $data_icms->setMaxLength(20);
        $data_sped->setMaxLength(20);
        $data_difal->setMaxLength(20);
        $data_fecop->setMaxLength(20);
        $data_antecipado->setMaxLength(20);
        $data_declaracao->setMaxLength(20);

        $data_iss->setTip("Data | Espaço vazio");
        $data_icms->setTip("Data | Espaço vazio");
        $data_sped->setTip("Data | Espaço vazio");
        $data_difal->setTip("Data | Espaço vazio");
        $data_fecop->setTip("Data | Espaço vazio");
        $data_antecipado->setTip("Data | Espaço vazio");
        $data_declaracao->setTip("Data | Espaço vazio");

        $id->setSize(100);
        $uf_id->setSize('88%');
        $data_iss->setSize('70%');
        $data_icms->setSize('70%');
        $data_sped->setSize('70%');
        $data_difal->setSize('70%');
        $data_fecop->setSize('70%');
        $data_antecipado->setSize('70%');
        $data_declaracao->setSize('70%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[],[]);
        $row2 = $this->form->addFields([new TLabel("Estado (UF):", null, '14px', null)],[$uf_id]);
        $row3 = $this->form->addFields([new TLabel("ICMS:", '#ff0000', '14px', null)],[$data_icms],[new TLabel("DIFAL:", null, '14px', null)],[$data_difal]);
        $row4 = $this->form->addFields([new TLabel("FECOP:", null, '14px', null)],[$data_fecop],[new TLabel("SPED:", null, '14px', null)],[$data_sped]);
        $row5 = $this->form->addFields([new TLabel("Antecipado:", null, '14px', null)],[$data_antecipado],[new TLabel("ISS:", '#ff0000', '14px', null)],[$data_iss]);
        $row6 = $this->form->addFields([new TLabel("Declaração (GIA):", '#ff0000', '14px', null)],[$data_declaracao],[],[]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_uf_uf = new TDataGridColumn('uf->uf', "UF", 'left');
        $column_data_icms = new TDataGridColumn('data_icms', "Data ICMS", 'left');
        $column_data_iss = new TDataGridColumn('data_iss', "Data ISS", 'left');
        $column_data_fecop = new TDataGridColumn('data_fecop', "Data FECOP", 'left');
        $column_data_difal = new TDataGridColumn('data_difal', "Data DIFAL", 'left');
        $column_data_antecipado = new TDataGridColumn('data_antecipado', "Data Antecipado", 'left');
        $column_data_sped = new TDataGridColumn('data_sped', "Data SPED", 'left');
        $column_data_declaracao = new TDataGridColumn('data_declaracao', "Data declaração", 'left');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_uf_uf);
        $this->datagrid->addColumn($column_data_icms);
        $this->datagrid->addColumn($column_data_iss);
        $this->datagrid->addColumn($column_data_fecop);
        $this->datagrid->addColumn($column_data_difal);
        $this->datagrid->addColumn($column_data_antecipado);
        $this->datagrid->addColumn($column_data_sped);
        $this->datagrid->addColumn($column_data_declaracao);

        $action_onEdit = new TDataGridAction(array('FormList_Prazos', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('FormList_Prazos', 'onDelete'));
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
        $container->add(TBreadCrumb::create(["Controle de cadastros","Cadastro de prazos e obrigações"]));
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onEdit($param = null) 
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new TblPrazos($key); // instantiates the Active Record 

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
                $object = new TblPrazos($key, FALSE); 

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

            $object = new TblPrazos(); // create an empty object 

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

            // creates a repository for TblPrazos
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

