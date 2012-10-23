<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//New Silex Application
$app = new Silex\Application();

//Setting Session
//You could use the datbase but because all the information is not meant to be kept, basic sessions are fine.
//Register Session
$app->register(new Silex\Provider\SessionServiceProvider());


$app->before(function ($request) {
    $request->getSession()->start();
});

$listOfToDos = array(
    1 => array(
        'name'      => '1 Example Todo title',
        'note'    => 'Example Todo Note 1',
        'id' => 1,
    ),
      2 => array(
        'name'      => '2 Example Todo title',
        'note'    => 'Example Note 2',
        'id' => 2,
    ),
       3 => array(
        'name'      => '3 Example Todo title',
        'note'    => 'Example Note 3 ',
        'id' => 3,
    ),
        4 => array(
        'name'      => '4 Example Todo title',
        'note'    => 'Example Note 4',
        'id' => 4,
    ),
         5 => array(
        'name'      => '5 Example Todo title',
        'note'    => 'Example Note 5',
        'id' => 5,
    ),
           6 => array(
        'name'      => '6 Example Todo title',
        'note'    => 'Example Note 6',
        'id' => 6,
    ),
            0 => array(
        'name'      => '0 Example Todo title',
        'note'    => 'Example Note 6',
        'id' => 0,
    ),
);

//$app['session']->set('listOfToDos', $listOfToDos);

/* Setting up Session
$app->before(function ($request) {
    $request->getSession()->start();
});
*/
//Setting up main page
//Display Form inputs name and note
//Display all Todos
$app->get('/', function(Request $request) use ($app,$listOfToDos) {
    $app['session']->set('user', array('username' => 'Erin'));
    $lastname = $request->get('name');
    return $request;
    $output ="
      <h2>ToDo {$lastname}</h2>
    <span>Welcome {$user['username']}!";
    $output .= ', what do you need Todo?</span>
    <form class="ToDoForm" action="/" method="get">
    	<span>ToDo</span>
    	<input type="text" id="ToDoNameInput" value="" placeholder="name" name="name"class="input required-field">
    	</br>
    	<span>Notes!</span>
    	<input type="text" id="ToDoNoteInput" value="" placeholder="note" name="note" class="input required-field">
    	</br>
    	<button id="submitTodoMain" class="ajax-submit" type="submit" name=""><span>Add it!</span></button>
   	</form>';

   	$output .='<div class="RecentTodosSection">
   		<h2>List of ToDos</h2>';

   	foreach ($listOfToDos as $ToDo) {
   		$output.= '<a class="recentToDo" href="/details/';
   		$output.= $ToDo['id'];
   		$output.='"><span>';
        $output .= $ToDo['name'];
        $output .= '</span></a><br />';
    }

   	$output .="
   	</div>";

    return $output;
});

$app->get('/lastfivetodos', function() use ($listOfToDos) {
   ksort($listOfToDos);
   $printedDos = 0;
    foreach ($listOfToDos as $ToDo) {
      //error_log('entered'.$ToDo['id'].$ToDo['name']);
      $output.= '<a class="recentToDo" href="/details/';
      $output.= $ToDo['id'];
      $output.='"><span>';
        $output .= $ToDo['name'];
        $output .= '</span></a><br />';
        $printedDos++;
        if($printedDos == 5){
          break;
        }
    }
    return $output;
  });

$app->get('/details/{id}', function (Silex\Application $app, $id) use ($listOfToDos) {
    if (!isset($listOfToDos[$id])) {
        $app->abort(404, "ToDo $id does not exist.");
    }
    $ToDo = $listOfToDos[$id];
    $output =  "<h1>To Do: {$ToDo['name']}</h1>".
            "<p>{$ToDo['note']}</p>";
    //display last 5 ToDoUpdates
    $output.="<h2>Most Recent Todos</h2>";
    ksort($listOfToDos);
   $printedDos = 0;
    foreach ($listOfToDos as $ToDo) {
      //error_log('entered'.$ToDo['id'].$ToDo['name']);
      $output.= '<a class="recentToDo" href="/details/';
      $output.= $ToDo['id'];
      $output.='"><span>';
        $output .= $ToDo['name'];
        $output .= '</span></a><br />';
        $printedDos++;
        if($printedDos == 5){
          break;
        }
    }
    return $output;
});


$app->run();
