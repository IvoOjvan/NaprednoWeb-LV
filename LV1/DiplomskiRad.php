<?php
require_once "iRadovi.php"; // Ensure the interface is included

class DiplomskiRad implements iRadovi
{
    private $id_rada;
    private $naziv_rada;
    private $tekst_rada;
    private $link_rada;
    private $oib_tvrtke;
    private $broj_stranice;

    function __construct($data)
    {
        $this->naziv_rada = $data['naziv_rada'];
        $this->tekst_rada = $data['tekst_rada'];
        $this->link_rada = $data['link_rada'];
        $this->oib_tvrtke = $data['oib_tvrtke'];
        $this->id_rada = $data['id_rada'];
        $this->broj_stranice = $data['broj_stranice'];
    }

    public static function create($data)
    {
        return new self($data);
    }

    public static function read($pdo, $page_number)
    {
        $q = "SELECT * FROM diplomski_radovi WHERE broj_stranice=:broj_stranice";
        $stmt = $pdo->prepare($q);
        $stmt->execute(['broj_stranice' => $page_number]);

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $item) {
            $rad = DiplomskiRad::create(
                array(
                    "id_rada" => $item["id_rada"],
                    "naziv_rada" => $item["naziv_rada"],
                    "tekst_rada" => $item["tekst_rada"],
                    "link_rada" => $item["link_rada"],
                    "oib_tvrtke" => $item["oib_tvrtke"],
                    "broj_stranice" => $item["broj_stranice"],
                )
            );
            $rad->print();
        }
    }

    function save($pdo)
    {
        // Check if the item already exists (e.g., by the 'id_rada' or 'link_rada')
        $checkQuery = "SELECT COUNT(*) FROM diplomski_radovi WHERE id_rada = :id_rada OR link_rada = :link_rada";
        $stmtCheck = $pdo->prepare($checkQuery);
        $stmtCheck->execute([
            'id_rada' => $this->id_rada,
            'link_rada' => $this->link_rada,
        ]);

        // Get the count of rows
        $existingCount = $stmtCheck->fetchColumn();

        if ($existingCount > 0) {
            return;
        }

        $q = "INSERT INTO diplomski_radovi (id_rada, naziv_rada, tekst_rada, link_rada, oib_tvrtke, broj_stranice) 
        VALUES (:id_rada, :naziv_rada, :tekst_rada, :link_rada, :oib_tvrtke, :broj_stranice)";
        $stmt = $pdo->prepare($q);
        $stmt->execute(
            array(
                'id_rada' => $this->id_rada,
                'naziv_rada' => $this->naziv_rada,
                'tekst_rada' => $this->tekst_rada,
                'link_rada' => $this->link_rada,
                'oib_tvrtke' => $this->oib_tvrtke,
                'broj_stranice' => $this->broj_stranice
            )
        );
    }

    function print()
    {
        echo "
        <div class='card mb-4 ms-4' style='width: 32rem;'>
        <div class='card-body'>
          <h5 class='card-title'>{$this->naziv_rada}</h5>
          <h6 class='card-subtitle mb-2 text-muted'>OIB Tvrtke: {$this->oib_tvrtke}</h6>
          <p class='card-text'>{$this->tekst_rada}</p>
          <a href='{$this->link_rada}' target='_blank' class='card-link'>Detalji</a>
        </div>
      </div>
      ";
    }
}
?>