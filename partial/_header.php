<?php  
session_start();
echo '<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#00c9c9;">
<div class="container-fluid">
    <a class="navbar-brand" href="/forum">DiscussionHub!</a>
    <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/forum"
                    >Home</a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    Top Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

                $sql = "SELECT category_name, category_id FROM `discussion` LIMIT 3";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    echo '<a class="dropdown-item" href="threadlist.php?catid=' . $row['category_id']. ' ">' . $row['category_name']. '</a>';
                    
                }

             echo   '</div>
            </li>
            <li class="nav-item">
                        <a class="nav-link " tabindex="-1" href="contact.php">Contact</a>
            </li>
        </ul>';

            
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
              echo '<form class="d-flex" method="get" action="search.php">
               <input
                class="form-control me-2"
                name="search"
                type="search"
                placeholder="Search"
                aria-label="Search"
            />
            <button class="btn btn-danger" type="submit">
                Search
            </button>
        </form>
        <p class="text-light my-0 mx-2 ">Welcome '. $_SESSION['username']. '</p>
        <a href="partial/_logout.php" class="btn btn-outline-light ml-2">Logout</a> ';
            }else{
                echo '<input
                class="form-control me-2"
                type="search"
                placeholder="Search"
                aria-label="Search"
            />
            <button class="btn btn-danger" type="submit">
                Search
            </button>
        </form>
        <button class="btn btn-outline-light  mx-2"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-outline-light ml-2"  data-bs-toggle="modal" data-bs-target="#signupModal">Get Start</button> ';
            }


   echo' </div>
</div>
</nav>';

include 'partial/_loginmodal.php';
include 'partial/_signupmodal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
    echo ' <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success!</strong> Now you can login.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div> ';
}
?>