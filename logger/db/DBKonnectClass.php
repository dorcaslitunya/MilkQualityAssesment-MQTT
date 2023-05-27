<?php
class db_konnekt_class
{
  public $isConn;

  //To show query error messages set on or to hide then set to off
  //For trouble shooting only
  public $ShowQryErrors = 'on'; //on or off

  //--->Connect to database - Start
  public function __construct($db_conn = array('host' => 'localhost', 'user' => 'root', 'pass' => '', 'database' => 'test',))
  {
    $host = isset($db_conn['host']) ? $db_conn['host'] : 'localhost';
    $user = isset($db_conn['user']) ? $db_conn['user'] : 'root';
    $pass = isset($db_conn['pass']) ? $db_conn['pass'] : '';

    $database = isset($db_conn['database']) ? $db_conn['database'] : die('no database set');

    // Create connection
    $connection = mysqli_connect($host, $user, $pass, $database);

    // Check connection
    if (!$connection) {
      //echo ("conasfasdfas");
      die("Connection failed: " . mysqli_connect_error());
      // return false;
    }
    if ($connection) {
      //echo ("conneted");
      $this->isConn = $connection;
    }
  }
  //--->Connect to database - End


  /*
    Different 5 types of queries
    - Select: all rows
    - Insert: add row(s)
    - Update: update field(s)
    - Delete: delete row(s)
    - Qry: general purpose query
  */

  //--->Select - Start
  function Select($SQLStatement)
  {
    include "db.konnekt.class.insert.php";
    return $result;
  }
  //--->Select - End


  //--->Insert - Start  
  function Insert($TableName, $row_arrays = array())
  {
    include "db.konnekt.class.insert.php";
    return $result;
  }
  //--->Insert - End

  //--->Update - Start
  function Update($strTableName, $array_fields, $array_where)
  {
    include "db.konnekt.class.update.php";
    return $result;
  }
  //--->Update - End

  //--->Delete - Start
  function Delete($strTableName, $array_where)
  {
    include "db.konnekt.class.delete.php";
    return $result;
  }
  //--->Delete - End


  function Qry($SQLStatement)
  {
    include "db.konnekt.class.query.php";
    return $result;
  }


  function Qry_and_return_array($SQLStatement)
  {
    $Qry_and_return_array_resp = array();
    include "db.konnekt.class.Qry_and_return_array.php";
    return $Qry_and_return_array_resp;
  }


  //--- register_user to table ---//
  function generic_insert_data($table_name, $dayta_array = array())
  {
    $generic_insert_resp = array();
    include "queries/generic_insert.php";
    // return $generic_insert_resp = json_encode($generic_insert_resp);
    return $generic_insert_resp;
  }
  //--- //register_user to table ---//



  //--- generic_create_table ---//
  function generic_create_table($table_name, $SQL_File)
  {
    echo BR . "received table name -> " . $table_name;
    echo BR . "query file path -> " . $SQL_File;
    $generic_create_table_resp = array();
    include "queries/generic_create_table.php";
    // return $generic_create_table_resp = json_encode($generic_create_table_resp);
    return $generic_create_table_resp;
  }
  //--- //generic_create_table ---//



  //--- Select user ---//
  function select_user($SQLStatement, $where_clause, $keys)
  {
    $select_user_resp = array();
    // $select_user_resp['user']=array();
    /*
    * This will get all of the rows from the table.  
      Call it like - 
      $db = new SimpleDBClass("host_name", "user_id", "password","database")
      $Qry = $db->Select( "SELECT * FROM Users WHERE site='codewithmark'")  
    */

    include "queries/profile.validate.php";
    //Will return a row data
    // return $select_user_resp = json_encode($select_user_resp);
    return $select_user_resp;
  }
  //--- //Select user---//

  function query_Generic_data($SQLStatement)
  {
    $con =  $this->isConn;

    try {
      $q = $con->query($SQLStatement);
      if ($q->num_rows > 0) {
        $query_GenericData_resp['succ'] = 1;
        $query_GenericData_resp['load'] = array();
        while ($row = $q->fetch_assoc()) {
          $assoc_rows = array($row)[0];
          array_push($query_GenericData_resp['load'], $assoc_rows);
        }
      } else {
        $query_GenericData_resp['succ'] = 1;
        $query_GenericData_resp['load'] = NULL;
      }
    } catch (Exception $excptn) {
      // Failed to connect
      $query_GenericData_resp['succ'] = 0;
      $query_GenericData_resp['code'] = mysqli_connect_errno(); //TODO For testing purposes only
      $query_GenericData_resp['info'] = mysqli_connect_error(); //TODO For testing purposes only
    }

    //close the open connection
    $con->close();
    return $query_GenericData_resp;
  }


  //--->Select in JSON- Start
  function Select_in_JSON($SQLStatement)
  {
    /*
    * This will get all of the rows from the table.  
      Call it like - 
      $db = new SimpleDBClass("host_name", "user_id", "password","database")
      $Qry = $db->Select( "SELECT * FROM Users WHERE site='codewithmark'")  
    */

    // declare array to store respose
    $select_in_JSON_resp = array();
    // run query
    include "db.konnekt.class.select.JSON.php";
    // return a JSON response
    // return json_encode($select_in_JSON_resp);
    return $select_in_JSON_resp;
  }
  //--->Select in JSON- End


  function CleanDBData($Data)
  {
    /*
      This will help in preventing sql injections

      Call it like this:
      $db = new SimpleDBClass("host_name", "user_id", "password","database")
      $Qry = $db->CleanDBData($_POST["user_name"]); 
    */
    // Create connection
    $con =  $this->isConn;
    $str = mysqli_real_escape_string($con, $Data);
    return $str;
  }


  function CleanHTMLData($Data)
  {
    /*
      This will remove all HTML tags
      $db = new SimpleDBClass("host_name", "user_id", "password","database")
      $Qry = $db->CleanHTMLData($_POST["user_entry"]); 
    */

    // Create connection
    $con =  $this->isConn;
    $str = mysqli_real_escape_string($con, $Data);

    $result = preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '', $str);

    return $result;
  }
}
