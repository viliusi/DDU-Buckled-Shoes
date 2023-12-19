<div class="container" style="margin-top:30px">
    <h2>Image Management</h2>
    <br>
    <button><a href="management-add-images.php">Add</a></button>
    <br> <br>
    <?php
    $images = Image::getAllImages();
    if ($images->count()) {
        echo $images->count() . " images found.";
        echo "<table style='width:100%; border: 1px solid'>";
        echo "<tr>";
        echo "<th>image_id</th>";
        echo "<th>name</th>";
        echo "<th>image_location</th>";
        echo "<th>Edit</th>";
        echo "</tr>";
        foreach ($images->results() as $image) {
            // build a table with the results, printing the variables "name", "price", "category" and "description"
            echo "<tr>";
            echo "<td>" . $image->image_id . "</td>";
            echo "<td>" . $image->name . "</td>";
            echo "<td>" . $image->image_location . "</td>";
            echo "<td><a href='management-edit-images.php?image_id=" . $image->image_id . "'>Edit</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No images found.";
    }
    ?>

    <br><br>

    <h4>Image preview</h4>

    <?php

    foreach ($images->results() as $image) {
        echo $image->image_id . "<br>";
        echo $image->name . "<br>";
        echo $image->image_location . "<br>";
        echo "<img src='" . $image->image_location . "' width='200' height='200'>" . "<br>";
    }


    ?>

</div>