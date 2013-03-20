<?php

/*
 * @author     Arietis Software <code@arietis-software.com>
 * @copyright  Copyright (c) 2011 Arietis Software Innovations
 * @license    http://www.arietis-software.com/license/gnu/license.txt    GNU License Version 3
 */

class Pagination
{

    private $modx;
    public $count;
    public $start;
    public $limit;
    public $prevPgHref = '#';
    public $nextPgHref = '#';
    public $pages = array();

    public function __construct($modx, $count = 0, $start = 0, $limit = 0)
    {
        $this->modx = &$modx;
        $this->count = $count;
        $this->start = $start;
        $this->limit = $limit;    
        
        for ($i=1;$i<=$count;$i++) {
            $start = ($i*$this->limit) + 1;
            $params = "&start=$start&limit=$this->limit";            
            $tmpArr = array(
                'href' => $this->modx->makeUrl($this->modx->resourceIdentifier, '', $params),
                'num' => $i,
            );
            array_push($this->pages, $tmpArr);
        }
    }

    public function getCurrPageNum()
    {
        return floor($this->start/$this->limit) + 1;
    }    

    public function getNumPages()
    {                       
        return ceil($this->count/$this->limit);
    }
    
    public function getPages()
    {
        return $this->pages;
    }

    public function getPrevPgHref()
    {
        //update the vars
        $this->start = $this->start - $this->limit;
        if ($this->start < 0) {
            $this->start = 0;
        }
        
        $params = "&start=$this->start&limit=$this->limit";
        return $this->modx->makeUrl($this->modx->resourceIdentifier, '', $params);
    }

    public function getNextPgHref()
    {
        //update the vars
        $this->start = $this->start + $this->limit;        
        if ($this->start > $this->getNumPages()) {
            $this->start = $this->getNumPages();
        }
        
        $params = "&start=$this->start&limit=$this->limit";
        return $this->modx->makeUrl($this->modx->resourceIdentifier, '', $params);
    }

}

?>
