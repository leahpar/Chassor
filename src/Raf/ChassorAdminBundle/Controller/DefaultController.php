<?php

namespace Raf\ChassorAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SaadTazi\GChartBundle\DataTable;

class DefaultController extends Controller
{
    public function accueilAction()
    {
        return $this->redirect($this->generateUrl('admin_chassor_lister'));
    }
    public function testAction()
    {
 $dataTable = new DataTable\DataTable();

$dataTable->addColumn('id1', 'label 1', 'string');
$dataTable->addColumn('id2', 'label 2', 'number');
//$dataTable->addColumnObject(new DataTable\DataColumn('id2', 'label 2', 'number'));

$dataTable->addRow(array('1', 5));
$dataTable->addRow(array('2', 2));
$dataTable->addRow(array('3', 0));
$dataTable->addRow(array('4', 10));
$dataTable->addRow(array('5', 4));
   
        return $this->render('ChassorAdminBundle:Stats:graph.html.twig',
                array('dataTable' => $dataTable->toArray()
            ));
    }
}
