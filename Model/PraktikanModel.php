<?php

class PraktikanModel{
    /**
     * Function get berfungsi untuk mengambil seluruh data praktikan
     * @param integer id berisi id praktikan
     */

    public function get($id)
    {
        $sql = "SELECT * FROM praktikan WHERE id = $id";
        $query = koneksi()->query($sql);
        return $query->fetch_assoc();
    }

    /**
     * Function index berfungsi untuk mengatur tampilan awal halaman praktikan
     */

    public function index()
    {
        $id = $_SESSION['praktikan']['id'];
        $data = $this->get($id);
        extract($data);
        require_once("View/praktikan/index.php");
    }

    /**
     * Function getPraktikum berfungsi untuk mengambil seluruh data praktikum yang aktif
     */

    public function getPraktikum()
    {
        $sql = "SELECT * FROM praktikum WHERE status = 1";
        $query = koneksi()->query($sql);
        $hasil = [];
        while ($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
        return $hasil;
    }

    /**
     * Function daftarPraktikum berfungsi untuk mengatur tampilan halaman daftar praktikum
     */

    public function daftarPraktikum()
    {
        $data = $this->getPraktikum();
        extract($data);
        require_once("View/praktikan/daftarPraktikum.php");
    }

    /**
     * Function getPendaftaranPraktikum berfungsi untuk mengambil data pendaftaran praktikum praktikan
     * @param integer idPraktikan berisi id praktikan
     */

    public function getPendaftaranPraktikum($idPraktikan)
    {
        $sql = "SELECT daftarprak.id as idDaftar, praktikum.nama as namaPraktikum, praktikum.id as idPraktikum , daftarprak.status as status FROM daftarprak
        JOIN praktikum ON praktikum.id = daftarprak.praktikum_id
        WHERE daftarprak.praktikan_id = $idPraktikan";

        $query = koneksi()->query($sql);
        $hasil = [];
        while ($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
        return $hasil;
    }

    /**
     * Function praktikum berfungsi untuk mengatur ke tampilan halaman praktikum praktikan
     */

    public function praktikum()
    {
        $idPraktikan = $_SESSION['praktikan']['id'];
        $data = $this->getPendaftaranPraktikum($idPraktikan);
        extract($data);
        require_once("View/praktikan/praktikum.php"); 
    }

    /**
     * Function getModul berfungsi untuk mengambil data modul dari praktikum yang aktif
     */

    public function getModul()
    {
        $sql = "SELECT modul.id as idModul , modul.nama as namaModul FROM modul 
        JOIN praktikum ON praktikum.id = modul.praktikum_id"; 
        //WHERE praktikum.status = 1";

        $query = koneksi()->query($sql);
        $hasil = [];
        while ($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
        return $hasil;
    }

    /**
     * Function getNilaiPraktikan berfungsi untuk mengambil data nilai praktikan di tiap-tiap praktikum
     * @param integer idPraktikan berisi id praktikan
     * @param integer idPraktikum berisi id praktikum
     */

    public function getNilaiPraktikan($idPraktikan, $idPraktikum)
    {
        $sql = "SELECT * FROM nilai 
        JOIN modul ON modul.id = nilai.modul_id
        WHERE praktikan_id = $idPraktikan
        AND praktikum_id = $idPraktikum
        ORDER BY modul.id";

        $query = koneksi()->query($sql);
        $hasil = [];
        while ($data = $query->fetch_assoc()){
            $hasil[] = $data;
        }
        return $hasil;
    }

    /**
     * Function nilaiPraktikan berfungsi untuk mengatur halaman nilai praktikum praktikan
     */

    public function nilaiPraktikan()
    {   
        $idPraktikan = $_SESSION['praktikan']['id'];
        $idPraktikum = $_GET['idPraktikum'];
        $modul = $this->getModul();
        $nilai = $this->getNilaiPraktikan($idPraktikan, $idPraktikum);
        extract($modul);
        extract($nilai);
        require_once("View/praktikan/nilaiPraktikan.php");
    }

    /**
     * Function prosesUpdate berfungsi untuk update data praktikan pada database
     * @param string nama berisi nama praktikan
     * @param string npm berisi npm praktikan
     * @param string password berisi password
     * @param string no_hp berisi nomor telepon
     * @param string id berisi id praktikan
     */

    public function prosesUpdate($nama, $npm, $password, $no_hp, $id){
        $sql = "UPDATE praktikan SET nama='$nama', npm='$npm', password='$password', nomor_hp='$no_hp' WHERE id='$id'";
        $query = koneksi()->query($sql);
        return $query;
    }

    /**
     * Function update ini berfungsi untuk menyimpan hasil edit
     */
    
    public function update(){
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $npm = $_POST['npm'];
        $no_hp = $_POST['no_hp'];
        $password = $_POST['password'];

        if($this->prosesUpdate($nama, $npm, $password, $no_hp, $id)){
            header("location: index.php?page=praktikan&aksi=view&pesan=Berhasil Ubah Data") ; //jangan ada spasi habis location
        } else {
            header("location: index.php?page=praktikan&aksi=edit&pesan=Gagal Ubah Data") ; //jangan ada spasi habis location
        }
    }

    /**
     * Function edit berfungsi untuk menampilakn form edit
     */

    public function edit(){
        $id = $_SESSION['praktikan']['id'];
        $data = $this->get($id);
        extract($data);
        require_once("View/praktikan/edit.php");
    }

    /**
     * Function prosesStorePraktikum berfungsi untuk input data daftar praktikum ke database
     * @param integer idPraktikan berisi id praktikan
     * @param integer idPraktikum berisi id praktikum
     */

    public function prosesStorePraktikum($idPraktikan, $idPraktikum){
        $sql = "INSERT INTO daftarprak(praktikan_id, praktikum_id, status) VALUE ($idPraktikan, $idPraktikum, 0)";
        $query = koneksi()->query($sql);
        return $query;
    }

    /**
     * Function storePraktikum berfungsi untuk memproses data praktikum yang dipilih untuk ditambahkan
     */

    public function storePraktikum(){
        $praktikum = $_POST['praktikum'];
        $idPraktikan = $_SESSION['praktikan']['id'];

        if($this->prosesStorePraktikum($idPraktikan, $praktikum)){
            header("location: index.php?page=praktikan&aksi=praktikum&pesan=Berhasil Daftar Praktikum") ; //jangan ada spasi habis location
        } else {
            header("location: index.php?page=praktikan&aksi=daftarPraktikum&pesan=Gagal Daftar Praktikum") ; //jangan ada spasi habis location
        }
    }
}
