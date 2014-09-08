<div>
<?php if(!empty($result)) : ?>
    <?php foreach($organizations as $organization) : ?>
        <div class="organization_search_result">
            <div class="organization_search_result_title">
                <h2><a href="organization.php?org=<?php echo $organization->abbreviation ?>"><?php echo $organization->name ?></a></h2>
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
    <div>No organizations were found based on your search.</div>
<?php endif; ?>
</div>
