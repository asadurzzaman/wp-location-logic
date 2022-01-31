<?php

/* Check if user has admin capabilities */
if(current_user_can('manage_options')){

    $host =  $this->admin_class->db->getHostData();


    $result = array("status" => 'true', "host" => $host);

}else{
    $result = array("status" => 'false');
}


echo json_encode($result,  JSON_UNESCAPED_UNICODE);