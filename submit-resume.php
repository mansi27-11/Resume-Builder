<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "project2db";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$all_success = true; 
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in.");
    }

    $user_id = $_SESSION['user_id'];
    $fname = clean_input($_POST['first_name']);
    $lname = clean_input($_POST['last_name']);
    $birthdate = clean_input($_POST['birthdate']);
    $gender = clean_input($_POST['gender']);
    $phone = clean_input($_POST['phone']);
    $designation = clean_input($_POST['designation']);
    $address = clean_input($_POST['address']);
    $description = clean_input($_POST['description']);
    $nationality = clean_input($_POST['nationality']);
    $lindin=clean_input($_POST['linkdin']);
    $github=clean_input($_POST['github']);
    $filename = '';
    

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = basename($_FILES['picture']['name']);
        $targetFilePath = $uploadDir . $filename;

        if (!move_uploaded_file($_FILES['picture']['tmp_name'], $targetFilePath)) {
            die("Error uploading image.");
        }
    }

    //1. Update user profile in tbl_user
    $sql1 = "UPDATE tbl_user SET first_name = ?, last_name = ?, birthdate = ?, phone_no = ?, gender = ?,
            profile_image = ?, profile_description = ?, profile_designation = ?, current_address = ?, nationality = ?,linkdin=?,github=?
            WHERE user_id = ?";

    $stmt1 = $conn->prepare($sql1);
    if (!$stmt1) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt1->bind_param("ssssssssssssi", $fname, $lname, $birthdate, $phone, $gender, $filename,
        $description, $designation, $address, $nationality, $lindin,$github,$user_id);

    if ($stmt1->execute()) {
        echo "User data updated successfully!<br>";
    } else {
        echo "Error updating user: " . $stmt1->error;
        $all_success = false;
    }
    $stmt1->close();

    $guid_result = $conn->query("SELECT guid FROM tbl_user WHERE user_id = '$user_id'");
    if ($guid_result && $guid_result->num_rows > 0) {
        $guid_row = $guid_result->fetch_assoc();
        $_SESSION['guid'] = $guid_row['guid']; // ✅ Store the guid for use in view-resume.php
    } else {
        die("Failed to fetch GUID.");
    }
    
    //2. Multiple education Form
    $user_id=$_SESSION['user_id'];
    $college_names = $_POST['collage_name'] ?? [];
    $degree_names = $_POST['degree_name'] ?? [];
    $cgpas = $_POST['cgpa'] ?? [];
    $start_dates = $_POST['start_date'] ?? [];
    $end_dates = $_POST['end_date'] ?? [];
    $cities = $_POST['city'] ?? [];
    $states = $_POST['state'] ?? [];
    $countries = $_POST['country'] ?? [];  
    $descriptions = $_POST['education_description'] ?? [];

    for ($i = 0; $i < count($college_names); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql2 = "INSERT INTO tbl_education (user_id, degree_name, college_name, cgpa, city, state, country, start_date, end_date, education_description, guid)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            die("Prepare failed for education: " . $conn->error);
        }

        $stmt2->bind_param("sssssssssss", $user_id, $degree_names[$i], $college_names[$i], $cgpas[$i], $cities[$i],
            $states[$i], $countries[$i], $start_dates[$i], $end_dates[$i], $descriptions[$i], $guid);

        if ($stmt2->execute()) {
            echo "Education entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting education entry #$i: " . $stmt2->error;
            $all_success = false;
        }

        $stmt2->close();
    }
    //3.Multiple Experience details
    $user_id=$_SESSION['user_id'];
    $compney_names = $_POST['compney_name'] ?? [];
    $job_titles = $_POST['job_title'] ?? [];
    $designations = $_POST['exp_designation'] ?? [];
    $satrt_dates = $_POST['exp_start_date'] ?? [];
    $end_dates = $_POST['exp_end_date'] ?? [];
    $cities= $_POST['exp_city'] ?? [];
    $states= $_POST['exp_state'] ?? [];
    $countries=$_POST['exp_country']??[];
    $descriptions= $_POST['exp_description']??[];

    for ($i = 0; $i < count($compney_names); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql3 = "INSERT INTO tbl_experience (user_id, compney_name, job_title, experience_designation, city, state, country, start_date, end_date, experience_description, guid)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt3 = $conn->prepare($sql3);
        if (!$stmt3) {
            die("Prepare failed for experience : " . $conn->error);
        }

        if (empty(trim($compney_names[$i]))) {
            continue;
        }

        $stmt3->bind_param("sssssssssss", $user_id, $compney_names[$i], $job_titles[$i], $designations[$i], $cities[$i],
            $states[$i], $countries[$i], $start_dates[$i], $end_dates[$i], $descriptions[$i], $guid);

        if ($stmt3->execute()) {
            echo "Experience entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting experience entry #$i: " . $stmt3->error;
            $all_success = false;
        }

        $stmt3->close();
    
    }

    //4.Multiple Skill details
    $user_id=$_SESSION['user_id'];
    $skill_names = $_POST['skill_name'] ?? [];
    $descriptions= $_POST['skill_description']??[];

    for ($i = 0; $i < count($skill_names); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql4 = "INSERT INTO tbl_skills (user_id, skill_name, skill_description,guid)
                 VALUES (?, ?, ?, ?)";

        $stmt4 = $conn->prepare($sql4);
        if (!$stmt4) {
            die("Prepare failed for skill: " . $conn->error);
        }

        $stmt4->bind_param("ssss", $user_id, $skill_names[$i],$descriptions[$i], $guid);

        if ($stmt4->execute()) {
            echo "Skill entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting skill entry #$i: " . $stmt4->error;
            $all_success = false;
        }

        $stmt4->close();
    }

    //5.Multiple Project Details
    $user_id=$_SESSION['user_id'];
    $project_titles = $_POST['project_title'] ?? [];
    $project_sub_titles = $_POST['project_sub_title'] ?? [];
    $project_description = $_POST['project_description'] ?? [];

    for ($i = 0; $i < count($project_titles); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql5 = "INSERT INTO tbl_project (user_id,project_title,sub_title,project_description,guid)
                 VALUES (?, ?, ?, ?,?)";

        $stmt5= $conn->prepare($sql5);
        if (!$stmt5) {
            die("Prepare failed for project: " . $conn->error);
        }

        $stmt5->bind_param("sssss", $user_id,$project_titles[$i],$project_sub_titles[$i],$project_description[$i], $guid);

        if ($stmt5->execute()) {
            echo "Project entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting Project entry #$i: " . $stmt5->error;
            $all_success = false;
        }

        $stmt5->close();
    }

    //6.Multiple Course Details
    $user_id=$_SESSION['user_id'];
    $course_names = $_POST['course_name'] ?? [];
    $organization_names = $_POST['organization_name'] ?? [];
    $satrt_dates = $_POST['cou_start_date'] ?? [];
    $end_dates = $_POST['cou_end_date'] ?? [];
    $cities= $_POST['cou_city'] ?? [];
    $states= $_POST['cou_state'] ?? [];
    $countries=$_POST['cou_country']??[];
    $descriptions= $_POST['cou_description']??[];

    for ($i = 0; $i < count($course_names); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql6 = "INSERT INTO tbl_course (user_id,course_name,oraganization,city,state,country,start_date,end_date,course_description,guid)
                 VALUES (?, ?, ?, ?,?,?,?,?,?,?)";

        $stmt6 = $conn->prepare($sql6);
        if (!$stmt6) {
            die("Prepare failed for course: " . $conn->error);
        }

        if (empty(trim($course_names[$i]))) {
            continue;
        }

        $stmt6->bind_param("ssssssssss", $user_id,$course_names[$i],$organization_names[$i],$cities[$i],$states[$i],$countries[$i],$satrt_dates[$i],$end_dates[$i],$descriptions[$i],$guid);

        if ($stmt6->execute()) {
            echo "course entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting course entry #$i: " . $stmt6->error;
            $all_success = false;
        }

        $stmt6->close();
    }
    //7. Multiple Language Details
    $user_id=$_SESSION['user_id'];
    $language_names = $_POST['language_name'] ?? [];
    $language_descriptions = $_POST['language_description'] ?? [];

    for ($i = 0; $i < count($language_names); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql7 = "INSERT INTO tbl_language (user_id,language_name,language_description,guid)
                 VALUES (?, ?, ?, ?)";

        $stmt7 = $conn->prepare($sql7);
        if (!$stmt7) {
            die("Prepare failed for language: " . $conn->error);
        }

        $stmt7->bind_param("ssss", $user_id,$language_names[$i],$language_description[$i], $guid);

        if ($stmt7->execute()) {
            echo "language entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting language entry #$i: " . $stmt7->error;
            $all_success = false;
        }

        $stmt7->close();
    }

    //8. Multiple Interest Details
    $user_id=$_SESSION["user_id"];
    $interest_names=$_POST["interest_name"] ?? [];
    $interest_descriptions=$_POST["interest_description"] ?? [];

    for ($i = 0; $i < count($interest_names); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql8 = "INSERT INTO tbl_interest (user_id,interest_name,interest_description,guid)
                 VALUES (?, ?, ?, ?)";

        $stmt8 = $conn->prepare($sql8);
        if (!$stmt8) {
            die("Prepare failed for interest: " . $conn->error);
        }

        $stmt8->bind_param("ssss", $user_id,$interest_names[$i],$interest_description[$i], $guid);

        if ($stmt8->execute()) {
            echo "interest entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting interest entry #$i: " . $stmt8->error;
            $all_success = false;
        }

        $stmt8->close();
    }

    //9.Multiple Certificate Details
    $user_id=$_SESSION["user_id"];
    $certificate_names=$_POST["certificate_name"] ?? [];
    $certificate_descriptions=$_POST["certificate_description"] ?? [];

    for ($i = 0; $i < count($certificate_names); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql9 = "INSERT INTO tbl_certificate (user_id,certificate_name,certificate_description,guid)
                 VALUES (?, ?, ?, ?)";

        $stmt9 = $conn->prepare($sql9);
        if (!$stmt9) {
            die("Prepare failed for certificate: " . $conn->error);
        }

        if (empty(trim($certificate_names[$i]))) {
            continue;
        }

        $stmt9->bind_param("ssss", $user_id,$certificate_names[$i],$certificate_descriptions[$i], $guid);

        if ($stmt9->execute()) {
            echo "certificate entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting certificate entry #$i: " . $stmt9->error;
            $all_success = false;
        }

        $stmt9->close();
    }

    //10. Multiple Awared Details
    $user_id=$_SESSION["user_id"];
    $award_names=$_POST["award_name"] ?? [];
    $award_dates=$_POST["award_date"]??[];
    $award_descriptions=$_POST["award_description"] ?? [];

    for ($i = 0; $i < count($award_names); $i++) {
        $guid = bin2hex(random_bytes(16));

        $sql10 = "INSERT INTO tbl_award (user_id,award_name,award_date,award_description,guid)
                 VALUES (?, ?, ?,?, ?)";

        $stmt10 = $conn->prepare($sql10);
        if (!$stmt10) {
            die("Prepare failed for award: " . $conn->error);
        }

        if (empty(trim($award_names[$i]))) {
            continue;
        }

        $stmt10->bind_param("sssss", $user_id,$award_names[$i],$award_dates[$i], $award_descriptions[$i], $guid);

        if ($stmt10->execute()) {
            echo "award entry $i inserted successfully!<br>";
        } else {
            echo "Error inserting award entry #$i: " . $stmt9->error;
            $all_success = false;
        }

        $stmt10->close();
    }

    //Insert Declaration Details
    $user_id=$_SESSION["user_id"];
    $declaration= clean_input($_POST['declaration']);
    $date=clean_input($_POST['dec_date']);
    $place= clean_input($_POST['dec_place']);
    $guid = bin2hex(random_bytes(16));

    $sql11 = "INSERT INTO tbl_declaration(user_id, declaration, place, date, guid)
                VALUES (?,?,?,?,? ) ";

    $stmt11 = $conn->prepare($sql11);
    if (!$stmt11) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt11->bind_param("sssss", $user_id, $declaration,$place,$date,$guid);

    if ($stmt11->execute()) {
        echo "Declaration Inserted Successfully!<br>";
    } else {
        echo "Error inserting declaration: " . $stmt11->error;
        $all_success = false;
    }
    $stmt11->close();
}
// Redirect if everything is successful
if ($all_success) {
    header("Location:view_resume.php");
    exit;
} else {
    echo "<p font-weight:bold;'> Some sections failed to save. Please review the errors above.</p>";
}

?>
