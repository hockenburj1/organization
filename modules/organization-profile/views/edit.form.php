<h1>Edit Organization</h1>
<div class="form">
    <div>
    <?php if(isset($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    </div>
    <form method="POST" type="multipart">
    <p>
        <label>Name:</label><input type="text" name="name" value="<?php echo $organization->name ?>"/>
    </p>
    <p>
        <label>Abbreviation:</label><input type="text" name="abbreviation" value="<?php echo $organization->name ?>"/>
    </p>
    <p>
        <label>Description:</label><textarea name="description" rows="5"><?php echo $organization->description ?></textarea>
    </p>
    <p>
        <label>Image/Logo:</label><input name="logo" type="file" />
    </p>
    <p>
        <label>Parent:</label><input type="text" name="parent" id="parent-name" value="<?php if(!empty($organization->parents)) { echo $organization->parents[0]->name; } ?>"/>
    </p>
    <p>
        <input name="request" type="checkbox" value="TRUE" <?php if(empty($_POST) || post('request') == 'TRUE') {echo "checked";} ?>/> I would like this organization to appear in the search results.
    </p>
    <input type="hidden" name="parent_id" id="parent_id" value="<?php echo $organization->parent ?>"/>
    <p>
        <input type="submit" class="button" value="Edit Organization"/>
    </p>
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