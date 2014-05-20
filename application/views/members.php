<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Members</title>
</head>
<body>

<div id="container">
    <h1>Members page</h1>

    <?php

    echo "<pre>";
    print_r($this->session->all_userdata());
    echo "</pre>";

    echo "<p>";
    echo base_url();
    echo "<br>";
    echo basename(base_url());
    echo "<br>";
    echo "</p>";

    ?>

    <a href="<? echo base_url()."index.php/main/logout" ?>">Logout</a>

</div>

</body>
</html>