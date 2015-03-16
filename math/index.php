<?php
  ////////////////////////////////////////////////////////////////////
  // Generates a math worksheet that can be printed and given to
  // an elementary math student.

  define('PlusSign', '+');
  define('MinusSign', '&minus;');
  define('TimesSign', '&times;');
  define('DivideSign', '&divide;');

  require './Addition.php';
  require './Subtraction.php';
  require './Multiplication.php';
  require './Division.php';

  function RenderHorizontalAssignment($assignment)
  {
    echo '<table height="100%" width="100%">'."\n";

    for($row = 0; $row < 10; $row++)
    {
      echo "<tr>\n";
      for($column = 0; $column < 3; $column++)
      {
        echo "<td align=left>";

        $assignment->RenderNextHorizontalProblem();

        echo "</td>\n";
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
  }

  function RenderVerticalAssignment($assignment)
  {
    echo '<table height="100%" width="100%">'."\n";

    for($row = 0; $row < 5; $row++)
    {
      echo "<tr>\n";
      for($column = 0; $column < 4; $column++)
      {
        echo "<td align=center>";

        $assignment->RenderNextVerticalProblem();

        echo "</td>\n";
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
  }

  function RenderAvailableAssignments($assignment, $key)
  {
    $script_name =  $_SERVER['SCRIPT_NAME'];

    $level = 1;
    while($assignment->SetLevel($level))
    {
      $description = $assignment->GetLevelDescription();
      echo "<a href=\"$script_name?key=$key&level=$level\">$description</a><br>\n";
      $level += 1;
    }
  }

  function Main()
  {
    echo "<html>\n";
    echo "<head>\n";
    echo "<title>My Math Assignment</title>\n";
    echo "<style>\n";
    echo "table { font: 30pt Times; vertical-align : top; }\n";
    echo "td.wo { padding-left: 1; text-align: right; }\n";
    echo "td.fo { padding-right: 1; text-align: left;  }\n";
    echo "td.wm { padding-left: 1; text-align: right; border-bottom:thin solid black; }\n";
    echo "td.fm { padding-right: 1; text-align: left; border-bottom:thin solid black; }\n";
    echo "td.dwo { padding-left: 1; text-align: right; border-left:thin solid black;}\n";
    echo "</style>\n";
    echo "<!-- this is a test -->\n";
    echo "</head>\n";
    echo "<body>\n";

    if (array_key_exists('key', $_GET) && array_key_exists('level', $_GET))
    {
      $key = $_GET['key'];
      $level = $_GET['level'];

      switch($key)
      {
      case 'addition':
        $assignment = new Addition;
        break;
      case 'subtraction':
        $assignment = new Subtraction;
        break;
      case 'multiplication':
        $assignment = new Multiplication;
        break;
      case 'division':
        $assignment = new Division;
        break;
      }

      if ($assignment->SetLevel($level))
      {
        if ($assignment->CanDoHorizontal())
        {
          RenderHorizontalAssignment($assignment);
        }
        else
        {
          RenderVerticalAssignment($assignment);
        }
      }
      else
      {
        echo "Invalid Level\n";
      }
    }
    else
    {
      echo "<h1>Addition Assignments</h1>\n";
      RenderAvailableAssignments(new Addition, "addition");

      echo "<h1>Subtraction Assignments</h1>\n";
      RenderAvailableAssignments(new Subtraction, "subtraction");

      echo "<h1>Multiplication Assignments</h1>\n";
      RenderAvailableAssignments(new Multiplication, "multiplication");

      echo "<h1>Division Assignments</h1>\n";
      RenderAvailableAssignments(new Division, "division");
    }

    echo "</body>\n";
    echo "</html>\n";
  }

  Main();
?>
