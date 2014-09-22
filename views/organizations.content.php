<h1>Organizations</h1>
<div>
<?php if(!empty($organizations)) : ?>
    <?php foreach($organizations as $organization) : ?>
        <div class="organization_search_result">
            <div class="organization_search_result_title">
                <h2><a href="organization.php?org=<?php echo $organization->id ?>"><?php echo $organization->name ?></a></h2>
                <span><?php echo $organization->description ?></span>
                <span>
                    <?php foreach($organization->tags as $tag) : ?>
                        <a href="#"><?php echo $tag ?></a>
                    <?php endforeach; ?>
                </span>
            </div>
            
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div>You are not currently a member of any organizations. <a href="search.php">Search for Organizations</a></div>
<?php endif; ?>
</div>
