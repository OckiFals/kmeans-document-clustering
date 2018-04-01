<?php

class Silhoutte_helper extends CI_Model {
    /**
     * @var array $tfidf
     */
    private $tfidf;
    /**
     * @var int $cluster_count
     */
    private $cluster_count;
    /**
     * @var array $cluster_kmean
     */
    private $cluster_kmean;

    /**
     * Silhoutte_helper constructor.
     * @param array $tfidf
     * @param int $cluster_count
     * @param array $cluster_kmean
     */
    public function __construct($tfidf, $cluster_count, $cluster_kmean) {
        parent::__construct();
        $this->tfidf = $tfidf;
        $this->cluster_count = $cluster_count;
        $this->cluster_kmean = $cluster_kmean;
    }

    public function process() {
        // TODO when cluster has only one document
        $results = [];
        // inner cluster
        $distance_a = [];
        $average_a = [];
        // outer cluster
        $distance_b = [];
        $average_b = [];

        // inner cluster distance
        foreach ($this->cluster_kmean as $cluster => $docs) {
            $docs_keys = array_keys($docs);
            foreach ($docs as $doc) {
                $i = 0;
                for (; $i < count($docs); $i++) {
                    if ($doc === $docs_keys[$i]) {
                        continue;
                    }
                    $distance_a[$cluster]["(${doc},${docs_keys[$i]})"] = 1 - $this->clusterDistance($doc, $docs_keys[$i]);
                }
            }
        }

        // average document distance with documents in outer cluster
        foreach ($this->cluster_kmean as $cluster_index => $cluster) {
            foreach ($cluster as $document) {
                $average_a["b(${document})"] = $this->averageInnerDistance($distance_a[$cluster_index], $document);
            }
        }

        // outer cluster distance
        $cluster_kmean_index = array_keys($this->cluster_kmean);
        foreach ($this->cluster_kmean as $cluster => $docs) {
            foreach ($docs as $doc) {
                foreach ($cluster_kmean_index as $cl) {
                    if ($cluster !== $cl) {
                        foreach ($this->cluster_kmean[$cl] as $doc_) {
                            $distance_b["d(${doc},${doc_})"] = 1 - $this->clusterDistance($doc, $doc_);
                        }
                    }
                }
            }
        }

        // average document distance with documents in outer cluster
        $this->averageOuterDistance($distance_b, $average_b);

        return $results;
    }

    /**
     * @param string $n document n
     * @param string $m document n+1
     * @return float
     */
    public function clusterDistance($n, $m) {
        $distance = 0;

        foreach ($this->tfidf as $term => $doc) {
            $distance += $doc[$n] * $doc[$m];
        }

        return $distance;
    }

    /**
     * @param $distance array cluster distance
     * @param $document string document name
     * @return int average distance
     */
    public function averageInnerDistance($distance, $document) {
        $average = [];

        foreach ($distance as $index => $value) {
            if (preg_match("(${document},d[0-9]+)", $index)) {
                $average[] = $value;
            }
        }

        return array_sum($average) / count($average);
    }

    /**
     * @param $distance array cluster distance
     * @param $average_b
     */
    public function averageOuterDistance($distance, &$average_b) {
        /*
         * Flip cluster kmean array, from:
         *
         * array(
         *  'c1' => array('d1', 'd2', ..),
         *  'c2' => array('d8', ..)
         * )
         *
         * To:
         *
         * array(
         *  'd1' => 'c1',
         *  'd2 => 'c1',
         *  ...
         *  'd8' => 'c2'
         * )
         */
        $cluster_kmean_flip = [];
        foreach ($this->cluster_kmean as $cluster => $docs) {
            foreach ($docs as $doc) {
                $cluster_kmean_flip[$doc] = $cluster;
            }
        }

        // distance before average
        $distance_b_raw = [];
        foreach ($distance as $key => $value) {
            preg_match("(d[0-9]+,d[0-9]+)", $key, $matches);
            $doc = explode(',', $matches[0]);
            /*
             * [
             *  'd1(c2)' => ‌[
             *    'd1,d2' => 0.853998629248431,
             *    'd1,d3' => 0.8898405206140072
             *  ],
             *  'd1(c3)' => [
             *    'd1,d5' => 0.7873851886817778
             *  ]
             *  .....
             * ]
             */
            $distance_b_raw[$doc[0] . '(' . $cluster_kmean_flip[$doc[1]] . ')'][$matches[0]] = $value;
        }

        foreach ($distance_b_raw as $key => $value) {
            $average_b[$key] = array_sum($value);
        }
    }

    /**
     * @return array
     */
    public function getTfidf() {
        return $this->tfidf;
    }

}
