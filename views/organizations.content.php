<div class="container-fluid">
    <div class="row" style="background-color:#dcdddf;">
        <div class="decorative-border"></div>
        <div class="col-xs-12 col-sm-3 col-md-3 right-nav">
            <h1 id="user-greeting" class="hidden-xs">Organizations</h1>
            <ul>
                <li>
                    <a href="dashboard.php">
                        <img src="templates/default/images/layout/thumb-home.png" alt="Dashboard" height="40" width="40" class="icon hidden-xs">
                        Dashboard
                    </a>
                </li>
                <li class="active">
                    <a href="organizations.php">
                        <img src="templates/default/images/layout/thumb-organizations.png" alt="Search Organization" height="40" width="40" class="icon hidden-xs">
                        Organizations
                    </a>
                </li>
                <li>
                    <a href="event.php">
                        <img src="templates/default/images/layout/thumb-events.png" alt="Search Events" height="40" width="40" class="icon hidden-xs">
                        Events
                    </a>
                </li>
                <li>
                    <a href="membership.php?action=update">
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        Edit User
                    </a>
                </li>
                <li>
                    <a href="organization.php?action=add_organization">
                        <img src="templates/default/images/layout/thumb-add.png" alt="Add Organization" height="40" width="40" class="icon hidden-xs">
                        Add Organization
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 content-wrap">
        <h1>Your Organizations</h1>
        <?php if (!empty($organizations)) : ?>
        <?php foreach ($organizations as $organization) : ?>
            <div class="row listing">
                <div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="listing-img"><img src="templates/default/images/content/FBLA-PBL.gif" class="img-responsive"></div>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8">
                    <h2><a href="organization.php?org=<?php echo $organization->id ?>"><?php echo $organization->name ?></a></h2>
                    <div class="meta-data">
                        <p><a href="">Members (5)</a> | <a href="">Articles (9)</a> | <a href="">Events (1)</a></p>
                    </div>
                    <p>This is roughly 50 words. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id pretium odio. Sed suscipit arcu id lorem vehicula, vel tristique elit lobortis. Nam imperdiet ex sit amet lobortis maximus. Nullam volutpat magna at lorem egestas, quis mollis leo aliquet. Aenean hendrerit fringilla ultrices. Praesent ornare in elit ut lacinia.</p>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else : ?>
            <div>You are not currently a member of any organizations. <a href="search.php">Search for Organizations</a></div>
        <?php endif; ?>
            
        </div><!--/content wrap-->
    </div><!--/row-->   
</div><!--/container-->
