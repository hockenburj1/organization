<?php
$json = file_get_contents('http://ipinfo.io/json');
$data = json_decode($json);
echo $data->city;

$event = new Event($db, 1);

$month = date("m");
$monthName = date("F");
$year = date("Y");

$firstDate = new DateTime("$year-$month-01 00:01:00");
$firstDay = $firstDate->format('w');
$daysInMonth = $firstDate->format('t');

# Calculate number of rows
$totalCells = $firstDay + $daysInMonth;
if($totalCells < 36){
    $rows = 5;
} 
else {
    $rows = 6;
}
$dayNumber = 1;
?>

<h2>Events</h2>
<hr>
<table width='280'  border='1'>
    <tr>
        <td align='center'><?php echo "$monthName $year" ?></td>
    </tr>
    <tr>
        <td>
            <table width='280'  border='0' cellspacing='2' cellpadding='2'>
                <tr align='center'>
                  <td width='40'>Sun</td>
                  <td width='40'>Mon</td>
                  <td width='40'>Tue</td>
                  <td width='40'>Wed</td>
                  <td width='40'>Thu</td>
                  <td width='40'>Fri</td>
                  <td width='40'>Sat</td>
                </tr>

                <?php for($currentRow=1; $currentRow <= $rows; $currentRow++) : ?>
                    <?php if($currentRow == 1) : ?>
                        <tr align='center'>
                        <?php for($currentCell  = 0; $currentCell < 7; $currentCell++) : ?>
                            <?php if($currentCell == $firstDay) : ?>
                                <td width='40'> <?php echo $dayNumber ?></td>
                                <?php $dayNumber++; ?>
                            <?php else : ?>
                                <?php if($dayNumber > 1) : ?>
                                    <td width='40'><?php echo $dayNumber ?></td>
                                    <?php $dayNumber++; ?>
                                <?php else : ?>
                                    <td width='40'>&nbsp;</td>
                                <?php endif; ?>
                             <?php endif; ?>
                        <?php endfor; ?>
                        </tr>
                    <?php else : ?>
                        <tr align='center'>
                        <?php for($currentCell = 0; $currentCell < 7; $currentCell++) : ?>
                            <?php if($dayNumber > $daysInMonth) : ?>
                                <td width='40'>&nbsp;</td>
                            <?php else : ?>
                                <td width='40'><?php echo $dayNumber ?></td>
                                <?php $dayNumber++; ?>                            
                            <?php endif; ?>
                        <?php endfor; ?>
                        </tr>
                    <?php endif; ?>
                <?php endfor; ?>
            </table>
        </td>
    </tr>
</table>