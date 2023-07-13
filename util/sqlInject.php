<?php
echo "aa";
//echo  mysql_real_escape_chars("aa'bb");
echo pg_escape_string("aa'cc");
//echo pg_escape_literal("aa'cc");