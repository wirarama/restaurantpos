<?
$header1 =& $workbook->addformat(array(
                                        'size' => 12,
                                        'bold' => 1,
										'align' => 'center',
                                        'top' => 1,
                                        'left' => 1,
                                        'right' => 1,
										'font'    => 'Times',
                                        ));
										
$header2 =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 1,
                                        'align' => 'center',
										'font'    => 'Times',
										'bottom' => 1,
                                        'top' => 1,
                                        'left' => 1,
                                        'right' => 1,
                                        ));
$headerku =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 1,
                                        'align' => 'center',
										'font'    => 'Times',
										'bottom' => 0,
                                        'top' => 1,
                                        'left' => 1,
                                        'right' => 1,
                                        ));

$header3 =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 0,
                                        'align' => 'center',
										'font'    => 'Times',
                                        'bottom' => 1,
                                        'left' => 1,
                                        'right' => 1,
                                        ));
										
$header4 =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 1,
                                        'align' => 'center',
										'font'    => 'Times',
                                        'left' => 1,
                                        'right' => 1,
                                        ));
										
$headerDt =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 0,
                                        'align' => 'left',
										'font'    => 'Times',
										'bottom' => 1,
                                        'left' => 1,
                                        'right' => 1
                                        ));
$headerDt2 =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 0,
                                        'align' => 'right',
										'font'    => 'Times',
										'bottom' => 1,
                                        'left' => 1,
                                        'right' => 1
                                        ));
$headerDt3 =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 0,
                                        'align' => 'right',
										'font'    => 'Times',
										'bottom' => 1,
                                        'left' => 1,
                                        'right' => 0
                                        ));
$headerDt4 =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 0,
                                        'align' => 'right',
										'font'    => 'Times',
										'bottom' => 1,
                                        'left' => 0,
                                        'right' => 1
                                        ));
$headerDt5 =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 0,
                                        'align' => 'right',
										'font'    => 'Times',
										'bottom' => 1,
                                        'left' => 0,
                                        'right' => 0
                                        ));
										
$headerDtc =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 0,
                                        'align' => 'center',
										'font'    => 'Times',
                                        'left' => 1,
                                        'right' => 1
                                        ));
										
$headerEnd =& $workbook->addformat(array(  'size' => 12,
                                        'bold' => 0,
                                        'align' => 'left',
										'font'    => 'Times',
                                        'left' => 1,
                                        'right' => 1,
										'bottom' => 1
                                        ));
										
$merg_cel  =& $workbook->addformat(array(
                                        'size' => 10,
                                        'bold' => 0,
                                        'align' => 'left',
                                        'top' => 1,
                                        'left' => 1,
                                        'right' => 1,
										'bottom' => 1,
                                        'merge'  => 1
                                        ));
										
$merg_cel2  =& $workbook->addformat(array(
                                        'size' => 10,
                                        'bold' => 1,
                                        'align' => 'right',
                                        'top' => 1,
                                        'left' => 1,
                                        'right' => 1,
										'bottom' => 1,
                                        'merge'  => 1
                                        ));
										
$merg_cel_titel  =& $workbook->addformat(array(
                                        'size' => 12,
										'font'    => 'Times',
                                        'bold' => 1,
                                        'align' => 'center',
                                        'merge'  => 1
                                        ));

$ttd  =& $workbook->addformat(array(
                                        'size' => 12,
										'font'    => 'Times',
                                        'bold' => 0,
                                        'align' => 'center',
                                        'merge'  => 1
                                        ));
?>