<?php
class AmazonAPIHelper{

	const ENDPOINT = "webservices.amazon.co.jp";
    const URI = "/onca/xml";
    const AWS_SECRET_KEY = "";
    
    public function saveBookDatasInfo($titleName, $controller) {
        $total_pages = 0;
        // リクエストパラメータ指定
        $params = array(
            "Service" => "AWSECommerceService",
            "Operation" => "ItemSearch",
            "AWSAccessKeyId" => "",
            "AssociateTag" => "",
            "ResponseGroup" => 'ItemAttributes',
            "SearchIndex" => "Books",
            "Title" => $titleName
        );
        $response = $this->getResponseData($params);
        $parsed_xml = null;
        // レスポンスを配列で取得
        if (isset($response)) {
            $parsed_xml = simplexml_load_string($response);
            //echo "parsed_xml data: \"".$parsed_xml."\"";
        }
        if ($response && isset($parsed_xml) && !$parsed_xml->faultstring && !$parsed_xml->Items->Request->Errors) {
            $total_pages = $parsed_xml->Items->TotalPages;
        }
        
        $count = $total_pages > 10 ? 10 : $total_pages;
        for ($i = 1; $i <= $count; $i++) {
            $this->saveMangaData($titleName, $i, $controller);
        }
    }

    private function saveMangaData($titleName, $page, $controller) {
        
        // リクエストパラメータ指定
        $params = array(
            "Service" => "AWSECommerceService",
            "Operation" => "ItemSearch",
            "AWSAccessKeyId" => "",
            "AssociateTag" => "",
            "ResponseGroup" => 'ItemAttributes, Offers, Images, Reviews',
            "SearchIndex" => "Books",
            "Title" => $titleName,
            "ItemPage" => $page,
        );
        
        $response = $this->getResponseData($params);
        $parsed_xml = null;
        // レスポンスを配列で取得
        if (isset($response)) {
            $parsed_xml = simplexml_load_string($response);
            //echo "parsed_xml data: \"".$parsed_xml."\"";
        }
        // Amazonへのレスポンスが正常に行われていたら
        if ($response && isset($parsed_xml) && !$parsed_xml->faultstring && !$parsed_xml->Items->Request->Errors) {
            foreach ($parsed_xml->Items->Item as $current) {
                $isbn           = $current->ItemAttributes->ISBN;
                $title          = $current->ItemAttributes->Title;
                $author         = $current->ItemAttributes->Author;
                $manufacturer   = $current->ItemAttributes->Manufacturer;
                $imgM         = $current->MediumImage->URL;
                $imgL         = $current->LargeImage->URL;

                $data = array(
                    'BookData' => array(
                        'isbn' => $isbn,
                        'title' => $title,
                        'author' => $author,
                        'manufacturer' => $manufacturer,
                        'imgM' => $imgM,
                        'imgL' => $imgL,
                        'searchName' => $titleName
                    )
                );
                $controller->BookData->create($data);
                $controller->BookData->save($data);
            }
            
        }
    }
    
    private function getResponseData($params) {
        
        // タイムスタンプの追加
        if (!isset($params["Timestamp"])) {
            $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
        }
        // パラメータをソート
        ksort($params);
        $pairs = array();
        // key=valueの形式に、URLエンコード
        foreach ($params as $key => $value) {
            array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
        }
        // パラメータ->url
        $canonical_query_string = join("&", $pairs);
        // ヘッダー内容追加
        $string_to_sign = "GET\n".self::ENDPOINT."\n".self::URI."\n".$canonical_query_string;

        // HMAC-SHA256ハッシュアルゴリズムでSignatureを生成（RFC2104準拠）
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, self::AWS_SECRET_KEY, true));
        // リクエスト用に追加
        $request_url = 'http://'.self::ENDPOINT.self::URI.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
        //echo "Signed URL: \"".$request_url."\"";
        error_reporting(0);
        $response = file_get_contents($request_url);
        error_reporting(-1);
        return $response;
    }
}