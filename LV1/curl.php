<?php

require_once 'simple_html_dom.php'; // Include the library
require 'DiplomskiRad.php';

$page_number = '2';
if (isset($_POST['page_number'])) {
    $page_number = $_POST['page_number'];
    //echo "<p>Page Number: " . $page_number . "</p>";
}

$url = "https://stup.ferit.hr/index.php/zavrsni-radovi/page/" . $page_number . "/"; // Dynamically set the page number in the URL

$html = new simple_html_dom();
$html->load_file($url);

$items = $html->find("article");

try {
    $pdo = new PDO(
        'mysql:dbname=radovi;host=localhost',
        'admin',
        'admin'
    );

} catch (PDOException $e) {
    echo '<p>Dogodila se iznimka: ' . $e->getMessage() . '</p>';
}

foreach ($items as $item) {
    //echo $item;

    // Extract elements
    $item_title = $item->find("h2.blog-shortcode-post-title.entry-title a", 0)->plaintext;
    $item_text = $item->find("div.fusion-post-content-container p", 0)->plaintext;
    $item_link = $item->find("a.fusion-rollover-title-link", 0)->href;

    $item_img_src = $item->find("img", 0)->src;
    preg_match('/(\d+)\.png$/', $item_img_src, $matches);
    $item_firm = $matches[1];

    preg_match('/\d+$/', $item->id, $matches);
    $item_id = $matches[0];

    $data = array(
        'naziv_rada' => $item_title,
        'tekst_rada' => $item_text,
        'link_rada' => $item_link,
        'oib_tvrtke' => $item_firm,
        'id_rada' => $item_id,
        'broj_stranice' => $page_number
    );

    $rad = DiplomskiRad::create($data);

    // Spremi rad
    $rad->save($pdo);
}

// Ispisi sve radove
DiplomskiRad::read($pdo, $page_number);

unset($pdo);
?>