<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
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
    <form action="search.php" method="get">
        <input class="search-box search-box-main" type="text" placeholder="Organization name..." id="keyword" name="keyword" value="<?php if(isset($_POST['keyword'])) echo $_POST['keyword'] ?>"/>
    <input class="search-box search-box-main" type="text" placeholder="Organization Association" id="tag" name="tag" value="<?php if(isset($_POST['tag'])) echo $_POST['tag'] ?>"/>
    <input class="button" type="submit" />
    </form>
</div>

<div>
<?php if(!empty($organizations)) : ?>
    <?php foreach($organizations as $organization) : ?>
        <div class="organization_search_result">
            <div class="organization_search_result_title">
                <h2><a href="organization.php?org=<?php echo $organization->id ?>"><?php echo $organization->name ?></a></h2>
                <span><?php echo $organization->description ?></span>
                <span>
                    <?php if(!empty($organization->tags)) : ?>
                        <?php foreach($organization->tags as $tag) : ?>
                            <a href="#"><?php echo $tag ?></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </span>
            </div>
            
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <?php if (isset($search_occured)) : ?>
        <div>No organizations were found based on your search.</div>
    <?php endif; ?>
<?php endif; ?>
</div>
