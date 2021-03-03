<?php

class Controle_ERPxLivros extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'db_fox_fiscal';
    private static $activeRecord = 'TblFechamento';
    private static $primaryKey = 'id';
    private static $formName = 'form_list_TblFechamento';

    function __construct()
    {

        parent::__construct();
        $this->form = new BootstrapFormBuilder(self::$formName);
        
        //criar as datagrids
        //datagrid 1
        $this->datagrid1 = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid1->disableHtmlConversion();
        $this->datagrid1->style = 'width: 100%';
        $this->datagrid1->setHeight(320);
        //datagrid 2
        $this->datagrid2 = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid2->disableHtmlConversion();
        $this->datagrid2->style = 'width: 100%';
        $this->datagrid2->setHeight(320);
        //datagrid 3 
        $this->datagrid3 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid3->disableHtmlConversion();
        $this->datagrid3->style = 'width:100%';
        $this->datagrid3->setHeight(320);
        //datagrid 4
        $this->datagrid4 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid4->disableHtmlConversion();
        $this->datagrid4->style = 'width:100%';
        $this->datagrid4->setHeight(320);
        //datagrid 5
        $this->datagrid5 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid5->disableHtmlConversion();
        $this->datagrid5->style = 'width: 100%';
        $this->datagrid5->setHeight(320);
        //datagrid 6 
        $this->datagrid6 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid6->disableHtmlConversion();
        $this->datagrid6->style = 'width: 100%';
        $this->datagrid6->setHeight(320);
        //datagrid 7
        $this->datagrid7 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid7->disableHtmlConversion();
        $this->datagrid7->style = 'width: 100%';
        $this->datagrid7->setHeight(320);
        //datagrid 8
        $this->datagrid8 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid8->disableHtmlConversion();
        $this->datagrid8->style = 'width: 100%';
        $this->datagrid8->setHeight(320);
        //datagrid 9 
        $this->datagrid9 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid9->disableHtmlConversion();
        $this->datagrid9->style = 'Width: 100%';
        $this->datagrid9->setHeight(320);
        //datagrid 10
        $this->datagrid10 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid10->disableHtmlConversion();
        $this->datagrid10->Style = 'Width: 100%';
        $this->datagrid10->setHeight(320); 
        //datagrid 11
        $this->datagrid11 = new BootstrapdatagridWrapper(new TDatagrid);
        $this->datagrid11->disableHtmlConversion();
        $this->datagrid11->Style = 'Width: 100%';
        $this->datagrid11->setHeight(320);
        //datagrid 12
        $this->datagrid12 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid12->disableHtmlConversion();
        $this->datagrid12->Style = 'Width: 100%';
        $this->datagrid12->setHeight(320);
        //datagrid 13
        $this->datagrid13 = new BootstrapDatagridWrapper(new TDataGrid); 
        $this->datagrid13->disableHtmlConversion();
        $this->datagrid13->style = 'Width: 100%';
        $this->datagrid13->setHeight (320);
        //datagrid 14 
        $this->datagrid14 = new BootstrapDAtagridWrapper(new TDatagrid);
        $this->datagrid14->disableHtmlConversion();
        $this->datagrid14->Style = 'Width: 100%';
        $this->datagrid14->setHeight(320);
        //datagrid 15
        $this->datagrid15 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid15->disableHtmlConversion();
        $this->datagrid15->Style = 'Width: 100%';
        $this->datagrid15->setHeight(320);
        //datagrid 16
        $this->datagrid16 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid16->disableHtmlConversion();
        $this->datagrid16->Style = 'Width: 100%';
        $this->datagrid16->setHeight(320);
        //datagrid17
        $this->datagrid17 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid17->disableHtmlConversion();
        $this->datagrid17->Style = 'Width: 100%';
        $this->datagrid17->setHeight(320);
        //datagrid18
        $this->datagrid18 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid18->disableHtmlConversion();
        $this->datagrid18->Style = 'Width: 100%';
        $this->datagrid18->setHeight(320);
        //datagrid19
        $this->datagrid19 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid19->disableHtmlConversion();
        $this->datagrid19->Style = 'Width: 100%';
        $this->datagrid19->setHeight(320);
        //datagrid20
        $this->datagrid20 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid20->disableHtmlConversion();
        $this->datagrid20->Style = 'Width: 100%';
        $this->datagrid20->setHeight(320);
        //datagrid21
        $this->datagrid21 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid21->disableHtmlConversion();
        $this->datagrid21->Style = 'Width: 100%';
        $this->datagrid21->setHeight(320);
        //datagrid22
        $this->datagrid22 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid22->disableHtmlConversion();
        $this->datagrid22->Style = 'Width: 100%';
        $this->datagrid22->setHeight(320);
        //datagrid23
        $this->datagrid23 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid23->disableHtmlConversion();
        $this->datagrid23->Style = 'Width: 100%';
        $this->datagrid23->setHeight(320);
        //datagrid24
        $this->datagrid24 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid24->disableHtmlConversion();
        $this->datagrid24->Style = 'Width: 100%';
        $this->datagrid24->setHeight(320);
        //datagrid25
        $this->datagrid25 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid25->disableHtmlConversion();
        $this->datagrid25->Style = 'Width: 100%';
        $this->datagrid25->setHeight(320);
        //datagrid26
        $this->datagrid26 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid26->disableHtmlConversion();
        $this->datagrid26->Style = 'Width: 100%';
        $this->datagrid26->setHeight(320);
        //datagrid27
        $this->datagrid27 = new BootstrapDatagridWrapper(new TDatagrid);
        $this->datagrid27->disableHtmlConversion();
        $this->datagrid27->Style = 'Width: 100%';
        $this->datagrid27->setHeight(320);
        
        //$this->datagrid1->makeScrollable();
        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_tbl_lojas_lojas = new TDataGridColumn('{tbl_lojas_id}', "Lojas", 'left');
        $column_tbl_fechamento_ERPxLivros_id = new TDataGridColumn('tbl_fechamento_ERPxLivros_id', "ERPxLivros", 'left');
        $column_tbl_fechamento_ERPxLivros_id->setTransformer( function($value, $object, $row) {

            $pk = $object->getPrimaryKey();

            $tbl_fechamento_ERPxLivros_erpxlivros = new TDBCombo($object->$pk.'_'.'tbl_fechamento_ERPxLivros_id', 'db_fox_fiscal', 'TblFechamentoErpxlivros', 'id', '{erpxlivros}','erpxlivros asc'  );
            $tbl_fechamento_ERPxLivros_erpxlivros->setSize('100%');

            $tbl_fechamento_ERPxLivros_erpxlivros->setFormName(self::$formName);
            $tbl_fechamento_ERPxLivros_erpxlivros->setValue($value);
            $action = new TAction( [$this, 'onSaveInline'] );
            $action->setParameter('column', 'tbl_fechamento_ERPxLivros_id');
            $tbl_fechamento_ERPxLivros_erpxlivros->setChangeAction( $action );
            return $tbl_fechamento_ERPxLivros_erpxlivros;
            
            
        });
        

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        //datagrid 1
        $this->datagrid1->addColumn($column_id);
        $this->datagrid1->addColumn($column_tbl_lojas_lojas);
        $this->datagrid1->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 2
        $this->datagrid2->addColumn($column_id);
        $this->datagrid2->addColumn($column_tbl_lojas_lojas);
        $this->datagrid2->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 3
        $this->datagrid3->addColumn($column_id);
        $this->datagrid3->addColumn($column_tbl_lojas_lojas);
        $this->datagrid3->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 4
        $this->datagrid4->addColumn($column_id);
        $this->datagrid4->addColumn($column_tbl_lojas_lojas);
        $this->datagrid4->addColumn($column_tbl_fechamento_ERPxLivros_id); 
        //datagrid 5
        $this->datagrid5->addColumn($column_id);
        $this->datagrid5->addColumn($column_tbl_lojas_lojas);
        $this->datagrid5->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 6
        $this->datagrid6->addColumn($column_id);
        $this->datagrid6->addColumn($column_tbl_lojas_lojas);
        $this->datagrid6->addColumn($column_tbl_fechamento_ERPxLivros_id);
        $this->datagrid6->createModel();
        //datagrid 7
        $this->datagrid7->addColumn($column_id);
        $this->datagrid7->addColumn($column_tbl_lojas_lojas);
        $this->datagrid7->addColumn($column_tbl_fechamento_ERPxLivros_id);
        $this->datagrid7->createModel();
        //datagrid 8
        $this->datagrid8->addColumn($column_id);
        $this->datagrid8->addColumn($column_tbl_lojas_lojas);
        $this->datagrid8->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 9
        $this->datagrid9->addColumn($column_id);
        $this->datagrid9->addColumn($column_tbl_lojas_lojas);
        $this->datagrid9->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 10
        $this->datagrid10->addColumn($column_id);
        $this->datagrid10->addColumn($column_tbl_lojas_lojas);
        $this->datagrid10->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 11
        $this->datagrid11->addColumn($column_id);
        $this->datagrid11->addColumn($column_tbl_lojas_lojas);
        $this->datagrid11->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 12
        $this->datagrid12->addColumn($column_id);
        $this->datagrid12->addColumn($column_tbl_lojas_lojas);
        $this->datagrid12->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 13
        $this->datagrid13->addColumn($column_id);
        $this->datagrid13->addColumn($column_tbl_lojas_lojas);
        $this->datagrid13->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 14
        $this->datagrid14->addColumn($column_id);
        $this->datagrid14->addColumn($column_tbl_lojas_lojas);
        $this->datagrid14->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 15
        $this->datagrid15->addColumn($column_id);
        $this->datagrid15->addColumn($column_tbl_lojas_lojas);
        $this->datagrid15->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 16
        $this->datagrid16->addColumn($column_id);
        $this->datagrid16->addColumn($column_tbl_lojas_lojas);
        $this->datagrid16->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 17
        $this->datagrid17->addColumn($column_id);
        $this->datagrid17->addColumn($column_tbl_lojas_lojas);
        $this->datagrid17->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 18
        $this->datagrid18->addColumn($column_id);
        $this->datagrid18->addColumn($column_tbl_lojas_lojas);
        $this->datagrid18->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 19
        $this->datagrid19->addColumn($column_id);
        $this->datagrid19->addColumn($column_tbl_lojas_lojas);
        $this->datagrid19->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 20
        $this->datagrid20->addColumn($column_id);
        $this->datagrid20->addColumn($column_tbl_lojas_lojas);
        $this->datagrid20->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 21
        $this->datagrid21->addColumn($column_id);
        $this->datagrid21->addColumn($column_tbl_lojas_lojas);
        $this->datagrid21->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 22
        $this->datagrid22->addColumn($column_id);
        $this->datagrid22->addColumn($column_tbl_lojas_lojas);
        $this->datagrid22->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 23
        $this->datagrid23->addColumn($column_id);
        $this->datagrid23->addColumn($column_tbl_lojas_lojas);
        $this->datagrid23->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 24
        $this->datagrid24->addColumn($column_id);
        $this->datagrid24->addColumn($column_tbl_lojas_lojas);
        $this->datagrid24->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 25
        $this->datagrid25->addColumn($column_id);
        $this->datagrid25->addColumn($column_tbl_lojas_lojas);
        $this->datagrid25->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 26
        $this->datagrid26->addColumn($column_id);
        $this->datagrid26->addColumn($column_tbl_lojas_lojas);
        $this->datagrid26->addColumn($column_tbl_fechamento_ERPxLivros_id);
        //datagrid 27
        $this->datagrid27->addColumn($column_id);
        $this->datagrid27->addColumn($column_tbl_lojas_lojas);
        $this->datagrid27->addColumn($column_tbl_fechamento_ERPxLivros_id);

        // create the datagrid model
        $this->datagrid1->createModel();
        $this->datagrid2->createModel();
        $this->datagrid3->createModel();
        $this->datagrid4->createModel();
        $this->datagrid5->createModel();
        $this->datagrid6->createModel();
        $this->datagrid7->createModel();
        $this->datagrid8->createModel();
        $this->datagrid9->createModel();
        $this->datagrid10->createModel();
        $this->datagrid11->createModel();
        $this->datagrid12->createModel();
        $this->datagrid13->createModel();
        $this->datagrid14->createModel();
        $this->datagrid15->createModel();
        $this->datagrid16->createModel();
        $this->datagrid17->createModel();
        $this->datagrid18->createModel();
        $this->datagrid19->createModel();
        $this->datagrid20->createModel();
        $this->datagrid21->createModel();
        $this->datagrid22->createModel();
        $this->datagrid23->createModel();
        $this->datagrid24->createModel();
        $this->datagrid25->createModel();
        $this->datagrid26->createModel();
        $this->datagrid27->createModel();



        //notebook 1
        //$notebook1 = new BootstrapNotebookWrapper(new TNotebook );
        //$notebook1->setTabsDirection('left');
        //notebook 1
        //$notebook2 = new BootstrapNotebookWrapper( new TNotebook );
        //$notebook2->setTabsDirection('left');
        
        //criar pagina notebook
        //$nb1_page1 = new TTable;
        //$nb2_page1 = new TTable;
        //adicionando pagina ao notebook
        //$notebook1->appendPage('Tabela geral', $nb1_page1);
        //$notebook2->appendPage('Tabela geral', $nb2_page1);

        //cria um scroll
        //subnotebook1 scrolls
        $snb1scroll1 = new TScroll;
        $snb1scroll2 = new TScroll;
        $snb1scroll3 = new TScroll;
        $snb1scroll4 = new TScroll;
        
        $snb1scroll1->setSize('100%','300');
        $snb1scroll2->setSize('100%','300');
        $snb1scroll3->setSize('100%','300');
        $snb1scroll4->setSize('100%','300');
        //subnotebook2 scrolls
        $snb2scroll1 = new TScroll;
        $snb2scroll2 = new TScroll;
        $snb2scroll3 = new TScroll;
        $snb2scroll4 = new TScroll;

        $snb2scroll1->setSize('100%','300');
        $snb2scroll2->setSize('100%','300');
        $snb2scroll3->setSize('100%','300');
        $snb2scroll4->setSize('100%','300');
        //subnotebook3 scrolls
        $snb3scroll1 = new TScroll;
        $snb3scroll2 = new TScroll;
        $snb3scroll3 = new TScroll;
        $snb3scroll4 = new TScroll;

        $snb3scroll1->setSize('100%','300');
        $snb3scroll2->setSize('100%','300');
        $snb3scroll3->setsize('100%','300');
        //subnotebook4 scrolls
        $snb4scroll1 = new TScroll;
        $snb4scroll2 = new TScroll;
        $snb4scroll3 = new TScroll;
        $snb4scroll4 = new TScroll;

        $snb4scroll1->setSize('100%','300');
        $snb4scroll2->setSize('100%','300');
        $snb4scroll3->setsize('100%','300');
        $snb4scroll4->setsize('100%','300');
        //subnotebook5 scrolls
        $snb5scroll1 = new TScroll;
        $snb5scroll2 = new TScroll;
        $snb5scroll3 = new TScroll;
        $snb5scroll4 = new TScroll;

        $snb5scroll1->setSize('100%','300');
        $snb5scroll2->setSize('100%','300');
        $snb5scroll3->setsize('100%','300');
        $snb5scroll4->setsize('100%','300');
        //subnotebook6 scrolls
        $snb6scroll1 = new TScroll;
        $snb6scroll2 = new TScroll;
        $snb6scroll3 = new TScroll;
        $snb6scroll4 = new TScroll;

        $snb6scroll1->setSize('100%','300');
        $snb6scroll2->setSize('100%','300');
        $snb6scroll3->setsize('100%','300');
        $snb6scroll4->setsize('100%','300');
        //subnotebook7 scrolls
        $snb7scroll1 = new TScroll;
        $snb7scroll2 = new TScroll;
        $snb7scroll3 = new TScroll;
        $snb7scroll4 = new TScroll;

        $snb7scroll1->setSize('100%','300');
        $snb7scroll2->setSize('100%','300');
        $snb7scroll3->setsize('100%','300');
        $snb7scroll4->setsize('100%','300');

        //criar o subnotebook
        //subnotebook 1
        $subnotebook1 = new TNotebook;
        $subnotebook1->setSize(150,50);
        //subnotebook 2
        $subnotebook2 = new TNotebook;
        $subnotebook2->setSize(150,50);
        //subnotebook 3
        $subnotebook3 = new TNotebook;
        $subnotebook3->setSize(150,50);
        //subnotebook 4
        $subnotebook4 = new TNotebook;
        $subnotebook4->setSize(150,50);
        //subnotebook 5
        $subnotebook5 = new TNotebook;
        $subnotebook5->setSize(150,50);
        //subnotebook 6
        $subnotebook6 = new TNotebook;
        $subnotebook6->setSize(150,50);
        //subnotebook 7
        $subnotebook7 = new TNotebook;
        $subnotebook7->setSize(150,50);

        //criar pagina subnotebook
        //subnotebook 1 tables
        $snb1_table1 = new TTable;
        $snb1_table2 = new TTable;
        $snb1_table3 = new TTable;
        $snb1_table4 = new TTable;
        //subnotebook 2 tables
        $snb2_table1 = new TTable;
        $snb2_table2 = new TTable;
        $snb2_table3 = new TTable;
        $snb2_table4 = new ttable;
        //subnotebook 3 tables
        $snb3_table1 = new TTable;
        $snb3_table2 = new TTable;
        $snb3_table3 = new TTable;
        $snb3_table4 = new TTable;
        //subnotebook 4 tables
        $snb4_table1 = new TTable;
        $snb4_table2 = new TTable;
        $snb4_table3 = new TTable;
        $snb4_table4 = new TTable;
        //subnotebook 5 tables
        $snb5_table1 = new TTable;
        $snb5_table2 = new TTable;
        $snb5_table3 = new TTable;
        $snb5_table4 = new TTable;
        //subnotebook 6 tables
        $snb6_table1 = new TTable;
        $snb6_table2 = new TTable;
        $snb6_table3 = new TTable;
        $snb6_table4 = new TTable;
        //subnotebook 7 tables
        $snb7_table1 = new TTable;
        $snb7_table2 = new TTable;
        $snb7_table3 = new TTable;
        $snb7_table4 = new TTable;

        /* 
        Nota: Colocar o Scroll no append page do notebook e um TTable dentro scroll 
              Colocar o datagrind dentro de uma celula de uma linha no TTable 
        */
        //-------------------------------------------------------------------------------------------------------------------------------------------
        //adicionando notebook 1:
        //Page 1
        $subnotebook1->appendPage('UF: AC',$snb1scroll1);
        $snb1scroll1->add($snb1_table1);
        $snb1linha1 = $snb1_table1->addRow();
        $snb1cell1 = $snb1linha1->addCell($this->datagrid1);
        $snb1cell1->valign = 'top';
        $snb1cell1->colspan = 2;
        //Page 2
        $subnotebook1->appendPage('UF: AL', $snb1scroll2);
        $snb1scroll2->add($snb1_table2);
        $snb1linha2 = $snb1_table2->addRow();
        $snb1cell2 = $snb1linha2->addCell($this->datagrid2);
        $snb1cell2->valign = 'top';
        $snb1cell2->colspan = 2;
        //Page 3
        $subnotebook1->appendPage('UF: AM', $snb1scroll3);
        $snb1scroll3->add($snb1_table3);
        $snb1linha3 = $snb1_table3->addRow();
        $snb1cell3 = $snb1linha3->addCell($this->datagrid3);
        $snb1cell3->valign = 'top';
        $snb1cell3->colspan = 2;
        //page 4 
        $subnotebook1->appendPage('UF: AP', $snb1scroll4);
        $snb1scroll4->add($snb1_table4);
        $snb1linha4 = $snb1_table4->addRow();
        $snbcell4 = $snb1linha4->addcell($this->datagrid4);
        $snbcell4->valign = 'top';
        $snbcell4->colspan = 2;
        //-------------------------------------------------------------------------------------------------------------------------------------------
        //adicionando notebook 2:
        //page 1
        $subnotebook2->appendPage('UF: BA',$snb2scroll1);
        $snb2scroll1->add($snb2_table1);
        $snb2linha1 = $snb2_table1->addRow();
        $snb2cell1=$snb2linha1->addCell($this->datagrid5);
        $snb2cell1->valign = 'top';
        $snb2cell1->colspan=2;
        //page2
        $subnotebook2->appendPage('UF: CE', $snb2scroll2);
        $snb2scroll2->add($snb2_table2);
        $snb2linha2 = $snb2_table2->addRow();
        $snb2cell2 = $snb2linha2->addCell($this->datagrid6);
        $snb2cell2->valign = 'top';
        $snb2cell2->colspan = 2;
        //page 3 
        $subnotebook2->appendPage('UF: DF', $snb2scroll3);
        $snb2scroll3->add($snb2_table3);
        $snb2linha3 = $snb2_table3->addRow();
        $snb2cell3 = $snb2linha3->addCell($this->datagrid7);
        $snb2cell3->valign = 'top';
        $snb2cell3->colspan = 2;
        //page 4
        $subnotebook2->appendPage('UF: ES', $snb2scroll4);
        $snb2scroll4->add($snb2_table4);
        $snb2linha4 = $snb2_table4->addRow();
        $snb2cell4 = $snb2linha4->addCell($this->datagrid8);
        $snb2cell4->valign = 'top';
        $snb2cell4->colspan = 2;
        //-------------------------------------------------------------------------------------------------------------------------------------------
        //adicionando notebook 3:
        //page 1
        $subnotebook3->appendPage('UF: GO',$snb3scroll1);
        $snb3scroll1->add($snb3_table1);
        $snb3linha1 = $snb3_table1->addRow();
        $snb3cell1=$snb3linha1->addCell($this->datagrid9);
        $snb3cell1->valign = 'top';
        $snb3cell1->colspan=2;
        //page2
        $subnotebook3->appendPage('UF: MA', $snb3scroll2);
        $snb3scroll2->add($snb3_table2);
        $snb3linha2 = $snb3_table2->addRow();
        $snb3cell2 = $snb3linha2->addCell($this->datagrid10);
        $snb3cell2->valign = 'top';
        $snb3cell2->colspan = 2;
        //page 3 
        $subnotebook3->appendPage('UF: MG', $snb3scroll3);
        $snb3scroll3->add($snb3_table3);
        $snb3linha3 = $snb3_table3->addRow();
        $snb3cell3 = $snb3linha3->addCell($this->datagrid11);
        $snb3cell3->valign = 'top';
        $snb3cell3->colspan = 2;
        //page 4
        $subnotebook3->appendPage('UF: MS', $snb3scroll4);
        $snb3scroll4->add($snb2_table4);
        $snb3linha4 = $snb3_table4->addRow();
        $snb3cell4 = $snb3linha4->addCell($this->datagrid12);
        $snb3cell4->valign = 'top';
        $snb3cell4->colspan = 2;
        //-------------------------------------------------------------------------------------------------------------------------------------------
        //adicionando notebook 4:
        //page 1
        $subnotebook4->appendPage('UF: MT',$snb4scroll1);
        $snb4scroll1->add($snb4_table1);
        $snb4linha1 = $snb4_table1->addRow();
        $snb4cell1=$snb4linha1->addCell($this->datagrid13);
        $snb4cell1->valign = 'top';
        $snb4cell1->colspan=2;
        //page2
        $subnotebook4->appendPage('UF: PA', $snb4scroll2);
        $snb4scroll2->add($snb4_table2);
        $snb4linha2 = $snb4_table2->addRow();
        $snb4cell2 = $snb4linha2->addCell($this->datagrid14);
        $snb4cell2->valign = 'top';
        $snb4cell2->colspan = 2;
        //page 3 
        $subnotebook4->appendPage('UF: PB', $snb4scroll3);
        $snb4scroll3->add($snb4_table3);
        $snb4linha3 = $snb4_table3->addRow();
        $snb4cell3 = $snb4linha3->addCell($this->datagrid15);
        $snb4cell3->valign = 'top';
        $snb4cell3->colspan = 2;
        //page 4
        $subnotebook4->appendPage('UF: PE', $snb4scroll4);
        $snb4scroll4->add($snb4_table4);
        $snb4linha4 = $snb4_table4->addRow();
        $snb4cell4 = $snb4linha4->addCell($this->datagrid16);
        $snb4cell4->valign = 'top';
        $snb4cell4->colspan = 2;
        //-------------------------------------------------------------------------------------------------------------------------------------------
        //adicionando notebook 5:
        //page 1
        $subnotebook5->appendPage('UF: PI',$snb5scroll1);
        $snb5scroll1->add($snb5_table1);
        $snb5linha1 = $snb5_table1->addRow();
        $snb5cell1=$snb5linha1->addCell($this->datagrid17);
        $snb5cell1->valign = 'top';
        $snb5cell1->colspan=2;
        //page2
        $subnotebook5->appendPage('UF: PR', $snb5scroll2);
        $snb5scroll2->add($snb5_table2);
        $snb5linha2 = $snb5_table2->addRow();
        $snb5cell2 = $snb5linha2->addCell($this->datagrid18);
        $snb5cell2->valign = 'top';
        $snb5cell2->colspan = 2;
        //page 3 
        $subnotebook5->appendPage('UF: RJ', $snb5scroll3);
        $snb5scroll3->add($snb5_table3);
        $snb5linha3 = $snb5_table3->addRow();
        $snb5cell3 = $snb5linha3->addCell($this->datagrid19);
        $snb5cell3->valign = 'top';
        $snb5cell3->colspan = 2;
        //page 4
        $subnotebook5->appendPage('UF: RN', $snb5scroll4);
        $snb5scroll4->add($snb5_table4);
        $snb5linha4 = $snb5_table4->addRow();
        $snb5cell4 = $snb5linha4->addCell($this->datagrid20);
        $snb5cell4->valign = 'top';
        $snb5cell4->colspan = 2;
        //-------------------------------------------------------------------------------------------------------------------------------------------
        //adicionando notebook 6:
        //page 1
        $subnotebook6->appendPage('UF: RO',$snb6scroll1);
        $snb6scroll1->add($snb6_table1);
        $snb6linha1 = $snb6_table1->addRow();
        $snb6cell1=$snb6linha1->addCell($this->datagrid21);
        $snb6cell1->valign = 'top';
        $snb6cell1->colspan=2;
        //page2
        $subnotebook6->appendPage('UF: RR', $snb6scroll2);
        $snb6scroll2->add($snb6_table2);
        $snb6linha2 = $snb6_table2->addRow();
        $snb6cell2 = $snb6linha2->addCell($this->datagrid22);
        $snb6cell2->valign = 'top';
        $snb6cell2->colspan = 2;
        //page 3 
        $subnotebook6->appendPage('UF: RS', $snb6scroll3);
        $snb6scroll3->add($snb6_table3);
        $snb6linha3 = $snb6_table3->addRow();
        $snb6cell3 = $snb6linha3->addCell($this->datagrid23);
        $snb6cell3->valign = 'top';
        $snb6cell3->colspan = 2;
        //page 4
        $subnotebook6->appendPage('UF: SC', $snb6scroll4);
        $snb6scroll4->add($snb6_table4);
        $snb6linha4 = $snb6_table4->addRow();
        $snb6cell4 = $snb6linha4->addCell($this->datagrid24);
        $snb6cell4->valign = 'top';
        $snb6cell4->colspan = 2;
        //-------------------------------------------------------------------------------------------------------------------------------------------
        //adicionando notebook 7:
        //page 1
        $subnotebook7->appendPage('UF: SE',$snb7scroll1);
        $snb7scroll1->add($snb7_table1);
        $snb7linha1 = $snb7_table1->addRow();
        $snb7cell1=$snb7linha1->addCell($this->datagrid25);
        $snb7cell1->valign = 'top';
        $snb7cell1->colspan=2;
        //page2
        $subnotebook7->appendPage('UF: SP', $snb7scroll2);
        $snb7scroll2->add($snb7_table2);
        $snb7linha2 = $snb7_table2->addRow();
        $snb7cell2 = $snb7linha2->addCell($this->datagrid26);
        $snb7cell2->valign = 'top';
        $snb7cell2->colspan = 2;
        //page 3 
        $subnotebook7->appendPage('UF: TO', $snb7scroll3);
        $snb7scroll3->add($snb7_table3);
        $snb7linha3 = $snb7_table3->addRow();
        $snb7cell3 = $snb7linha3->addCell($this->datagrid27);
        $snb7cell3->valign = 'top';
        $snb7cell3->colspan = 2;
        //page 4
        /*
        $subnotebook7->appendPage('UF: RN', $snb7scroll4);
        $snb7scroll4->add($snb7_table4);
        $snb7linha4 = $snb7_table4->addRow();
        $snb7cell4 = $snb7linha4->addCell($this->datagrid20);
        $snb7cell4->valign = 'top';
        $snb7cell4->colspan = 2;
        */
        
        

        //adiciona o subnotebook 1 no notebook 1
        //$row1 = $nb1_page1->addRow();
        //$row1->addCell($subnotebook1);
        //$row1->addCell($subnotebook2);
        
        

        //criar pagina 1
        //$page1 = new TTable;
        //$linha=$page1->addRow();
        //$cell=$linha->addCell($this->datagrid1);
        //$cell->valign = 'top';
        //$cell->colspan=2;
        //$notebook1->appendPage('Tabela geral', $page1);


        

        //criar a caixa horizontal
        $hbox1 = new THBox;
        $hbox1->add($subnotebook1);
        $hbox1->add($subnotebook2);
        $hbox1->add($subnotebook3);
        $hbox1->add($subnotebook4);

        $hbox2 = new THBox;
        $hbox2->add($subnotebook5);
        $hbox2->add($subnotebook6);
        $hbox2->add($subnotebook7);
        //$hbox2->add($subnotebook4);

        $subnotebookstable = new TTable;
        $snbtlinha1 = $subnotebookstable->addRow();
        $snbtlinha2 = $subnotebookstable->addRow();
        $snbtcell1 = $snbtlinha1->addCell($hbox1);
        $snbtcell2 = $snbtlinha2->addCell($hbox2);


        //criar a caixa vertical
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($subnotebookstable);

        parent::add($vbox);
    }


    public static function onSaveInline($param)
    {
        $name   = $param['_field_name'];
        $value  = $param['_field_value'];
        $column = $param['column'];
        $parts  = explode('_', $name);
        $id     = $parts[0];

        try
        {
            // open transaction
            TTransaction::open(self::$database);
            $class = self::$activeRecord;

            $object = $class::find($id);
            if ($object)
            {
                $object->$column = $value;
                $object->store();
            }

            // close transaction
            TTransaction::close();
        }
        catch (Exception $e)
        {
            // show the exception message
            new TMessage('error', $e->getMessage());
        }
    }




    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'db_fox'
            TTransaction::open(self::$database);
            // creates a repository for TblFechamento
            $repository = new TRepository(self::$activeRecord);
            $limit = 100;
            // creates a criteria
            $criteria1 = new TCriteria;
            $criteria1->add(new TFilter('id','in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 1)"));
            $criteria2 = new TCriteria;
            $criteria2->add(new TFilter('id','in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 2)"));
            $criteria3 = new TCriteria;
            $criteria3->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 3)"));
            $criteria4 = new TCriteria;
            $criteria4->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 4)"));
            $criteria5 = new TCriteria;
            $criteria5->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 5)"));
            $criteria6 = new TCriteria;
            $criteria6->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 6)"));
            $criteria7 = new TCriteria;
            $criteria7->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 7)"));
            $criteria8 = new TCriteria;
            $criteria8->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 8)"));
            $criteria9 = new TCriteria;
            $criteria9->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 9)"));
            $criteria10 = new TCriteria;
            $criteria10->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 10)"));
            $criteria11 = new TCriteria;
            $criteria11->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 11)"));
            $criteria12 = new TCriteria;
            $criteria12->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 12)"));
            $criteria13 = new TCriteria;
            $criteria13->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 13)"));
            $criteria14 = new TCriteria;
            $criteria14->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 14)"));
            $criteria15 = new TCriteria;
            $criteria15->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 15)"));
            $criteria16 = new TCriteria;
            $criteria16->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 16)"));
            $criteria17 = new TCriteria;
            $criteria17->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 17)"));
            $criteria18 = new TCriteria;
            $criteria18->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 18)"));
            $criteria19 = new TCriteria;
            $criteria19->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 19)"));
            $criteria20 = new TCriteria;
            $criteria20->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 20)"));
            $criteria21 = new TCriteria;
            $criteria21->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 21)"));
            $criteria22 = new TCriteria;
            $criteria22->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 22)"));
            $criteria23 = new TCriteria;
            $criteria23->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 23)"));
            $criteria24 = new TCriteria;
            $criteria24->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 24)"));
            $criteria25 = new TCriteria;
            $criteria25->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 25)"));
            $criteria26 = new TCriteria;
            $criteria26->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 26)"));
            $criteria27 = new TCriteria;
            $criteria27->add(new TFilter('id', 'in',"(SELECT id FROM tbl_lojas WHERE tbl_lojas.uf_id = 27)"));

            if (empty($param['order']))
            {
                $param['order'] = 'id';    
            }
            if (empty($param['direction']))
            {
                $param['direction'] = 'asc';
            }
            $criteria1->setProperties($param); // order, offset
            $criteria1->setProperty('limit', $limit);
            $criteria2->setProperties($param); // order, offset
            $criteria2->setProperty('limit', $limit);
            $criteria3->setProperties($param); // order, offset
            $criteria3->setProperty('limir', $limit);
            $criteria4->setProperties($param); // order, offset
            $criteria4->setProperty('limir', $limit);
            $criteria5->setProperties($param); // order, offset
            $criteria5->setProperty('limir', $limit);
            $criteria6->setProperties($param); // order, offset
            $criteria6->setProperty('limir', $limit);
            $criteria7->setProperties($param); // order, offset
            $criteria7->setProperty('limir', $limit);
            $criteria8->setProperties($param); // order, offset
            $criteria8->setProperty('limir', $limit);
            $criteria9->setProperties($param); // order, offset
            $criteria9->setProperty('limir', $limit);
            $criteria10->setProperties($param); // order, offset
            $criteria10->setProperty('limir', $limit);
            $criteria11->setProperties($param); // order, offset
            $criteria11->setProperty('limir', $limit);
            $criteria12->setProperties($param); // order, offset
            $criteria12->setProperty('limir', $limit);
            $criteria13->setProperties($param); // order, offset
            $criteria13->setProperty('limir', $limit);
            $criteria14->setProperties($param); // order, offset
            $criteria14->setProperty('limir', $limit);
            $criteria15->setProperties($param); // order, offset
            $criteria15->setProperty('limir', $limit);
            $criteria16->setProperties($param); // order, offset
            $criteria16->setProperty('limir', $limit);
            $criteria17->setProperties($param); // order, offset
            $criteria17->setProperty('limir', $limit);
            $criteria18->setProperties($param); // order, offset
            $criteria18->setProperty('limir', $limit);
            $criteria19->setProperties($param); // order, offset
            $criteria19->setProperty('limir', $limit);
            $criteria20->setProperties($param); // order, offset
            $criteria20->setProperty('limir', $limit);
            $criteria21->setProperties($param); // order, offset
            $criteria21->setProperty('limir', $limit);
            $criteria22->setProperties($param); // order, offset
            $criteria22->setProperty('limir', $limit);
            $criteria23->setProperties($param); // order, offset
            $criteria23->setProperty('limir', $limit);
            $criteria24->setProperties($param); // order, offset
            $criteria24->setProperty('limir', $limit);
            $criteria25->setProperties($param); // order, offset
            $criteria25->setProperty('limir', $limit);
            $criteria26->setProperties($param); // order, offset
            $criteria26->setProperty('limir', $limit);
            $criteria27->setProperties($param); // order, offset
            $criteria27->setProperty('limir', $limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }
            //Aplica cada filtro do criteria a datagrid
            // load the objects according to criteria
            //------------------datagrid 1----------------------------
            $object1 = $repository->load($criteria1);
            $this->datagrid1->clear();
            if ($object1)
            {
                // iterate the collection of active records
                foreach ($object1 as $object1)
                {
                    // add the object inside the datagrid
                    $this->datagrid1->addItem($object1);
                }
            }
            // reset the criteria for record count
            $criteria1->resetProperties();
            $count= $repository->count($criteria1);
            //------------------datagrid 2----------------------------
            $object2 = $repository->load($criteria2);
            $this->datagrid2->clear();
            if ($object2)
            {
                foreach ($object2 as $object2)
                {
                    $this->datagrid2->addItem($object2);
                }
            }
            $criteria2->resetProperties();
            $count= $repository->count($criteria2);
            //------------------datagrid 3----------------------------
            $object3 = $repository->load($criteria3);
            $this->datagrid3->clear();
            if ($object3)
            {
                foreach($object3 as $object3)
                {
                    $this->datagrid3->addItem($object3);
                }
            }
            //------------------datagrid 4----------------------------
            $object4 = $repository->load($criteria4);
            $this->datagrid4->clear();
            if ($object4)
            {
                foreach($object4 as $object4)
                {
                    $this->datagrid4->addItem($object4);
                }
            }
            //------------------datagrid 5----------------------------
            $object5 = $repository->load($criteria5);
            $this->datagrid5->clear();
            if ($object5)
            {
                foreach($object5 as $object5)
                {
                    $this->datagrid5->addItem($object5);
                }
            }
            //------------------datagrid 6----------------------------
            $object6 = $repository->load($criteria6);
            $this->datagrid6->clear();
            if ($object6)
            {
                foreach($object6 as $object6)
                {
                    $this->datagrid6->addItem($object6);
                }
            }
            //------------------datagrid 7----------------------------
            $object7 = $repository->load($criteria7);
            $this->datagrid7->clear();
            if ($object7)
            {
                foreach($object7 as $object7)
                {
                    $this->datagrid7->addItem($object7);
                }
            }
            //------------------datagrid 8----------------------------
            $object8 = $repository->load($criteria8);
            $this->datagrid8->clear();
            if ($object8)
            {
                foreach($object8 as $object8)
                {
                    $this->datagrid8->addItem($object8);
                }
            }
            //------------------datagrid 9----------------------------
            $object9 = $repository->load($criteria9);
            $this->datagrid9->clear();
            if ($object9)
            {
                foreach($object9 as $object9)
                {
                    $this->datagrid9->addItem($object9);
                }
            }
            //------------------datagrid 10----------------------------
            $object10 = $repository->load($criteria10);
            $this->datagrid10->clear();
            if ($object10)
            {
                foreach($object10 as $object10)
                {
                    $this->datagrid10->addItem($object10);
                }
            }
            //------------------datagrid 11----------------------------
            $object11 = $repository->load($criteria11);
            $this->datagrid11->clear();
            if ($object11)
            {
                foreach($object11 as $object11)
                {
                    $this->datagrid11->addItem($object11);
                }
            }
            //------------------datagrid 12----------------------------
            $object12 = $repository->load($criteria12);
            $this->datagrid12->clear();
            if ($object12)
            {
                foreach($object12 as $object12)
                {
                    $this->datagrid12->addItem($object12);
                }
            }
            //------------------datagrid 13----------------------------
            $object13 = $repository->load($criteria13);
            $this->datagrid13->clear();
            if ($object13)
            {
                foreach($object13 as $object13)
                {
                    $this->datagrid13->addItem($object13);
                }
            }
            //------------------datagrid 14----------------------------
            $object14 = $repository->load($criteria14);
            $this->datagrid14->clear();
            if ($object14)
            {
                foreach($object14 as $object14)
                {
                    $this->datagrid14->addItem($object14);
                }
            }
            //------------------datagrid 15----------------------------
            $object15 = $repository->load($criteria15);
            $this->datagrid15->clear();
            if ($object15)
            {
                foreach($object15 as $object15)
                {
                    $this->datagrid15->addItem($object15);
                }
            }
            //------------------datagrid 16----------------------------
            $object16 = $repository->load($criteria16);
            $this->datagrid16->clear();
            if ($object16)
            {
                foreach($object16 as $object16)
                {
                    $this->datagrid16->addItem($object16);
                }
            }
            //------------------datagrid 17----------------------------
            $object17 = $repository->load($criteria17);
            $this->datagrid17->clear();
            if ($object17)
            {
                foreach($object17 as $object17)
                {
                    $this->datagrid17->addItem($object17);
                }
            }
            //------------------datagrid 18----------------------------
            $object18 = $repository->load($criteria18);
            $this->datagrid18->clear();
            if ($object18)
            {
                foreach($object18 as $object18)
                {
                    $this->datagrid18->addItem($object18);
                }
            }
            //------------------datagrid 19----------------------------
            $object19 = $repository->load($criteria19);
            $this->datagrid19->clear();
            if ($object19)
            {
                foreach($object19 as $object19)
                {
                    $this->datagrid19->addItem($object19);
                }
            }
            //------------------datagrid 20----------------------------
            $object20 = $repository->load($criteria20);
            $this->datagrid20->clear();
            if ($object20)
            {
                foreach($object20 as $object20)
                {
                    $this->datagrid20->addItem($object20);
                }
            }
            //------------------datagrid 21----------------------------
            $object21 = $repository->load($criteria21);
            $this->datagrid21->clear();
            if ($object21)
            {
                foreach($object21 as $object21)
                {
                    $this->datagrid21->addItem($object21);
                }
            }
            //------------------datagrid 22----------------------------
            $object22 = $repository->load($criteria22);
            $this->datagrid22->clear();
            if ($object22)
            {
                foreach($object22 as $object22)
                {
                    $this->datagrid22->addItem($object22);
                }
            }
            //------------------datagrid 23----------------------------
            $object23= $repository->load($criteria23);
            $this->datagrid23->clear();
            if ($object23)
            {
                foreach($object23 as $object23)
                {
                    $this->datagrid23->addItem($object23);
                }
            }
            //------------------datagrid 24----------------------------
            $object24 = $repository->load($criteria24);
            $this->datagrid24->clear();
            if ($object24)
            {
                foreach($object24 as $object24)
                {
                    $this->datagrid24->addItem($object24);
                }
            }
            //------------------datagrid 25----------------------------
            $object25 = $repository->load($criteria25);
            $this->datagrid25->clear();
            if ($object25)
            {
                foreach($object25 as $object25)
                {
                    $this->datagrid25->addItem($object25);
                }
            }
            //------------------datagrid 26----------------------------
            $object26 = $repository->load($criteria26);
            $this->datagrid26->clear();
            if ($object26)
            {
                foreach($object26 as $object26)
                {
                    $this->datagrid26->addItem($object26);
                }
            }
            //------------------datagrid 27----------------------------
            $object27 = $repository->load($criteria27);
            $this->datagrid27->clear();
            if ($object27)
            {
                foreach($object27 as $object27)
                {
                    $this->datagrid27->addItem($object27);
                }
            }




            //$this->pageNavigation->setCount($count); // count of records
            //$this->pageNavigation->setProperties($param); // order, page
            //$this->pageNavigation->setLimit($limit); // limit

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
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) )
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

            $object = new TblFechamento(); // create an empty object //</blockLine>

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            //</beforeStoreAutoCode> //</blockLine>

            $object->store(); // save the object //</blockLine>

            //</afterStoreAutoCode> //</blockLine>

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; //</blockLine>

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            //</messageAutoCode> //</blockLine>
            //<generatedAutoCode>
            new TMessage('info', "Registro salvo", $messageAction);
            //</generatedAutoCode>
            $this->onReload();
            //</endTryAutoCode> //</blockLine>

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> //</blockLine>

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    

}