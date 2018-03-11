<?php
//seting header to json
//header('Content-Type: aplication/json');
//$command = escapeshellcmd('./test.py');
//database
define("DB_HOST",'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','DUKS1992');
define('DB_NAME','ROBOT');

//get connection
#........................$nodes = explode('second',trim($node));
$node =  shell_exec('python ./visited.py');
$nodes = explode('second',trim($node));

$visited = $nodes[0];
$env = $nodes[1];
#.......................

$conn =new mysqli(DB_HOST,DB_USERNAME, DB_PASSWORD,DB_NAME);

if(!$conn){
	die("Connection failed".$conn->error);
          }
echo "Connected successfully\n";

//check the is there a new data is in the database
$query_data = sprintf("SELECT * FROM Path_planner WHERE isNew = 1");
$result = mysqli_fetch_array($conn->query($query_data));
if($result){
	  // path.............................................
	$data_con = array();
   $path = explode('), (',trim($result[1],'[()]'));
	 $path_coordinate = array();
          foreach($path as $data)
		{
          	$path_coordinate[] = array_map('floatval',explode(',',$data));
	 }
	 $ref = $result[2];

   $query_obstacle = sprintf("SELECT * FROM SLAM WHERE No = $ref");
   $result_data = mysqli_fetch_array($conn->query($query_obstacle));

	 //cylinders..............................................

	 $cylinders = explode('], [',trim($result_data[5],'[[]]'));
	 $cylinder_list = array();
	 foreach($cylinders as $data)
	 {
		$cylinder_list[] = array_map('floatval',explode(',',$data));
	 }
	 //position...............................................
	 $position = array_map('floatval',explode(',',trim($result_data[2],'[]')));
   $goal = $result[3];
	 $xbase = $result[4];
	 $ybase = $result[5];

  //................creating json object...................
	$data_con = array('path_data'=>$path_coordinate,
	                          'obstacle'=>$cylinder_list,
														'visited_nodes'=>$visited,
														'env_nodes'=>$env,
														'position'=>$position,
														'goal'=>$goal,
														'X_base'=>$xbase,
														'y_base'=>$ybase,
											);
	//.......................................................
	if(file_exists('results.json')) unlink('results.json');

     $fp = fopen('results.json', 'w');
	  fwrite($fp, json_encode(array("data"=>$data_con)));
     fclose($fp);
	//.......................................................
	       }
else	{
	printf("No new data from the server.....");
	sleep(0.5);
	}
?>
