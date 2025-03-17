function mastdon($data)
{
	$mastodonUrl = 'https://{your-Instance}/api/v1/statuses'; // インスタンスのドメインに置き換えてください
	$accessToken = ''; // あなた自身のアクセストークン
	$data = [
		'status' => $data['value1'],
		'visibility' => 'public', // public => 世界中に private => ホームのフォロワーへ
	];

	$jsonData = json_encode($data);

	$ch = curl_init($mastodonUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Authorization: Bearer ' . $accessToken,
		'Content-Type: application/json',
	]);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($httpCode >= 200 && $httpCode < 300) {
		// 成功
		return json_decode($response, true);
	} else {
		// エラー
		error_log("Mastodon投稿失敗 (HTTP $httpCode): " . $response);
		return false;
	}
}

mastdon(["value1" => "送信するテキスト"];
