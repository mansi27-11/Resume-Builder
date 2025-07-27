<?php
session_start();
$guid = $_SESSION['guid'] ?? null;
if (!$guid) {
    die("Unauthorized access.");
}

$conn = new mysqli("localhost", "root", "", "project2db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $conn->query("SELECT * FROM tbl_user WHERE guid = '$guid'")->fetch_assoc();
$user_id = $user['user_id'];

$education = $conn->query("SELECT * FROM tbl_education WHERE user_id = '$user_id'");
$experience = $conn->query("SELECT * FROM tbl_experience WHERE user_id = '$user_id'");
$skills = $conn->query("SELECT * FROM tbl_skills WHERE user_id = '$user_id'");
$projects = $conn->query("SELECT * FROM tbl_project WHERE user_id = '$user_id'");
$courses = $conn->query("SELECT * FROM tbl_course WHERE user_id = '$user_id'");
$languages = $conn->query("SELECT * FROM tbl_language WHERE user_id = '$user_id'");
$interests = $conn->query("SELECT * FROM tbl_interest WHERE user_id = '$user_id'");
$certificates = $conn->query("SELECT * FROM tbl_certificate WHERE user_id = '$user_id'");
$awards = $conn->query("SELECT * FROM tbl_award WHERE user_id = '$user_id'");
$declaration = $conn->query("SELECT * FROM tbl_declaration WHERE user_id = '$user_id'")->fetch_assoc();

 function ensureUrlPrefix($url) {
          if (!$url) return '';
          if (strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0) {
              return $url;
          }
          return 'https://' . $url;
      }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Resume</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <style>
    body {
      padding: 2rem;
      background-image: url("bg1.jpg");
      background-size: cover;
      background-repeat: no-repeat;
    }
    @page {
      margin: 0;
    }
    .resume-container {
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 750px;
      margin: 0 auto;
      padding: 40px;
      box-sizing: border-box;
    }
    .profile-pic {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    h2 {
      margin-top: 2rem;
    }
   .heading{
      display: flex;
      flex-direction: column;
      align-items: center;      
      justify-content: center;   
      text-align: center;  
      margin-left: 40px;      
    }
    .content-items {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      flex-wrap: wrap;
    }
    .content-left {
      flex: 1;
      max-width: 30%;
      text-align: left;
      font-weight: 500;
      color: #555;
    }
    .content-right {
      flex: 2;
      max-width: 65%;
      padding-left: 2rem;
      text-align: left;
    }
    @media (max-width: 768px) {
      .content-items {
        flex-direction: column;
      }
      .content-left, .content-right {
        max-width: 100%;
        padding-left: 0;
      }
    }
    .declare-right{
      margin-top: 50px;
      text-align: right;
      
    }
     @media print {
      .no-print {
        display: none !important;
      }
    }

  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
  <div style="text-align: right; margin-bottom: 10px;">
    <div class="no-print">
    
    <button onclick="window.print()" class="button is-primary"  title="📝 Tip: Please select A3 paper size when printing.">Download / Print PDF</button>
    </div>
  </div>
<div class="container resume-container">
  <div class="columns">
    <div class="column is-one-quarter">
      <figure class="image is-150x150">
        <img src="http://localhost/resume/uploads/<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile Picture" class="profile-pic">
      </figure>
    </div>
    <div class="heading">
      <h1 class="title"><?= $user['first_name'] . ' ' . $user['last_name'] ?></h1>
      <p class="subtitle"><?= $user['profile_designation'] ?? '' ?></p>
      <p>
        <i class="bi bi-envelope-fill"></i><a href="https://mail.google.com/mail/?view=cm&to=<?= htmlspecialchars($user['email']) ?>" target="_blank">
          <?= htmlspecialchars($user['email']) ?>
        </a>&nbsp;|&nbsp;
        <i class="bi bi-telephone-fill"></i> <?= '+91 '.$user['phone_no'] ?? '' ?> &nbsp;|&nbsp;
        <i class="bi bi-geo-alt-fill"></i></i> <?= $user['nationality'] ?? '' ?> &nbsp;|&nbsp;
        <i class="bi bi-calendar2-week-fill"></i><?= $user['birthdate'] ?? ''?>
      </p>
      <p>
        <a href="<?= ensureUrlPrefix($user['linkdin']) ?>" target="_blank">Linked In</a> | 
        <a href="<?= ensureUrlPrefix($user['github']) ?>" target="_blank">Github</a>
      </p>
    </div>
  </div>

  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-person-fill"></i>  Profile</h2>
    <hr>
    <p><?= $user['profile_description'] ?? '' ?></p>
  </div>

  <?php if ($experience->num_rows > 0): ?>
  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-person-workspace"></i>  Experience</h2>
    <hr>
    <?php while ($row = $experience->fetch_assoc()): ?>
      <div class="content-items">
        <div class="contet-left">
          <?= date('d-m-Y', strtotime($row['start_date'])) ?> to <?= date('d-m-Y', strtotime($row['end_date'])) ?><br>
          <?=$row['city'].' , '.$row['country']?><br>
        </div>
        <div class="content-right">
          <strong><?= $row['job_title'] ?> - <?= $row['experience_designation'] ?> | <i><?= $row['compney_name'] ?></strong></i><br>
          <?= $row['experience_description'] ?>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
  <?php endif; ?>

  <?php if ($education->num_rows > 0): ?>
    <div class="content">
      <h2 class="has-text-info"><i class="bi bi-mortarboard-fill"></i>  Education</h2>
      <hr>
      <?php while ($row = $education->fetch_assoc()): ?>
        <div class="content-items">
          <div class="content-left">
            <?= date('d-m-Y', strtotime($row['start_date'])) ?> to <?= date('d-m-Y', strtotime($row['end_date'])) ?><br>
            <?= $row['city'] . ' , ' . $row['country'] ?>
          </div>
          <div class="content-right">
            <strong><?= $row['degree_name'] ?> - <?= $row['college_name'] ?></strong><br>
            <?= $row['education_description'] ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>


  <?php if ($skills->num_rows > 0): ?>
  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-person-fill-gear"></i>  Skills</h2>
    <hr>
    <ul>
      <?php while ($row = $skills->fetch_assoc()): ?>
        <li><strong><?= $row['skill_name'] ?></strong>   <?= $row['skill_description'] ?></li>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

  <?php if ($projects->num_rows > 0): ?>
  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-trello"></i>  Projects</h2>
    <hr>
    <?php while ($row = $projects->fetch_assoc()): ?>
      <div>
        <li><strong><?= $row['project_title'] ?> - <?= $row['sub_title'] ?></strong></li><br>
        <?= $row['project_description'] ?>
      </div>
    <?php endwhile; ?>
  </div>
  <?php endif; ?>

  <?php if ($courses && $courses->num_rows > 0): ?>
    <div class="content">
        <h2 class="has-text-info"><i class="bi bi-book-half"></i>  Courses</h2>
        <hr>
        <?php while ($row = $courses->fetch_assoc()): ?>
            <div class="content-items">
              <div class="left-content">
                <?= $row['start_date'] ?> to <?= $row['end_date'] ?><br>
                <?= $row['city'] . ' , ' . $row['country'] ?><br>
              </div>
              <div class="content-right">
                <strong><?= $row['course_name'] ?> - <?= $row['oraganization'] ?></strong><br>
                <?= $row['course_description'] ?>
              </div>
            </div>
        <?php endwhile; ?>
    </div>
  <?php endif; ?>


  <?php if ($languages->num_rows > 0): ?>
  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-chat-dots-fill"></i>  Languages</h2>
    <hr>
    <ul>
      <?php while ($row = $languages->fetch_assoc()): ?>
        <li><strong><?= $row['language_name'] ?></strong></li><br> <?= $row['language_description'] ?>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

  <?php if ($interests->num_rows > 0): ?>
  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-stars"></i>  Interests</h2>
    <hr>
    <ul>
      <?php while ($row = $interests->fetch_assoc()): ?>
        <li><strong><?= $row['interest_name'] ?></strong></li><br> <?= $row['interest_description'] ?>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

  <?php if ($certificates->num_rows > 0): ?>
  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-award-fill"></i>  Certificates</h2>
    <hr>
    <ul>
      <?php while ($row = $certificates->fetch_assoc()): ?>
        <li><strong><?= $row['certificate_name'] ?></strong></li><br> 
        <?= $row['certificate_description'] ?>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

  <?php if ($awards->num_rows > 0): ?>
  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-award-fill"></i>  Awards</h2>
    <hr>
    <ul>
      <?php while ($row = $awards->fetch_assoc()): ?>
        <li><strong><?= $row['award_name'] ?></strong> (<?= $row['award_date'] ?>)</li><br> 
        <?= $row['award_description'] ?>
      <?php endwhile; ?>
    </ul>
  </div>
  <?php endif; ?>

  <?php if ($declaration): ?>
  <div class="content">
    <h2 class="has-text-info"><i class="bi bi-pencil-square"></i>  Declaration</h2>
    <hr>
    <p><?= $declaration['declaration'] ?></p>
    <div class="declare-right">
      <strong>_______________________</strong><br>
      <strong><?= $user['first_name'] . ' ' . $user['last_name'] ?><br></strong>
      <strong>Place:</strong> <?= $declaration['place'] ?><br>
      <strong>Date:</strong> <?= $declaration['date'] ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>




</body>
</html>
