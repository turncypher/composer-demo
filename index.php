<?php
/**
 * Created by PhpStorm.
 * User: emmanuel
 * Date: 17-11-22
 * Time: 上午8:53
 */

require_once 'vendor/autoload.php';

// psr4
$psr4Demo = new \Psr4\Demo();
$psr4Demo->test();

// psr0


// classmap
$classMapDemo1 = new \Lib\ClassMapDemo1();
$classMapDemo2 = new ClassMapDemo2();
$classMapDemo3 = new ClassMapDemo3();
$classMapDemo1->test();
$classMapDemo2->test();
$classMapDemo3->test();

// files
test1();
test2();


$dependenceOne = new \DependenceOne\DependenceOne();
$dependenceOne->test();

$dependenceTwo = new \DependenceTwo\DependenceTwo();
$dependenceTwo->test();