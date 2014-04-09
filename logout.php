<?php
setcookie('photoLogged',"",time()-3600);
header("Location: admin.php?".rand(1,9999));