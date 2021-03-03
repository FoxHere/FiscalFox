<?php

class FormList_protFinanc extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblProtFinanc';
    private static $primaryKey = 'id';
    private static $formName = 'form_list_TblProtFinanc';

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        //$this->form2 = new BootstrapFormBuilder;

        // define the form title
        $this->form->setFormTitle("Protocolo financeiro");
      //  $this->form2->setFormTitle("Protocolo financeiro2");

        //variáveis de cadastro
        $id = new TEntry('id');
        $departamento_id = new TDBCombo('departamento_id', 'db_fox_fiscal', 'TblDepartamento', 'id', '{departamento}','departamento asc'  );
        $vencimento = new TDate('vencimento');
        $num_pedido = new TEntry('num_pedido');
        $prestador_id = new TDBUniqueSearch('prestador_id', 'db_fox_fiscal', 'TblPrestador', 'id', 'cod','id desc'  );
        $valor = new TNumeric('valor', '2', ',', '.' );
        $categoria_id = new TDBCombo('categoria_id', 'db_fox_fiscal', 'TblCategoria', 'id', '{categoria}','categoria asc'  );
        $envio = new TDate('envio');


        $departamento_id->addValidation("Departamento_id", new TRequiredValidator()); 
        $vencimento->addValidation("Vencimento", new TRequiredValidator()); 
        $num_pedido->addValidation("Nº Pedido", new TRequiredValidator()); 
        $prestador_id->addValidation("Prestador", new TRequiredValidator()); 
        $valor->addValidation("Valor", new TRequiredValidator()); 
        $categoria_id->addValidation("Categoria_id", new TRequiredValidator()); 
        $envio->addValidation("Envio", new TRequiredValidator()); 

        




        //$id->setEditable(false);
        $prestador_id->setMinLength(1);

        $envio->setDatabaseMask('yyyy-mm-dd');
        $vencimento->setDatabaseMask('yyyy-mm-dd');

        $num_pedido->setMask('000000000');
        $envio->setMask('dd/mm/yyyy');
        $vencimento->setMask('dd/mm/yyyy');
        $prestador_id->setMask('{cod} - {doc} - {nome} ');

        $id->setSize('100%');
        $envio->setSize('100%');
        $valor->setSize('100%');
        $vencimento->setSize('100%');
        $num_pedido->setSize('100%');
        $prestador_id->setSize('100%');
        $categoria_id->setSize('100%');
        $departamento_id->setSize('100%');
        $envio->setValue(date("Y-m-d"));
        $valor->setNumericMask(2,',','.',true);

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', 'B'),$id],[new TLabel("Departamento:", '', '14px', 'B'),$departamento_id],[new TLabel("Vencimento:", '', '14px', 'B'),$vencimento],[new TLabel("Nº Pedido:", '', '14px', 'B'),$num_pedido],[new TLabel("Prestador:", '', '14px', 'B'),$prestador_id],[new TLabel("Valor:", '', '14px', 'B'),$valor],[new TLabel("Categoria:", '', '14px', 'B'),$categoria_id],[new TLabel("Envio:", '', '14px', 'B'),$envio]);
        $row1->layout = [' col-sm-1',' col-sm-1',' col-sm-1',' col-sm-1','col-sm-3',' col-sm-1 ',' col-sm-1 ',' col-sm-1 ',' col-sm-1 ',' col-sm-1 ',' col-sm-1 '];

        //campo da iframepara os campo de busca--------------------------------------------------------
        $buscaDepartamento = new TDBCombo('buscaDepartamento', 'db_fox_fiscal', 'TblDepartamento', 'id', '{departamento}','departamento asc'  );
        $buscaVencimento = new TDate('buscaVencimento');
        $buscaPedido = new TEntry('buscaPedido');
        $buscaPrestador = new TDBUniqueSearch('buscaPrestador', 'db_fox_fiscal', 'TblPrestador', 'id', 'cod','id desc'  );
        $buscaCategoria = new TDBCombo('buscaCategoria', 'db_fox_fiscal', 'TblCategoria', 'id', '{categoria}','categoria asc'  );
        $buscaValor = new TNumeric('buscaValor', '2', ',', '.' );
        $buscaEnvio = new TDate('buscaEnvio');
        
        $prestador_id->setMinLength(1);

        $buscaEnvio->setDatabaseMask('yyyy-mm-dd');
        $buscaVencimento->setDatabaseMask('yyyy-mm-dd');
        $buscaPedido->setMask('000000000');
        $buscaEnvio->setMask('dd/mm/yyyy');
        $vencimento->setMask('dd/mm/yyyy');
        $buscaPrestador->setMask('{cod} - {doc} - {nome} ');

        $buscaEnvio->setSize('100%');
        $buscaValor->setSize('100%');
        $buscaVencimento->setSize('100%');
        $buscaPedido->setSize('100%');
        $buscaPrestador->setSize('100%');
        $buscaCategoria->setSize('100%');
        $buscaDepartamento->setSize('100%');

        $buscaPrestador->setMinLength(1);

        //$buscaEnvio->setValue(date("Y-m-d"));
        $buscaValor->setNumericMask(2,',','.',true);

        $buscaEnvio->placeholder = "buscar pelo envio";
        $buscaValor->placeholder = "buscar por valor";
        $buscaVencimento->placeholder = "buscar pelo vencimento";
        $buscaPedido->placeholder = "buscar pelo pedido";
        $buscaPrestador->placeholder = "buscar pelo Prestador";
        $buscaCategoria->placeholder = "busca";
        $buscaDepartamento->placeholder = "busca";
        $row2 = $this->form->addContent([new TFormSeparator("Filtros de busca","#007bff","#eeeeee")]);
        $row2 = $this->form->addFields([],[new TLabel("Departamento:", '#007bff', '14px', 'B'),$buscaDepartamento],[new TLabel("Venciemnto:", '#007bff', '14px', 'B'),$buscaVencimento], [new TLabel("Pedido:", '#007bff', '14px', 'B'),$buscaPedido],[new TLabel("Prestador:", '#007bff', '14px', 'B'),$buscaPrestador],[new TLabel("Valor:", '#007bff', '14px', 'B'),$buscaValor],[new TLabel("Categoria:", '#007bff', '14px', 'B'),$buscaCategoria],[new TLabel("Data envio:", '#007bff', '14px', 'B'),$buscaEnvio]);
        $row2->layout = ['col-sm-1','col-sm-1','col-sm-1','col-sm-1','col-sm-3','col-sm-1','col-sm-1','col-sm-1'];
        
        /*
        $frame = new TFrame;
        $frame->oid = 'frame-measures';
        $frame->setLegend('Campo de procura');

        $buttonHide = new TButton('show_hide fas:save #ffffff');
        $buttonHide->class = 'btn btn-default btn-sm active';
        $buttonHide->setLabel('Campos de busca');
        $buttonHide->addfunction("\$('[oid=frame-measures]').slideToggle(); $(this).toggleClass( 'active' )");
        $buttonHide->setImage('fas:search #000000');
        $row5 = $this->form->addFields([$buttonHide]);
        $row6 = $this->form->addFields([$frame]);
        $tablehide = new TTable;
        $tablehide->width = '50%';
        $row1 = $tablehide->addRow();
        $row1->addCell(new TLabel(' Departamento'));
        $row1->addCell($buscaDepartamento);
        $row1->addCell(new TLabel(' Vencimento'));
        $row1->addCell($buscaVencimento);
        $row1->addCell(new TLabel(' Nº Pedido'));
        $row1->addCell($buscaPedido);
        $row2 = $tablehide->addRow();
        $row2->addCell(new TLabel(' Prestador'));
        $row2->addCell($buscaPrestador);
        $row2->colspan=8;
        $row3 = $tablehide->addRow();
        $row3->addCell(new TLabel(' Categoria'));
        $row3->addCell($buscaCategoria);
        $row3->addCell(new TLabel(' Valor'));
        $row3->addCell($buscaValor);
        $row3->addCell(new TLabel(' Envio'));
        $row3->addCell($buscaEnvio);
        $frame->add($tablehide);
        */
        
        

        //---------------------------------------------------------------------------------------------



        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $buttonBuscar = new TButton('button_tbutton');
        $buttonBuscar = $this->form->addAction("Procurar",new TAction([$this, 'onSearch']), 'fas:search #000000');
        $buttonBuscar->addStyleClass('btn-default');
        // creates a Datagrid
        $this->datagrid = new  TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);

        
        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        $this->datagrid->datatable = 'true';
        
        //campo de busca na data grid------------------------------------------------------------------
        $inputSearch = new TEntry('input_search');
        $inputSearch->placeholder = ('Digite para busca rápida na pagina atual');
        $inputSearch->setSize('100%');
        $this->datagrid->enableSearch($inputSearch, 'departamento->departamento, vencimento, num_pedido, prestador->nome, categoria->categoria, envio, valor');
        //---------------------------------------------------------------------------------------------



        $column_id = new TDataGridColumn('id', "Id", 'center');
        $column_departamento_departamento = new TDataGridColumn('departamento->departamento', "Departamento", 'left');
        $column_vencimento = new TDataGridColumn('vencimento', "Vencimento", 'left');
        $column_num_pedido = new TDataGridColumn('num_pedido', "Nº Pedido", 'left');
        $column_prestador_cod = new TDataGridColumn('{prestador->nome}', "Prestador", 'left');
        $column_categoria_categoria = new TDataGridColumn('categoria->categoria', "Categoria", 'left');
        $column_valor = new TDataGridColumn('valor', "Valor", 'right');
        $column_envio = new TDataGridColumn('envio', "Envio", 'left');
        
        $column_valor->setTransformer(function($value, $object, $row) 
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
       

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_departamento_departamento);
        $this->datagrid->addColumn($column_vencimento);
        $this->datagrid->addColumn($column_num_pedido);
        $this->datagrid->addColumn($column_prestador_cod);
        $this->datagrid->addColumn($column_categoria_categoria);
        $this->datagrid->addColumn($column_valor);
        $this->datagrid->addColumn($column_envio);
        $column_vencimento->setTransformer(array($this, 'formatDate1'));
        $column_envio->setTransformer(array($this, 'formatDate2'));
        //$column_valor->setTransformer(array($this, 'formatSalary'));
        //$column_num_pedido->setTransformer(array($this, 'formatPedido'));

        $action_group = new TDataGridActionGroup("", 'fas:cog');
        $action_group->addHeader('O que deseja fazer?');

        $action_onEdit = new TDataGridAction(array('FormList_protFinanc', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('FormList_protFinanc', 'onDelete'));
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

        $panel = new TPanelGroup('');
        $panel->add($this->datagrid)->class = 'table-bordered';
        $panel->addHeaderWidget($this->pageNavigation);
        $panel->addHeaderWidget($inputSearch);
        
        //$panel->add($this->datagrid)->style = 'overflow-x:auto';
        //$panel->add($this->datagrid)->class = 'table-bordered';
        

        $panel->addFooter($this->pageNavigation);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Recebimento","Protocolo financeiro"]));
        $container->add($this->form);
        //$container->add($this->form2);
        $container->add($panel);

        parent::add($container);

    }
    public function onSearch($param = NULL)
    {
    
       // get the search form data
       $data = $this->form->getData();
       $filters = [];

       TSession::setValue(__CLASS__.'_filter_data', NULL);
       TSession::setValue(__CLASS__.'_filters', NULL);

        /*
        $buscaDepartamento = new TDBCombo('buscaDepartamento', 'db_fox_fiscal', 'TblDepartamento', 'id', '{departamento}','departamento asc'  );
        $buscaVencimento = new TDate('buscaVencimento');
        $buscaPedido = new TEntry('buscaPedido');
        $buscaPrestador = new TDBUniqueSearch('buscaPrestador', 'db_fox_fiscal', 'TblPrestador', 'id', 'cod','id desc'  );
        $buscaCategoria = new TDBCombo('buscaCategoria', 'db_fox_fiscal', 'TblCategoria', 'id', '{categoria}','categoria asc'  );
        $buscaValor = new TNumeric('buscaValor', '2', ',', '.' );
        $buscaEnvio = new TDate('buscaEnvio');
        */

        if (isset($data->buscaVencimento) AND ( (is_scalar($data->buscaVencimento) AND $data->buscaVencimento !== '') OR (is_array($data->buscaVencimento) AND (!empty($data->buscaVencimento)) )) )
        {

            $filters[] = new TFilter('vencimento', '=', $data->buscaVencimento);// create the filter 
        }

        if (isset($data->buscaPedido) AND ( (is_scalar($data->buscaPedido) AND $data->buscaPedido !== '') OR (is_array($data->buscaPedido) AND (!empty($data->buscaPedido)) )) )
        {

            $filters[] = new TFilter('num_pedido', '=', $data->buscaPedido);// create the filter 
        }

        if (isset($data->buscaValor) AND ( (is_scalar($data->buscaValor) AND $data->buscaValor !== '') OR (is_array($data->buscaValor) AND (!empty($data->buscaValor)) )) )
        {

            $filters[] = new TFilter('valor', '=', $data->buscaValor);// create the filter 
        }

        if (isset($data->buscaDepartamento) AND ( (is_scalar($data->buscaDepartamento) AND $data->buscaDepartamento !== '') OR (is_array($data->buscaDepartamento) AND (!empty($data->buscaDepartamento)) )) )
        {

            $filters[] = new TFilter('departamento_id', '=', $data->buscaDepartamento);// create the filter 
        }

        if (isset($data->buscaEnvio) AND ( (is_scalar($data->buscaEnvio) AND $data->buscaEnvio !== '') OR (is_array($data->buscaEnvio) AND (!empty($data->buscaEnvio)) )) )
        {

            $filters[] = new TFilter('envio', '=', $data->buscaEnvio);// create the filter 
        }

        if (isset($data->buscaPrestador) AND ( (is_scalar($data->buscaPrestador) AND $data->buscaPrestador !== '') OR (is_array($data->buscaPrestador) AND (!empty($data->buscaPrestador)) )) )
        {

            $filters[] = new TFilter('prestador_id', '=', $data->buscaPrestador);// create the filter 
        }

        if (isset($data->buscaCategoria) AND ( (is_scalar($data->buscaCategoria) AND $data->buscaCategoria !== '') OR (is_array($data->buscaCategoria) AND (!empty($data->buscaCategoria)) )) )
        {

            $filters[] = new TFilter('categoria_id', '=', $data->buscaCategoria);// create the filter 
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
    
    public function formatPedido($column_num_pedido, $object)
    {
        
    }
    public function formatSalary($column_valor, $object, $row)
    {
        $number = number_format($column_valor, 2, ',', ',');
        if ($column_valor > 0)
        {
            return "<span style='color:blue;text-align:right'>$number</span>";
        }
        else
        {
            $row->style = "background: #FFF9A7";
            return "<span style='color:red'>$number</span>";
        }
    }    
    public static function onView($param)
    {
        $dep = $param['departamento_id'];
    }
    public function formatDate1($column_vencimento, $object)
    {
        $date = new DateTime($object->vencimento);
        return $date->format('d/m/Y');
    }
    public function formatDate2($column_vencimento, $object)
    {
        $date = new DateTime($object->envio);
        return $date->format('d/m/Y');
    }

    public function onEdit($param = null) 
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new TblProtFinanc($key); // instantiates the Active Record 

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
                $object = new TblProtFinanc($key, FALSE); 

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

            $object = new TblProtFinanc(); // create an empty object 

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
            //$this->form->clear(true);
            //$this->loaded = true;
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

