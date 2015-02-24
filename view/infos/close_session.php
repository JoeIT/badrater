<?php
session_start();
session_destroy();

header('Location: ../../index.php');
?>

<body>

<table width='100%'>
	<tr>
		<td align='center' class='notice_text'><h1>Cerrando sesi&oacute;n!</h1><td>
	</tr>
</table>

</body>