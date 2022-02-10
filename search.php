<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <style>
    #maincontainer {
        min-height: 100vh;
    }
    </style>
    <title>DiscussionHub!</title>
</head>

<body>
    <?php include 'partial/_dvconnect.php'; ?>
    <?php include 'partial/_header.php'; ?>

    <div class="container my-3 " id="maincontainer">
        <h1 class="py-3">Search result for <em>"<?php echo $_GET['search']?>"</em></h1>
        <?php
        $noResult=true;
        $query = $_GET["search"];
    $sql = "SELECT * FROM threads where match (thread_title, thread_desc) against('$query')";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_id = $row['thread_id'];
    $url = "threads.php?threadid=". $thread_id;
$noResult=false;
    echo '<div class="result">
    <h3><a href="'. $url. '" class="text-dark">'. $title. '</a></h3>
    <p>'. $desc. '</p>
</div>';
    }
    if($noResult){
       echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">No Result Found</h1>
            <p class="lead">Suggestions:<ul>
            <li>Make sure that all words are spelled correctly.</li>
            <li> Try different keywords.</li>
            <li>Try more general keywords.</li>
            </ul></p>
        </div>
        </div>';
    }
?>
    </div>
    <?php include 'partial/_footer.php'; ?>

    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script> -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>