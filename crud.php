<?php
    define('_H_','127.0.0.1:3306');
    define('_U_','root'); 
    define('_P_',''); 
    define('_D_','cdcol');
       
    echo "<!DOCTYPE html>
            <html>
                <head>
                    <meta charset=\"UTF-8\">        
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\"/>
                    <meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\">
                    <meta content=\"IE=edge,chrome=1\" http-equiv=\"X-UA-Compatible\">
                    <meta content=\"no-cache,no-store,must-revalidate,max-age=-1\" http-equiv=\"Cache-Control\">
                    <meta content=\"no-cache,no-store\" http-equiv=\"Pragma\">
                    <meta content=\"-1\" http-equiv=\"Expires\">
                    <meta content=\"Serge M Frezier\" name=\"author\">
                    <meta content=\"INDEX,FOLLOW\" name=\"robots\">
                    <meta content=\"\" name=\"keywords\">
                    <meta content=\"\" name=\"description\">
                    <!--<meta name=\"mobile-web-app-capable\" content=\"yes\">-->
                    <style>
                        table#taMain {border: 5px solid red;border-collapse: collapse;}
                        table#taMain > thead {color:white; font-weight:bold}
                        table#taMain > thead > tr {background-color:green;}
                        table#taMain > thead > tr > td {padding:4px; width:100px!important; max-width:100px!important; min-width:100px!important}
                        table#taMain > tbody {color:blue;}
                        table#taMain > tbody > tr > td {border: 0.5px solid orange;}
                        table#taMain > tfoot {color:red;}
                    </style>
                </head>
                <body>
                ";

                $_CRUDOP='';
                
                //SELECT
                $_FIELDS='';
                $_WHERE='';
                $_ORDER='';
                
                //INSERT
                $_VALUES='';
                
                //DELETE
                $_WHERE_DEL=NULL;
                
                
                if(isset($_GET["CRUDOP"])){
                    $_CRUDOP=$_GET["CRUDOP"];
                    echo "<div id='curQueryStringA'>CRUD: ".$_CRUDOP."<div>";
                }else{
                    $_CRUDOP='SELECT';
                    echo "<div id='curQueryStringA'>CRUD: ".$_CRUDOP."<div>";                    
                }
                
                //SELECT
                if($_CRUDOP=='SELECT'){
                    if(isset($_GET["FI"])){
                        $_FIELDS=$_GET["FI"];
                        if(($_FIELDS!='')&&($_FIELDS!=NULL)){
                            echo "<div id='curQueryStringB'>FIELDS: ".$_FIELDS."<div>";
                        }else{
                            $_FIELDS='*';
                            echo "<div id='curQueryStringB'>FIELDS: ".$_FIELDS."<div>";                    
                        }
                    }else{
                        $_FIELDS='*';
                        echo "<div id='curQueryStringB'>FIELDS: ".$_FIELDS."<div>";                    
                    }
                    if(isset($_GET["WH"])){
                        $_WHERE=$_GET["WH"];
                        if(($_WHERE!='')&&($_WHERE!=NULL)){
                            echo "<div id='curQueryStringC'>WHERE: ".$_WHERE."<div>";
                        }else{
                            $_WHERE='';
                            echo "<div id='curQueryStringC'>WHERE: ".$_WHERE."<div>";
                        }
                    }else{
                        $_WHERE='';
                        echo "<div id='curQueryStringC'>WHERE: ".$_WHERE."<div>";                    
                    }
                    if(isset($_GET["ORD"])){
                        $_ORDER=$_GET["ORD"];
                        if(($_ORDER!='')&&($_ORDER!=NULL)){
                            echo "<div id='curQueryStringD'>ORDER: ".$_ORDER."<div>";
                        }else{
                            $_ORDER='';
                            echo "<div id='curQueryStringD'>ORDER: ".$_ORDER."<div>";
                        }
                    }else{
                        $_ORDER='';
                        echo "<div id='curQueryStringD'>ORDER: ".$_ORDER."<div>";                    
                    }
                }
                
                //INSERT
                if($_CRUDOP=='INSERT'){
                    if(isset($_GET["VALS"])){
                        $_VALUES=$_GET["VALS"];
                        if(($_VALUES!='')&&($_VALUES!=NULL)){
                            echo "<div id='curQueryStringE'>VALUES: ".$_VALUES."<div>";
                        }else{
                            $_VALUES='';
                            echo "<div id='curQueryStringE'>VALUES: ".$_VALUES."<div>";
                        }
                    }else{
                        $_VALUES='';
                        echo "<div id='curQueryStringE'>VALUES: ".$_VALUES."<div>";                    
                    }
                }
                
                //DELETE
                // Caution if no WHERE we delete the whole table
                if($_CRUDOP=='DELETE'){
                    if(isset($_GET["WHDEL"])){
                        $_WHERE_DEL=$_GET["WHDEL"];
                        if(($_WHERE_DEL!='')&&($_WHERE_DEL!=NULL)){
                            echo "<div id='curQueryStringF'>WHERE DELETE: ".$_WHERE_DEL."<div>";
                        }else{
                            echo '<div id="conn_MessageRedDELETE" style="color:red;font-weight:bold;">VOLONTARY ERROR A. I BLOCK SO THAT WE DO NOT DELTE THE WHOLE TABLE.</div>';
                            die();
                        }
                    }else{
                        echo '<div id="conn_MessageRedDELETE" style="color:red;font-weight:bold;">VOLONTARY ERROR B. I BLOCK SO THAT WE DO NOT DELTE THE WHOLE TABLE.</div>';
                        die();                   
                    }
                }
                
                
                echo "
                    <div id=\"container_upper\">
                        <h2>Object Oriented CRUD operations</h2>
                        <h2>Toward an OO CRUD REST API. Test page 1</h2>
                        <br />
                        Please note that for demo purposes I integrated the PHP classes and the markup code on the same page.
                        <br />
                        It is probably better to separate them.
                        <br />
                        One can choose the CRUD operations and other optional settings by using the QueryString.
                        <br />                        
                        See below:
                        <br /><br />                        
                        SELECT STATEMENT (in fact CRUDOP is always SELECT for the select() function:
                        <br />                        
                        TO SELECT: Add -> ?CRUDOP=SELECT to the QueryString
                        <br />                        
                        TO SELECT ALL ROWS FROM TABLE: Add -> ?CRUDOP=SELECT to the QueryString
                        <br />                        
                        TO SELECT SOME ROWS FROM TABLE: Add -> ?CRUDOP=SELECT&FI=SINGER,YEAR to the QueryString
                        <br />                        
                        TO SELECT ALL ROWS FROM TABLE WHERE: Add -> ?CRUDOP=SELECT&FI=MYCOL&WH=SINGER LIKE \'Gene Vincent\' to the QueryString
                        <br> 
                        OR ?CRUDOP=SELECT&FI=SINGER,YEAR&WH=SINGER%20LIKE%20%27Gene%20Vincent%27                        
                        <br />                        
                        TO ADD AN ORDER BY: Add -> ?CRUDOP=SELECT&FI=MYCOL&WH=SINGER LIKE 'Gene Vincent'&ORD=SINGER DESC
                        <br> 
                        OR ?CRUDOP=SELECT&FI=SINGER,YEAR&WH=SINGER%20LIKE%20%27Gene%20Vincent%27&ORD=SINGER%20DESC
                        <br /><br />
                        TO INSERT Add -> ?CRUDOP=INSERT&VALS=V1~V2~V3~V4 to the QueryString (Auto-increment column should show NULL
                        <br /><br />
                        Caution if no WHERE we delete the whole table
                        <br />
                        TO DELETE Add -> ?CRUDOP=DELETE&WHDEL=ID LIKE 9
                        <br /><br />
                        In other circumstances, the code could use a form, you would submit it and grab the submitted values.
                        <br />
                        That NON-RESPONSIVE page is juste here for demo purposes.
                    </div>
                    <br />
        ";


/* Object Oriented CRUD Operations */

class Dbname{
    var $dbName;    //that var is only used in that class
    public function _setDbName($new_dbName){
        $this->dbname=$new_dbName;
    }
    public function getDbName(){        
        return $this->dbname;    
    }    
}

class NumRes{
    var $numResults;    //that var is only used in that class       
    public function _setNumResults($new_numResults){
        $this->numResults=$new_numResults;
    }        
    public function getNumResults(){
        return $this->numResults;    
    }     
}

class Res{
    var $result;   //that var is only used in that class 
    public function _setResult($new_result){
        $this->result=$new_result;
    }
    public function getResult(){
        return $this->result;    
    }   
}


class Database{
    //$this here refers to this scope ex $this->disconn
    var $curDbName;
    var $curHandle;
    var $curState;
    
    var $new_conn;
    var $connected;
    
    public function _setConn($new_conn){
        $this->conn=$new_conn;
    }
    public function getConn(){
        return $this->conn;    
    }

    public function _setConnState($connected){  /* 1  or 0 */
        $this->areWeConnected=$connected;
    }
    public function getConnState(){   /* 1  or 0 */
        return $this->areWeConnected;    
    }

    public function connect(){
        //$this here refers to the class Database scope ex: $this->disconnect()
        
        $curDbName=new Dbname;
        $curDbName->_setDbName(_D_);
        echo "Database name is: ".$curDbName->getDbName();
        
        $curHandle = new mysqli(_H_,_U_,_P_,$curDbName->getDbName());  //note the new mysqli vs mysql_connect 
        //$curConn=$this->getConn();
        
        if($curHandle){
            if ($curHandle->connect_errno) {
                echo '<div id="conn_MessageRed" style="color:red;font-weight:bold;">ERROR 001. We are NOT connected. Connect failed.</div>';
                //trigger_error('Database connection failed: '  . $curHandle->connect_error, E_USER_ERROR);
                $this->_setConnState(0);
                $curState=0;
                echo 'After CONNECTION ERROR, $curConn->getConnState() is: '.$this->getConnState().'<br>';
                die();
            }else{
                echo '<div id="conn_MessageGreen" style="color:green;font-weight:bold;">Success: A proper connection to MySQL was made! Host information: '.mysqli_get_host_info($curHandle).'</div>';
                $this->_setConnState(1);
                $curState=1;
                $this->_setConn($curHandle);
            }
            echo 'After connection, $this->getConnState() is: '.$this->getConnState().'<br>';
            echo 'After connection, $curState is: '.$curState.'<br>';
        }
    } 
    
    public function disconnect(){
        echo '<pre>'.'1 - function disconnect starts '.'</pre>';
        //$curConnState = 0;
        echo '<pre>'.'2 - Current connState(should be one): '.$this->getConnState().'</pre>';
        $ccc=$this->getConn();
        if(mysqli_close($ccc)){
            //We reset everything
            $this->_setConnState(0);
            $this->_setConn(NULL);
            $curState=0;
            echo '<div id="deconn_MessageGreen" style="color:green;font-weight:bold;">Now we are correctly disconnected</div>';
        } 
        echo 'After we disconnected, $this->getConnState() is: '.$this->getConnState().'<br>';
        echo 'After we disconnected, $curState is: '.$curState.'<br>';
    }
    

    public function tableExists($table){
        echo "s3 - db: "._D_."~tableExits starts<br>";
        $ccc=$this->getConn();  /* using the handle */
        $tablesInDb = mysqli_query($ccc,'SHOW TABLES FROM '._D_.' LIKE "'.$table.'"');
        if($tablesInDb){
            echo "s4 - mysqli_num_rows=: ".mysqli_num_rows($tablesInDb) ."<br>";
            if(mysqli_num_rows($tablesInDb)==1){
                return true; 
            }else{ 
                return false; 
            }
        }
    }
    
    private $result = array();
    public function select($table, $cols = '*', $where = null, $order = null){
echo "s1 - select Starts<br>";
        //echo 'Table name is: '.$table.', Number of rows:'.$cols.'<br>';
        $q = 'SELECT '.$cols.' FROM '.$table;
        
        if($where != null){
            $q .= ' WHERE '.$where;
        }
        if($order != null){
            $q .= ' ORDER BY '.$order;
        }
echo "s2 - ".$q."<br>";
        if(self::tableExists($table)){           /* Note self:: here */
echo "continuing after verifying the table with query q: <br>".$q."<br>";            
            $ccc=$this->getConn();
            $query = mysqli_query($ccc,$q);
            if($query){
                
                //Calling external class
                $curNumRes=new NumRes;
                $curNumRes->_setNumResults(mysqli_num_rows($query));
                $nR=$curNumRes->getNumResults();
                echo "curNumRes->getNumResults(): ".$nR."<br>";
                $curRes=new Res;
                
                //the table
                echo "<table id='taMain'>";
                for($i = 0; $i < $nR; $i++){
                    $r = mysqli_fetch_array($query);
                    $key = array_keys($r);
                    $numKey = count($key);
                    //we just want one header row
                    if($i==0){
                        //the headers
                        echo "<thead><tr>";
                        for($h = 0; $h < $numKey; $h++){
                            echo "<td>".$key[$h]."</td>";  
                        }
                        echo "</tr></thead><tbody>";
                    }
                    for($x = 0; $x < $numKey; $x++){
                        // Sanitizes keys so only alphavalues are allowed
                        if(!is_int($key[$x])){
                            //echo "Column header----------->".$key[$x]."<br>";
                            if(mysqli_num_rows($query) > 1){
                                $this->result[$i][$key[$x]] = $r[$key[$x]];
                                $curRes->_setResult($this->result[$i][$key[$x]]);
                            }else if(mysqli_num_rows($query) < 1){
                                $this->result = NULL;
                                $curRes->_setResult($this->result);
                            }else{
                                $this->result[$key[$x]] = $r[$key[$x]];
                                $curRes->_setResult($this->result[$key[$x]]);
                            }
                            if($x==0){
                                echo "<tr>";
                            }
                                    echo "<td colspan='2'>".$curRes->getResult()."</td>";
                            if($x==$numKey-1){    //7 because we have 8 cells in our rows
                                echo "</tr>";
                            }
                        }
                    }
                }
                echo "</tbody></table>";
                return true; 
            }else{
                return false; 
            }
        }else{
          return false; 
        }

    }    
    
    private $curValsString;
    private $curValsArray = array();
    public function insert($table,$cols = null,$values){
        
        /*ID column, the last one is auto-increment so we leave it alone */
        
        echo "i1 - insert Starts<br>";
        if(self::tableExists($table)){
            $insert = 'INSERT INTO '.$table;
            echo "i2 - ".$insert.'<br />';
            if($cols != null){
                echo "i3 - cols: ".$cols.'<br />';
                $insert .= ' ('.$cols.')';
                echo "i4 - ".$insert.'<br />';
            }else{
                echo '<div id="conn_MessageRedInsert1" style="color:red;font-weight:bold;">ERROR 003. insert function. Columns are not defined.</div>';
                die(); 
            }
            
            if($values==NULL||$values==''){ 
                echo '<div id="conn_MessageRedInsert2" style="color:red;font-weight:bold;">ERROR 004. insert function. Values are not defined.</div>';
                die();                
            }

            echo "i5 - values: ".$values.'<br />';
            $curValsArray=explode('~',$values);
            echo "i6 - count values: ".count($curValsArray).'<br />';
            for($i = 0; $i < count($curValsArray); $i++){
                echo "i7 - curValsArray[i]: ".$curValsArray[$i].'<br />';
                //checking the datatype, here we are looking for 2 strings values
                //and one int(11) for the YEAR field
                if(($i==0)||($i==1)){
                    if(is_string($curValsArray[$i])){
                        $curValsArray[$i] = '\''.$curValsArray[$i].'\'';
                        echo 'insert DT string validation OK<br />';
                    }else{
                        echo '<div id="conn_MessageRedInsertDTverif1" style="color:red;font-weight:bold;">ERROR . insert function. One of the 2 first values is not a string.</div>';
                        die();                  
                    }
                }
                if(($i==2)){
                    if(is_numeric($curValsArray[$i])){
                        $curValsArray[$i] = '\''.$curValsArray[$i].'\'';
                        echo 'insert DT number validation OK<br />';
                    }else{
                        echo '<div id="conn_MessageRedInsertDTverif2" style="color:red;font-weight:bold;">ERROR . insert function. The third value is not a number.</div>';                    
                        die();                        
                    }
                }
            }
            $curValsString = implode(',',$curValsArray);
            $insert .= ' VALUES ('.$curValsString.')';
            echo 'i8 - '.$insert.'<br />';
            $cci=$this->getConn();
            $ins = mysqli_query($cci,$insert);
            if($ins){
                echo '<div id="conn_MessageGreenInsert1" style="color:green;font-weight:bold;">Data correctly inserted</div>';
                return true; 
            }else{
                echo '<div id="conn_MessageRedInsert3" style="color:red;font-weight:bold;">ERROR 005. insert function. FAILURE, NOT INSERTED.</div>';
                die();  
                return false; 
            }
        }
    }    

    public function delete($table,$where = null){   
        /*
         * This function simply deletes either a table or a row from our database. 
         * As such we must pass the table name and an optional $_WHERE_DEL clause. 
         * The $_WHERE_DEL clause will let us know if we need to delete a row(STRING) or the whole table(NULL). 
         * If the where clause is not NULL, that means that entries that match will be deleted. 
         */
        
        if(self::tableExists($table)){
            if($where == null){
                $delete = 'DELETE '.$table;
                //voluntary error as we do not want to delete our table
                echo '<div id="conn_MessageRedDELETEdel" style="color:red;font-weight:bold;">VOLONTARY ERROR. I BLOCK SO THAT WE DO NOT DELTE THE WHOLE TABLE.</div>';
                die();
            }else{
                $delete = 'DELETE FROM '.$table.' WHERE '.$where; 
            }
            $ccd=$this->getConn();
            $del = mysqli_query($ccd,$delete);
 
            if($del){
                echo '<div id="conn_MessageGreenDel" style="color:green;font-weight:bold;">1 row correctly deleted</div>';
                return true; 
            }else{
               echo '<div id="conn_MessageRedDelete1" style="color:red;font-weight:bold;">ERROR 006. delete function. FAILURE, ROW NOT DELETED</div>';
               die();  
               return false; 
            }
        }else{
            echo '<div id="conn_MessageRedDelete2" style="color:red;font-weight:bold;">ERROR 007. delete function. FAILURE, NON-EXISTING TABLE</div>';
            die();
            return false; 
        }
    }
        
    
    
    public function update()    {   }


    //public function get_connection(){
        //return connect();
    //}





}    /* End Class Database */


//Database::connect();  //works OK

//include('crud.php');
$db = new Database();
$db->connect();
$tableName='cds';
echo '<br />>>>'.$_CRUDOP.'<<<<br />';
if($_CRUDOP=='SELECT'){
    $db->select($tableName,$_FIELDS,$_WHERE,$_ORDER);
}elseif($_CRUDOP=='INSERT'){
    $_FIELDS="`TITLE`,`SINGER`,`YEAR`,`ID`";    /*Note the backticks ` */
    $db->insert($tableName,$_FIELDS,$_VALUES);
}elseif($_CRUDOP=='DELETE'){
    $db->delete($tableName,$_WHERE_DEL);
    // To delete a whole table: $db->delete($tableName,NULL); I blocked it just in case in the code above
}elseif($_CRUDOP=='UPDATE'){
    
}else{
    echo '<div id="conn_MessageRedCRUDOP" style="color:red;font-weight:bold;">ERROR 002. CRUDOP not recognized.</div>';
    die();
}

//$R=new Res;
//$res = $R->getResult();
//echo $res;
$db->disconnect();

echo "</body></html>";