<?php
include "dbConnect.php";
$username = $_GET ['userid'];

$result = mysqli_query ( $con, "Update User set Status='yes' where UserID='$username'" );

?>
<script type="text/javascript">
  				alert("Your registration has been confirmed. You can now login into Tutor Me!!.");
  				document.location.href = 'index.php'
				</script>
<?php

?>