<?php 
include('test1.php');
function stopword($file) {
	$servername = "localhost";
	$username = "ockifals";
	$password = "admin123";
	$dbname = "sholeh_skripsi";

		// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$lines = $file;
	$abstrak = "";
	$jadi = null;
	$sql = "SELECT stopword FROM stopword";
	$stopwordz = array();
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_array()) {
			$stopwordz[] = $row[0];
		}
	}

	$conn->close();

	$trimmed = array_map('trim', $stopwordz);

	$lines1 = array_map('trim', $lines);
	$lines1 = preg_replace('/[0-9]+/', '', $lines1); // hapus angka

	foreach ($lines1 as $line => $kata) {
		$abstrak = $kata;
			// $words = trim(preg_replace('/\s\s+/', ' ', $abstrak));
			// $words = preg_replace('/\b\w\b\s?/', '', $words);
		$string = str_replace(str_split(':%.,()'), '', $abstrak); // hapus tanda baca
		$string = str_replace(str_split('-'), ' ', $string);
		$string1 = explode(" ", strtolower($string));
		$string2 = implode(" ", array_diff($string1, $trimmed));
		$jadi = explode(" ", $string2);
	}

	$temp = array();

	$stemming = new Stemming();

	$iter_count = ceil(count($jadi) / 50);

	for ($i = 0; $i < $iter_count; $i++) {
		$start = $i * 50;
		$end = ($start + 50 <= count($jadi)) ? $start + 49 : count($jadi);
		$array_kata = array_slice($jadi, $start, $end);
		$array_kata = $stemming->hapuspartikel($array_kata);
		$array_kata = $stemming->hapuspp($array_kata);
		$array_kata = $stemming->hapusawalan($array_kata);
		$array_kata = $stemming->hapusawalan2($array_kata);
		$array_kata = $stemming->hapusakhiran($array_kata);
		$temp = array_merge($temp, $array_kata);
	}

	$hitung = array_count_values($temp);
	ksort($hitung);
	return $hitung;
}

$servername = "localhost";
$username = "ockifals";
$password = "admin123";
$dbname = "sholeh_skripsi";
	// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id_dokumen, abstrak FROM tambah_dokumen";
$abstrak_id = [];
$abstrak = array();
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$index = 0;
	while ($row = $result->fetch_array()) {
		$abstrak_id['d'.($index+1)] = $row[0];
		$abstrak[] = $row[1];
		$index++;
	}
}

// $conn->close();

$terms = [];
$terms_temp = [];
$df_array = [];
$idf_array = [];
$wtf = [];
$wtf_temp = [];
for ($i = 0; $i < count($abstrak); $i++) {
	$file = array($abstrak[$i]);
	$terms_temp[$i] = stopword($file);
	$terms = array_merge($terms, $terms_temp[$i]);

	$wtf_temp[$i] = $terms_temp[$i]; 
		// iterasi untuk menghitung wtf per term
	foreach ($wtf_temp[$i] as $term => $count) {
		$wtf_temp[$i][$term] = (0 != $count) ? 1 + log10($count) : 0;
	}
	$wtf = array_merge($wtf, $wtf_temp[$i]);
}

// test input
$cluster_count = $this->session->userdata('kluster');

