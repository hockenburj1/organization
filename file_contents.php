<?php
$start = microtime();

$json = json_decode(file_get_contents('http://www.usa.gov/api/USAGovAPI/contacts.json/contacts'));
?>

<?php foreach($json->Contact as $row) : ?>
<?php $url = $row->Web_Url;?>

<a href="<?php echo $url[0]->Url ?>" class='title'><?php echo $row->Name ?></a> - <?php if(isset($row->Phone[0])) {echo $row->Phone[0];} ?><br />
<?php endforeach; 

?>

