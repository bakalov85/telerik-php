<?php
include 'includes/constants.php';

if (!empty($_GET['filterByGroup'])) {
      $filters['filterByGroup'] = (int) $_GET['filterByGroup'];
}
if (!empty($_GET['filterByStartDate'])) {
      $startDate = preg_replace('/[^0-9-]/', '', $_GET['filterByStartDate']);
      $startDateFormatError = false;
      if (strlen($startDate) != 10) {
            $startDateFormatError = true;
      } 
      else {
            $dateExpl = explode('-', $startDate);
            if (count($dateExpl) != 3) {
                  $startDateFormatError = true;
            } 
            elseif (!checkdate((int) $dateExpl[1], (int) $dateExpl[0], (int) $dateExpl[2])) {
                  $startDateFormatError = true;
            }
      }
      if ($startDateFormatError) {
            $messageErrors[] = 16;
            unset($startDate);
      } 
      else {
            $filters['startDate'] = strtotime("$startDate 00:00:00");
      }
}

if (!empty($_GET['filterByEndDate'])) {
      $endDate = preg_replace('/[^0-9-]/', '', $_GET['filterByEndDate']);
      $endDateFormatError = false;
      if (strlen($endDate) != 10) {
            $endDateFormatError = true;
      } 
      else {
            $dateExpl = explode('-', $endDate);
            if (count($dateExpl) != 3) {
                  $endDateFormatError = true;
            } 
            elseif (!checkdate((int) $dateExpl[1], (int) $dateExpl[0], (int) $dateExpl[2])) {
                  $endDateFormatError = true;
            }
      }
      if ($endDateFormatError) {
            $messageErrors[] = 17;
            unset($endDate);
      } 
      else {
            $filters['endDate'] = strtotime("$endDate 00:00:02");
      }
      
      if ($filters['endDate'] < $filters['startDate'] && !$endDateFormatError && !$startDateFormatError) {
            $filters['endDate'] = strtotime("$startDate 00:00:02");
            $filters['startDate'] = strtotime("$endDate 00:00:00");
            $tempVar = $endDate;
            $endDate = $startDate;
            $startDate = $tempVar;
      }
      
}
if ( (int)$_GET['futureExpenceHide'] == 1 ) {
      $filters['endDate'] = time();
      if (isset($filters['startDate'])) {
            unset($filters['startDate']);
      }
      $checked['futureExpenceHide'] = ' checked';
}
if ( (int)$_GET['futureExpenceOnly'] == 1 ) {
      $filters['startDate'] = time();
      if (isset($filters['endDate'])) {
            unset($filters['endDate']);
      }
      $checked['futureExpenceOnly'] = ' checked';
      
}
if ($_GET['futureExpenceOnly'] == 1 && $_GET['futureExpenceHide'] == 1) {
      $messageErrors[] = 18;
      unset($filters['endDate'],$filters['startDate']);
}
$totalTable = '
      <h2>Списък на всички разходи</h2>
      <table class="list">
      <tr>
            <th>№</th>
            <th>Дата</th>
            <th>Наименование</th>
            <th>Вид</th>
            <th>Сума</th>
            <th>Действие</th>
      </tr>';

