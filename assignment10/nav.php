<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        if ($path_parts['filename'] == "home") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="home.php">Home</a></li>';
        }
        if ($path_parts['filename'] == "events") {
            print '<li class="activePage">Events</li>';
        } else {
            print '<li><a href="events.php">Events</a></li>';
        }
        if ($path_parts['filename'] == "submit") {
            print '<li class="activePage">Submit</li>';
        } else {
            print '<li><a href="submit.php">Submit</a></li>';
        }
        
        if ($path_parts['filename'] == "tables") {
            print '<li class="activePage">Display Tables</li>';
        } else {
            print '<li><a href="tables.php">Display Tables</a></li>';
        }
        ?>
    </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

