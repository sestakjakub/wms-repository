<?php
namespace Wms;
use Nette;

/**
 * Tabulka keyword
 */
class KeywordRepository extends Repository
{
    public function GetKeywordFromName($keyword)
    {
        $row = $this->getTable()->where("keyword",$keyword)->fetch();
        if ($row) 
        {
            return $row;
        }
        return $this->connection->table("keyword")->insert(array("keyword"=>$keyword));
    }
    
}