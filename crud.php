<?php
    define('_H_','127.0.0.1:3306');
    define('_U_','root'); 
    define('_P_',''); 
    define('_D_','cdcol');
    
    echo "<!DOCTYPE html>
            <html>
                <head>
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
    public function select($table, $rows = '*', $where = null, $order = null){
echo "s1 - select Starts<br>";
        //echo 'Table name is: '.$table.', Number of rows:'.$rows.'<br>';
        $q = 'SELECT '.$rows.' FROM '.$table;
        
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
    
    public function insert()        {   }
    public function delete()        {   }
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
$db->select($tableName);
//$db->select($tableName,'*', 'SINGER LIKE \'Gene Vincent\'');
//$R=new Res;
//$res = $R->getResult();
//echo $res;
$db->disconnect();

echo "</html>";