<h2>Delete Role</h2>
<hr>
Are you sure you would like to remove the <?php echo $role['title'] ?> role?<br />
<br />
<a href="organization.php?org=<?php echo $organization->id ?>&action=delete_role&rid=<?php echo $role['id'] ?>&confirm=TRUE">Confirm Delete</a><br/>
<a href="organization.php?org=<?php echo $organization->id ?>&action=delete_role&rid=<?php echo $role['id'] ?>&confirm=FALSE">Cancel</a><br/>