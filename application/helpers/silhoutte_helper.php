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
        // outer cluster
        $distance_b = [];
        foreach ($this->cluster_kmean as $cluster => $docs) {
            $docs_keys = array_keys($docs);
            foreach ($docs as $doc) {
                $i = 0;
                for (; $i < count($docs); $i++) {
                    if ($doc === $docs_keys[$i]) {
                        continue;
                    }
                    $distance_a[$cluster]["(${doc},${docs_keys[$i]})"] = 1 - $this->innerClusterDistance($doc, $docs_keys[$i]);
                }
            }
        }

        // average distance of inner cluster
        foreach ($this->cluster_kmean as $cluster_index => $cluster) {
            foreach ($cluster as $document) {
                $results[] = $this->averageDistance($distance_a[$cluster_index], $document);
            }
        }

        return $results;
    }

    /**
     * @param string $n document n
     * @param string $m document n+1
     * @return float
     */
    public function innerClusterDistance($n, $m) {
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
    public function averageDistance($distance, $document) {
        $average = [];

        foreach ($distance as $index => $value) {
            if (preg_match("(${document},d[1-9])", $index)) {
                $average[] = $value;
            }
        }

        return array_sum($average) / count($average);
    }

    /**
     * @return array
     */
    public function getTfidf() {
        return $this->tfidf;
    }

}
