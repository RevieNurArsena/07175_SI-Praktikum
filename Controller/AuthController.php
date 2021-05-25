<?php

class AuthController{
    private $model;

    /** Function ini adalan konstruktor yang berguna menginisialisasi object auth model*/
    public function __construct()
    {
        $this->model = new AuthModel();
    }

    /**
     * Function index berfungsi untuk mengatur tampilan awal
     */
    public function index()
    {
        require_once("View/auth/index.php");
    }

    /**
     * Function login_aslab berfungsi untuk mengatur halaman login untuk aslab
     */

    public function login_aslab()
    {
        require_once("View/auth/login_aslab.php");
    }

    /**
     * Function login_praktikan berfungsi untuk mengatur ke halaman login praktikan
     */

    public function login_praktikan()
    {
        require_once("View/auth/login_praktikan.php");
    }

    /**
     * Function authAslab berfungsi untuk authentication aslab
     */
    public function authAslab()
    {
        $npm = $_POST['npm'];
        $password = $_POST['password'];
        $data = $this->model->prosesAuthAslab($npm, $password);

        if($data){
            $_SESSION['role'] = 'aslab';
            $_SESSION['aslab'] = $data;
            header("location:index.php?page=aslab&aksi=view&pesan=Berhasil Login");

        }else {
            header("location:index.php?page=auth&aksi=loginAslab&pesan=Password atau Npmanda salah !!");
        }
    }

    /**
     * Function authPraktikan berfungsi untuk authentication aslab
     */
    public function authPraktikan()
    {
        $npm = $_POST['npm'];
        $password = $_POST['password'];
        $data = $this->model->prosesAuthPraktikan($npm, $password);

        if($data){
            $_SESSION['role'] = 'praktikan';
            $_SESSION['praktikan'] = $data;
            header("location:index.php?page=praktikan&aksi=view&pesan=Berhasil Login");

        }else {
            header("location:index.php?page=auth&aksi=loginPraktikan&pesan=Password atau Npmanda salah !!");
        }
    }

    /**
     * Function daftarpraktikan berfungsi untuk mengatur tampilan daftar 
     */

    public function daftarpraktikan()
    {
        require_once("View/auth/daftar_praktikan.php");
    }

    /**
     * Fungsi storePraktikan ini berfungsi ini untuk memproses data untuk ditambahkan
     * fungsi ini membutuhkan data nama, npm, notelp, password dengan metode http request POST
     */

    public function storePraktikan(){
        $nama = $_POST['nama'];
        $npm = $_POST['npm'];
        $no_hp = $_POST['no_hp'];
        $password = $_POST['password'];

        if($this->model->prosesStorePraktikan($nama, $npm, $no_hp, $password)){
            header("location: index.php?page=auth&aksi=view&pesan=Berhasil Daftar") ; //jangan ada spasi habis location
        } else {
            header("location: index.php?page=auth&aksi=daftarpraktikan&pesan=Gagal Daftar") ; //jangan ada spasi habis location
        }
    }

    /** Function logout untuk destroy session login sebelumnya */
    public function logout()
    {
        session_destroy();
        header("location:index.php?page=auth&aksi=view&pesan=Berhasil Logout !!");
    }
}