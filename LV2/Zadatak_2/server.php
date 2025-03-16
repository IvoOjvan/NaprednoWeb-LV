<?php

session_start();
$encryption_key = md5("m0J n3Ki kLjuc");

// Odaber cipher metodu AES
$cipher = 'AES-128-CTR';

// Stvori IV sa ispravnom dužinom
$iv_length = openssl_cipher_iv_length($cipher);
$options = 0;

// Generiraj siguran inicijalizacijski vektor (IV) - 16 byte
$encryption_iv = openssl_random_pseudo_bytes($iv_length);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['fileToUpload'])) {
        $upload_dir = 'uploads';
        if (!is_dir($upload_dir)) {
            if (!@mkdir($upload_dir, 0777, true)) {
                die("
                    <div class='alert alert-danger' role='alert'>
                        Failed to create directory: $dir
                    </div>
                ");
            }
        }

        $file = $_FILES['fileToUpload'];
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];

        if (in_array($file['type'], $allowed_types)) {
            $file_content = file_get_contents($file['tmp_name']);
            $encrypted_file = openssl_encrypt(
                $file_content,
                $cipher,
                $encryption_key,
                $options,
                $encryption_iv
            );

            if ($encrypted_file === false) {
                echo "<div class='alert alert-danger' role='alert'>Encryption failed!</div>";
                exit;
            }

            $filename = pathinfo($file['name'], PATHINFO_FILENAME);

            $encrypted_file_path = $upload_dir . '/' . $filename . ".enc";
            $key_file_path = $upload_dir . '/' . $filename . ".key";

            // Spremi kriptiranu datoteku i ključ
            if (!file_put_contents($encrypted_file_path, $encrypted_file)) {
                echo
                    "<div class='alert alert-danger' role='alert'>
                    Failed to save encrypted file.
                </div>";
            } else if (!file_put_contents($key_file_path, base64_encode($encryption_iv))) {
                echo "<div class='alert alert-danger' role='alert'>
                        Failed to save key.
                    </div>";
            } else {
                echo
                    "<div class='alert alert-success' role='alert'>
                    File encrypted successfully
                </div>";
            }

        } else {
            echo
                "<div class='alert alert-danger' role='alert'>
                    Unsuported file type!
                </div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>
        No file uploaded!
      </div>";
    }
}


?>