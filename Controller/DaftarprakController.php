<?php

class DaftarprakController{
    private $model;

    /** Function ini adalan konstruktor yang berguna menginisialisasi object daftarprak model*/
    public function __construct()
    {
        $this->model = new DaftarPrakModel();
    }

    /**
     * Function index berfungsi untuk mengatur tampilan awal halaman daftar
     */

    public function index()
    {
        $data = $this->model->get();
        extract($data);
        require_once("View/daftarprak/index.php");
    }

    /**
     * Function verif berfungsi untuk memverifikasi praktikan yang sudah mendaftar praktikum
     */
    
    public function verif(){
        $id = $_GET['id'];
        $idAslab = $_SESSION['aslab']['id'];
        if($this->model->prosesVerif($id, $idAslab)){
            header("location: index.php?page=daftarprak&aksi=view&pesan=Berhasil Verif Praktikan") ; //jangan ada spasi habis location
        } else {
            header("location: index.php?page=daftarprak&aksi=view&pesan=Gagal Verif Praktikan") ; //jangan ada spasi habis location
        }
    }

    /**
     * Function unVerif berfungsi untuk membatalkan verifikasi
     */

    public function unVerif(){
        $id = $_GET['id'];
        $idPraktikan = $_GET['praktikan'];
        if($this->model->prosesUnVerif($id, $idPraktikan)){
            header("location: index.php?page=daftarprak&aksi=view&pesan=Berhasil Un-Verif Praktikan") ; //jangan ada spasi habis location
        } else {
            header("location: index.php?page=daftarprak&aksi=view&pesan=Gagal Un-Verif Praktikan") ; //jangan ada spasi habis location
        }
    }
}