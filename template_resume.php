<?php
if (!isset($user)) exit;

function sectionTitle($title) {
    return "<h2 style='color: #3273dc; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-top: 30px;'>$title</h2>";
}

// Prepare absolute path for profile image
$profileImagePath = realpath(__DIR__ . '/uploads/' . $user['profile_image']);
$profileImageSrc = ($profileImagePath && file_exists($profileImagePath)) ? 'data:image/png;base64,' . base64_encode(file_get_contents($profileImagePath)) : '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 40px;
      color: #333;
    }
    .resume-container {
      width: 100%;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .profile-pic {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    .heading {
      display: flex;
      flex-direction: column;
      align-items: center;      
      justify-content: center;   
      text-align: center;  
      margin-left: 50px; 
    }
    h2 {
      margin-top: 2rem;
    }
    .content-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1.5rem;
      border-bottom: 1px solid #ddd;
      padding-bottom: 1rem;
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
    
    ul {
      padding-left: 20px;
    }
    a {
      color: #3273dc;
      text-decoration: none;
    }
  </style>
</head>
<body>
<div class="resume-container">

  <div class="heading">
    <?php if ($profileImageSrc): ?>
      <img src="<?= $profileImageSrc ?>" alt="Profile" class="profile-pic">
    <?php endif; ?>
    <h1><?= $user['first_name'] . ' ' . $user['last_name'] ?></h1>
    <h3><?= $user['profile_designation'] ?></h3>
    <p><?= $user['email'] ?> | +91 <?= $user['phone_no'] ?></p>
    <p><?= $user['nationality'] ?> | <?= $user['birthdate'] ?></p>
    <p><a href="<?= $user['linkdin'] ?>">LinkedIn</a> | <a href="<?= $user['github'] ?>">GitHub</a></p>
    
  </div>

  <?= sectionTitle('Profile') ?>
  <hr>
  <p><?= $user['profile_description'] ?></p>

  <?php if ($experience->num_rows > 0): ?>
    <?= sectionTitle('Experience') ?>
    <hr>
    <?php while ($row = $experience->fetch_assoc()): ?>
        <div class="content-item">
            <div class="content-left">
                <?= $row['start_date'] ?> to <?= $row['end_date'] ?><br><?= $row['city'] ?>, <?= $row['country'] ?>
            </div>
            <div class="content-right">
                <strong><?= $row['job_title'] ?> - <?= $row['experience_designation'] ?> | <?= $row['compney_name'] ?></strong>
                <?= nl2br($row['experience_description']) ?>
            </div>
        </div>
        
    <?php endwhile; ?>
  <?php endif; ?>

  <?php if ($education->num_rows > 0): ?>
    <?= sectionTitle('Education') ?>
    <?php while ($row = $education->fetch_assoc()): ?>
      <div class="item">
        <div class="two-column">
          <div class="left"><?= $row['start_date'] ?> - <?= $row['end_date'] ?><br><?= $row['city'] ?>, <?= $row['country'] ?></div>
          <div class="right">
            <strong><?= $row['degree_name'] ?> - <?= $row['college_name'] ?></strong>
            <div><?= $row['education_description'] ?></div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>

  <?php if ($skills->num_rows > 0): ?>
    <?= sectionTitle('Skills') ?>
    <ul>
      <?php while ($row = $skills->fetch_assoc()): ?>
        <li><strong><?= $row['skill_name'] ?>:</strong> <?= $row['skill_description'] ?></li>
      <?php endwhile; ?>
    </ul>
  <?php endif; ?>

  <!-- You can continue for projects, courses, etc. just like above -->

</div>
</body>
</html>
