<?php
    require_once("../Required.php");

    Required::SwiftLogger()->SessionMan()->SwiftJSON()->SwiftCSRF()->Validable()->SwiftDatetime()->ZeroSQL();
   
    $logger = new SwiftLogger(ROOT_DIRECTORY);
   
    $session = new SessionMan(TIMEOUT_VALUE);
    $session->start();
   
    // $sessionExpiredURL = BASE_URL."error_pages/session_expired.php";
    if (!$session->isActive()) {
        $json = JSON::Failure("Please login");
        die($json);
    }
    
    if ($session->isExpired()) {
        $json = JSON::Failure("Please login");
        die($json);
    }
   
    try {
        $has = $session->has("loggedIn");
        if(!$has){
            $json = JSON::Failure("Please login");
            die($json);
        }
    } catch (\SessionManException $th) {
        $json = JSON::Failure("Please login");
        die($json);
    }
   
   
   $json = new SwiftJSON();
   $csrf = new SwiftCSRF();

    $is_valid = $csrf->isCsrfValid("purchase_schedule");
    if(!$is_valid){
        $json_stirng = $json->failed()->message("Security issue found.")->create();
        exit($json_stirng);
    }

    $form = new Validable();
    $clock = new SwiftDatetime(true);

    $db = new ZeroSQL();
    $db->Server(DATABASE_SERVER)->Password(DATABASE_PASSWORD)->Database(DATABASE_NAME)->User(DATABASE_USER_NAME);

    
    $newExpenses = array();
    try{
        $expense_date = $form->label("Date")->httpPost("date")->required()->asDate()->validate();
        $site_id = $form->label("Site Name")->httpPost("site_id")->required()->asInteger(false)->validate();
        if(isset($_POST["head"])){
            $headCount =  count($_POST["head"]);

            for ($i=0; $i < $headCount; $i++) { 
                $newExpense = $db->new("contractor_expenses");
                $newExpense->expense_date = $expense_date;
                $newExpense->site_id = $site_id;

                $newExpense->expense_head_id = $_POST["head"][$i];
                $rate = $_POST["rate"][$i];
                $newExpense->rate = $form->label("Rate")->value($rate)->required()->asFloat(false)->minValue(1)->validate();
                $quantity = $_POST["quantity"][$i];
                $newExpense->quantity = $form->label("Quantity")->value($quantity)->required()->asFloat(false)->minValue(1)->validate();
                $newExpense->total_amount = $_POST["total"][$i];
                $newExpense->create_datetime = new DateTime("now", new DateTimeZone("Asia/Dhaka"));
                $newExpenses[] = $newExpense;
            }
        }
    } catch (Unvalidable $v) {
        die(JSON::Failure($v->getMessage()));
    }
    try{
        //enter data in projects table.
        $db->connect();
        $db->startTransaction();
        foreach ($newExpenses as $new) {
            $newProject = $db->insert($new)->execute();
        }
        $db->stopTransaction();
        $db->close();

        echo '{"issuccess":true, "message":"Successfully Saved."}';
    }
    catch(ZeroException $exp){
        $db->rollBack();
        $db->close();
        $logger->createLog($exp->getMessage());
        $json_string = $json->failed()->message("Problem in saving data. If the problem persists, contact with admin.")->create();
        die($json_string);
    }
?>