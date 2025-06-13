<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require './config/connection.php';

$sql = "SELECT * FROM contactnew";
$query = mysqli_query($con, $sql);
$dataset = [];
while($row = mysqli_fetch_assoc($query)){
    $dataset[] = $row;
};

foreach($dataset as $data){
    $newData = array();
    $sql = "SELECT id FROM invoice_user WHERE email = '".$data['logid'] . "'";
    $query = mysqli_query($con, $sql);
    if(mysqli_num_rows($query)){   
        $agent_id = mysqli_fetch_assoc($query)['id'];
    }else{
        $agent_id = 0;
    }

    $newData['agent_id'] = $agent_id;
    $newData['customer_id'] = 0;
    $newData['agent_name_1'] = $data['a'];
    $newData['agent_name_2'] = $data['a'];

    $newData['customer_name_1'] = $data['b'];
    $newData['customer_name_2'] = $data['b'];
    $newData['customer_name_3'] = $data['b'];

    $newData['company_name_1'] = $data['c'];
    $newData['company_name_2'] = $data['c'];

    $newData['contract_date_start'] = $data['d'];
    $newData['contract_date_end'] = $data['e'];

    $sql = "SELECT * FROM contractitem WHERE rand = '".$data['rand'] . "'";
    $query = mysqli_query($con, $sql);
    $items = array();
    if(mysqli_num_rows($query)){   
        while($row = mysqli_fetch_assoc($query)){
            $items[] = $row;
        }
    }

    $newData['services'] = $data['services'];

    if(count($items)){
        foreach($items as $item){
            $newData['services'] .= "
                <br>
                <p>
                    ".$item['g']." ". $item['h']."$ 
                    <br>
                    ".$item['des']."
                </p>
            ";
        }
    }

    $newData['maintenance_period'] = $data['i'];
    $newData['shipping_handling'] = $data['ee'];
    $newData['sale_tax'] = $data['ff'];
    $newData['total_purchase'] = $data['gg'];
    $newData['additional_deposit'] = $data['hh'];
    $newData['payment_date'] = $data['ii'];
    $newData['dues_after_deposit'] = $data['jj'];
    $newData['contract_sign_date_agent'] = $data['mm'];
    $newData['contract_sign_date_customer'] = $data['oo'];
    $newData['agent_sign'] = $data['company_sign'];
    $newData['customer_sign'] = $data['client_sign'];

    $sql = "INSERT INTO contract (agent_id, customer_id, agent_name_1, agent_name_2, customer_name_1, customer_name_2, customer_name_3, company_name_1, company_name_2, contract_date_start, contract_date_end, services, maintenance_period, shipping_handling, sale_tax, total_purchase, additional_deposit, payment_date, dues_after_deposit, contract_sign_date_agent, contract_sign_date_customer, customer_sign, agent_sign) VALUES ('".$newData['agent_id']."','".$newData['customer_id']."','".$newData['agent_name_1']."','".$newData['agent_name_2']."','".$newData['customer_name_1']."','".$newData['customer_name_2']."','".$newData['customer_name_3']."','".$newData['company_name_1']."','".$newData['company_name_2']."','".$newData['contract_date_start']."','".$newData['contract_date_end']."','".$newData['services']."','".$newData['maintenance_period']."','".$newData['shipping_handling']."','".$newData['sale_tax']."','".$newData['total_purchase']."','".$newData['additional_deposit']."','".$newData['payment_date']."','".$newData['dues_after_deposit']."','".$newData['contract_sign_date_agent']."','".$newData['contract_sign_date_customer']."','".$newData['agent_sign']."','".$newData['customer_sign']."')";


    $count = 0;
    $res = mysqli_query($con, $sql);
    $inserts = '';
    if($res){
        $inserted_id = mysqli_insert_id($con);
        $sql = "SELECT * FROM contract_invoices WHERE contract_id=".$data['id'];
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            $contract_invoices = array();
            while($row=mysqli_fetch_assoc($res)){
                // $contract_invoices[] = $row;
                $inserts .= "INSERT INTO contract_invoices (contract_id, invoice_id) VALUES ($inserted_id, ".$row['invoice_id'].")|";
            }
        }


        $count++;
    }
    echo $inserts;

    // $insertsArr = explode('|', $inserts);
    // if(count($insertsArr)){
    //     foreach($insertsArr as $sql){
    //         mysqli_query($con, $sql)
    //     }
    // }

}