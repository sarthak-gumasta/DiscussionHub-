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
$id = $_GET['catid'];
$sql = "SELECT * FROM `discussion` WHERE category_id= $id";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
$catname = $row['category_name'];
$catdesc = $row['category_description'];
}
?>
    <?php 
    $alert = false;
$method = $_SERVER['REQUEST_METHOD'];
if($method=='POST'){
    // Insert into db
    $th_title = $_POST['title'];

    $th_title = str_replace("<", "&lt;", $th_title);
    $th_title = str_replace(">", "&gt;", $th_title); 
    $th_desc = $_POST['desc'];
    $th_desc = str_replace("<", "&lt;", $th_desc);
    $th_desc = str_replace(">", "&gt;", $th_desc);    

    $sno = $_POST['sno'];
    $sql = "INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
    $result = mysqli_query($conn, $sql);
    $alert = true;
    if($result){
echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>SUCCESS!</strong> Your thread has been added!Please wait for community to respond.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div> ';
    }
}
?>


    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname?> forums</h1>
            <p class="lead"><?php echo $catdesc ?>.</p>
            <hr class="my-4">
            <p>This is a peer to peer forum. No Spam / Advertising / Self-promote in the forums is not allowed. Do not
                post copyright-infringing material. Do not post “offensive” posts, links or images. Do not cross post
                questions. Remain respectful of other members at all times.</p>
        </div>
    </div>
    <script src="ckeditor/ckeditor.js"></script>
    <div class="container">
        <h3 class="py-2"> Start a Discussion</h3>
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            echo'<form action="' . $_SERVER["REQUEST_URI"]. '" method="post">
            <div class="form-group">
                <label for="title">Problem Name</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <small id="text" class="form-text text-muted">Problem name should be short.</small>
            </div>
            <div class="form-group">
                <label for="desc">Elaborate your concern </label>
                <textarea class="form-control text-muted" id="desc" name="desc" rows="3"></textarea>
                <input type="hidden" name="sno" value="' . $_SESSION["sno"] .'">
            </div>
            <button type="submit" class="btn" style="background-color:#00c9c9;">Submit</button>
        </form>
        <script>CKEDITOR.replace("desc",{
            toolbar : "basic",
            uiColor : "# 9AB8F3",
            enterMode : CKEDITOR.ENTER_BR
            });</script>';
        }
        else{
            echo '<p class="lead">You are not logged in. Please login to be able to start a Discussion.  </p>';
        }
?>
    </div>

    <div class="container my-2 mb-5" id="ques">
        <h3 class="py-2">Browse question?</h3>

        <?php 
        $noResult = true;
    $id = $_GET['catid'];
$sql = "SELECT * FROM `threads` WHERE thread_cat_id= $id";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
    $noResult = false;
$id = $row['thread_id'];
$title = $row['thread_title'];
$desc = $row['thread_desc'];
$comment_time = $row['timestamp'];
$thread_user_id = $row['thread_user_id'];
$sql2 = "SELECT user_name FROM `user` where sno='$thread_user_id'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
 echo '<div class="media my-3">
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpY0PT9Nx-q6ogDmoB8NH6Qg3IB9YrdsQRleDrQ4_u7WcafFUFv7gEVJ5GVTnd6CA0cpo&usqp=CAU"
    width="50px" class="mr-3" alt="User photo">
<div class="media-body">' .
    '<h5 class="mt-0 "><a class="text-dark" href="threads.php?threadid=' . $id. '">' . $title . '</a></h5>
    <p>' . $desc . '</p>
</div>'. '<p class="font-weight my-0">Asked by:<strong> ' . $row2['user_name']. ' </strong> at <strong>' . $comment_time. ' </strong> </p>
</div>';
}
if($noResult){
    echo ' <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">No Question</h1>
      <p class="lead">Feel free to ask questions.</p>
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