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

    ?>

</div>

</body>
</html>