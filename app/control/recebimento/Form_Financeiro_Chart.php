<?php

class Form_Financeiro_Chart extends TPage
{
    private $form; // form
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblProtFinanc';
    private static $primaryKey = 'id';
    private static $formName = 'formChart_TblProtFinanc';

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
        $this->form->setFormTitle("Gráfico financeiro");

        $dt_Inicio = new TDate('dt_Inicio');
        $dt_Fim = new TDate('dt_Fim');
        $categoria_id = new TDBSelect('categoria_id', 'db_fox_fiscal', 'TblProtFinanc', 'id', '{categoria->categoria} ','id asc'  );

        $categoria_id->addValidation("categoria", new TRequiredValidator()); 

        $dt_Fim->setMask('dd/mm/yyyy');
        $dt_Inicio->setMask('dd/mm/yyyy');

        $dt_Fim->setValue('31/12/2020');
        $dt_Inicio->setValue('01/01/2020');

        $dt_Fim->setDatabaseMask('yyyy-mm-dd');
        $dt_Inicio->setDatabaseMask('yyyy-mm-dd');

        $dt_Fim->setTip("Data fim ");
        $dt_Inicio->setTip("Data Início");

        $dt_Fim->setSize(170);
        $dt_Inicio->setSize(170);
        $categoria_id->setSize('97%', 140);

        $row1 = $this->form->addFields([new TLabel("Envio:", null, '15px', 'B')],[new TLabel("Data Início:", null, '14px', 'B', '100%'),$dt_Inicio],[new TLabel("Data Fim:", null, '14px', 'B', '100%'),$dt_Fim]);
        $row1->layout = [' col-sm-2 control-label',' col-sm-2',' col-sm-2'];

        $row2 = $this->form->addFields([],[new TLabel("Categoria:", null, '14px', 'B', '100%'),$categoria_id]);
        $row2->layout = [' col-sm-2',' col-sm-4'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongenerate = $this->form->addAction("Gerar", new TAction([$this, 'onGenerate']), 'fas:search #ffffff');
        $btn_ongenerate->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Recebimento","Gráfico financeiro"]));
        $container->add($this->form);

        parent::add($container);

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

        if (isset($data->dt_Inicio) AND ( (is_scalar($data->dt_Inicio) AND $data->dt_Inicio !== '') OR (is_array($data->dt_Inicio) AND (!empty($data->dt_Inicio)) )) )
        {

            $filters[] = new TFilter('envio', '>=', $data->dt_Inicio);// create the filter 
        }
        if (isset($data->dt_Fim) AND ( (is_scalar($data->dt_Fim) AND $data->dt_Fim !== '') OR (is_array($data->dt_Fim) AND (!empty($data->dt_Fim)) )) )
        {

            $filters[] = new TFilter('envio', '<=', $data->dt_Fim);// create the filter 
        }
        if (isset($data->categoria_id) AND ( (is_scalar($data->categoria_id) AND $data->categoria_id !== '') OR (is_array($data->categoria_id) AND (!empty($data->categoria_id)) )) )
        {

            $filters[] = new TFilter('categoria_id', '=', $data->categoria_id);// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);
    }

    /**
     * Load the datagrid with data
     */
    public function onGenerate()
    {
        try
        {
            $this->onSearch();
            // open a transaction with database 'db_fox_fiscal'
            TTransaction::open(self::$database);
            $param = [];
            // creates a repository for TblProtFinanc
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = new TCriteria;

            if ($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $monthNames = ['01'=> '01'._t('January'), '02'=>'02'._t('February'), '03'=>'03'._t('March'), '04'=>'04'._t('April'), '05'=>'05'._t('May'), '06'=>'06'._t('June'), '07'=>'07'._t('July'), '08'=>'08'._t('August'), '09'=>'09'._t('September'), '10'=>'10'._t('October'), '11'=>'11'._t('November'), '12'=>'12'._t('December')];

            if ($objects)
            {
                $dataTotals = [];
                $data = [];
                $groups = [];
                foreach ($objects as $obj)
                {
                    $group1 = $obj->categoria_id;
                    $group2 = $obj->envio;

                    $group2 = $monthNames[TDateTime::convertToMask($group2, 'yyyy-mm-dd', 'm')];

                    $groups[$group2] = true;
                    $numericField = $obj->id;

                    $dataTotals[$group1][$group2]['count'] = isset($dataTotals[$group1][$group2]['count']) ? $dataTotals[$group1][$group2]['count'] + 1 : 1;
                    $dataTotals[$group1][$group2]['sum'] = isset($dataTotals[$group1][$group2]['sum']) ? $dataTotals[$group1][$group2]['sum'] + $numericField  : $numericField;

                }

                $groups = ['x'=>true]+$groups;

                $tempGroups = ['x'=>true];
                unset($groups['x']);
                foreach($groups as $key=>$value)
                {
                    $tempGroups[substr($key, 2)] = true;
                }
                $groups = $tempGroups;
                $data = [array_keys($groups)];
                $line = array_fill(0, count($groups), NULL);

                foreach ($dataTotals as $group1 => $group1Totals) 
                {
                    ksort($dataTotals);

                    $lineData = $line;

                    $lineData[0] = $group1;
                    foreach ($group1Totals as $group2 => $totals) 
                    {
                        $group2 = substr($group2, 2);
                        $posi = array_search($group2, array_keys($groups));

                        $lineData[$posi] = $totals['count'];

                    }
                    $data[] = $lineData;
                }

                $chart = new THtmlRenderer('app/resources/c3_bar_chart.html');
                $chart->enableSection('main', [
                    'data'=> json_encode($data),
                    'height' => 300,
                    'precision' => 2,
                    'decimalSeparator' => ',',
                    'thousandSeparator' => '.',
                    'prefix' => '',
                    'sufix' => '',
                    'width' => 100,
                    'widthType' => '%',
                    'title' => 'Pagamentos no prazo',
                    'showLegend' => 'true',
                    'showPercentage' => 'false',
                    'barDirection' => 'false'
                ]);

                parent::add($chart);
            }
            else
            {
                new TMessage('error', _t('No records found'));
            }

            // close the transaction
            TTransaction::close();
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

}

