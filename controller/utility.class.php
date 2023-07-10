<?php
class Utility
{
  public function generateRandomString($length)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function generateRandomText($length)
  {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
  /**
   * Summary of generateRandomDigits
   * @param mixed $length
   * @return string
   */
  public function generateRandomDigits($length)
  {
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function dayinterval($start, $end)
  {
    $interval = date_diff($start, $end);
    return $interval->format('%R%a days');
  }
  public function money($amount)
  {
    $regex = "/\B(?=(\d{3})+(?!\d))/i";
    return "&#8358;" . preg_replace($regex, ",", $amount);
  }

  public function grader($score)
  {
    if ($score >= 75) {
      $grade = "A";
      $remarks = "Excellent";
    } elseif ($score >= 65) {
      $grade = "B";
      $remarks = "Very Good";
    } elseif ($score >= 50) {
      $grade = "C";
      $remarks = "Moderate";
    } elseif ($score >= 45) {
      $grade = "D";
      $remarks = "Fair";
    } elseif ($score >= 40) {
      $grade = "E";
      $remarks = "Needs Help";
    } else {
      $grade = "F";
      $remarks = "Needs Help";
    }
    return $grade . "  -  " . $remarks;
  }

  public function RemoveSpecialChar($str)
  {
    $result = str_replace(array('\'', '"', ',', ';', '<', '>', '/'), '', $str);
    return $result;
  }

  public function notifier($notification_alert, $notification_message)
  {
    $result = '<div class="alert bg-gradient-' . $notification_alert . ' alert-dismissible text-sm  text-white  fade show" role="alert">
                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text"><strong>Response!</strong> ' . $notification_message . '</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>';
    $_SESSION['msg'] = $result;
  }


  /**
   * Summary of handleUploadedFile
   * @param mixed $inputName
   * @param mixed $allowedTypes
   * @param mixed $maxFileSize
   * @param mixed $uploadPath
   * @return string
   */
  public function handleUploadedFile($inputName, $allowedTypes, $maxFileSize, $uploadPath) {
    $file = $_FILES[$inputName];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];
  
    // Check if there was an error uploading the file
    if ($fileError !== UPLOAD_ERR_OK) {
      return "There was an error uploading the file.";
    }
  
    // Check if the file type is allowed
    if (!in_array($fileType, $allowedTypes)) {
      return "Invalid file type. Please upload an image file.";
    }
  
    // Check if the file size is within the limit
    if ($fileSize > $maxFileSize) {
      return "File size is too large. Please upload a file smaller than " . $maxFileSize . " bytes.";
    }

    
    $utility =new Utility();
    $saveFileName = ($utility->generateRandomString(8)).($utility->RemoveSpecialChar($fileName));
    // Move the uploaded file to the designated folder
    if (move_uploaded_file($fileTmpName, $uploadPath . '/' . $saveFileName)) {
      $_SESSION['fileName'] = $saveFileName;
      return "success";
    } else {
      return "There was an error uploading the file.";
    }
  }

  /**
   * Summary of calculateAge
   * @param mixed $birthdate
   * @return int
   */
  public function calculateAge($birthdate) {
    // Create DateTime objects for the birthdate and current date
    $birthDateObj = new DateTime($birthdate);
    $currentDateObj = new DateTime();

    // Calculate the difference between the two dates
    $ageInterval = $currentDateObj->diff($birthDateObj);

    // Return the calculated age
    return $ageInterval->y;
}
  

}

?>