if (file_exists('data.txt')) {
      $result = file('data.txt');
      $countResult = count($result);
      $biggestCost['val'] = 0;
      
      if ($countResult > 0 ) {
      
          foreach ($result as $key => $value) {
                $columns = explode('|', $value);
                
                if (count($columns) != 5) {
                      continue;
                }
                $datesArr[] = $columns[1];
                
                if ($filters['filterByGroup'] != 0 && $filters['filterByGroup'] != $columns[3]) {
                      continue;
                }
                if (isset($filters['startDate']) && $columns[1] < $filters['startDate']) {
                      continue;
                }
                if (isset($filters['endDate']) && $columns[1] > $filters['endDate']) {
                      continue;
                }
                
                $groupId = (int) $columns[3];
    
                $i++;
                if ($i % 2) {
                      $trClass = 'even';
                } 
                else {
                      $trClass = 'odd';
                }          
                if ( (float)$columns[4] > $biggestCost['val']) {
                      $biggestCost['val'] = $columns[4];
                      $biggestCost['name'] = $columns[2];
                } 
                elseif ($biggestCost['name'] && $columns[4] == $biggestCost['val']) {
                      $biggestCost['name'] .= ', ' . $columns[2];
                }
    
    
    
                $sum += (float)$columns[4];
    
                $sumByGroup[$groupId] += $columns[4];
    
                $niceDate = date('d M Y', $columns[1]);      #m-d-Y
                if (mb_strlen($columns[2]) > 60) {
                      $columns[2] = mb_substr($columns[2], 0, 60). '...';
                }
                
                $totalTable .= '<tr class="' . $trClass . '">
                              <td>' . $i . '</td>
                              <td>' . $niceDate . '</td>
                              <td>' . $columns[2] . '</td>
                              <td><a href="index.php?filterByGroup=' . (int) $columns[3] . '" title="Покажи всички разходи от този вид">' . $groups[$groupId] . '</a></td>
                              <td>' . number_format($columns[4], 2, '.', " ") . '</td>
                              <td class="tac">
                                  <a href="form.php?action=edit&rowNumb=' . $key . '" title="Редакция на записа"><img src="images/edit.png" width="18" height="18" alt="Редакция на записа" /> </a>&nbsp;
                                  <a href="form.php?action=delete&rowNumb=' . $key . '" title="Изтриване на записа" onclick="return confirm(\'Сигурен ли си, че искаш да изтриеш точно ' . $columns[2] . ' ?\')"><img src="images/delete.png" width="18" height="18" alt="Изтриване на записа" /></a>
                              </td>
                           </tr>';
          }
    
    
          if ($sum == 0) {

                  if ($filters['startDate'] || $filters['endDate']) {
                        $addSimpleTips = '<p>Нямаш разходи за избраният период !</p>';
                  } elseif ($filters['filterByGroup']) {
                        $addSimpleTips = '<p>Нямаш разходи за "' . $groups[$filters['filterByGroup']] . '" !</p>';
                        $addSimpleTips .= '<p>Можеш да добавиш разходи за тази група от тук : <a href="form.php?group=' . $filters['filterByGroup'] . '">Добавяне на разходи</a></p>';
                        if (array_key_exists($filters['filterByGroup'], $groupsHints)) {
                              $addSimpleTips .= '<p class="tips">' . $groupsHints[$filters['filterByGroup']] . '</p>';
                        }
                  }
            }
    
          $totalTable .= '<tr>
                        <td colspan="4" class="tar"><strong>Общо :</strong></td>
                        <td class="sum"><strong>' . number_format($sum, 2, '.', ' ') . '</strong></td>
                        <td></td>
                        </tr>
                        </table>
                        ' . $addSimpleTips;
    
          if (is_array($filters)) {
                $totalTable .= '<p><a href="index.php" title="Премахване на всички филтри и показване на всички разходи за всички видове">Премахни всички филтри</a></p>';
          }
    
          if (count($datesArr) > 1) {
                $datesArr = array_unique($datesArr);
                sort($datesArr);
                $countDates = count($datesArr);
                if (!$filters['startDate']) {
                      $filters['startDate'] = $datesArr[0];
                }
                if (!$filters['endDate']) {
                      $filters['endDate'] = $datesArr[$countDates - 1];
                }
                $jsStartDate = $datesArr[0];
                $jsEndDate = $datesArr[$countDates - 1];
          } 
          else {
                $filters['startDate'] = $filters['endDate'] = time();
          }
    
          if (count($sumByGroup) > 1) {
                $tableByGroups = '
                  <h2>Разпределение на разходите по видове</h2>
                  <table class="list">
                  <tr>
                    <th>Вид разход</th>
                    <th>Обща Сума</th>
                    <th>Процент</th>
                  </tr>';
                $i = 0;
                arsort($sumByGroup);
                foreach ($sumByGroup as $key => $value) {
                      $i++;
                      if ($i % 2) {
                            $trClass = 'even';
                      } 
                      else {
                            $trClass = 'odd';
                      }
    
                      $percentFromTotal = ( $value / $sum ) * 100;
                      /* Само за подравняване */
                      if ($percentFromTotal < 10) {
                            $addSpace = '&nbsp;&nbsp;';
                      }
                      else {
                            $addSpace = '';
                      }
                      
                      $tableByGroups .= '<tr class="' . $trClass . '">
                                      <td>' . $groups[$key] . '</td>
                                      <td>' . number_format($value, 2, '.', " ") . '</td>
                                      <td>' . $addSpace . '' . number_format($percentFromTotal, 2, '.', " ") . '%</td>
                                    </tr>';
                }
                $tableByGroups .= '</table>';
          }
          if (isset($biggestCost['name']) && $i > 1) {
                $showBiggestCost = '<p>Най-големият ти разход е за <b>' . $biggestCost['name'] .
                        '</b> на стойност <b>' . number_format($biggestCost['val'], 2, '.', " ") . '</b></p>';
          }
      }
      else {
          $totalTable = '<h2>До момента няма никакви въведени данни !</h2>
                        Можеш да въведеш от тук : <a href="form.php">Добави разход</a>';
      }
}

