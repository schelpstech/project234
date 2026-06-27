<?php

class Utility
{
  public function generateRandomString($length)
  {
    return $this->randomFromAlphabet((int) $length, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
  }

  public function generateRandomText($length)
  {
    return $this->randomFromAlphabet((int) $length, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
  }

  public function generateRandomDigits($length)
  {
    return $this->randomFromAlphabet((int) $length, '1234567890');
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
    return preg_replace('/[^A-Za-z0-9._-]/', '', (string) $str);
  }

  public function notifier($notification_alert, $notification_message)
  {
    $allowedAlerts = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
    $alert = in_array($notification_alert, $allowedAlerts, true) ? $notification_alert : 'info';
    $message = $this->escape((string) $notification_message);

    $_SESSION['msg'] = '<div class="alert bg-gradient-' . $alert . ' alert-dismissible text-sm text-white fade show" role="alert">
                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text"><strong>Response!</strong> ' . $message . '</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>';
  }

  public function handleUploadedFile($inputName, $allowedTypes, $maxFileSize, $uploadPath)
  {
    unset($_SESSION['fileName']);

    if (!isset($_FILES[$inputName]) || !is_array($_FILES[$inputName])) {
      return "No file was uploaded.";
    }

    $file = $_FILES[$inputName];
    $fileTmpName = $file['tmp_name'] ?? '';
    $fileSize = (int) ($file['size'] ?? 0);
    $fileError = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
    $allowedTypes = array_map('strtolower', (array) $allowedTypes);

    if ($fileError !== UPLOAD_ERR_OK) {
      return $this->uploadErrorMessage($fileError);
    }

    if ($fileSize <= 0) {
      return "The uploaded file is empty.";
    }

    if ($fileSize > (int) $maxFileSize) {
      return "File size is too large. Please upload a file smaller than " . (int) $maxFileSize . " bytes.";
    }

    if (!is_uploaded_file($fileTmpName)) {
      return "Invalid upload request.";
    }

    $detectedType = $this->detectMimeType($fileTmpName);
    if (!in_array($detectedType, $allowedTypes, true)) {
      return "Invalid file type. Please upload a file in the required format.";
    }

    $extension = $this->extensionForMimeType($detectedType);
    if ($extension === '') {
      return "Unsupported file type.";
    }

    if (!is_dir($uploadPath) && !mkdir($uploadPath, 0755, true)) {
      return "Upload folder is not available.";
    }

    if (!is_writable($uploadPath)) {
      return "Upload folder is not writable.";
    }

    $saveFileName = $this->generateRandomString(24) . '.' . $extension;
    $destination = rtrim($uploadPath, '/\\') . DIRECTORY_SEPARATOR . $saveFileName;

    if (move_uploaded_file($fileTmpName, $destination)) {
      @chmod($destination, 0644);
      $_SESSION['fileName'] = $saveFileName;
      return "success";
    }

    return "There was an error uploading the file.";
  }

  public function calculateAge($birthdate)
  {
    $birthDateObj = new DateTime($birthdate);
    $currentDateObj = new DateTime();
    $ageInterval = $currentDateObj->diff($birthDateObj);

    return $ageInterval->y;
  }

  public function inputEncode($input)
  {
    return bin2hex(base64_encode((string) $input));
  }

  public function inputDecode($encodedData)
  {
    $binary = @hex2bin((string) $encodedData);
    if ($binary === false) {
      return false;
    }

    return base64_decode($binary, true);
  }

  public function encodePassword($input)
  {
    return $this->hashPassword($input);
  }

  public function hashPassword($input)
  {
    return password_hash((string) $input, PASSWORD_DEFAULT);
  }

  public function verifyPassword($inputPassword, $storedHashedPassword)
  {
    return $this->isPasswordHash($storedHashedPassword)
      && password_verify((string) $inputPassword, (string) $storedHashedPassword);
  }

  public function isPasswordHash($storedPassword)
  {
    $info = password_get_info((string) $storedPassword);
    return !empty($info['algo']);
  }

  public function passwordNeedsRehash($storedPassword)
  {
    return $this->isPasswordHash($storedPassword)
      && password_needs_rehash((string) $storedPassword, PASSWORD_DEFAULT);
  }

  public function verifySchoolPassword($inputPassword, $storedPassword)
  {
    $inputPassword = (string) $inputPassword;
    $storedPassword = (string) $storedPassword;

    if ($this->verifyPassword($inputPassword, $storedPassword)) {
      return true;
    }

    $legacyDecoded = $this->inputDecode($storedPassword);
    return hash_equals($storedPassword, $inputPassword)
      || ($legacyDecoded !== false && hash_equals((string) $legacyDecoded, $inputPassword))
      || hash_equals($storedPassword, $this->inputEncode($inputPassword));
  }

  public function verifyAdminPassword($inputPassword, $storedPassword)
  {
    $inputPassword = (string) $inputPassword;
    $storedPassword = (string) $storedPassword;

    if ($this->verifyPassword($inputPassword, $storedPassword)) {
      return true;
    }

    $decoded = @convert_uudecode($storedPassword);
    return is_string($decoded) && hash_equals($decoded, $inputPassword);
  }

  public function shouldMigratePassword($storedPassword)
  {
    return !$this->isPasswordHash($storedPassword) || $this->passwordNeedsRehash($storedPassword);
  }

  public function escape($value)
  {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  }

  private function randomFromAlphabet(int $length, string $alphabet)
  {
    $length = max(1, $length);
    $max = strlen($alphabet) - 1;
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $alphabet[random_int(0, $max)];
    }

    return $randomString;
  }

  private function detectMimeType($path)
  {
    if (class_exists('finfo')) {
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $mimeType = $finfo->file($path);
      if (is_string($mimeType) && $mimeType !== '') {
        return strtolower($mimeType);
      }
    }

    if (function_exists('mime_content_type')) {
      return strtolower((string) mime_content_type($path));
    }

    return '';
  }

  private function extensionForMimeType($mimeType)
  {
    $extensions = [
      'image/jpeg' => 'jpg',
      'image/png' => 'png',
      'image/gif' => 'gif',
      'application/pdf' => 'pdf',
    ];

    return $extensions[strtolower((string) $mimeType)] ?? '';
  }

  private function uploadErrorMessage($errorCode)
  {
    $messages = [
      UPLOAD_ERR_INI_SIZE => 'The uploaded file is larger than the server allows.',
      UPLOAD_ERR_FORM_SIZE => 'The uploaded file is larger than the form allows.',
      UPLOAD_ERR_PARTIAL => 'The file was only partially uploaded.',
      UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
      UPLOAD_ERR_NO_TMP_DIR => 'The server upload folder is missing.',
      UPLOAD_ERR_CANT_WRITE => 'The server could not write the uploaded file.',
      UPLOAD_ERR_EXTENSION => 'A server extension stopped the upload.',
    ];

    return $messages[$errorCode] ?? 'There was an error uploading the file.';
  }
}

?>
