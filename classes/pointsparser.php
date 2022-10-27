<?
namespace Naumedia\Example;

class PointsParser
{
    public $textData = null;
    public $pointsData = [];

    public function __construct($textData)
    {
        $this->textData = trim($textData);
    }

    public function parse($obLineParser)
    {
        $pointsData = [];
        foreach (explode("\n", $this->textData) as $line)
        {
          $line = trim($line);
          if (!empty($line))
          {
            $obLineParser->parse($line);
            $addr = $obLineParser->getAddr();
            $goods = $obLineParser->getGoods();
            $pointsData[$addr] = $goods;
            // echo "<pre>";
            // print_r($line);
            // echo "</pre>";
          }
        }

        $this->pointsData = $pointsData;

    }

    public function getPointsData()
    {
        return $this->pointsData;
    }
}