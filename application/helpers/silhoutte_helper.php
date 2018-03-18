<?php

class Silhoutte_helper extends CI_Model {
    /**
     * @var array $tfidf
     */
    private $tfidf;
    /**
     * @var array $cluster_kmean
     */
    private $cluster_kmean;

    public function __construct(array $tfidf, array $cluster_kmean) {
        parent::__construct();
        $this->tfidf = $tfidf;
        $this->cluster_kmean = $cluster_kmean;
    }

    public function process(): array {
        $results = [];
        foreach ($this->tfidf as $cluster => $docs) {
            $docs_keys = array_keys($docs);
            foreach ($docs as $doc) {
                $i = 0;
                for (; $i < count($docs); $i++) {
                    if ($doc === $docs_keys[$i]) {
                        continue;
                    }
                    $results["(${doc},${docs_keys[$i]})"] = 0;
                }
            }
        }

        return $results;
    }

    /**
     * @return array
     */
    public function getTfidf(): array {
        return $this->tfidf;
    }

}
