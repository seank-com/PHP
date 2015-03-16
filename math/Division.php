<?php

class Division
{
  private $quotients = 0;
  private $divisors = 0;
  private $remainders = 0;
  private $find = 0;
  private $blank = 0;

  private $Repeats = array();

  private $Quotient = "";
  private $Divisor = "";
  private $Dividend = "";

  private function GetNextProblem()
  {
    $happy = FALSE;
    while($happy == FALSE)
    {
      switch($this->quotients)
      {
      case 1:
        $this->Quotient = strval(mt_rand(1, 9));
        break;
      case 2:
        $this->Quotient = strval(mt_rand(10, 99));
        break;
      case 3:
        $this->Quotient = strval(mt_rand(100, 999));
        break;
      }

      switch($this->divisors)
      {
      case 1:
        $this->Divisor = strval(mt_rand(1, 9));
        break;
      case 2:
        $this->Divisor = strval(mt_rand(10, 99));
        break;
      }

      if ($this->remainders == 2)
      {
        $this->Remainder = strval(mt_rand(1, $this->Divisor - 1));
      }
      else
      {
        $this->Remainder = 0;
      }

      $this->Dividend = (($this->Quotient) * ($this->Divisor)) + $this->Remainder;

      $sol = "(" . $this->Quotient . ")(" . $this->Divisor . ")";

      if (array_key_exists($sol, $this->Repeats))
      {
        $happy = FALSE;
      }
      else
      {
        $this->Repeats[$sol] = $sol;
        $happy = TRUE;

        if ($this->find == 2)
        {
          $this->blank = strval(mt_rand(1, 3));
        }
        else
        {
          $this->blank = 3;
        }
      }
    }
  }

  public function SetLevel($level)
  {
    for($this->quotients = 1; $this->quotients <= 3; $this->quotients++)
    {
      for($this->divisors = 1; $this->divisors <= 2; $this->divisors++)
      {
        $findmax = 1;
        If ($this->quotients == 1 && $this->divisors == 1)
        {
          $findmax = 2;
        }

        for($this->find = 1; $this->find <= $findmax; $this->find++)
        {
          $remaindersmax = 2;
          if ($this->quotients == 1 && $this->divisors == 1)
          {
            $remaindersmax = 1;
          }

          for($this->remainders = 1; $this->remainders <= $remaindersmax; $this->remainders++)
          {
            $level -= 1;
            if ($level == 0)
            {
              return TRUE;
            }
          }
        }
      }
    }
    return FALSE;
  }

  public function CanDoHorizontal()
  {
    if ($this->quotients == 1 && $this->divisors == 1)
    {
      return TRUE;
    }
    return FALSE;
  }

  public function GetLevelDescription()
  {
    $result = "Division with $this->quotients digit quotients and $this->divisors digit divisors";
    if ($this->remainders == 2)
    {
      $result = $result . " with remainders";
    }

    if ($this->find == 2)
    {
      $result = $result . " with missing operands";
    }

    return $result;
  }

  public function RenderNextHorizontalProblem()
  {
    $this->GetNextProblem();

    echo "<table><tr><td>";
    switch($this->blank)
    {
    case 1:
      echo "<u>&nbsp;&nbsp;&nbsp;&nbsp;</u> " . DivideSign . " $this->Divisor = $this->Quotient";
      break;
    case 2:
      echo "$this->Dividend " . DivideSign . " <u>&nbsp;&nbsp;&nbsp;&nbsp;</u> = $this->Quotient";
      break;
    case 3:
      echo "$this->Dividend " . DivideSign . " $this->Divisor = <u>&nbsp;&nbsp;&nbsp;&nbsp;</u>";
      break;
    }
    echo "</td></tr></table>";
  }

  public function RenderNextVerticalProblem()
  {
    $this->GetNextProblem();

    echo "<table cellspacing=0>";
    echo "<tr><td class=wo>&nbsp;</td><td class=wm>&nbsp;</td></tr>";
    echo "<tr><td class=wo>$this->Divisor</td><td class=dwo>$this->Dividend</td></tr>";
    echo "</table>";
  }
}
?>
