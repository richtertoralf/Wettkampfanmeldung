<?php
session_start();

// Session zerstören, um den Admin abzumelden
session_destroy();

// Weiterleiten zur Startseite nach dem Abmelden
header("Location: ../index.php");
exit();
