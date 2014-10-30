<?php if(isset($role)) : ?>
    <h2>Update Role</h2>
<?php else : ?>
    <h2>Add Role</h2>
<?php endif; ?>
<hr>
<div><?php if(isset($error)) {echo $error;} ?></div>
<form method="post">
    Name: <input type="text" name="role_name" value="<?php if(isset($role)) {echo $role['title'];} ?>"/><br/>
<?php foreach($all_permissions as $permission) : ?>
    <?php if(in_array($permission['pid'], $role_permissions)) : ?>
        <span><input name="selected_permissions[]" type="checkbox" value="<?php echo $permission['pid'] ?>" checked /><?php echo $permission['name'] ?></span>
    <?php else : ?>
        <span><input name="selected_permissions[]" type="checkbox" value="<?php echo $permission['pid'] ?>" /><?php echo $permission['name'] ?></span>
    <?php endif; ?>
    <br/>
<?php endforeach; ?>
    <input type="submit" class="button" />
</form>

