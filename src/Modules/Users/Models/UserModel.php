<?php

namespace Se7entech\Contractnew\Modules\Users\Models;
use Se7entech\Contractnew\Helpers\EscapeString;

class UserModel{
    private static $table = 'invoice_user';

    public static function postUser($data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);

        $sql = "INSERT INTO " . self::$table ." (first_name, last_name, email, password, mobile, address, designation, role, zone_id, smtp_user, smtp_pass, avatar, status) VALUES ('".$data['firstname']."','".$data['lastname']."', '" . $data['email'] . "', '" . $data['password'] . "', '" . $data['phone'] . "', '" . $data['address'] . "', '" . $data['designation'] . "', '" . $data['role'] . "', '" . $data['zone_id'] . "', '" . $data['smtp_user'] . "', '" . $data['smtp_pass'] . "', '" . $data['avatar'] . "', '" . $data['status'] . "')";
        
        return(mysqli_query($con, $sql));
    }

    public static function getAll(){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table;

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            while($row = mysqli_fetch_assoc($res)){
                array_push($response, $row);
            }
        }
        
        return $response;
    }

    public static function getById($id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT * FROM " . self::$table . " WHERE id=$id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            return mysqli_fetch_assoc($res);
        }
        
        return false;
    }

    public static function getByEmail($email){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT email, first_name, last_name FROM " . self::$table . " WHERE email='$email'";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            return mysqli_fetch_assoc($res);
        }
        
        return false;
    }

    public static function update($id, $data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);
        
        $sql = "UPDATE " . self::$table . " SET first_name='" . $data['firstname'] . "', last_name='" . $data['lastname'] . "',  mobile='" . $data['phone'] . "', address='" . $data['address'] . "', designation='" . $data['designation'] . "', role='" . $data['role'] . "', zone_id='" . $data['zone_id'] . "', status='" . $data['status'] . "', smtp_user='" . $data['smtp_user'] . "', smtp_pass='" . $data['smtp_pass'] . "', avatar='" . $data['avatar'] . "' WHERE id=$id";
        return(mysqli_query($con, $sql));
    }

    public static function delete($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "DELETE FROM " . self::$table . " WHERE id=$id";
        $res = mysqli_query($con, $sql);
        return $res;
    }

    public static function updateTax($id, $data){
        include __DIR__ . '/../../../../config/connection.php';
        $data = EscapeString::escapeArray($con, $data);

        $sqlSearch = "SELECT * FROM taxes WHERE user_id = '" . $id . "'";
        $res1 = mysqli_query($con, $sqlSearch);

        if(mysqli_num_rows($res1)){
            $sqlUpdate = "
                UPDATE taxes SET 
                payer_info='".$data['payer_info']."', 
                payer_tin='".$data['payer_tin'] . "', 
                recipient_tin='".$data['recipient_tin'] . "', 
                recipient_name='".$data['recipient_name'] . "', 
                street_address='".$data['street_address'] . "', 
                city_town='".$data['city_town'] . "', 
                account_number='".$data['account_number'] . "', 
                2nd_tin_not='".$data['2nd_tin_not'] . "', 
                1_rents='".$data['1_rents'] . "', 
                2_royalties='".$data['2_royalties'] . "', 
                3_other_income='".$data['3_other_income'] . "', 
                4_federal_income='".$data['4_federal_income'] . "', 
                5_fishing_boat='".$data['5_fishing_boat'] . "',
                6_medical_health='".$data['6_medical_health'] . "', 
                7_payer_direct='".$data['7_payer_direct'] . "', 
                8_substitute_payments='".$data['8_substitute_payments'] . "', 
                9_crop_insurance='".$data['9_crop_insurance'] . "', 
                10_gross_proceeds='".$data['10_gross_proceeds'] . "', 
                11_fish_purchased='".$data['11_fish_purchased'] . "', 
                12_section_409a='".$data['12_section_409a'] . "', 
                13_fatca_filing='".$data['13_fatca_filing'] . "', 
                14_excess_golden='".$data['14_excess_golden'] . "', 
                15_nonqualified_deferred='".$data['15_nonqualified_deferred'] . "', 
                16_state_tax='".$data['16_state_tax'] . "', 
                16_state_tax_2='".$data['16_state_tax_2'] . "', 
                17_state_payers_state='".$data['17_state_payers_state'] . "', 
                17_state_payers_state_2='".$data['17_state_payers_state_2'] . "', 
                18_state_income='".$data['18_state_income'] . "', 
                18_state_income_2='".$data['18_state_income_2'] . "' 
                WHERE user_id='" . $id . "'";

            $res2 = mysqli_query($con, $sqlUpdate);
            if($res2){
                return $data;
            }else{
                return false;
            }
            
        }else{
            $sqlInsert = "INSERT INTO taxes (user_id, payer_info, payer_tin, recipient_tin, recipient_name, street_address, city_town, account_number, 2nd_tin_not, 1_rents, 2_royalties, 3_other_income, 4_federal_income, 5_fishing_boat, 6_medical_health, 7_payer_direct, 8_substitute_payments, 9_crop_insurance, 10_gross_proceeds, 11_fish_purchased, 12_section_409a, 13_fatca_filing, 14_excess_golden, 15_nonqualified_deferred, 16_state_tax, 16_state_tax_2, 17_state_payers_state, 17_state_payers_state_2, 18_state_income, 18_state_income_2) 
            VALUES ('"
            . $data['user_id'] . "', '"
            . $data['payer_info']."', '" 
            . $data['payer_tin'] . "', '" 
            . $data['recipient_tin'] . "', '" 
            . $data['recipient_name'] . "', '" 
            . $data['street_address'] . "', '" 
            . $data['city_town'] . "', '" 
            . $data['account_number'] . "', '" 
            . $data['2nd_tin_not'] . "', '" 
            . $data['1_rents'] . "', '" 
            . $data['2_royalties'] . "', '" 
            . $data['3_other_income'] . "', '" 
            . $data['4_federal_income'] . "', '" 
            . $data['5_fishing_boat'] . "', '" 
            . $data['6_medical_health'] . "', '" 
            . $data['7_payer_direct'] . "', '" 
            . $data['8_substitute_payments'] . "', '" 
            . $data['9_crop_insurance'] . "', '" 
            . $data['10_gross_proceeds'] . "', '" 
            . $data['11_fish_purchased'] . "', '" 
            . $data['12_section_409a'] . "', '" 
            . $data['13_fatca_filing'] . "', '" 
            . $data['14_excess_golden'] . "', '" 
            . $data['15_nonqualified_deferred'] . "', '" 
            . $data['16_state_tax'] . "', '" 
            . $data['16_state_tax_2'] . "', '" 
            . $data['17_state_payers_state'] . "', '" 
            . $data['17_state_payers_state_2'] . "', '" 
            . $data['18_state_income'] . "', '" 
            . $data['18_state_income_2'] . "')";

            $res2 = mysqli_query($con, $sqlInsert);
            if($res2){
                return $data;
            }else{
                return false;
            }
        }

    }

    public static function getByIdWithTaxes($id){
        include __DIR__ . '/../../../../config/connection.php';
        $response = array();
        $sql = "SELECT " . self::$table.".id as __user_id, " . self::$table.".*, taxes.id as taxes_id, taxes.* FROM " . self::$table . " LEFT JOIN taxes ON (taxes.user_id = " . self::$table . ".id) WHERE " . self::$table . ".id=$id";

        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res)){
            // $return =  mysqli_fetch_assoc($res);
           
            return mysqli_fetch_assoc($res);
        }
        
        return false;
    }

    public static function updateContract($id, $data){
        include __DIR__ . '/../../../../config/connection.php';
        
        $user = self::getById($id);
        $response = array('success' => false, 'data' => $data);
        if($user){
            if($user['signature'] != null){
                $response['success'] = true;
                $response['data'] = array(
                    'signature' => $user['signature'],
                    'sign_ip' => $user['sign_ip'],
                    'sign_user_agent' => $user['sign_user_agent'],
                    'sign_date' => $user['sign_date'],
                    'user_name' => $user['first_name'] . ' ' . $user['last_name'],
                    'contract_duration' => $user['contract_duration']
                );
            }else{
                $sql = "UPDATE " . self::$table . " SET user_fully_registered='1', signature='" . $data['signature'] . "', sign_ip='" . $data['sign_ip'] . "', sign_user_agent='" . $data['sign_user_agent'] . "', sign_date='" . $data['sign_date'] . "', contract_duration='". $data['contract_duration'] . "' WHERE id='" . $id . "'";

                $res = mysqli_query($con, $sql);
                $response['success'] = $res;
            }
        }

        return $response;  
        
    }

    public static function getOldestContract($id){
        include __DIR__ . '/../../../../config/connection.php';

        $sql = "select contract_date_start as sign_date from contract where agent_id = '" . $id . "' and contract_date_start <> '0000-00-00' order by contract_date_start asc limit 1";
        $res = mysqli_query($con, $sql);
        if($res){
            return mysqli_fetch_assoc($res);
        }else{
            return false;
        }
    }
}