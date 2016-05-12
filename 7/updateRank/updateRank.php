<?php

    updateRankDataTable("total");
    updateRankDataTable("story");
    updateRankDataTable("drawing_skill");
    updateRankDataTable("chara_appeal");
    updateRankDataTable("world_view");

    updateEvaluationCountTable();

    
    // 総合トップ10をソートで取得して、rank_dataテーブルに保存    
    function updateRankDataTable($rankType) {
        if($rankType == "") return;

        try {
            $pdo = new PDO('mysql:dbname=cakephpdb;charset=utf8;host=localhost','sunuma','sunuma0320');
        } 
        catch(PDOException $e) {
            var_dump($e->getMessage());
        }
        // トランザクション開始
        $pdo->beginTransaction();
        // 前回のランキングデータを削除
        $deleteStmt = $pdo->prepare("DELETE FROM rank_data WHERE type=:delete_type");
        $deleteStmt->bindValue(':delete_type', $rankType);
        $success = $deleteStmt->execute();
        if(!$success) {
            // 戻す
            $pdo->rollBack();
            echo "SQL error : DELETE FROM rank_data ...";
        }

        // ソート用の総合値
        $sortValue = '';
        switch ($rankType) {
            case 'total':
                $sortValue = 'total_point';
                break;
            case 'story':
                $sortValue = 'story_point';
                break;
            case 'drawing_skill':
                $sortValue = 'drawing_skill_point';
                break;
            case 'chara_appeal':
                $sortValue = 'chara_appeal_point';
                break;
            case 'world_view':
                $sortValue = 'world_view_point';
                break;
        }
        // 評価内容から評価ポイントの合計を出してそれぞれの総合値の高い順にソートする
        $stmt = $pdo->prepare("SELECT *, SUM(total) AS total_point, SUM(story) AS story_point, SUM(drawing_skill) AS drawing_skill_point, SUM(chara_appeal) AS chara_appeal_point, SUM(world_view) AS world_view_point FROM book_evaluations GROUP BY book_id ORDER BY ".$sortValue." DESC LIMIT 10");
        $success = $stmt->execute();

        if(!$success) {
            // 戻す
            $pdo->rollBack();
            echo "SQL error : SELECT * FROM book_evaluations ...";
        } else {
            // ランキング順位
            // 一つ前のポイント、前回と同じ順位だった場合は同一順位にする
            $rankCount = 0;
            $prevRankCount = 0;
            $prevPoint = -1;
            while ($evaluationData = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $stmtBookData = $pdo->prepare("SELECT * FROM book_data WHERE id=:book_id");
                $stmtBookData->bindValue(':book_id', $evaluationData['book_id']);
                $success = $stmtBookData->execute();
                if($success) {
                    // 順位チェック
                    if($evaluationData[$rankType] != $prevPoint) {
                        $rankCount += 1;
                        $prevRankCount = $rankCount;
                    } else {
                        $rankCount = $prevRankCount;
                    }
                    
                    $bookData = $stmtBookData->fetch(PDO::FETCH_ASSOC);
                    $stmtRankData = $pdo->prepare("INSERT INTO rank_data (id, book_id, title, author, manufacturer, imgM, imgL, story, drawing_skill, chara_appeal, world_view, total,  type, rank) VALUES(NULL, :book_id, :title, :author, :manufacturer, :imgM, :imgL, :story, :drawing_skill, :chara_appeal, :world_view, :total, :type, :rank)");

                    $stmtRankData->bindValue(':book_id', $bookData['id']);
                    $stmtRankData->bindValue(':title', $bookData['title']);
                    $stmtRankData->bindValue(':author', $bookData['author']);
                    $stmtRankData->bindValue(':manufacturer', $bookData['manufacturer']);
                    $stmtRankData->bindValue(':imgM', $bookData['imgM']);
                    $stmtRankData->bindValue(':imgL', $bookData['imgL']);
                    $stmtRankData->bindValue(':story', $evaluationData['story_point']);
                    $stmtRankData->bindValue(':drawing_skill', $evaluationData['drawing_skill_point']);
                    $stmtRankData->bindValue(':chara_appeal', $evaluationData['chara_appeal_point']);
                    $stmtRankData->bindValue(':world_view', $evaluationData['world_view_point']);
                    $stmtRankData->bindValue(':total', $evaluationData['total_point']);
                    $stmtRankData->bindValue(':type', $rankType);
                    $stmtRankData->bindValue(':rank', $rankCount);
                    $success = $stmtRankData->execute();
                    // 前回のポイントを更新
                    $prevPoint = $evaluationData[$rankType];
                    
                } else {
                    // 戻す
                    $pdo->rollBack();
                    echo "SQL error : SELECT * FROM book_data ...";
                }
            }
            //全て処理が終わったらコミット
            $pdo->commit();
        }
    }

    // 評価数の多い漫画を１０タイトル保存
    function updateEvaluationCountTable() {
        try {
            $pdo = new PDO('mysql:dbname=cakephpdb;charset=utf8;host=localhost','sunuma','sunuma0320');
        } 
        catch(PDOException $e) {
            var_dump($e->getMessage());
        }
        // トランザクション開始
        $pdo->beginTransaction();
        // 前回のランキングデータを削除
        $deleteStmt = $pdo->prepare("DELETE FROM rank_data WHERE type=:delete_type");
        $deleteStmt->bindValue(':delete_type', 'evaluationData_count');
        $success = $deleteStmt->execute();
        if(!$success) {
            // 戻す
            $pdo->rollBack();
            echo "SQL error : DELETE FROM rank_data ...";
        }

        // 評価の数が多かった順にソート
        $stmt = $pdo->prepare("SELECT *, COUNT(book_id) AS id_count FROM book_evaluations GROUP BY book_id ORDER BY id_count DESC LIMIT 10");
        $success = $stmt->execute();

        if(!$success) {
            // 戻す
            $pdo->rollBack();
            echo "SQL error : SELECT * FROM book_evaluations ...";
        } else {
            // ランキング順位
            // 一つ前のポイント、前回と同じ順位だった場合は同一順位にする
            $rankCount = 0;
            $prevRankCount = 0;
            $prevPoint = -1;
            while ($evaluationData = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $stmtBookData = $pdo->prepare("SELECT * FROM book_data WHERE id=:book_id");
                $stmtBookData->bindValue(':book_id', $evaluationData['book_id']);
                $success = $stmtBookData->execute();
                if($success) {
                    // 順位チェック
                    if($evaluationData[$rankType] != $prevPoint) {
                        $rankCount += 1;
                        $prevRankCount = $rankCount;
                    } else {
                        $rankCount = $prevRankCount;
                    }
                    
                    $bookData = $stmtBookData->fetch(PDO::FETCH_ASSOC);
                    $stmtRankData = $pdo->prepare("INSERT INTO rank_data (id, book_id, title, author, manufacturer, imgM, imgL, story, drawing_skill, chara_appeal, world_view, total,  type, rank) VALUES(NULL, :book_id, :title, :author, :manufacturer, :imgM, :imgL, :story, :drawing_skill, :chara_appeal, :world_view, :total, :type, :rank)");

                    $stmtRankData->bindValue(':book_id', $bookData['id']);
                    $stmtRankData->bindValue(':title', $bookData['title']);
                    $stmtRankData->bindValue(':author', $bookData['author']);
                    $stmtRankData->bindValue(':manufacturer', $bookData['manufacturer']);
                    $stmtRankData->bindValue(':imgM', $bookData['imgM']);
                    $stmtRankData->bindValue(':imgL', $bookData['imgL']);
                    $stmtRankData->bindValue(':story', $evaluationData['story']);
                    $stmtRankData->bindValue(':drawing_skill', $evaluationData['drawing_skill']);
                    $stmtRankData->bindValue(':chara_appeal', $evaluationData['chara_appeal']);
                    $stmtRankData->bindValue(':world_view', $evaluationData['world_view']);
                    // トータルに評価数を入れる　TODO:後でテーブルに評価数用のカラムを追加
                    $stmtRankData->bindValue(':total', $evaluationData['id_count']);
                    $stmtRankData->bindValue(':type', 'evaluationData_count');
                    $stmtRankData->bindValue(':rank', $rankCount);
                    $success = $stmtRankData->execute();
                    // 前回のポイントを更新
                    $prevPoint = $evaluationData[$rankType];
                    
                } else {
                    // 戻す
                    $pdo->rollBack();
                    echo "SQL error : SELECT * FROM book_data ...";
                }
            }
            //全て処理が終わったらコミット
            $pdo->commit();
        }
    }
?>
    