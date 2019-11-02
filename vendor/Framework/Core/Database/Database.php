<?php
namespace Engine\Core\Database;

use Exception;
use Engine\Core\Database\Connection;


class Database {
    private $dbh, $tables = [], $_t;
    private static $instance=NULL;

    public function __construct(){
        $connect = new Connection();
        $this->dbh = $connect->getLink();
        $this->tables = $this->dbh->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
    }


    public static function instance()
    {
        return self::$instance == NULL ? self::$instance = new self() : self::$instance ;
    }

    public function __get($name)
    {
        if (in_array($name,$this->tables)){
        $this->_t = $name;
        return $this;
        }
        echo (sprintf('Таблица %s не существует', $name));
        exit;
    }

    // private $where = [
    //     [null, "field",'>',10],
    //     ["("],
    //     [")"]
    // ];
    // private $order = ["By","Decs"];
    // private $groupBy = [["vasya","ASC"],"pop"];
    // private $join = [
    //     ["INNER","table","alias","on"]
    // ];
    // private $limit = [10,50];

    private $where = [];
    private $having = [];
    private $order = [];
    private $groupBy = [];
    private $join = [];
    private $limit = [];

    /**
     * Лимит запросов и пропуск записей
     *
     * @param integer $limit - Максимальное количество выборки записей
     * @param integer $offset - Сколько функций пропустить при выборке
     * @return void
     */
    public function limit(int $limit, int $offset = NULL){
        $this->limit = [$limit, $offset];
        return $this;
    }
    private function _join($table, $field, $linkTo= null, $alias = null,$type = "INNER"){

        if ($linkTo === null)$linkTo = "$this->_t`.`id";
        else $linkTo = str_replace('.','`.`', $linkTo);
        $on = (empty($alias)? "`{$table}`" : "`{$alias}`").".`{$field}` = `{$linkTo}`";

        $this->join[] = [$type,$table,$alias];
    }

    public function join($table, $field, $linkTo= null, $alias = null){
        $this->_join($table, $field, $linkTo, $alias ); 
        return $this;
    }
    public function leftJoin($table, $field, $linkTo= null, $alias = null){
        $this->_join($table, $field, $linkTo, $alias, "LEFT" );
        return $this;
    }
    public function rightJoin($table, $field, $linkTo= null, $alias = null){
        $this->_join($table, $field, $linkTo, $alias, "RIGHT" );
        return $this;
    }
    public function groupBy($field) {$this->groupBy[] = str_replace('.','`.`', $field);}
    public function asc($field){
        $this->order[] = [str_replace('.','`.`', $field),"ASC"];
        return $this;
    }
    public function desc($field){
        $this->order[] = [str_replace('.','`.`', $field),"DESC"];
    }
    private function _where($type,$field, $sign, $value){
        if($value===null){
            $value = $sign;
            $sign="=";
        }
        if (!is_integer($value[0]) && $value[0]!=":" && $value[0]!="?" ) $value = $this->dbh->quote($value);
        return  [$type, str_replace('.','`.`', $field), $sign, $value];
    }
    public function where($field, $sign, $value){
        $this->where[]=$this->_where("",$field,$sign,$value);
        return $this;
    }
    public function andWhere($field, $sign, $value){
        $this->where[]=$this->_where("AND", $field, $sign, $value);
        return $this;
    }
    public function orWhere($field, $sign, $value){
        $this->where[]=$this->_where("OR", $field, $sign, $value);
        return $this;
    }

    public function whereGroup(callable $where)
    {
        $this->where[] =["("];
        $where($this);
        $this->where[] = [")"];
        return $this;
    }
    public function andWhereGroup(callable $where)
    {
        $this->where[] = ["AND"];
        $this->where[] =["("];
        $where($this);
        $this->where[] = [")"];
        return $this;
    }
    public function orWhereGroup(callable $where)
    {
        $this->where[] = ["OR"];
        $this->where[] =["("];
        $where($this);
        $this->where[] = [")"];
        return $this;
    }

    public function having($field, $sign, $value){
        $this->having[]=$this->_where("",$field,$sign,$value);
        return $this;
    }
    public function andHaving($field, $sign, $value){
        $this->having[]=$this->_where("AND", $field, $sign, $value);
        return $this;
    }
    public function orHaving($field, $sign, $value){
        $this->having[]=$this->_where("OR", $field, $sign, $value);
        return $this;
    }

    public function havingGroup (callable $having)
    {
        $this->having[] =["("];
        $having($this);
        $this->having[] = [")"];
        return $this;
    }

    private function _select($table, $wheres = [] , $joins = null, $orders = null, $fields ="*", $group_by = null, $havings = null, $limit = null)
    {
    $q = "SELECT {$fields} FROM `{$table}`";

    if (!empty($join)){
        foreach ($joins as $join){
            $q.=" {$join[0]} JOIN `{$join[1]}`";
            if (!empty($join[2])) $q.=" AS `{$join[2]}`";
            $q.= " ON ({$join[3]})";
        }
        
    }
    
    if (!empty($wheres)){
        $q.= " WHERE";
        foreach ($wheres as $where){
            if (!empty($where[0]))  $q.=" {$where[0]} ";

            if(count($where)>1){
                $q.= "( `{$where[1]}` {$where[2]} {$where[3]} )";
            }
        }
    }


    if (!empty($group_by)){
        $q.= " GROUP BY (`".implode('`,`',$group_by)."`)";
    }
    

    if (!empty($havings)){
        $q.= " HAVING";
        foreach ($havings as $where){
            $q.=" {$where[0]}";
            if(count($where)>1){
                $q.= "( `{$where[1]}` {$where[2]} {$where[3]} )";
            }
        }}

    if (!empty($orders)){
        $q.=" ORDER BY";
        $tmp = [];
        foreach($orders as $order){
            $q.=" `{$order[0]}` {$order[1]}";
            $q.= implode(',',$tmp);
        }
    }

    if (!empty($limit)){
        $q.= " LIMIT {$limit[0]}";
        if (!empty($limit[1])) $q.=" OFFSET {$limit[1]}";
    }

    return $q;
    }

    public function get(){
        $query = $this->_select($this->_t,$this->where, $this->join, $this->order, "*", $this->groupBy, $this->having, $this->limit);
        return $this->dbh->query($query)->fetchAll();
    }
}