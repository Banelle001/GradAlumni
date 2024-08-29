<!-- views/Alumni_dash.php -->
<?php
// Include the configuration file
include '../config/config.php';

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <link rel="stylesheet" href="../css/home2.css">
       
    </head>

    <body >
    <?php include '../includes/nav.php'; ?>


    <main>
     
     <!-- Profile 1 - Bootstrap Brain Component -->
<section class="bg-light py-3 py-md-5 py-xl-8">
<div class="container">
 <div class="row justify-content-md-center">
   <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
    
    
   </div>
 </div>
</div>

<!--profile card ends here-->

<div class="container">
 <div class="row gy-4 gy-lg-0">
   <div class="col-12 col-lg-4 col-xl-3">
     <div class="row gy-4">
       <div class="col-12">
         <div class="card widget-card border-light shadow-sm">
          
           <div class="card-body">
<!--user profile image-->
           <div class="text-center mb-3">
                             <img src="<?php echo htmlspecialchars($user_photo); ?>" class="img-fluid rounded-circle" >
                         </div>
             <h5 class="text-center mb-1"><?php echo htmlspecialchars($user_name) . " " . htmlspecialchars($user_surname); ?>!</h5>
             <p class="text-center text-secondary mb-4"><?php echo htmlspecialchars($user_job); ?></p>
             <ul class="list-group list-group-flush mb-4">
               <li class="list-group-item d-flex justify-content-between align-items-center">
                 <h6 class="m-0">Followers</h6>
                 <span>7,854</span>
               </li>
               <li class="list-group-item d-flex justify-content-between align-items-center">
                 <h6 class="m-0">Following</h6>
                 <span>5,987</span>
               </li>
               <li class="list-group-item d-flex justify-content-between align-items-center">
                 <h6 class="m-0">Friends</h6>
                 <span>4,620</span>
               </li>
             </ul>
             <div class="d-grid m-0">
               <button class="btn btn-outline-primary" type="button">Follow</button>
             </div>
           </div>
         </div>
       </div>

<!--profile card ends here-->

 
       <div class="col-12">
         <div class="card widget-card border-light shadow-sm">
           <div class="card-header text-bg-primary">About Me</div>
           <div class="card-body">
             <ul class="list-group list-group-flush mb-0">
               <li class="list-group-item">
                 <h6 class="mb-1">
                   <span class="bii bi-mortarboard-fill me-2"></span>
                   Education
                 </h6>
                 <span><?php echo htmlspecialchars($user_education); ?></span>
               </li>
             
               <li class="list-group-item">
                 <h6 class="mb-1">
                   <span class="bii bi-building-fill-gear me-2"></span>
                   Company
                 </h6>
                 <span><?php echo htmlspecialchars($user_company); ?></span>
               </li>
             </ul>
           </div>
         </div>
       </div>
       <div class="col-12">
         <div class="card widget-card border-light shadow-sm">
           
         </div>
       </div>
     </div>
   </div>
   <div class="col-12 col-lg-8 col-xl-9">
     <div class="card widget-card border-light shadow-sm">
       <div class="card-body p-4">
         
         <div class="tab-content pt-4" id="profileTabContent">
           
             </div>
           </div>
         
           <div class="post-card">
        <div class="post-header">
            <img src="user_photo.jpg" alt="User Photo" class="user-photo">
            <div class="user-info">
                <h2>Username</h2>
                <p>Posted on: <span class="post-date">2024-08-01</span></p>
            </div>
        </div>
        <div class="post-content">
            <p>This is an example post content. It can be text, images, or a combination of both.</p>
        </div>
        <div class="post-actions">
            <button class="like-btn">Like (<span class="like-count">0</span>)</button>
            <button class="comment-btn">Comment</button>
        </div>
        <div class="post-comments">
            <form class="comment-form">
                <input type="text" placeholder="Add a comment..." class="comment-input">
                <button type="submit">Post</button>
            </form>
            <div class="comments-list">
                <!-- Comments will be dynamically added here -->
            </div>
        </div>
    </div>
   
         </div>
       </div>
     </div>
   </div>
 </div>
</div>

</section>

     </main>
        <?php include '../includes/footer.php'; ?>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
       <script>// script.js
document.addEventListener('DOMContentLoaded', () => {
    const likeBtn = document.querySelector('.like-btn');
    const likeCount = document.querySelector('.like-count');
    const commentForm = document.querySelector('.comment-form');
    const commentInput = document.querySelector('.comment-input');
    const commentsList = document.querySelector('.comments-list');

    let likes = 0;

    likeBtn.addEventListener('click', () => {
        likes++;
        likeCount.textContent = likes;
        // Here, you can make an AJAX call to update the likes count in the database
    });

    commentForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const commentText = commentInput.value.trim();
        if (commentText !== '') {
            addComment(commentText);
            commentInput.value = '';
            // Here, you can make an AJAX call to save the comment in the database
        }
    });

    function addComment(text) {
        const comment = document.createElement('div');
        comment.classList.add('comment');
        comment.textContent = text;
        commentsList.appendChild(comment);
    }
});
</script>
    </body>
</html>