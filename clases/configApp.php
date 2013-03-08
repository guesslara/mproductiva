<?php
/*
 *Nuevo archivo de configuracion en el servidor, y con las nueva forma de crear variables de session
 *
*/
error_reporting(0);//se ocultan los errores en ejecucion
ini_set("expose_php",0);
ini_set("session.save_path","path donde se guardaran las sesiones");//parh donde se guardarn las sesiones en el servidor
ini_set("session.name","cambiar el nombre de la cookie");//
ini_set("session.gc_probability",10);//se aumenta la probabilidad de que se inicie el garbage collector
ini_set("session.gc_divisor",100);
ini_set("session.cookie_httponly",1);//la cookie no podra ser accedida por javascript
ini_set("session.hash_function",1);//con esto se usara sha1 como generadora del id
ini_set("session.use_cookies",1);//se activa el uso de sessiones por cookies
ini_set("session.use_only_cookies",1);//se obliga a guardar el id de session en cookies
ini_set("session.gc_maxlifetime",600);//se reduce el tiempo de la duracion de la basura
ini_set("session.cache_expire",10000);//tiempo en minutos de la variable de sesion
?>