<?php

class Clustering_helper extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('Document_model');
        $this->load->model('Stopword_model');
        $this->load->model('Basicword_model');
        $this->load->helper('stemming_helper');
    }

    public function process($cluster_count) {
        $abstrak = [];

        $result = $this->Document_model->getAll();
        foreach ($result as $index => $doc) {
            $abstrak[] = $doc->abstrak . ' ' . $doc->daftar_isi;
        }

        $terms = [];
        $terms_temp = [];
        $df_array = [];
        $idf_array = [];
        $wtf = [];
        $wtf_temp = [];
        $stemming = new Stemming_helper();
        for ($i = 0; $i < count($abstrak); $i++) {
            $file = array($abstrak[$i]);
            $terms_temp[$i] = $stemming->stopword($file);
            $terms = array_merge($terms, $terms_temp[$i]);

            $wtf_temp[$i] = $terms_temp[$i];
            // iterasi untuk menghitung wtf per term
            foreach ($wtf_temp[$i] as $term => $count) {
                $wtf_temp[$i][$term] = (0 != $count) ? 1 + log10($count) : 0;
            }
            $wtf = array_merge($wtf, $wtf_temp[$i]);
        }

        ksort($terms);
        ksort($wtf);
        $tfidf_arraycount = array_fill(0, count($abstrak), 0);
        $tfidf_sqrt = array();
        $i = 0;
        $df = 0;
        foreach ($terms as $term => $count) {
            $i++;
            foreach ($terms_temp as $jindex => $hasil) {
                if (array_key_exists($term, $hasil)) {
                    $df++;
                }
            }
            $df_array[$i] = $df;
            $df = 0;

            $idf_array[$i] = (float)number_format(log(count($abstrak) / $df_array[$i]), 5);
            foreach ($wtf_temp as $jindex => $hasil) {
                if (array_key_exists($term, $hasil)) {
                    $tfidf = (float)number_format(
                        $wtf_temp[$jindex][$term] * $idf_array[$i],
                        5
                    );
                } else {
                    $tfidf = 0.0;
                }

                $tfidf_arraycount[$jindex] += $tfidf;
                $tfidf_sqrt[$jindex] = sqrt($tfidf_arraycount[$jindex]);
            
            }
        }

        $no = 0;
        $df = 0;
        $tfidf_hasil_array = [];
        $clustering_array = [];
        foreach ($abstrak as $index => $obj) {
            for ($i = 0; $i < $cluster_count; $i++) {
                $clustering_array['d' . ($index + 1)]['c' . ($i + 1)] = 0;
            }
        }
        foreach ($terms as $term => $count) {
            // normalisasi
            $no++;
            foreach ($wtf_temp as $jindex => $hasil) {
                if (array_key_exists($term, $hasil)) {
                    $tfidf = (float)number_format(
                        $wtf_temp[$jindex][$term] * $idf_array[$no],
                        5
                    );
                } else {
                    $tfidf = 0.0;
                }
                $random = [];
                $tfidf_hasil = $tfidf / $tfidf_sqrt[$jindex];
                for ($i = 0; $i < $cluster_count; $i++) {
                    $random[$i] = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
                    $clustering_array['d' . ($jindex + 1)]['c' . ($i + 1)] += $tfidf_hasil * $random[$i];
                }
                $tfidf_hasil_array[$term]['d' . ($jindex + 1)] = $tfidf_hasil;
            }
        }

        $cluster_kmean = [];
        for ($i = 0; $i < $cluster_count; $i++) {
            $max = 'c1';
            foreach ($clustering_array as $jindex => $cluster) {
                for ($j = 0; $j < $cluster_count; $j++) {
                    if ($clustering_array[$jindex]['c' . ($j + 1)] > $clustering_array[$jindex][$max]) {
                        $max = 'c' . ($j + 1);
                    }
                }
                // array_push($cluster_kmean[$max], $jindex);
                $cluster_kmean[$max][$jindex] = $jindex;
            }
        }

        $centroid = [];

        // hitung centroid
        foreach ($tfidf_hasil_array as $key => $value){
            for ($i = 0; $i < $cluster_count; $i++){
                $sum = 0;
                if (array_key_exists('c' . ($i + 1), $cluster_kmean)) {
                    foreach ($cluster_kmean['c' . ($i + 1)] as $c => $d) {
                        $sum += $value[$d];
                    }
                }
                $centroid[$key][$i] = array_key_exists('c' . ($i + 1), $cluster_kmean) ? 
                $sum / count($cluster_kmean['c' . ($i + 1)]) : 0;
            }
        }

        $no = 0;
        $clustering_array_baru = [];
        foreach ($abstrak as $index => $obj) {
            for ($i = 0; $i < $cluster_count; $i++) {
                $clustering_array_baru['d' . ($index + 1)]['c' . ($i + 1)] = 0;
            }
        }
        foreach ($tfidf_hasil_array as $term => $value) {
            foreach ($value as $jindex => $hasil) {
            
                for ($i = 0; $i < $cluster_count; $i++) {
                    $clustering_array_baru[$jindex]['c' . ($i + 1)] += $hasil * $centroid[$term][$i];
                }
            
            }
        }

        $cluster_kmean = [];
        for ($i = 0; $i < $cluster_count; $i++) {
            $max = 'c1';
            foreach ($clustering_array_baru as $jindex => $cluster) {
                for ($j = 0; $j < $cluster_count; $j++) {
                    if ($clustering_array[$jindex]['c' . ($j + 1)] > $clustering_array[$jindex][$max]) {
                        $max = 'c' . ($j + 1);
                    }
                }
                $cluster_kmean[$max][$jindex] = $jindex;   
            }
        }	

        return $cluster_kmean;
    }
}