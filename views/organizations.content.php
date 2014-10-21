<div class="page_head">
    <div class="col-lg-9">
        <h1>Organizations</h1>
    </div>
    <div class="col-lg-1 header-buttons">
        <a href="organization.php?action=add_organization"><img src="images/new_file.png" height="25" /><br/>New</a>
    </div>   
</div>
<div class="col-lg-12">

    <?php if (!empty($organizations)) : ?>
        <?php foreach ($organizations as $organization) : ?>
            <a href="organization.php?org=<?php echo $organization->id ?>">
				<div class="organization_search_result">
				<div class="organization_search_result_title">
                    <h4><?php echo $organization->name ?></h4>
					
                    <!--<span><?php echo $organization->description ?></span>
                    <span>
                        <?php foreach ($organization->tags as $tag) : ?>
                            <a href="#"><?php echo $tag ?></a>
                        <?php endforeach; ?>
                    </span>-->
                </div>  
								
            </div></a>
        <?php endforeach; ?>
    <?php else : ?>
        <div>You are not currently a member of any organizations. <a href="search.php">Search for Organizations</a></div>
    <?php endif; ?>
</div>
