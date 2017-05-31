<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
# [START example]
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
		
// create the Silex application
$app = new Application();
$app['pdo'] = function ($app) {
    $pdo = new PDO(
        $app['mysql.dsn'],
        $app['mysql.user'],
        $app['mysql.password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $pdo;
};
$app->get('/', function (Application $app, Request $request) {
    $ip = $request->GetClientIp();
    // Keep only the first two octets of the IP address
    $pdo = $app['pdo'];
    
 $octets = explode($separator = ':', $ip);
    if (count($octets) < 2) {  // Must be ip4 address
        $octets = explode($separator = '.', $ip);
    }
    if (count($octets) < 2) {
        $octets = ['bad', 'ip'];  // IP address will be recorded as bad.ip.
    }
    // Replace empty chunks with zeros.
    $octets = array_map(function ($x) {
        return $x == '' ? '0' : $x;
    }, $octets);
    $user_ip = $octets[0] . $separator . $octets[1];
    // Look up the last 10 visits
	
    $select = $pdo->prepare(
        'SELECT FROM do_product_hdr');
    $select->execute();
   
    $visits = [""];
    $format = strtolower($_GET['format']) == 'json';
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
       
       
		$prod_name= $rows['prod_name'];
		$time= $rows['time'];
		$fromdate1= $rows['fromdate'];
		$todate1= $rows['todate'];
		$points= $rows['points'];
		$fromdate= strtotime($rows['fromdate']);
		$todate= strtotime($rows['todate']);
		
$timeDiff = abs($todate - $fromdate);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
$numberDays = intval($numberDays);
               
		
		 $posts[] = array('prod_name' => $prod_name,'fromdate' =>$fromdate1, 'todate' =>$todate1,'interval'=>$numberDays,'time'=>$time,'points'=>$points);
    }
    if($format == 'json') {
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
  }
  else {
    header('Content-type: text/xml');
    echo '';
    foreach($posts as $index => $post) {
      if(is_array($post)) {
        foreach($post as $key => $value) {
          echo '<',$key,'>';
          if(is_array($value)) {
            foreach($value as $tag => $val) {
              echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            }
          }
          echo '</',$key,'>';
        }
      }
    }
    echo '';
  }
	 return new Response(implode("\n", $visits), 200,
        ['Content-Type' => 'json']);
});
# [END example]
return $app;