<?php
define('DIR_PLAY_ROOT', dirname(__FILE__));
require_once dirname(dirname(__FILE__)) .'/TrueApi.php';

error_reporting(E_ALL);
if (!function_exists('pr')) {
    function pr($arr) {
        if (is_array($arr) && count($arr)) {
            print_r($arr);
        } else {
            var_dump($arr);
        }
        echo "\n";
    }
}
if (!function_exists('prd')) {
    function prd($arr) {
        pr($arr);
        die();
    }
}
if (!function_exists('d')) {
    function d() {
        $args = func_get_args();
        if (count($args) == 1) {
            prd($args[0]);
        } else {
            prd($args);
        }
    }
}

class Play {

    public function  __construct() {
        if (false) {
            $this->TrueApi = new TrueApi(array(
                'log-print-level' => 'debug',
                'verifySSL' => false,
                'service' => 'http://admin.true.dev/cakephp/',
            ));
            $this->TrueApi->auth('munin',
                file_get_contents(DIR_PLAY_ROOT.'/pw'),
                file_get_contents(DIR_PLAY_ROOT.'/apikey'),
                'Employee'
            ); // , 'Employee'
        } else {
            
            $this->TrueApi = new TrueApi(array(
                'log-print-level' => 'debug',
                'verifySSL' => false,
                'service' => 'http://cake.truecare.dev/',
            ));
            $this->TrueApi->auth('1823',
                file_get_contents(DIR_PLAY_ROOT.'/pw_cust'),
                file_get_contents(DIR_PLAY_ROOT.'/apikey_cust'),
                'Customer'
            ); // , 'Customer'
        }

    }
    
    public function main() {

        $servers = $this->TrueApi->Servers->index();
        print_r($servers);

        die();

        $this->TrueApi->opt(array(
            'returnData' => false,
            'format' => 'json',
            'buffer' => true,
        ));

        $x = $this->TrueApi->ConfigFiles->view('munin');
        prd($x);

//
//        $x = $this->TrueApi->ApiControllers->index();
//        #prd($x);
//        die()


        die();


        $x = $this->TrueApi->Servers->edit(2862, array('relatie_id' => 1378));
        
        #$w = $this->TrueApi->Servers->index();


        prd(compact('x', 'w'));



        die();

        $this->TrueApi->Servers->apiBuffer(true);
        $w = $this->TrueApi->Servers->add(array('color' => 'gray', 'os_serial' => 'x'));
        $y = $this->TrueApi->Servers->edit(2313, array('color' => 'gray', 'os_serial' => 'x'));
        $z = $this->TrueApi->Servers->apiBuffer('flush');
        pr(compact('w', 'x', 'y', 'z'));


        die();

        $x = $this->TrueApi->PharosNotifications->store(array(
            1 => array(
                'pharos_data_id' => '567101645',
                'relatie_id' => '1378',
                'server_id' => '3736',
                'port' => 'ssh',
                'status' => 'down',
                'sent' => '6',
                'mstamp' => '2009-11-20 13:31:14',
                'stamp' => '2009-11-20 13:31:20',
            ),
            2 => array(
                'pharos_data_id' => '567101645',
                'relatie_id' => '1378',
                'server_id' => '3736',
                'port' => 'ssh',
                'status' => 'down',
                'sent' => '6',
                'mstamp' => '2009-11-20 13:31:14',
                'stamp' => '2009-11-20 13:31:20',
            ),
        ));
        prd($x);

        prd($this->TrueApi->rest('put', 'servers/edit/2313', array('color' => 'black')));

        $feedback = array();
        if (false !== ($response = $this->TrueApi->Servers->edit(2313, array('color' => 'gray', 'os_serial' => 'x')))) {
            $feedback[] = $response;
        }
        if (false !== ($response = $this->TrueApi->Servers->view(2313))) {
            $feedback[] = $response;
        }
    //        if (false !== ($response = $this->TrueApi->Servers->monitored())) {
    //            $feedback[] = $response;
    //        }

        return $feedback;
    }

}

$Play = new Play();
prd($Play->main());
?>