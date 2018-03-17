<?php

class Stemming_helper extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('Stopword_model');
        $this->load->model('Basicword_model');
    }

    public function stopword($lines) {
        $result = $this->Stopword_model->getAll();

        foreach ($result as $index => $stopword) {
            $stopwordz[] = $stopword->stopword;
        }

        $trimmed = array_map('trim', $stopwordz);

        $lines1 = array_map('trim', $lines);
        $lines1 = preg_replace('/[0-9]+/', '', $lines1); // hapus angka
        $lines1 = preg_replace('/\s+/', ' ', $lines1); // hapus baris baru

        foreach ($lines1 as $line => $kata) {
            $abstrak = $kata;
            $string = str_replace(str_split(':%.,()'), '', $abstrak); // hapus tanda baca
            $string = str_replace(str_split('-'), ' ', $string);
            $string1 = explode(" ", strtolower($string));
            $string2 = implode(" ", array_diff($string1, $trimmed));
            $jadi = explode(" ", $string2);
        }

        $temp = array();

        $iter_count = ceil(count($jadi) / 50);

        for ($i = 0; $i < $iter_count; $i++) {
            $start = $i * 50;
            $end = ($start + 50 <= count($jadi)) ? $start + 49 : count($jadi);
            $array_kata = array_slice($jadi, $start, $end);
            $array_kata = $this->hapuspartikel($array_kata);
            $array_kata = $this->hapuspp($array_kata);
            $array_kata = $this->hapusawalan($array_kata);
            $array_kata = $this->hapusawalan2($array_kata);
            $array_kata = $this->hapusakhiran($array_kata);
            $temp = array_merge($temp, $array_kata);
        }

        $hitung = array_count_values($temp);
        ksort($hitung);
        return $hitung;
    }

    public function cari($array_kata) {
        $temp_in_query = "(";
        foreach ($array_kata as $index => $kata) {
            $temp_in_query .= ($index == count($array_kata) - 1) ? "'$kata'" : "'$kata', ";
        }
        $temp_in_query .= ")";
        $hasil = [];
        $result = $this->Basicword_model->filterIN($temp_in_query);

        foreach ($result as $index => $basicword) {
             array_push($hasil, $basicword->word);
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
                } else if (substr($kata, 0, 3) == "mem") {
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