ksort($terms);
ksort($wtf);
$tfidf_arraycount = array_fill(0, count($abstrak), 0);
$tfidf_sqrt = array();
$i = 0;
$df = 0;
foreach ($terms as $term => $count) : ?>
	<?php $i++;?>
	<?php foreach ($terms_temp as $jindex => $hasil) : ?>
				<?php if (array_key_exists($term, $hasil)) : ?>
					<?php $df++;?>
				<?php endif; ?>
	<?php endforeach; ?>
	<?php
		$df_array[$i] = $df;
		$df = 0
		?>
		<?php $idf_array[$i] = (float) number_format(log(count($abstrak) / $df_array[$i]), 5); ?>
		<?php foreach ($wtf_temp as $jindex => $hasil) : ?>
			<?php if (array_key_exists($term, $hasil)) : ?>
			<?php
				$tfidf = (float) number_format(
					$wtf_temp[$jindex][$term] * $idf_array[$i],
					5
				);
			?>
			<?php else : ?>
			<?php $tfidf = 0.0; ?>
			<?php endif; ?>
			
			<?php
			$tfidf_arraycount[$jindex] += $tfidf;
			$tfidf_sqrt[$jindex] = sqrt($tfidf_arraycount[$jindex]); 
			?>
		<?php endforeach; ?>
	<?php endforeach; ?>
	<?php 
	$no = 0;
	$df = 0;
	$tfidf_hasil_array = [];
	$clustering_array = [];
	foreach ($abstrak as $index => $obj) {
		for ($i = 0; $i < $cluster_count; $i++) {
			$clustering_array['d' . ($index + 1)]['c' . ($i + 1)] = 0;
		}
	}
	foreach ($terms as $term => $count) : ?>
		<!-- normalisasi -->
		<?php $no++ ?>
		<?php foreach ($wtf_temp as $jindex => $hasil) : ?>
			<?php if (array_key_exists($term, $hasil)) : ?>
			<?php
			$tfidf = (float)number_format(
				$wtf_temp[$jindex][$term] * $idf_array[$no],
				5
			);
			?>
			<?php else : ?>
			<?php $tfidf = 0.0; ?>
			<?php endif; ?>
			
			<?php
			$random = [];
			$tfidf_hasil = $tfidf / $tfidf_sqrt[$jindex];
			for ($i = 0; $i < $cluster_count; $i++) {
				$random[$i] = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
				$clustering_array['d' . ($jindex + 1)]['c' . ($i + 1)] += $tfidf_hasil * $random[$i];
			}
			$tfidf_hasil_array[$term]['d' . ($jindex + 1)] = $tfidf_hasil;
			?>
		<?php endforeach; ?>
	<?php endforeach;?>

	<?php $cluster_kmean = []; ?>
	<?php for ($i = 0; $i < $cluster_count; $i++) : ?>
		<?php $max = 'c1'; ?>
		<?php foreach ($clustering_array as $jindex => $cluster) : ?>
			<?php 
				for ($j=0; $j < $cluster_count ; $j++) { 
					if ($clustering_array[$jindex]['c' . ($j + 1)] > $clustering_array[$jindex][$max]) {
						$max = 'c' . ($j + 1);
					}
				}
				// array_push($cluster_kmean[$max], $jindex);
				$cluster_kmean[$max][$jindex] = $jindex;							
			?>
		<?php endforeach; ?>
	<?php endfor; ?>
	
	<?php 
	$centroid = [];
	$cluster_baru = []; 
	?>

	<!-- hitung centroid -->
	<?php foreach ($tfidf_hasil_array as $key => $value): ?>
			<?php for($i = 0; $i < $cluster_count; $i++): ?>
					<?php $sum = 0 ?>
					<?php foreach ($cluster_kmean['c' . ($i+1	)] as $c => $d) : ?>
						<?php $sum += $value[$d] ?>
					<?php endforeach; ?>
					<?php $centroid[$key][$i] = $sum / count($cluster_kmean['c' . ($i+1	)]); 
					?>
			<?php endfor; ?>
	<?php endforeach; ?>

	<?php foreach ($abstrak as $index => $abstraka) : ?>
	<?php endforeach; ?>
	<?php for($i = 0; $i < $cluster_count; $i++): ?>
	<?php endfor; ?>
	<?php 
	$no = 0;
	$clustering_array_baru = [];
	foreach ($abstrak as $index => $obj) {
		for ($i = 0; $i < $cluster_count; $i++) {
			$clustering_array_baru['d' . ($index + 1)]['c' . ($i + 1)] = 0;
		}
	}
	foreach ($tfidf_hasil_array as $term => $value) : ?>
		<?php foreach ($value as $jindex => $hasil) : ?>
			<?php
			for ($i = 0; $i < $cluster_count; $i++) {
				$clustering_array_baru[$jindex]['c' . ($i + 1)] += $hasil * $centroid[$term][$i];
			}
			?>
		<?php endforeach; ?>
	<?php endforeach;?>
	
	<?php $cluster_kmean = []; ?>
	<?php for ($i = 0; $i < $cluster_count; $i++) : ?>
			<?php $max = 'c1'; ?>
			<?php foreach ($clustering_array_baru as $jindex => $cluster) : ?>
				<?php 
					for ($j=0; $j < $cluster_count ; $j++) { 
						if ($clustering_array[$jindex]['c' . ($j + 1)] > $clustering_array[$jindex][$max]) {
							$max = 'c' . ($j + 1);
						}
					}
					$cluster_kmean[$max][$jindex] = $jindex;							
				?>
			<?php endforeach; ?>
		<?php endfor; ?>

	
	