$pageTitle = 'Списък с направените разходи';

if (array_key_exists($filters['filterByGroup'], $groups)) {
      $addToTitle = ' за "' . $groups[$filters['filterByGroup']] . '"';
} 
elseif (is_null($filters['filterByGroup'])) {
      $addToTitle = ' - ' . $groups[0];
}

if ($filters['startDate']) {
      $addToTitle .= ', От ' . date('d.m.Y', $filters['startDate']);
}
if ($filters['startDate']) {
      $addToTitle .= ' до ' . date('d.m.Y', $filters['endDate']);
}

include 'includes/header.php';
?>
<div class="menu">
      <a href ="index.php" class="current">Списък с всички разходи</a>
      <a href="form.php">Добави разход</a> 
      <a href="javascript:void(0)" id="showHideFilter">Покажи филтрите</a> 
</div>

<?php
include 'includes/messages.php';
?>

<div class="menu" id="filter" style="display:none">
      <form method="GET" action="index.php" class="formFilter">
            <h3>Филтриране :</h3>        
            <table>
                  <tr>
                        <td>Начална дата : </td>
                        <td><input type='text' name='filterByStartDate' value='<?php echo date('d-m-Y', $filters['startDate']); ?>' class="dateInput" id="filterStartDate" /></td>
                  </tr>
                  <tr>
                        <td>Крайна дата : </td>
                        <td><input type='text' name='filterByEndDate' value='<?php echo date('d-m-Y', $filters['endDate']); ?>' class="dateInput" id="filterEndDate"  /></td>
                  </tr>
                  <tr>
                        <td>По видове : </td>
                        <td>
                              <select name="filterByGroup">
                                    <?php echo generateOptionSelect($groups, $filters['filterByGroup']); ?>
                              </select>
                        </td>
                  </tr>
                  <tr>
                        <td colspan="2">
                              <label><input type="checkbox" value="1" name="futureExpenceHide" <?php echo $checked['futureExpenceHide']; ?> />Спри показването на бъдещи разходи</label>
                              <label><input type="checkbox" value="1" name="futureExpenceOnly" <?php echo $checked['futureExpenceOnly']; ?> />Покажи само бъдещите разходи</label>
                         </td>
                  </tr>
            </table>
            <br />
            <input type="submit" value="Филтрирай" />
      </form>
</div>

<div id="container">
<?php
echo '
    <div class="leftPart">' . $totalTable . '</div>
    <div class="rightPart">
      ' . $tableByGroups . '
      ' . $showBiggestCost . '
    </div>
    ';

include 'includes/footer.php';
?>