<?php
// Create connection
$con =  $this->isConn;

// Check connection
if (!$con) {
    $select_user_resp['success'] = 0;
    $select_user_resp['code'] = mysqli_errno($con);
    $select_user_resp['info'] = mysqli_error($con);

    // die("Connection failed in query function - " . mysqli_connect_error());
    die(json_encode($select_user_resp));
}

// Connection is made
if ($con) {
    //$SQLStatement = "SELECT * FROM UserProfile WHERE user_id='abc'"; 
    try {
        $result = $con->query($SQLStatement . " " . $where_clause);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($verify = password_verify($keys, $row['password'])) {
                    $select_user_resp['success'] = 1;
                    $select_user_resp['code'] = 1;
                    $select_user_resp['info'] = null;
                    $select_user_resp['name'] = $row['user_name'];
                    $select_user_resp['email'] = $row['user_email'];
                    $select_user_resp['active'] = $row['user_active_state_code'];
                    $select_user_resp['access'] = $row['user_access_state_code'];
                    $select_user_resp['level'] = $row['user_access_rank_code'];
                    $select_user_resp['group'] = $row['grp_handle'];
                    $select_user_resp['role'] = $row['user_institution_role_code'];
                } else {
                    $select_user_resp['success'] = 0;
                    $select_user_resp['code'] = 0;
                    $select_user_resp['info'] = "pass error";
                }
            }
        } else {
            $select_user_resp['success'] = 0;
            $select_user_resp['code'] = 0;
            $select_user_resp['info'] = "no such entry";
        }
    } catch (exception $e) {
        //Fail to run query.
        $select_user_resp['success'] = 0;
        $select_user_resp['code'] = mysqli_errno($con);
        $select_user_resp['info'] = mysqli_error($con);
    }
    $con->close();
}
