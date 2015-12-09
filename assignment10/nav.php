<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ul>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        if ($path_parts['filename'] == "home") {
            print '<li id="activePage" class="navButton" >Home</li>';
        } else {
            print '<li class="navButton"><a href="home.php">Home</a></li>';
        }
        if ($path_parts['filename'] == "events") {
            print '<li id="activePage" class="navButton">Events</li>';
        } else {
            print '<li class="navButton"><a href="events.php">Events</a></li>';
        }
        if ($path_parts['filename'] == "submit") {
            print '<li id="activePage" class="navButton">Submit</li>';
        } else {
            print '<li class="navButton"><a href="submit.php">Submit</a></li>';
        }

        ?>
    </ul>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

