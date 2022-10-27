<?
namespace Naumedia\Example;

class CurrentLineParser extends LineParser
{
    public $addr = "";
    public $goods = [];
    private $boolFirstWithHouse = false;

    public function __construct()
    {
    }

    public function getAddr()
    {
      return $this->addr;
    }

    public function getGoods()
    {
      return $this->goods;
    }

    public function parse($line)
    {
      $parts = explode(",", $line);
      $parts = array_map(function($v) {
        return trim($v);
      }, $parts);
      $parts = array_filter($parts);

      $addr = $goods = [];
      if (count($parts) > 2)
      {
        foreach ($parts as $k => $text)
        {
          if ($k == 0)
          {
            if (preg_match("/\d/", $text))
              $this->boolFirstWithHouse = true;
          }

          $boolIsAddr = $this->isAddr($text, $k, $parts);

          if ($boolIsAddr)
            $addr[] = $text;
          else
            $goods[] = $text;

        }

        $tmp = [];
        foreach ($goods as $k => $text)
        {
          $boolIsGood = true;
          if ($k > 0)
          {
            if (preg_match("/\d(|\s)шт/", $text))
            {
              $boolIsGood = false;
            }
          }

          if ($boolIsGood)
          {
            $tmp[] = $text;
          }
          else
          {
            $tmp[count($tmp) - 1] .= ", ".$text;
          }
        }
        $goods = $tmp;
      }
      else
      {
        $addr[] = $parts[0];
        if (count($parts) == 2)
          $goods[] = $parts[1];
      }

      $addr = implode(", ", $addr);

      $this->addr = $addr;
      $this->goods = $goods;
    }
    private function isAddr($text, $k, $parts)
    {
      if ($k == 0)
      {
        $boolIsAddr = true;
      }
      
      if ($k == 1)
      {
        if ($this->boolFirstWithHouse == true)
        {
          if (preg_match("/(^|\s)кв/", $text))
            $boolIsAddr = true;
        }
        else
        {
          if (preg_match("/(\d|деревня|поселок)/", $text))
            $boolIsAddr = true;
        }
      }
      elseif ($k == 2)
      {
        if (preg_match("/(^|\s)кв/", $text))
          $boolIsAddr = true;
      }
      return $boolIsAddr;
    }

    public function getPointsData()
    {
        return $this->pointsData;
    }
}