<?php foreach ($organizations as $organization) : ?>
    <div class="organization-box">
        <span class="title"><?php echo $organization->name; ?></span>
    <br />
    
    <!-- Display document for organization. -->
    <?php if(!empty($organization->get_documents())) :?>
        <?php foreach ($organization->get_documents() as $document) : ?>
            <a href="<?php echo $document['url'] ?>" ><?php echo $document['title'] ?></a>
            <?php if($user->is_admin): ?>
                <span class="remove_link">Remove Document</span><br />
            <?php endif;?>
        <?php endforeach;?>
    <?php else : ?>
        <span>There are currently no documents for this organization.</span>
    <?php endif; ?>

        
   <!-- Display document for organization administrators. -->     
   <?php if(!empty($organization->get_admin_documents())) :?>
   <br />
   <span class="subtitle">Administrative Documents: </span><br />
       <?php foreach ($organization->get_admin_documents() as $document) : ?>
            <a href="<?php echo $document['url'] ?>"><?php echo $document['title'] ?></a><br />
        <?php endforeach;?>
    <?php endif; ?>
    </div>
<?php endforeach; ?>

