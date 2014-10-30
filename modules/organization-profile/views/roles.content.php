<h2>Roles</h2>
<hr>
<?php foreach($roles as $role) : ?>
    <span><a href="organization.php?org=<?php echo $organization->id ?>&action=edit_role&rid=<?php echo $role['rid'] ?>"><?php echo $role['title'] ?></span>
    <span><a onClick='confirmDelete(<?php echo $role['rid'] ?>)'>Delete</a></span>
    <br/>
<?php endforeach; ?>

<script type="text/javascript">
function confirmDelete(rid)
{
    var status = confirm("Are you sure you want to delete ?");
    if(status)
    {
        window.location = "organization.php?org=" + <?php echo $organization->id ?> + "&action=delete_role&rid=" + rid;
    }
}
</script>

