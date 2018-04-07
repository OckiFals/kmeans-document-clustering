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
        $this->averageInnerDistance($distance_a, $average_a);

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

        $coeficient = $this->shilhoutteCoeficient($average_a, $average_b);

        return [
            'average_a' => $average_a,
            'average_b' => $average_b,
            'coeficient' => $coeficient
        ];
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
     * @param $average_a array
     */
    public function averageInnerDistance($distance, &$average_a) {
        foreach ($this->cluster_kmean as $cluster_index => $cluster) {
            foreach ($cluster as $document) {

                /*
                 * if cluster with has no document, set average to 0 and continue iteration
                 */
                if (!array_key_exists($cluster_index, $distance)) {
                    $average_a["a(${document})"] = 0;
                    continue;
                }

                $average = [];
                foreach ($distance[$cluster_index] as $index => $value) {
                    if (preg_match("(${document},d[0-9]+)", $index)) {
                        $average[] = $value;
                    }
                }
                /*
                 *  [
                 *   'd1' => 0.853998629248431,
                 *   'd2' => 0.8898405206140072,
                 *   ...
                 *  ]
                 */
                $average_a[$document] = array_sum($average) / count($average);
            }
        }
    }

    /**
     * @param $distance array cluster distance
     * @param $average_b array
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
            preg_match("#d[0-9]+,d[0-9]+#", $key, $matches);
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
            preg_match("#d[0-9]+#", $key, $matches);
            $doc = explode(',', $matches[0]);
            /*
             *  [
             *   'd1(c2)' => 0.87186035093412,
             *   'd2(c2)' => 0.9396565253587,
             *   'd1(c3)' => 0.87155666631582,
             *   ...
             *  ]
             */
            $average_b[$doc[0]][] = array_sum($value) / count($distance_b_raw[$key]);
        }

        foreach ($average_b as $doc => $array_value) {
            unset($average_b[$doc]);
            /*
             *  [
             *   'd1' => 0.853998629248431,
             *   'd2' => 0.8898405206140072,
             *   ...
             *  ]
             */
            $average_b[$doc] = array_sum($array_value) / count($array_value);
        }
    }

    /**
     * @param array $average_a
     * @param array $average_b
     * @return array
     */
    public function shilhoutteCoeficient(array $average_a, array $average_b) {
        $result = [];

        foreach ($average_a as $doc => $value_a) {
            $result[$doc] = ($average_b[$doc] - $value_a) / max($value_a, $average_b[$doc]);
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getTfidf() {
        return $this->tfidf;
    }

}
