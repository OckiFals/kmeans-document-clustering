<?php

class Stemming {

    public function __construct() {
        $servername = "localhost";
        $username = "ockifals";
        $password = "admin123";
        $dbname = "sholeh_skripsi";
        $this->conn = new mysqli($servername, $username, $password, $dbname);
    }

    public function cari($array_kata) {
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        $temp_in_query = "(";
        foreach ($array_kata as $index => $kata) {
            $temp_in_query .= ($index == count($array_kata) - 1) ? "'$kata'" : "'$kata', ";
        }
        $temp_in_query .= ")";

        //membuat variabel $hasil untuk menampilkan hasil mengambil kata dasar dari database
        //$hasil = mysql_num_rows(mysql_query("SELECT * FROM tb_katadasar WHERE katadasar='$kata'"));
        $sql = "SELECT * FROM tb_katadasar WHERE katadasar IN $temp_in_query";
        $hasil = [];
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                array_push($hasil, $row[1]);
            }
        }

        return $hasil; //mengeksekusi variabel $hasil
    }

    //langkah 1 - hapus partikel
    public function hapuspartikel($array_kata) {
        $kata_dasar = $this->cari($array_kata);
        foreach ($array_kata as $index => $kata) {
            if (!in_array($kata, $kata_dasar)) {
                if ((substr($kata, -3) == 'kah') ||
                    (substr($kata, -3) == 'lah') ||
                    (substr($kata, -3) == 'pun')) {
                    $kata = substr($kata, 0, -3);
                }
            }
            $array_kata[$index] = $kata;
        }
        return $array_kata;
    }

    //langkah 2 - hapus possesive pronoun
    public function hapuspp($array_kata) {
        $kata_dasar = $this->cari($array_kata);

        foreach ($array_kata as $index => $kata) {
            if (!in_array($kata, $kata_dasar)) {
                if (strlen($kata) > 4) {
                    if ((substr($kata, -2) == 'ku') || (substr($kata, -2) == 'mu')) {
                        $kata = substr($kata, 0, -2);
                    } else if ((substr($kata, -3) == 'nya')) {
                        $kata = substr($kata, 0, -3);
                    }
                }
            }
            $array_kata[$index] = $kata;
        }
        return $array_kata;
    }

    //langkah 3 hapus first order prefiks (awalan pertama)
    public function hapusawalan($array_kata) {
        $kata_dasar = $this->cari($array_kata);

        foreach ($array_kata as $index => $kata) {
            if (!in_array($kata, $kata_dasar)) {
                if (substr($kata, 0, 4) == "meng") {
                    if (substr($kata, 4, 1) == "e" || substr($kata, 4, 1) == "u") {
                        $kata = "k" . substr($kata, 4);
                    } else if (substr($kata, 4, 1) == "a") {
                        $kata = substr($kata, 4);
                    } else {
                        $kata = substr($kata, 4);
                    }
                } else if (substr($kata, 0, 4) == "meny") {
                    $kata = "s" . substr($kata, 4);
                } else if (substr($kata, 0, 3) == "men") {
                    if (substr($kata, 3, 1) == "a" || substr($kata, 3, 1) == "i" || substr($kata, 3, 1) == "u" || substr($kata, 3, 1) == "e" || substr($kata, 3, 1) == "o") {
                        $kata = "t" . substr($kata, 3);
                    } else {
                        $kata = substr($kata, 3);
                    }
                } /*else if(substr($kata,0,3)=="mem"){
                if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
                if(substr($kata,3,1)=="a" || substr($kata,3,1)=="i" || substr($kata,3,1)=="e" || substr($kata,3,1)=="u" || substr($kata,3,1)=="o"){
                $kata = "m".substr($kata,3);
                }
                }else{
                $kata = substr($kata,3);
                }
                }*/
                else if (substr($kata, 0, 3) == "mem") {
                    if (substr($kata, 3, 1) == "a") {
                        $kata = "m" . substr($kata, 3);
                    } else if (substr($kata, 3, 2) == "in") {
                        $kata = "m" . substr($kata, 3);
                    } else if (substr($kata, 3, 1) == "i") {
                        $kata = "p" . substr($kata, 3);
                    } else {
                        $kata = substr($kata, 3);
                    }
                } else if (substr($kata, 0, 2) == "me") {
                    $kata = substr($kata, 2);
                } else if (substr($kata, 0, 4) == "peng") {
                    //if(substr($kata,4,1)=="e" || substr($kata,4,1)=="a"){
                    if (substr($kata, 4, 1) == "e") {
                        $kata = "k" . substr($kata, 4);
                    } else {
                        $kata = substr($kata, 4);
                    }
                } else if (substr($kata, 0, 4) == "peny") {
                    $kata = "s" . substr($kata, 4);
                } else if (substr($kata, 0, 3) == "pen") {
                    if (substr($kata, 3, 1) == "a" || substr($kata, 3, 1) == "i" || substr($kata, 3, 1) == "e" || substr($kata, 3, 1) == "u" || substr($kata, 3, 1) == "o") {
                        $kata = "t" . substr($kata, 3);
                    } else {
                        $kata = substr($kata, 3);
                    }
                } else if (substr($kata, 0, 3) == "pem") {
                    if (substr($kata, 3, 1) == "a" || substr($kata, 3, 1) == "i" || substr($kata, 3, 1) == "e" || substr($kata, 3, 1) == "u" || substr($kata, 3, 1) == "o") {
                        $kata = "p" . substr($kata, 3);
                    } else {
                        $kata = substr($kata, 3);
                    }
                } else if (substr($kata, 0, 2) == "di") {
                    $kata = substr($kata, 2);
                } else if (substr($kata, 0, 3) == "ter") {
                    $kata = substr($kata, 3);
                } else if (substr($kata, 0, 2) == "ke") {
                    $kata = substr($kata, 2);
                }
            }
            $array_kata[$index] = $kata;
        }
        return $array_kata;
    }

    //langkah 4 hapus second order prefiks (awalan kedua)
    public function hapusawalan2($array_kata) {
        $kata_dasar = $this->cari($array_kata);

        foreach ($array_kata as $index => $kata) {
            if (!in_array($kata, $kata_dasar)) {

                if (substr($kata, 0, 3) == "ber") {
                    $kata = substr($kata, 3);
                } else if (substr($kata, 0, 3) == "bel") {
                    $kata = substr($kata, 3);
                } else if (substr($kata, 0, 2) == "be") {
                    $kata = substr($kata, 2);
                } else if (substr($kata, 0, 3) == "per" && strlen($kata) > 5) {
                    $kata = substr($kata, 3);
                } else if (substr($kata, 0, 2) == "pe" && strlen($kata) > 5) {
                    $kata = substr($kata, 2);
                } else if (substr($kata, 0, 3) == "pel" && strlen($kata) > 5) {
                    $kata = substr($kata, 3);
                } else if (substr($kata, 0, 2) == "se" && strlen($kata) > 5) {
                    $kata = substr($kata, 2);
                }
            }
            $array_kata[$index] = $kata;
        }
        return $array_kata;
    }

    ////langkah 5 hapus suffiks
    public function hapusakhiran($array_kata) {
        $kata_dasar = $this->cari($array_kata);

        foreach ($array_kata as $index => $kata) {
            if (!in_array($kata, $kata_dasar)) {
                if (substr($kata, -3) == "kan") {
                    $kata = substr($kata, 0, -3);
                } else if (substr($kata, -1) == "i") {
                    $kata = substr($kata, 0, -1);
                } else if (substr($kata, -2) == "an") {
                    $kata = substr($kata, 0, -2);
                }
            }
            $array_kata[$index] = $kata;
        }
        return $array_kata;
    }
}

?>