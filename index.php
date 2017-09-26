<?php

$a = [1, 3, 2, 5, 4, 4, 6, 3, 2];
echo did_cross_previous_path($a);

function did_cross_previous_path($a){

  $coordinate_base_map=[]; //mapa za bazu u kojoj ce biti smestene koordinate svakog kornjacinog koraka pretrazuje se 
                          //preko md5 serializovanog string koji je  jedinstveni key svake tacke prolaska
  $coordinate_base = [];//baza koordinata svakog predjenog koraka na kornjacinom putu
  $coordinate = ['x' => 0,'y' => 0];//pocetne koordinate
  $course = ['n', 'e', 's', 'w'];//kurs kretanja
 

  foreach($a as $pas => $distance){

    
    $direction = array_shift($course);//trenutni kurs
    array_push($course, $direction);//trenutni kurs ide na kraj niza, pravi se mesto za kurs sledece iteracije

    $current_coordinates = [];//niz u koji smestamo trenutnu poziciju u kojo se kornjaca nasla,key je md5 serializovani string 

      if($direction === 'n'){

      $x = $coordinate['x'];
      $y = $coordinate['y'] + $distance;

        for ($i = 1;$i <= $distance;$i++) {

          $steps = $y-$i;
          $current_coordinates[md5(serialize(['x' => $x, 'y' => $steps]))] = ['x' => $x, 'y' => $steps];

        }

      }


      if($direction === 'e'){

      $x = $coordinate['x'] + $distance;
      $y = $coordinate['y'];


        for ($i = 1;$i <= $distance;$i++) {
          $steps = $x-$i;
          $current_coordinates[md5(serialize(['x' => $steps, 'y' => $y]))] = ['x' => $steps, 'y' => $y];

        }

      }

      if($direction === 's'){

      $x = $coordinate['x'];
      $y = $coordinate['y'] - $distance;

        for ($i = 1;$i <= $distance;$i++) {
          $steps = $y+$i;
          $current_coordinates[md5(serialize(['x' => $x, 'y' => $steps]))] = ['x' => $x, 'y' => $steps];

        }

      }

      if($direction === 'w'){

      $x = $coordinate['x'] - $distance;
      $y = $coordinate['y'];

        for ($i = 1;$i <= $distance;$i++) {
          $steps = $x + $i;
          $current_coordinates[md5(serialize(['x' => $steps, 'y' => $y]))] = ['x' => $steps, 'y' => $y];

        }
      }

   //provera i punjenje niza trenutnim koordinatama
    $coordinate_base[] = (array_reverse($current_coordinates));
    $val=count($coordinate_base)-1;
      foreach ($current_coordinates as $key => $value) {
        if (array_key_exists($key, $coordinate_base_map)) {
          return $pas+1;
        }else{
          $coordinate_base_map[$key] = $val;
        }
      }
   

    //setujemo trenutne  coordinate pred iduci pokret
    $coordinate = ['x' => $x,'y' => $y];

  }

  return 0;

}