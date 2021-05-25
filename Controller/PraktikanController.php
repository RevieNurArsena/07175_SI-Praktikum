<?php

class PraktikanController{
    private $model;

    /** Function ini adalan konstruktor yang berguna menginisialisasi object praktikan model*/
    public function __construct()
    {
        $this->model = new PraktikanModel();
    }

    /**
     * Function index berfungsi untuk mengatur tampilan awal halaman praktikan
     */

    public function index()
    {
        $id = $_SESSION['praktikan']['id'];
        $data = $this->model->get($id);
        extract($data);
        require_once("View/praktikan/index.php");
    }

    /**
     * Function edit berfungsi untuk menampilakn form edit
     */

    public function edit(){
        $id = $_SESSION['praktikan']['id'];
        $data = $this->model->get($id);
        extract($data);
        require_once("View/praktikan/edit.php");
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

        if($this->model->prosesUpdate($nama, $npm, $password, $no_hp, $id)){
            header("location: index.php?page=praktikan&aksi=view&pesan=Berhasil Ubah Data") ; //jangan ada spasi habis location
        } else {
            header("location: index.php?page=praktikan&aksi=edit&pesan=Gagal Ubah Data") ; //jangan ada spasi habis location
        }
    }

        /**
     * Function praktikum berfungsi untuk mengatur ke tampilan halaman praktikum praktikan
     */

    public function praktikum()
    {
        $idPraktikan = $_SESSION['praktikan']['id'];
        $data = $this->model->getPendaftaranPraktikum($idPraktikan);
        extract($data);
        require_once("View/praktikan/praktikum.php"); 
    }

    /**
     * Function daftarPraktikum berfungsi untuk mengatur tampilan halaman daftar praktikum
     */

    public function daftarPraktikum()
    {
        $data = $this->model->getPraktikum();
        extract($data);
        require_once("View/praktikan/daftarPraktikum.php");
    }

    /**
     * Function storePraktikum berfungsi untuk memproses data praktikum yang dipilih untuk ditambahkan
     */

    public function storePraktikum(){
        $praktikum = $_POST['praktikum'];
        $idPraktikan = $_SESSION['praktikan']['id'];

        if($this->model->prosesStorePraktikum($idPraktikan, $praktikum)){
            header("location: index.php?page=praktikan&aksi=praktikum&pesan=Berhasil Daftar Praktikum") ; //jangan ada spasi habis location
        } else {
            header("location: index.php?page=praktikan&aksi=daftarPraktikum&pesan=Gagal Daftar Praktikum") ; //jangan ada spasi habis location
        }
    }

    /**
     * Function nilaiPraktikan berfungsi untuk mengatur halaman nilai praktikum praktikan
     */

    public function nilaiPraktikan()
    {   
        $idPraktikan = $_SESSION['praktikan']['id'];
        $idPraktikum = $_GET['idPraktikum'];
        $modul = $this->model->getModul();
        $nilai = $this->model->getNilaiPraktikan($idPraktikan, $idPraktikum);
        extract($modul);
        extract($nilai);
        require_once("View/praktikan/nilaiPraktikan.php");
    }
}