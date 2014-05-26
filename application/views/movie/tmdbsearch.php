<h1>Search Movie in TMDB</h1>
<p>

    <?php

    echo form_open('movie/tmdbsearch');

    echo "<p>Suchen: ";
    echo form_input('search');
    echo form_submit('search_submit', 'Suchen', $this->input->post('search'));
    echo "</p>";

    echo form_close();

    ?>

</p>
<?php echo $movietable; ?>