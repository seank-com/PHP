<?php

class Multiplication
{
  private $digits1 = 0;
  private $digits2 = 0;
  private $fractionaldigits = 0;
  private $find = 0;
  private $blank = 0;

  private $Repeats = array();

  private $WP1 = "";
  private $WP2 = "";
  private $FP1 = "";
  private $FP2 = "";
  private $WPS = "";

  private function GetNextProblem()
  {
    $happy = FALSE;
    while($happy == FALSE)
    {
      switch($this->digits1)
      {
      case 1:
        $o1 = strval(mt_rand(1, 9));
        break;
      case 2:
        $o1 = strval(mt_rand(10, 99));
        break;
      case 3:
        $o1 = strval(mt_rand(100, 999));
        break;
      case 4:
        $o1 = strval(mt_rand(1000, 9999));
        break;
      case 5:
        $o1 = strval(mt_rand(10000, 99999));
        break;
      }
      switch($this->digits2)
      {
      case 1:
        $o2 = strval(mt_rand(1, 9));
        break;
      case 2:
        $o2 = strval(mt_rand(10, 99));
        break;
      case 3:
        $o2 = strval(mt_rand(100, 999));
        break;
      case 4:
        $o2 = strval(mt_rand(1000, 9999));
        break;
      case 5:
        $o2 = strval(mt_rand(10000, 99999));
        break;
      }

      $sol = "(" . $o1 . ")(" . $o2 . ")";

      if (array_key_exists($sol, $this->Repeats))
      {
        $happy = FALSE;
      }
      else
      {
        $this->Repeats[$sol] = $sol;
        $happy = TRUE;

        $this->WP1 = $o1;
        $this->WP2 = $o2;

        if ($this->find == 2)
        {
          $this->blank = mt_rand(1, 3);
          $this->WPS = $this->WP1 * $this->WP2;
        }
        else
        {
          $this->blank = 3;
          $this->WPS = " ";
        }

        $this->FP1 = "&nbsp;";
        $this->FP2 = "&nbsp;";

        if ($this->fractionaldigits > 0)
        {
          for($i = 0; $i < $this->fractionaldigits; $i++)
          {
            $o1 /= 10;
            $o2 /= 10;
          }

          list($this->WP1, $this->FP1) = explode('.', $o1);
          list($this->WP2, $this->FP2) = explode('.', $o2);

          while(strlen($this->FP1) < $this->fractionaldigits)
          {
            $this->FP1 = $this->FP1 . '0';
          }

          while(strlen($this->FP2) < $this->fractionaldigits)
          {
            $this->FP2 = $this->FP2 . '0';
          }

          $this->FP1 = '.' . $this->FP1;
          $this->FP2 = '.' . $this->FP2;
        }
      }
    }
  }

  public function SetLevel($level)
  {
      for($this->fractionaldigits = 0; $this->fractionaldigits <= 4; $this->fractionaldigits++)
      {
          if ($this->fractionaldigits == 0)
          {
              $digitsmin = 1;
              $digitsmax = 4;
          }
          elseif ($this->fractionaldigits == 2)
          {
              $digitsmin = 3;
              $digitsmax = 5;
          }
          else
          {
              $digitsmin = $this->fractionaldigits + 1;
              $digitsmax = $this->fractionaldigits + 1;
          }

          for($this->digits1 = $digitsmin; $this->digits1 <= $digitsmax; $this->digits1++)
          {
              for($this->digits2 = $this->fractionaldigits + 1; $this->digits2 <= $this->digits1; $this->digits2++)
              {
                  $findmax = 1;
                  if ($this->digits1 == 1)
                  {
                      $findmax = 2;
                  }

                  for($this->find = 1; $this->find <= $findmax; $this->find++)
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
      if ($this->digits1 == 1)
      {
          return TRUE;
      }
      return FALSE;
  }

  public function GetLevelDescription()
  {
      $result = "Multiplication of $this->digits1 digit numbers with $this->digits2 digit numbers";
      if ($this->fractionaldigits > 0)
      {
          $result = $result . " ($this->fractionaldigits behind the decimal)";
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
          echo "<u>&nbsp;&nbsp;&nbsp;&nbsp;</u> " . TimesSign . " $this->WP2 = $this->WPS";
          break;
      case 2:
          echo "$this->WP1 " . TimesSign . " <u>&nbsp;&nbsp;&nbsp;&nbsp;</u> = $this->WPS";
          break;
      case 3:
          echo "$this->WP1 " . TimesSign . " $this->WP2 = <u>&nbsp;&nbsp;&nbsp;&nbsp;</u>";
          break;
      }
      echo "</td></tr></table>";
  }

  public function RenderNextVerticalProblem()
  {
      $this->GetNextProblem();

      echo "<table cellspacing=0>";
      echo "<tr><td class=wo>$this->WP1</to><td class=fo>$this->FP1</td></tr>";
      echo "<tr><td class=wm>" . TimesSign . " $this->WP2</td><td class=fm>$this->FP2</td></tr>";
      echo "<tr><td class=wo>&nbsp;</td><td class=fo>&nbsp;</td></tr>";
      echo "</table>";
  }
}
?>
