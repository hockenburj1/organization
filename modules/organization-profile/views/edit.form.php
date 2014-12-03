<div class="container-fluid">
    <div class="row" style="background-color:#dcdddf;">
    <?php include('views/menu-start.php'); ?>
    	<ul>
            <li>
                    <a href="dashboard.php">
                        <img src="templates/default/images/layout/thumb-home.png" alt="Dashboard" height="40" width="40" class="icon hidden-xs">
                        Dashboard
                    </a>
            </li>
 <?php if ( $user->has_permission($organization->id, 'edit_organization') ) : ?>
                    <li>
                        <a href="organizations.php">
                            <img src="templates/default/images/layout/thumb-organizations.png" alt="Search Organization" height="40" width="40" class="icon hidden-xs">
                            Organizations
                        </a>
                    </li>
                    <li class="active">
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=edit_organization">
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        Edit Organization</a>
                    </li>
                    <?php endif; ?>
                <li>
                    <a href="organization.php?action=add_organization">
                        <img src="templates/default/images/layout/thumb-add.png" alt="Add Organization" height="40" width="40" class="icon hidden-xs">
                        Add Organization
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 content-wrap">
<h1>Edit Organization</h1>
<hr>
<div class="form form-horizontal">
    <div>
    <?php if(isset($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    </div>
    <form role="form" method="POST" type="multipart" class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-2 control-label">Name:</label>
		<div class="col-sm-10">
			<input type="text" name="name" class="form-control" value="<?php echo $organization->name ?>"/>
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Abbreviation:</label>
		<div class="col-sm-10">
			<input type="text" name="abbreviation" class="form-control"  value="<?php echo $organization->name ?>"/>
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Description:</label>
		<div class="col-sm-10">
			<textarea name="description" rows="5" class="form-control" ><?php echo $organization->description ?></textarea>
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Image/Logo:</label>
		<div class="col-sm-10">
			<input name="logo" type="file" />
		</div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Parent:</label>
		<div class="col-sm-10">
			<input type="text" name="parent" id="parent-name" class="form-control"  value="<?php if(!empty($organization->parents)) { echo $organization->parents[0]->name; } ?>"/>
		</div>
    </div>
    <div class="form-group">
        <input name="request" type="checkbox" value="TRUE" <?php if(empty($_POST) || post('request') == 'TRUE') {echo "checked";} ?>/> I would like this organization to appear in the search results.
    </div>
    <input type="hidden" name="parent_id" id="parent_id" value="<?php echo $organization->parent ?>"/>
    <div class="form-group">
        <button type="submit" class="button" class="btn btn-default">Edit Organization</button>
    </div>
    </form>
</div>
<div class="form-extra">
    <div>
        <h3>Tip</h3>
        <span>Abbreviations should be short and easy to remember. These will be searchable as well as present in your organizations URL.</span>
    </div>
    <br />
    <div>
        <h3>Parent Organizations</h3>
        <span>Organizations can be linked with their parent organizations with this feature. To begin searching begin typing the organizations name and options will be provided to choose from.</span>
    </div>
</div>
        </div><!--/content wrap-->
    </div><!--/row-->   
</div><!--/container-->

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
$(function() {
    $( '#parent-name' ).autocomplete({
        source: "<?php echo $module_url ?>parent-search.php",
        minLength: 2,
        select: function( event, ui ) {
            $('#parent_id').val(ui.item.id);
        }
    });  
});
</script>