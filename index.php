<?php
//xhprof_enable();
try {
    define('APPLICATION_PATH', dirname(__FILE__));

    $application = new Yaf\Application( APPLICATION_PATH . "/conf/application.ini");

    $application->run();
} catch(Exception $e) {
    echo json_encode([
        'errno' => -999999,
        'errmsg' => 'error' . $e->getMessage(),
    ]);
}

//$xhprof_data = xhprof_disable();
//$XHPROF_ROOT = dirname(__FILE__) . '/application/library/ThirdParty/xhprof';
//
//include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
//include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";
//$xhprof_runs = new XHProfRuns_Default();
//
//$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");
//header("XhprofID:" . $run_id);
?>
