<?php
class MethodTest
{
    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        /*echo "Calling object method '$name' "
             . implode(', ', $arguments). "\n";*/
         echo $name."<br>";
         echo "<pre>"; var_dump($arguments); echo "<br>";
         echo "<pre>"; var_dump(implode(', ', $arguments)); echo "<br>";
    }

    /**  As of PHP 5.3.0  */
    public static function __callStatic($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        echo "Calling static method '$name' "
             . implode(', ', $arguments). "\n";
    }
}

$obj = new MethodTest;
$obj->runTestfff('in object context');

MethodTest::runTesdfast('in static context');  // As of PHP 5.3.0
?>