<?php

class AuthModel{

      public function prosesAuthAslab($npm, $password)
      {
          $sql = "select * from aslab where npm='$npm' and password='$password'";
          $query = koneksi()->query($sql);
          return $query->fetch_assoc();
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
     * Function prosesStorePraktikan ini berfungsi untuk menambahkan data ke database
     * @param nama berisi data nama
     * @param npm berisi data npm
     * @param no_hp berisi data nomor hp
     * @param password berisi data password 
     */

    public function prosesStorePraktikan($nama, $npm, $no_hp, $password){
        $sql = "INSERT INTO praktikan(nama, npm, nomor_hp, password) VALUE ('$nama', '$npm', '$no_hp', '$password')";
        return koneksi()->query($sql);
    }

}
