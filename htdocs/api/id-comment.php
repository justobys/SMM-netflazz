<?php
error_reporting(0);
function search_comments($url, $target = '') {
	$keren = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36";
	$hashv ="2.txt";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $keren);
	curl_setopt($ch, CURLOPT_URL, "$url?__a=1");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	$data = json_decode($result);
	if (isset($data->graphql->shortcode_media->edge_media_to_parent_comment->edges)) {
		$simpan_komen = [];
		// simpan komen
		foreach($data->graphql->shortcode_media->edge_media_to_parent_comment->edges as $hasil) {
			$simpan_komen[] = $hasil;
			if ($hasil->node->edge_threaded_comments->count > 0) {
				foreach ($hasil->node->edge_threaded_comments->edges as $hasil2) {
					$simpan_komen[] = $hasil2;
				}
			}
		}
		// loop real komen
		$total_komen = 0;
		foreach ($simpan_komen as $hasil) {
			if($hasil->node->owner->username == $target) {
				$print_comment[] = ['id' => $hasil->node->id,'text' => $hasil->node->text];
				$total_komen++;
			}
		}
	} elseif (isset($data->graphql->shortcode_media->edge_media_to_comment->edges)) {
		$total_komen = 0;
		foreach($data->graphql->shortcode_media->edge_media_to_comment->edges as $hasil) {
			if($hasil->node->owner->username == $target) {
				$print_comment[] = ['id' => $hasil->node->id,'text' => $hasil->node->text];
				$total_komen++;
			}
		}
	}
	return ['count' => $total_komen, 'result' => $print_comment];
}
print(json_encode(search_comments($_GET['link'],$_GET['username'])));