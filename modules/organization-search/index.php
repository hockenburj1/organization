<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#tag" ).autocomplete({
      source: "<?php echo $module_url ?>search-processor.php",
      minLength: 2   
    });
    
  });
  </script>
  
<div id="search-form">
    <form action="search.php" method="post">
        <input class="search-box search-box-main" type="text" placeholder="Organization name..." id="keyword" name="keyword" value="<?php if(isset($_POST['keyword'])) echo $_POST['keyword'] ?>"/>
    <input class="search-box search-box-main" type="text" placeholder="Organization Association" id="tag" name="tag" value="<?php if(isset($_POST['tag'])) echo $_POST['tag'] ?>"/>
    <input class="button" type="submit" />
    </form>
</div>
  
<?php  
if (!empty($_POST)) {
    $query;
    
    $keyword = $_POST['keyword'];
    $tag = $_POST['tag'];
    
    // if no tag provided search against keywords only
    if(empty($tag)) {
        $query = "SELECT * FROM Organization WHERE name LIKE :keyword OR abbreviation LIKE :keyword OR description LIKE :keyword ORDER BY name";
        $params = array('keyword' => "%$keyword%");
    }
    
    // if a tag was provided 
    else {
        $tag_query = "SELECT tid FROM tag WHERE name = :tag";
        $tag_params = array('tag' => "$tag");
        $tag_result = $db->query($tag_query, $tag_params);
        $tag_id;
        
        // if tag wasn't found in selection
        if(empty($tag_result)) {
            $query = "SELECT * FROM Organization WHERE name LIKE :keyword OR abbreviation LIKE :keyword OR description LIKE :keyword ORDER BY name";
            $params = array('keyword' => $keyword);
        }
        
        // tag was found
        else {
            $tag_id = $tag_result[0]['tid'];
            $query ="
                SELECT organization.oid, organization.name, organization.abbreviation, organization.description
                FROM organization
                JOIN tag_membership as tm ON organization.oid = tm.oid
                WHERE tm.tid = :tag_id && (name LIKE :keyword OR abbreviation LIKE :keyword OR description LIKE :keyword)
                ORDER BY name";
            $params = array('tag_id' => $tag_id, 'keyword' => "%$keyword%");
        }
    }
    
    $result = $db->query($query, $params);
    $organizations = array();
    
    foreach ($result as $organization) {
        $organizations[] = new Organization($db, $organization['oid']);
    }
    
    include($module_location . 'views/search.content.php');
    
}

?>
