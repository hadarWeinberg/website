<!DOCTYPE html>

<?php
    // Include DB config file
    require_once "db_credentials.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Define variables and initialize with empty values
        $name = trim($_POST["name"]);
        $last_name = trim($_POST["last_name"]);
        $address = trim($_POST["address"]);
        $city = trim($_POST["city"]);
        $zip = trim($_POST["zip"]);
        $state = trim($_POST["state"]);
        $phone = trim($_POST["phone"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $height = trim($_POST["height"]);
        $skin = trim($_POST["skin"]);
        $eyes = trim($_POST["eyes"]);
        $hair = trim($_POST["hair"]);
        $body = trim($_POST["body"]);
        $gender = trim($_POST["gender"]);
        $experience = trim($_POST["experience"]);
        
        if (empty($name) || empty($last_name) || empty($email) || empty($address) || empty($city) || empty($zip) || empty($state) || empty($phone) || empty($password) || empty($height) || empty($experience)) {
            $err = "יש למלא את כל השדות בטופס ההרשמה";
        }
        else {
            $sql = "SELECT * FROM users WHERE email = '$email'";

            $result = $connection->query($sql);
            // Check if email exists, if yes print error
            if ($result->num_rows > 0) {
                $err = "אימייל זה כבר קיים במערכת.";
            }
            else {
                $uppercase = preg_match('@[A-Z]@', $password);
                $lowercase = preg_match('@[a-z]@', $password);
                $number = preg_match('@[0-9]@', $password);
                $specialChars = preg_match('@[^\w]@', $password);
            
                if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6) {
                    $err ="סיסמא צריכה להכיל לפחות אות אחת גדולה, אות אחת קטנה, מספר, סימן מיוחד ולהיות באורך 6 ומעלה.";
                }
                else {
                    $file1 = $_FILES['productImage1']['tmp_name'];
                    if (is_uploaded_file($file1)) {
                        $check = getimagesize($file1);
                        if ($check !== false) {
                            $file_type = pathinfo($file1, PATHINFO_EXTENSION);
                            $data = file_get_contents($file1);
                            $productImage1 = 'data:image/' . $file_type . ';base64,' . base64_encode($data);
                        } else {
                            $err = "אחד או יותר מהקבצים שהועלו אינו תמונה";
                        }                        
                    } 
                    
                    $file2 = $_FILES['productImage2']['tmp_name'];
                    if (is_uploaded_file($file2)) {
                        $check = getimagesize($file2);
                        if ($check !== false) {
                            $file_type = pathinfo($file2, PATHINFO_EXTENSION);
                            $data = file_get_contents($file2);
                            $productImage2 = 'data:image/' . $file_type . ';base64,' . base64_encode($data);
                        } else {
                            $err = "אחד או יותר מהקבצים שהועלו אינו תמונה";
                        }                        
                    } 
                    
                    $file3 = $_FILES['productImage3']['tmp_name'];
                    if (is_uploaded_file($file3)) {
                        $check = getimagesize($file3);
                        if ($check !== false) {
                            $file_type = pathinfo($file3, PATHINFO_EXTENSION);
                            $data = file_get_contents($file3);
                            $productImage3 = 'data:image/' . $file_type . ';base64,' . base64_encode($data);
                        } else {
                            $err = "אחד או יותר מהקבצים שהועלו אינו תמונה";
                        }                        
                    }
                    
                    
                    if (empty($err)) {
                        $encrypted_password = password_hash($password, PASSWORD_DEFAULT); // encrypt password before saving to db
                        
                        $query = "INSERT INTO users (name, last_name, address, city, zip, state, phone, email, password, height, skin, eyes, hair, body, gender, experience, product_image_1, product_image_2, product_image_3) VALUES ('".$name."', '".$last_name."', '".$address."', '".$city."', '".$zip."', '".$state."', '".$phone."', '".$email."', '".$encrypted_password."', '".$height."', '".$skin."', '".$eyes."', '".$hair."', '".$body."', '".$gender."', '".$experience."', '".$productImage1."', '".$productImage2."', '".$productImage3."')";
                        
                        if ($connection->query($query) == FALSE)
                        {
                            echo "<script> 
                                alert('משהו השתבש בעת ההרשמה. אנא נסה שוב מאוחר יותר. $connection->error); 
                            </script>";
                        } 
                        else //User was created successfully, popup message, start a new session and redirect to main page
                        {
                            $query = "SELECT id FROM users WHERE email = '$email'";
                            $result = $connection->query($query);
                            if ($result->num_rows > 0)
                            {
                                //if email exist, verify password
                                $row = $result->fetch_assoc();
                                $userId = $row["id"];
                                
                                session_start();
                                $_SESSION["loggedin"] = true;
                                $_SESSION["user-id"] = $userId;
                                $_SESSION["name"] = $name;
                                $_SESSION["last_name"] = $last_name;
                                
                                echo "<script>
                                    sessionStorage.setItem('user-id', '$userId');
                                    sessionStorage.setItem('name', '$name');
                                    sessionStorage.setItem('last_name', '$last_name');
                                    alert('ההרשמה בוצעה בהצלחה!');
                                    window.location.href='/index.html';
                                 </script>";    
                            }
                        }
                    }
                }
            }
        }
    }
    
?>

<html lang="he-IL" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/form.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
  

  <title>הרשמה</title>
  
  <script src="../js/jquery.js"></script>
  <script src="../js/jquery-ui.min.js"></script>
   
      
  <main>
       <div id="menu" >
        
      </div>
     <script>
         $("menu").load("../Includes/menu.html")
     </script>
    
    <h1>הרשמה לאתר</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
      <div class="row container-fluid">
        <div class="col-lg-8 wrapper">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <h3>פרטים אישיים:</h3>
                <div class="form-group">
                    <label for="name"> שם פרטי</label>
                    <input type="text" id="name" name="name" placeholder="" value="<?php echo $name; ?>" required>
                </div>

                <div class="form-group">
                    <label for="last_name"> שם משפחה:</label>
                    <input type="text" id="last_name" name="last_name" placeholder="" value="<?php echo $last_name; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="address"> כתובת:</label>
                    <input type="text" id="address" name="address" placeholder="" value="<?php echo $address; ?>" required>
                </div>

                <div class="form-group">
                    <label for="city"> עיר:</label>
                    <input type="text" id="city" name="city" placeholder="" value="<?php echo $city; ?>" required>
                </div>

                <div class="form-group">
                    <label for="zip">מיקוד:</label>
                    <input type="text" id="zip" name="zip" placeholder="10001"  value="<?php echo $zip; ?>" required>
                </div>

                <div class="form-group">
                    <label for="state">ארץ:</label>
                    <input type="text" id="state" name="state" placeholder="" value="<?php echo $state; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">טלפון:</label>
                    <input type="text" id="phone" name="phone" placeholder="******-*05" value="<?php echo $phone; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email"> אימייל:</label>
                    <input type="email" id="email" name="email" placeholder="example@example.com" value="<?php echo $email; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">סיסמה:</label>
                    <input type="password" id="password" name="password" title="סיסמא צריכה להכיל לפחות אות אחת גדולה, אות אחת קטנה, מספר, סימן מיוחד ולהיות באורך 6 ומעלה."; required>
                    <span class="glyphicon glyphicon-info-sign" title="סיסמא צריכה להכיל לפחות אות אחת גדולה, אות אחת קטנה, מספר, סימן מיוחד ולהיות באורך 6 ומעלה.";></span>
                </div>
              </div>

              <div class="col-sm-6">
                <h3>תכונות:</h3>

                <div class="form-group">
                    <label for="height">גובה:</label>
                    <input type="text" id="height" name="height" placeholder="cm"  value="<?php echo $height; ?>" required>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                        <label id="c2" for="skin">צבע עור:</label>
                        <select id="c2" name="skin" size="1" required>
                            <option value="בהיר">בהיר</option>
                            <option value="כהה">כהה</option>
                    	    <option value="שזוף">שזוף</option>
                        </select>
                    </div>
                  </div>
                  <br>

                  <div class="col-lg-12">
                      <div class="form-group">
                          <label id="c2" for="eyes">צבע עיניים:
                          <select id="c2" name="eyes" size="1" required>
                            <option value="ירוקות">ירוקות</option>
                            <option value="כחולות">כחולות</option>
                            <option value="חומות">חומות</option>
                            <option value="שחורות">שחורות</option>
                            <option value="דבש">דבש</option>
                            <option value="אפור">אפור</option>
                          </select>
                      </div>
                  </div>
                  <br>

                  <div class="col-lg-12">
                    <div class="form-group">
                        <label id="c2" for="hair">צבע שיער:</label>
                        <select id="c2" name="hair" size="1" required>
                          <option value="בלונד"> בלונד</option>
                          <option value="חום">חום</option>
                          <option value="שחור">שחור</option>
                          <option value="אדום">אדום</option>
                          <option value="סגול">סגול</option>
                          <option value="ורוד">ורוד</option>
                          <option value="אפור">אפור</option>
                          <option value="לבן">לבן</option>
                        </select>
                    </div>
                  </div>


                  <div class="col-lg-12">
                      <div class="form-group">
                        <label id="c2" for="body">מבנה גוף:</label>
                        <select id="c2" name="body" size="1" required>
                          <option value="רזה">רזה</option>
                          <option value="מלא">מלא</option>
                          <option value="ממוצע">ממוצע</option>
                        </select>
                      </div>
                  </div>


                  <div class="col-lg-12">
                      <div class="form-group">
                        <label id="c2" for="gender">מין:</label>
                        <select id="c2" name="gender" size="1" required>
                          <option value="נקבה">נקבה</option>
                          <option value="זכר">זכר</option>
                          <option value="אחר">אחר</option>
                        </select>
                      </div>
                  </div>

                  <div class="col -lg-12">
                    <br>
                    <h6>העלאת 3 תמונות:</h6>

                    <div class="form-group">
                        <input type="file" id="productImage1" name="productImage1" class="txtBox" value="<?php echo $_SESSION["file1"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="file" id="productImage2" name="productImage2" class="txtBox" value="<?php echo $_SESSION["file2"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="file" id="productImage3" name="productImage3" class="txtBox" value="<?php echo $_SESSION["file3"]; ?>" required>
                    </div>

                  </div>
                  <div class="col-lg-12">
                    <br>
                    <div class="form-group">
                        <label for="experience">ניסיון:</label>
                        <textarea id="experience" name="experience" rows="4" cols="50" value="<?php echo $experience; ?>"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <label id="c2">
                  <input type="checkbox" checked="checked" name="sameadr" required> אני מסכימ/ה לתנאי השימוש באתר ובכפוף לתקנון
                </label>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                    <input type="submit" class="b" value="שלח">
                </div>
              </div>
              <span class="help-block" style="color: red; font-weight: 700; font-size:18px;"><?php echo $err; ?></span>
            </div>
          </div>
        </div>
      </div>
    </form>
  </main>

</head>

<body>

</body>

</html>
