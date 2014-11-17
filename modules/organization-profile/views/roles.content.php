<h2>Roles</h2>
<hr>
<?php foreach($roles as $role) : ?>
    <span><a href="organization.php?org=<?php echo $organization->id ?>&action=edit_role&rid=<?php echo $role['id'] ?>"><?php echo $role['title'] ?></span>
    <span><a href="organization.php?org=<?php echo $organization->id ?>&action=delete_role&rid=<?php echo $role['id'] ?>">Delete</a></span>
    <br/>
<?php endforeach; ?>
<span><a href="organization.php?org=<?php echo $organization->id ?>&action=add_role">Add Role</a></span>


