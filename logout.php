<?php
setcookie('photoLogged',"",time()-3600);
header("Location: admin.php");