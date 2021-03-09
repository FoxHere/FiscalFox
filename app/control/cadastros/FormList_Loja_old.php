<?php

class FormList_Loja extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblLojas';
    private static $primaryKey = 'id';
    private static $formName = 'form_list_TblLojas';

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

        $filterVar = "1";
        $criteria_responsavel_id->add(new TFilter('tbl_grupo_id', '=', $filterVar)); 

        $id = new TEntry('id');
        $loja = new TEntry('loja');
        $status_id = new TDBCombo('status_id', 'db_fox_fiscal', 'TblStatus', 'id', '{status}','status asc'  );
        $empresa_id = new TDBCombo('empresa_id', 'db_fox_fiscal', 'TblEmpresa', 'id', '{empresa}','empresa asc'  );
        $numCapta = new TEntry('numCapta');
        $responsavel_id = new TDBCombo('responsavel_id', 'db_fox_fiscal', 'TblResponsaveis', 'id', '{responsavel}','responsavel asc' , $criteria_responsavel_id );
        $endereco = new TEntry('endereco');
        $cidades_id = new TDBCombo('cidades_id', 'db_fox_fiscal', 'TblCidades', 'id', '{cidades}  - {uf->uf} ','cidades asc'  );
        $uf_id = new TDBCombo('uf_id', 'db_fox_fiscal', 'TblUf', 'id', '{uf}','uf asc'  );
        $cep = new TEntry('cep');
        $shopping = new TEntry('shopping');
        $cnpj = new TEntry('cnpj');
        $inscEstadual = new TEntry('inscEstadual');
        $inscMunicipal = new TEntry('inscMunicipal');
        $nire = new TEntry('nire');
        $buscaLoja = new TDBUniqueSearch('buscaLoja', 'db_fox_fiscal', 'TblLojas', 'loja', 'loja','loja asc'  );

        $status_id->addValidation("Status", new TRequiredValidator()); 
        $empresa_id->addValidation("Empresa id", new TRequiredValidator()); 
        $numCapta->addValidation("Nº", new TRequiredValidator()); 
        $responsavel_id->addValidation("Responsável", new TRequiredValidator()); 
        $endereco->addValidation("Rual Tal", new TRequiredValidator()); 
        $cidades_id->addValidation("Cidade", new TRequiredValidator()); 
        $uf_id->addValidation("UF", new TRequiredValidator()); 
        $cep->addValidation("CEP", new TRequiredValidator()); 
        $shopping->addValidation("Shopping", new TRequiredValidator()); 
        $cnpj->addValidation("CNPJ", new TRequiredValidator()); 
        $inscEstadual->addValidation("Inscrição estadual", new TRequiredValidator()); 

        $buscaLoja->setMinLength(1);
        $id->setEditable(false);

        $nire->placeholder = "Sem pontuação";

        $numCapta->setMask('0000');
        $cep->setMask('00000-000');
        $cnpj->setMask('00.000.000/0000-00');
        $buscaLoja->setMask('{loja} - {uf->uf} ');

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

        $id->setSize(70);
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
        $buscaLoja->setSize('71%');
        $inscEstadual->setSize('100%');
        $inscMunicipal->setSize('100%');
        $responsavel_id->setSize('100%');

        $row1 = $this->form->addContent([new TFormSeparator("Dados Principais", '#333333', '18', '#eeeeee')]);
        $row2 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id],[new TLabel("Loja:", null, '14px', null)],[$loja],[new TLabel("Status:", '#ff0000', '14px', null)],[$status_id],[new TLabel("Empresa:", '#ff0000', '14px', null)],[$empresa_id],[new TLabel("Nº do Capta:", '#ff0000', '14px', null)],[$numCapta]);
        $row2->layout = [' col-sm-1 control-label',' col-sm-1',' col-sm-1 control-label',' col-sm-1',' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label',' col-sm-1',' col-sm-1','col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("Responsável:", '#ff0000', '14px', null)],[$responsavel_id]);
        $row3->layout = [' col-sm-1',' col-sm-11'];

        $row4 = $this->form->addContent([new TFormSeparator("Localização", '#333333', '18', '#eeeeee')]);
        $row5 = $this->form->addFields([new TLabel("Endereço", '#ff0000', '14px', null)],[$endereco]);
        $row5->layout = [' col-sm-1',' col-sm-11'];

        $row6 = $this->form->addFields([new TLabel("Cidade:", '#ff0000', '14px', null)],[$cidades_id],[new TLabel("UF:", '#ff0000', '14px', null)],[$uf_id],[new TLabel("CEP:", '#ff0000', '14px', null)],[$cep],[new TLabel("Shopping:", '#ff0000', '14px', null)],[$shopping]);
        $row6->layout = [' col-sm-1',' col-sm-3',' col-sm-1',' col-sm-1',' col-sm-1','col-sm-2',' col-sm-1','col-sm-2'];

        $row7 = $this->form->addContent([new TFormSeparator("Documentos legais", '#333333', '18', '#eeeeee')]);
        $row8 = $this->form->addFields([new TLabel("CNPJ:", '#ff0000', '14px', null)],[$cnpj],[new TLabel("I.E:", '#ff0000', '14px', null)],[$inscEstadual],[new TLabel("I.M:", null, '14px', null)],[$inscMunicipal],[new TLabel("NIRE:", null, '14px', null)],[$nire]);
        $row8->layout = [' col-sm-1 control-label',' col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label','col-sm-2',' col-sm-1 control-label','col-sm-2'];

        $row9 = $this->form->addContent([new TFormSeparator("Filtro de busca", '#333333', '18', '#eeeeee')]);
        $row11 = $this->form->addFields([new TLabel("Loja", null, '14px', null)],[$buscaLoja]);
        $row11->layout = [' col-sm-1',' col-sm-2'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $tbn_procurar = $this->form->addAction("Procurar", new TAction([$this, 'procuraLoja']),'fas:search #ffffff');
        $tbn_procurar->addStyleClass('btn-success');

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_empresa_empresa = new TDataGridColumn('empresa->empresa', "Empresa id", 'left');
        $column_status_status = new TDataGridColumn('status->status', "Status", 'left');
        $column_numCapta = new TDataGridColumn('numCapta', "Nº", 'left');
        $column_loja = new TDataGridColumn('loja', "Loja", 'left');
        $column_uf_uf = new TDataGridColumn('uf->uf', "UF", 'left');
        $column_endereco = new TDataGridColumn('endereco', "Endereço", 'left');
        $column_cidades_cidades = new TDataGridColumn('cidades->cidades', "Cidade", 'left');
        $column_cep = new TDataGridColumn('cep', "CEP", 'left');
        $column_shopping = new TDataGridColumn('shopping', "Shopping", 'left');
        $column_cnpj = new TDataGridColumn('cnpj', "CNPJ", 'left');
        $column_inscEstadual = new TDataGridColumn('inscEstadual', "I.E", 'left');
        $column_inscMunicipal = new TDataGridColumn('inscMunicipal', "I.M", 'left');
        $column_nire = new TDataGridColumn('nire', "NIRE", 'left');
        $column_responsavel_responsavel = new TDataGridColumn('responsavel->responsavel', "Responsável", 'left');

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);

        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_empresa_empresa);
        $this->datagrid->addColumn($column_status_status);
        $this->datagrid->addColumn($column_numCapta);
        $this->datagrid->addColumn($column_loja);
        $this->datagrid->addColumn($column_uf_uf);
        $this->datagrid->addColumn($column_endereco);
        $this->datagrid->addColumn($column_cidades_cidades);
        $this->datagrid->addColumn($column_cep);
        $this->datagrid->addColumn($column_shopping);
        $this->datagrid->addColumn($column_cnpj);
        $this->datagrid->addColumn($column_inscEstadual);
        $this->datagrid->addColumn($column_inscMunicipal);
        $this->datagrid->addColumn($column_nire);
        $this->datagrid->addColumn($column_responsavel_responsavel);

        $action_group = new TDataGridActionGroup("", 'fas:cog');
        $action_group->addHeader('');

        $action_onEdit = new TDataGridAction(array('FormList_Loja', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('FormList_Loja', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
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
        $container->add(TBreadCrumb::create(["Controle de cadastros","Cadastro de Lojas"]));
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
            $filters[] = new Tfilter('loja','=', "{$data->buscaLoja}");
        }
        
        $param = array();
        $param['offset'] = 0;
        $param['first_page'] = 1;

        $this->form->setData($data);

        Tsession::setValue(__class__.'_filter_data',$data);
        Tsession::setValue(__CLASS__.'_filters',$filters);

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

            // creates a repository for TblLojas
            $repository = new TRepository(self::$activeRecord);
            $limit = 15;
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

                if($filters = Tsession::getValue(__CLASS__.'_filters'))
                {
                    foreach($filters as $filter){
                        $criteria->add($filter);
                    }
                }

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

