<?php
try {
    define('APPLICATION_PATH', dirname(__FILE__));

    $application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

    $application->bootstrap()->run();
} catch(Exception $e) {
    echo json_encode([
        'errno' => -999999,
        'errmsg' => 'error' . $e->getMessage(),
    ]);
}
?>
