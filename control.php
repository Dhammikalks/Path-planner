<?php //logtime.php
if(isset($_POST['X_post']))
{
    $x = $_POST['X_post'];
    $y = $_POST['Y_post'];

    $pos = [$x,$y];
  $result =  shell_exec('python ./goal.py '.escapeshellarg(json_encode($pos)) . ' 2>&1');
   // Do whatever you want with the $uid
echo $results;
}
?>

