<?php
    define('H','127.0.0.1:3306');
    define('U','root'); 
    define('P',''); 
    define('D','cdcol');

/* Object Oriented CRUD Operations */

/* Making sure that we can do our basic MySQL functions */

/* For the connection handler */
class Conn{    
    var $conn; //that var is only used in that class
    var $areWeConnected; //that var is only used in that class
    
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


class Database{
    //$this here refers to this scope ex $this->disconn
    
    public $conHandle=NULL;    

    
    public function connect(){
        //$this here refers to the class Database scope ex: $this->disconnect()
        //We can access other sibling functions using $this->

        $curDbName=new Dbname;
        $curDbName->_setDbName(D);
        echo "Database name is: ".$curDbName->getDbName();
        
        $conHandle = new mysqli(H,U,P,$curDbName->getDbName());  //note the new mysqli vs mysql_connect 
        $curConn=new Conn;
        $curConn->_setConn($conHandle);   //we might need it unsure maybe to close the connection
        
        //$curResult = array();
        //$curDbName=D;
        //$curNumResults=0;

        if($conHandle){
            if ($conHandle->connect_errno) {
                echo '<div id="conn_MessageRed" style="color:red;font-weight:bold;">ERROR 001. We are NOT connected. Connect failed.</div>';
                //trigger_error('Database connection failed: '  . $conHandle->connect_error, E_USER_ERROR);
                $curConn->_setConnState(0);
                die();
            }else{
                echo '<div id="conn_MessageGreen" style="color:green;font-weight:bold;">Success: A proper connection to MySQL was made! Host information: '.mysqli_get_host_info($curConn->getConn()).'</div>';
                //same using directly $conHandle
                //echo '<div id="conn_MessageGreen" style="color:green;font-weight:bold;">Success: A proper connection to MySQL was made! Host information: '.mysqli_get_host_info($conHandle).'</div>';
                $curConn->_setConnState(1);
            }
            echo 'After connection, $curConn->getConnState() is: '.$curConn->getConnState().'<br>';
            
            
            ///blah blah
            
            
            
            if($curConn->getConnState()===1){
                Database::disconnect($curConn,$conHandle);
                echo 'After deconnection, $curConn->getConnState() is: '.$curConn->getConnState().'<br>';
                echo '<div id="deconn_MessageGreen" style="color:green;font-weight:bold;">Now we are correctly deconnected'.$curConn->getConn().'</div>';
            }
        }
    } 
    

    public function disconnect($curConn,$conHandle){       
                if($conHandle->close()){
                    //We reset everything
                    $curConn->_setConnState(0);
                    //$curConn->_setConn(NULL);   /* or $curConn=NULL; */
                    $curConn=NULL;                
                }    
    }
    
/* 
    public function tableExists($table){
        echo "db: ".D."~tableExits starts<br>";
        echo "tableExists starts<br>";
        $tablesInDb = mysqli_query($conn,'SHOW TABLES FROM '.D.' LIKE "'.$table.'"');
        if($tablesInDb){
            if(mysqli_num_rows($tablesInDb)==1){
                return true; 
            }else{ 
                return false; 
            }
        }
    }
    
    
    public function select($table, $rows = '*', $where = null, $order = null){
echo "select Starts<br>";
        //echo 'Table name is: '.$table.', Number of rows:'.$rows.'<br>';
        //$this->tableExists($table);
        $q = 'SELECT '.$rows.' FROM '.$table;
        
        if($where != null){
            $q .= ' WHERE '.$where;
        }
        if($order != null){
            $q .= ' ORDER BY '.$order;
        }
echo $q."<br>";
        if(self::tableExists($table)){  
            $query = mysqli_query(parent::conn,$q);
            if($query){
                $this->numResults = mysqli_num_rows($query);
                for($i = 0; $i < $this->numResults; $i++){
                    $r = mysqli_fetch_array($query);
                    $key = array_keys($r); 
                    for($x = 0; $x < count($key); $x++){
                        // Sanitizes keys so only alphavalues are allowed
                        if(!is_int($key[$x])){
                            if(mysqli_num_rows($query) > 1){
                                $this->result[$i][$key[$x]] = $r[$key[$x]];
                            }else if(mysqli_num_rows($query) < 1){
                                $this->result = null; 
                            }else{
                                $this->result[$key[$x]] = $r[$key[$x]];
                            }
                        }
                    }
                }            
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




*/
}


Database::connect();
    


//$selection = CLA_Database::select('cds','*', $where = null, $order = null);
