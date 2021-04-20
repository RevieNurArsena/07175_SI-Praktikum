<?php

class AuthModel{
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
     * Function daftarpraktikan berfungsi untuk mengatur tampilan daftar 
     */

      public function daftarpraktikan()
      {
          require_once("View/auth/daftar_praktikan.php");
      }

      public function prosesAuthAslab($npm, $password)
      {
          $sql = " select * from aslab where npm='$npm' and password='$password'";
          $query = koneksi()->query($sql);
          return $query->fetch_assoc();
      }

      /**
       * Function authAslab berfungsi untuk authentication aslab
       */
      public function authAslab()
      {
        $npm = $_POST['npm'];
        $password = $_POST['password'];
        $data = $this->prosesAuthAslab($npm, $password);

        if($data){
            $_SESSION['role'] = 'aslab';
            $_SESSION['aslab'] = $data;
            header("location:index.php?page=aslab&aksi=view&pesan=Berhasil Login");

        }else {
            header("location:index.php?page=auth&aksi=loginAslab&pesan=Password atau Npmanda salah !!");
        }
      }

      /**
       * Function untuk cek data dari database berdasarkan
       * @param String $npm berisi npm
       * @param String $password berisi password
       */

       public function prosesAuthPraktikan($npm, $password)
       {
        $sql = "select * from praktikan where npm='$npm' and password='$password'";
        $query = koneksi()->query($sql);
        return $query->fetch_assoc();
       }

    /**
       * Function authPraktikan berfungsi untuk authentication aslab
       */
      public function authPraktikan()
      {
        $npm = $_POST['npm'];
        $password = $_POST['password'];
        $data = $this->prosesAuthPraktikan($npm, $password);

        if($data){
            $_SESSION['role'] = 'praktikan';
            $_SESSION['praktikan'] = $data;
            header("location:index.php?page=praktikan&aksi=view&pesan=Berhasil Login");

        }else {
            header("location:index.php?page=auth&aksi=loginPraktikan&pesan=Password atau Npmanda salah !!");
        }
      }

      public function logout()
      {
          session_destroy();
          header("location:index.php?page=auth&aksi=view&pesan=Berhasil Logout !!");
      }
}
