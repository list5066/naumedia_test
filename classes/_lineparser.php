<?
namespace Naumedia\Example;

abstract class LineParser {
    abstract public function getAddr();
    abstract public function getGoods();
    abstract public function parse($line);

}