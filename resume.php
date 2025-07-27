<?php
session_start();
?>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create Resume</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
  <style>
    body {
      background-image: url('bg1.jpg');
      background-size: cover;
      background-repeat: no-repeat;
    }
    .step-wrapper {
      display: flex;
      min-height: 80vh;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .left-panel {
      width: 30%;
      background-image: url("bg1.jpg");
      background-size: cover;
      color:black;
      padding: 2rem;
      border-top-left-radius: 10px;
      border-bottom-left-radius: 10px;
    }
    .left-panel h2 {
      color:black;
      margin-bottom: 2rem;
    }
    .left-panel ul {
      list-style: none;
      padding-left: 0;
    }
    .left-panel ul li {
      margin-bottom: 1.5rem;
      opacity: 0.6;
    }
    .left-panel ul li.active {
      font-weight: bold;
      opacity: 1;
    }
    .form-panel {
      width: 70%;
      padding: 2rem;
    }
    .step-section { display: none; }
    .step-section.active { display: block; }
    .mt-20 { margin-top: 20px; }
    .error-message {
      color: red;
      font-size: 0.85rem;
      margin-top: 0.25rem;
    }
    input.error, textarea.error, select.error {
      border-color: red;
    }
  </style>
</head>
<body>
  <section class="section">
    <div class="container">
      <div class="step-wrapper">
        <div class="left-panel">
          <h2 class="title is-3">Resume</h2>
          <p>Enter your information to get closer to companies.</p>
          <ul id="stepList">
            <li class="active">1. Personal Information</li>
            <li>2. Education Details</li>
            <li>3. Work Experience</li>
            <li>4. Skill </li>
            <li>5. Project </li>
            <li>6. Course </li>
            <li>7. Language </li>
            <li>8. Interest </li>
            <li>9. Certificate </li>
            <li>10. Award </li>
            <li>11. Declaration </li>
          </ul>
        </div>
        <div class="form-panel">
          <form id="resumeform" method="POST" action="submit-resume.php" enctype="multipart/form-data">
            <!-- Step 1: Personal Info -->
            <div class="step-section active" data-step="1">
              <h2 class="title is-4">Your Personal Information</h2>
              <p class="subtitle is-6">Enter your Personal Information to get closer to companies.</p>
              <div class="field">
                <label class="label" for="picture">Profile Picture*</label>
                <input class="input" type="file" name="picture" id="picture" required>
                <p class="error-message"></p>
              </div>
              <div class="columns">
                <div class="column">
                  <label class="label" for="first_name">First Name*</label>
                  <div class="control">
                    <input class="input" type="text" name="first_name" id="first_name" placeholder="First Name" required />
                    <p class="help is-danger error-message"></p>
                  </div>
                </div>
                <div class="column">
                  <label class="label" for="last_name">Last Name*</label>
                  <input class="input" type="text" name="last_name" id="last_name" placeholder="Last Name" required/>
                  <p class="error-message"></p>
                </div>
              </div>
              <div class="columns">
                <div class="column">
                  <label class="label" for="birthdate">Birthdate*</label>
                  <input class="input" type="date" name="birthdate" id="birthdate" required>
                  <p class="error-message"></p>
                </div>
                <div class="column">
                  <label class="label" for="gender">Gender*</label>
                  <div class="select is-fullwidth">
                    <select name="gender" required name="gender" id="gender">
                      <option value="disabled selected">--Select your gender--</option>
                      <option>Male</option>
                      <option>Female</option>
                      <option>Other</option>
                    </select>
                  </div>
                  <p class="error-message"></p>
                </div>
              </div>
              <div class="columns">
                <div class="column">
                  <label class="label" for="phone">Phone Number*</label>
                  <input class="input" type="number" name="phone" id="phone" placeholder="Phone Number" required/>
                  <p class="error-message"></p>
                </div>
                <div class="column">
                  <label class="label" for="email">Email</label>
                  <input class="input" type="email" name="email" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" readonly />
                  <p class="error-message"></p>
                </div>
              </div>
              <div class="columns">
                <div class="column">
                  <label class="label" for="nationality">Nationality*</label>
                  <input class="input" type="text" name="nationality" id="nationality" required>
                  <p class="error-message"></p>
                </div>
                <div class="column">
                  <label class="label" for="designation">Designation*</label>
                  <input class="input" type="text" name="designation" id="designation" required>
                  <p class="error-message"></p>
                </div>
              </div>
              <div class="columns">
                <div class="column">
                  <label class="label" for="address">Current Address*</label>
                  <textarea class="textarea is-small" name="address" id="address" required></textarea>
                  <p class="error-message"></p>
                </div>
                <div class="column">
                  <label class="label" for="description">Profile Description*</label>
                  <textarea class="textarea is-small" name="description" id="description" required></textarea>
                  <p class="error-message"></p>
                </div>
              </div>
              <div class="field">
                <label class="label" for="linkdin">LinkdIn Profile*</label>
                <input class="input" name="linkdin" id="linkdin" type="text" required />
                <p class="error-message"></p>
              </div>
              <div class="field">
                <label class="label" for="github">GitHub Profile*</label>
                <input class="input" name="github" id="github" type="text" required />
                <p class="error-message"></p>
              </div>

            </div>

            <!--Step 2 Education-->

            <div class="step-section" data-step="2">
              <h2 class="title is-4">Step 2: Education Details</h2>
              <p class="subtitle is-6">Enter your Education Details to get closer to companies.</p>
              <div class="field">
                <label class="label" for="educationCount">Number of Education details you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="educationCount" name="educationCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="educationInputs"></div>
            </div>
            <!--Step 3 Experience-->
            <div class="step-section" data-step="3">
              <h2 class="title is-4">Step 3: Experience</h2>
              <p class="subtitle is-6">Enter your Working Experience to get closer to companies.</p>
              <div class="field">
                <label class="label" for="educationCount">Number of  Working Experience you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="experienceCount" name="experienceCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="experienceInputs"></div>
            </div>
            <!--Step 4 Skill-->
            <div class="step-section" data-step="4">
              <h2 class="title is-4">Step 4: Skill</h2>
              <p class="subtitle is-6">Enter your Skill to get closer to companies.</p>
              <div class="field">
                <label class="label" for="skillCount">Number of Skill you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="skillCount" name="skillCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="skillInputs"></div>
            </div>
            <!--Step 5 Project-->
            <div class="step-section" data-step="5">
              <h2 class="title is-4">Step 5: Project</h2>
              <p class="subtitle is-6">Enter your Project to get closer to companies.</p>
              <div class="field">
                <label class="label" for="skillCount">Number of Project you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="projectCount" name="projectCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="projectInputs"></div>
            </div>
            <!--Step 6 Course-->
            <div class="step-section" data-step="6">
              <h2 class="title is-4">Step 6:Course </h2>
              <p class="subtitle is-6">Enter your Course to get closer to companies.</p>
              <div class="field">
                <label class="label" for="skillCount">Number of Course you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="courseCount" name="courseCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="courseInputs"></div>
            </div>
            <!--Step 7 Language-->
            <div class="step-section" data-step="7">
              <h2 class="title is-4">Step 7:Language </h2>
              <p class="subtitle is-6">Enter Language that you Know to get closer to companies.</p>
              <div class="field">
                <label class="label" for="languageCount">Number of Language you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="languageCount" name="languageCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="languageInputs"></div>
            </div>
            <!--Step 8 Interest-->
            <div class="step-section" data-step="8">
              <h2 class="title is-4">Step 8: Interest </h2>
              <p class="subtitle is-6">Enter Your Interest to get closer to companies.</p>
              <div class="field">
                <label class="label" for="interestCount">Number of Interest you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="interestCount" name="interestCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="interestInputs"></div>
            </div>
            <!--Step 9 Certificate-->
            <div class="step-section" data-step="9">
              <h2 class="title is-4">Step 9: Certificate </h2>
              <p class="subtitle is-6">Enter Your Certificates to get closer to companies.</p>
              <div class="field">
                <label class="label" for="certificateCount">Number of Certificates you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="certificateCount" name="certificateCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="certificateInputs"></div>
            </div>
            <!--Step 10 Award-->
            <div class="step-section" data-step="10">
              <h2 class="title is-4">Step 10: Award </h2>
              <p class="subtitle is-6">Enter Your Award to get closer to companies.</p>
              <div class="field">
                <label class="label" for="awardCount">Number of Award you want to Enter</label>
                <div class="control">
                  <div class="select">
                    <select id="awardCount" name="awardCount">
                      <option value="">Select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="awardInputs"></div>
            </div>
             <!--Step 11 Declaration-->
            <div class="step-section" data-step="11">
              <h2 class="title is-4">Step 11: Declaration </h2>
              <p class="subtitle is-6">Enter Declaration to get closer to companies.</p>
              <div class="field">
                <label class="label" for="declaration">Declaration*</label>
                <textarea class="textarea is-small" name="declaration" id="declaration" required ></textarea>
                <p class="error-message"></p>
              </div>
              <div class="columns">
                <div class="column">
                  <label class="label" for="dec_date">Date*</label>
                  <div class="control">
                    <input class="input" type="date" name="dec_date" id="dec_date" required />
                    <p class="help is-danger error-message"></p>
                  </div>
                </div>
                <div class="column">
                  <label class="label" for="dec_place">Place*</label>
                  <input class="input" type="text" name="dec_place" id="dec_place" required/>
                  <p class="error-message"></p>
                </div>
              </div>
            </div>


              <div class="buttons mt-20">
              <button type="button" class="button is-light" id="prevBtn">Previous</button>
              <button type="button" class="button is-link" id="nextBtn">Next</button>
              <button type="submit" class="button is-primary" id="submitBtn" style="display: none;">Submit</button>
            </div>
          </form>
      </div> 
    </div>          
  </section>         
 
  <script>

   
    let currentStep = 1;
    const stepList = document.querySelectorAll('#stepList li');
    const totalSteps = document.querySelectorAll('.step-section').length;

    const showStep = (step) => {
      document.querySelectorAll('.step-section').forEach((section) => {
      section.classList.remove('active');
        if (parseInt(section.dataset.step) === step) {
          section.classList.add('active');
        }
      });

      document.querySelectorAll('#stepList li').forEach((li, index) => {
        li.classList.toggle('active', index === (step - 1));
      });

      document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'inline-block';
      document.getElementById('nextBtn').style.display = step === totalSteps ? 'none' : 'inline-block';
      document.getElementById('submitBtn').style.display = step === totalSteps ? 'inline-block' : 'none';
    };

    $(document).ready(function () {
       // Autofill declaration date with today's date
      $('input[name="dec_date"]').val(new Date().toISOString().split('T')[0]);

      const form = $('#resumeform');
      $.validator.addMethod("validPhone",function(value,element){
        return this.optional(element) || /^\d{10}$/.test(value);
      }, "Please enter a valid 10-digit phone number.");

      $.validator.addMethod("validLinkedIn", function (value, element) {
        return this.optional(element) || /linkedin\.com\/.+$/i.test(value);
      }, "Please enter a valid LinkedIn profile URL (e.g., linkedin.com/in/username)");

      $.validator.addMethod("validGitHub", function (value, element) {
        return this.optional(element) || /github\.com\/[A-Za-z0-9_-]+\/?$/i.test(value);
      }, "Please enter a valid GitHub profile URL (e.g., github.com/username)");


      form.validate({
        errorClass: 'error-message',
        errorPlacement: function (error, element) {
          error.insertAfter(element);
        },
        rules: {
          phone: {
            required: true,
            validPhone: true
          },
          linkdin: {
            required: true,
            validLinkedIn: true
          },
          github: {
            required: true,
            validGitHub: true
          }
        }
      });

      $('#nextBtn').click(function () {
        const currentSection = $('.step-section[data-step="' + currentStep + '"]');
        if (form.valid()) {
          currentStep++;
          showStep(currentStep);
        }
      });

      $('#prevBtn').click(function () {
        currentStep--;
        showStep(currentStep);
      });

      $('#submitBtn').click(function (e) {
        if (!form.valid()) {
          e.preventDefault();
        }
      });
      showStep(currentStep);
    });

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('birthdate').setAttribute('max',today);

    

    function addStartEndDateValidation(startId, endId) {
      const startInput = document.getElementById(startId);
      const endInput = document.getElementById(endId);
      const errorMsg=endInput.parentElement.querySelector('.error-message');

      function compareDates() {
        if (startInput.value && endInput.value && Date.parse(endInput.value) < Date.parse(startInput.value)) {
          errorMsg.textContent ="End date should be greater than Start date";
          endInput.value = "";
        }else{
          errorMsg.textContent="";
        }
      }

      startInput.addEventListener('change', compareDates);
      endInput.addEventListener('change', compareDates);
    }

      document.getElementById('educationCount').addEventListener('change', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('educationInputs');
        container.innerHTML = '';
        for (var i = 1; i <= count; i++) {
          container.innerHTML += `
            <div class="field">
              <label class="label" for="collage_name">School/Collage/Univercity Name*</label>
              <input class="input" name="collage_name[]" id="collage_name_${i}" type="text" required />
              <p class="error-message"></p>
            </div>
            <div class="columns">
              <div class="column">
                <label class="label" for="degree_name">Degree Name*</label>
                <input class="input" type="text" name="degree_name[]" id="degree_name_${i}" required />
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="cgpa">Gread/CGPA*</label>
                <input class="input" type="text" name="cgpa[]" id="cgpa_${i}" required />
                <p class="error-message"></p>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <label class="label" for="start_date">Start Date*</label>
                <input class="input" type="date" name="start_date[]" id="start_date_${i}" required />
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="end_date">End Date*</label>
                <input class="input" type="date" name="end_date[]" id="end_date_${i}" required />
                <p class="error-message" ></p>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <label class="label" for="city">City*</label>
                <input class="input" type="text" name="city[]" id="city_${i}" required/>
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="state">State*</label>
                <input class="input" type="text" name="state[]" id="state_${i}" required />
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="country">Country*</label>
                <input class="input" type="text" name="country[]" id="country_${i}" required/>
                <p class="error-message"></p>
              </div>
            </div>
            <div class="field">
              <label class="label" for="education_description">Education Description*</label>
              <textarea class="textarea is-small" name="education_description[]" id="education_description_${i}" required ></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
            `;
        }
        
        for (let i = 1; i <= count; i++) {
          addStartEndDateValidation(`start_date_${i}`, `end_date_${i}`);
        } 
      });

      //Step 3 Experiance
      document.getElementById('experienceCount').addEventListener('change', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('experienceInputs');
        container.innerHTML = '';
        for (var i = 1; i <= count; i++) {
          container.innerHTML += `
            <div class="field">
              <label class="label" for="compney_name">Compney Name</label>
              <input class="input" name="compney_name[]" id="compney_name_${i}" type="text" />
              <p class="error-message"></p>
            </div>
            <div class="columns">
              <div class="column">
                <label class="label" for="job_title">Job Title</label>
                <input class="input" type="text" name="job_title[]" id="job_title_${i}" />
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="exp_designation">Designation</label>
                <input class="input" type="text" name="exp_designation[]" id="exp_designation_${i}"/>
                <p class="error-message"></p>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <label class="label" for="exp_start_date">Start Date</label>
                <input class="input" type="date" name="exp_start_date[]" id="exp_start_date_${i}" />
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="exp_end_date">End Date</label>
                <input class="input" type="date" name="exp_end_date[]" id="exp_end_date_${i}" />
                <p class="error-message" ></p>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <label class="label" for="exp_city">City</label>
                <input class="input" type="text" name="exp_city[]" id="exp_city_${i}" />
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="exp_state">State</label>
                <input class="input" type="text" name="exp_state[]" id="exp_state_${i}" />
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="exp_country">Country</label>
                <input class="input" type="text" name="exp_country[]" id="exp_country_${i}"/>
                <p class="error-message"></p>
              </div>
            </div>
            <div class="field">
              <label class="label" for="exp_description">Experience Description</label>
              <textarea class="textarea is-small" name="exp_description[]" id="exp_description_${i}" ></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
            `;
        }
        
        for (let i = 1; i <= count; i++) {
          addStartEndDateValidation(`exp_start_date_${i}`, `exp_end_date_${i}`);
        } 
      });
      //4. Skill
      document.getElementById('skillCount').addEventListener('change', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('skillInputs');
        container.innerHTML = '';
        for (var i = 1; i <= count; i++) {
          container.innerHTML += `
            <div class="field">
              <label class="label" for="skill_name">Skill Name*</label>
              <input class="input" name="skill_name[]" id="skill_name_${i}" type="text" required />
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="skill_description"> Description </label>
              <textarea class="textarea is-small" name="skill_description[]" id="skill_description_${i}" ></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
            `;
        }
      });
      //5. Project
      document.getElementById('projectCount').addEventListener('change', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('projectInputs');
        container.innerHTML = '';
        for (var i = 1; i <= count; i++) {
          container.innerHTML += `
            <div class="field">
              <label class="label" for="project_title">Project Title*</label>
              <input class="input" name="project_title[]" id="project_title_${i}" type="text" required />
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="project_sub_title">Sub Title</label>
              <input class="input" name="project_sub_title[]" id="project_sub_title_${i}" type="text"/>
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="project_description"> Description </label>
              <textarea class="textarea is-small" name="project_description[]" id="project_description_${i}" ></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
            `;
        }
      });
      //6.Course
      document.getElementById('courseCount').addEventListener('change', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('courseInputs');
        container.innerHTML = '';
        for (var i = 1; i <= count; i++) {
          container.innerHTML += `
            <div class="field">
              <label class="label" for="course_name">Course Name</label>
              <input class="input" name="course_name[]" id="course_name_${i}" type="text"/>
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="organization_name">Organization Name</label>
              <input class="input" type="text" name="organization_name[]" id="organization_name_${i}"/>
              <p class="error-message"></p>
            </div>
              
            <div class="columns">
              <div class="column">
                <label class="label" for="cou_start_date">Start Date</label>
                <input class="input" type="date" name="cou_start_date[]" id="cou_start_date_${i}"/>
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="cou_end_date">End Date</label>
                <input class="input" type="date" name="cou_end_date[]" id="cou_end_date_${i}"/>
                <p class="error-message" ></p>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <label class="label" for="cou_city">City</label>
                <input class="input" type="text" name="cou_city[]" id="cou_city_${i}"/>
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="cou_state">State</label>
                <input class="input" type="text" name="cou_state[]" id="cou_state_${i}"/>
                <p class="error-message"></p>
              </div>
              <div class="column">
                <label class="label" for="cou_country">Country</label>
                <input class="input" type="text" name="cou_country[]" id="cou_country_${i}"/>
                <p class="error-message"></p>
              </div>
            </div>
            <div class="field">
              <label class="label" for="cou_description">Course Description</label>
              <textarea class="textarea is-small" name="cou_description[]" id="cou_description_${i}" ></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
            `;
        }
        
        for (let i = 1; i <= count; i++) {
          addStartEndDateValidation(`cou_start_date_${i}`, `cou_end_date_${i}`);
        } 
      });
      //7. Language
      document.getElementById('languageCount').addEventListener('change', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('languageInputs');
        container.innerHTML = '';
        for (var i = 1; i <= count; i++) {
          container.innerHTML += `
            <div class="field">
              <label class="label" for="language_name">Language*</label>
              <input class="input" name="language_name[]" id="language_name_${i}" type="text" required />
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="language_description"> Description </label>
              <textarea class="textarea is-small" name="language_description[]" id="language_description_${i}" ></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
            `;
        }
      });
      //8.Interest
      document.getElementById('interestCount').addEventListener('change', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('interestInputs');
        container.innerHTML = '';
        for (var i = 1; i <= count; i++) {
          container.innerHTML += `
            <div class="field">
              <label class="label" for="interest_name">Interest*</label>
              <input class="input" name="interest_name[]" id="interest_name_${i}" type="text" required />
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="interest_description"> Description </label>
              <textarea class="textarea is-small" name="interest_description[]" id="interest_description_${i}" ></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
            `;
        }
      });
      //9.Certificate
      document.getElementById('certificateCount').addEventListener('change', function () {
        const count = parseInt(this.value);
        const container = document.getElementById('certificateInputs');
        container.innerHTML = '';
        for (var i = 1; i <= count; i++) {
          container.innerHTML += `
            <div class="field">
              <label class="label" for="certificate_name">Certificate</label>
              <input class="input" name="certificate_name[]" id="certificate_name_${i}" type="text" />
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="certificate_description"> Description </label>
              <textarea class="textarea is-small" name="certificate_description[]" id="certificate_description_${i}" ></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
            `;
        }
      });
      //10.award
      document.getElementById('awardCount').addEventListener('change', function () {
        const count= parseInt(this.value);
        const container = document.getElementById('awardInputs');
        container.innerHTML = '';
        for (let i = 1; i <= count; i++) {
        container.innerHTML += `
            <div class="field">
              <label class="label" for="award_name_${i}">Award Name</label>
              <input class="input" name="award_name[]" id="award_name_${i}" type="text" />
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="award_date_${i}">Date</label>
              <input class="input" name="award_date[]" id="award_date_${i}" type="date"/>
              <p class="error-message"></p>
            </div>
            <div class="field">
              <label class="label" for="award_description_${i}">Description</label>
              <textarea class="textarea is-small" name="award_description[]" id="award_description_${i}"></textarea>
              <p class="error-message"></p>
            </div>
            <hr>
          `;
        }
      });
  </script>
</body>
</html>