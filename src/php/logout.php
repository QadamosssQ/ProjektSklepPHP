<?php

require "conn.php";

session_destroy();

header("Location: login.php");