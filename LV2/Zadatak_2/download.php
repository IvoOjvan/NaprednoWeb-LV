<?php
$upload_dir = 'uploads/';
$decryption_key = md5("m0J n3Ki kLjuc");
$cipher = 'AES-128-CTR';
$options = 0;

$files = glob($upload_dir . "*.enc");

if (empty($files)) {
    echo "<p>No encrypted documents found.</p>";
    exit;
}

foreach ($files as $file) {
    $filename = basename($file, ".enc");
    $keyFile = $upload_dir . $filename . ".key";

    if (file_exists($keyFile)) {
        $decryption_iv = base64_decode(file_get_contents($keyFile));
        $encrypted_data = file_get_contents($file);

        $decrypted_data = openssl_decrypt(
            $encrypted_data,
            $cipher,
            $decryption_key,
            $options,
            $decryption_iv
        );

        if ($decrypted_data === false) {
            echo "<p>Error decrypting file: $filename</p>";
            continue;
        }

        // Spremi dekriptirani file
        $decrypted_file_path = $upload_dir . "decrypted_" . $filename;
        file_put_contents($decrypted_file_path, $decrypted_data);

        echo "<a href='$decrypted_file_path' download>Download $filename</a><br>";
    }
}

?>