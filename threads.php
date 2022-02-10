<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-- Bootstrap css version5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="ckeditor/ckeditor.js"></script>
    <style>
    #ques {
        min-height: 233px;
    }
    </style>
    <title>DiscussionHub!</title>
</head>

<body>
    <?php include 'partial/_dvconnect.php'; ?>
    <?php include 'partial/_header.php'; ?>
    <?php 
$id = $_GET['threadid'];
$sql = "SELECT * FROM `threads` WHERE thread_id= $id";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
$title = $row['thread_title'];
$desc = $row['thread_desc'];
$thread_user_id = $row['thread_user_id'];
$sql2 = "SELECT user_name FROM `user` where sno='$thread_user_id'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$posted_by = $row2['user_name'];
}
?>

    <?php 
    $alert = false;
$method = $_SERVER['REQUEST_METHOD'];
if($method=='POST'){
    // Insert into db
    $comment = $_POST['comment'];
    $comment = str_replace("<", "&lt;", $comment);
    $comment = str_replace(">", "&gt;", $comment);
    $sno = $_POST['sno'];
    $sql = "INSERT INTO `comment` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
    $result = mysqli_query($conn, $sql);
    $alert = true;
    if($result){
echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>SUCCESS!</strong> Your comment has been added.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div> ';
    }
}
?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $title?> </h1>
            <p class="lead"><?php echo $desc ?>.</p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
            <p>Posted by: <b><?php echo $posted_by; ?></b></p>
        </div>
    </div>
    <script src="ckeditor/ckeditor.js"></script>
    <div class="container">
        <h3 class="py-2">Post Comment</h3>
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo'<form action="' . $_SERVER["REQUEST_URI"]. '" method="post">
            <div class="form-group">
                <label for="comment">Type your comment </label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="' . $_SESSION["sno"] .'">
            </div>
            <button type="submit" class="btn" style="background-color:#00c9c9;">Post Comment</button>
        </form>
        <script>CKEDITOR.replace("comment",{
            toolbar : "basic",
            uiColor : "# 9AB8F3",
            enterMode : CKEDITOR.ENTER_BR
            });</script>';
        }else{
            echo '<p class="lead">You are not logged in. Please login to be able to start a Discussion.  </p>';
        }
?>
    </div>

    <div class="container my-2 mb-5" id="ques">
        <h3 class="py-2">Discussions</h3>

        <?php 
        $noResult = true;
    $id = $_GET['threadid'];
$sql = "SELECT * FROM `comment` WHERE thread_id= $id";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
    $noResult = false;
$id = $row['comment_id'];
$comment = $row['comment_content'];
$comment_time = $row['comment_time'];
$comment_by = $row['comment_by'];
$sql2 = "SELECT user_name FROM `user` where sno='$comment_by'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
 echo '<div class="media my-3">
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpY0PT9Nx-q6ogDmoB8NH6Qg3IB9YrdsQRleDrQ4_u7WcafFUFv7gEVJ5GVTnd6CA0cpo&usqp=CAU"
    width="50px" class="mr-3" alt="User photo">
<div class="media-body">
<p class="font-weight-bold my-0">' . $row2['user_name']. ' at ' . $comment_time. '  </p>
    <p>' . $comment . '</p>
</div>
</div>';
}
if($noResult){
    echo ' <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">No Comments Fond</h1>
      <p class="lead">If you know the solution so please do the comment.</p>
    </div>
    </div> ';
    }
?>
    </div>


    <?php include 'partial/_footer.php'; ?>
    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper (version-5) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>