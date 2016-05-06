<!-- File: /app/View/Posts/view.ctp -->

<div class="bookdata">

    <h1><?php echo h($book['BookData']['title']); ?></h1>
    <br>

    <div class="bookInfo">
        <p><small>作者:<?php echo $book['BookData']['author']; ?></small></p>
        <p><small>出版社:<?php echo $book['BookData']['manufacturer']; ?></small></p>
        <?php echo $this->Html->image($book['BookData']['imgL']);?>

        <div class="box">
            <canvas id="radarChart" height="450" width="450"></canvas>
            <div id="legend"></div>
        </div>
    </div>
    <div class="evaluation">
    <?php
        $options = array('5' => 'すごくいい!', '4' => 'いい', '3' => 'ふつう', '2' => 'あんまり', '1' => 'うーん..');
        $attributes = array('value' => 3);
        echo $this->Form->create('BookEvaluation', array('url' => array('action' => 'add', $book['BookData']['id'])));
        echo $this->Form->radio('ストーリー', $options, $attributes);
        echo $this->Form->radio('画力', $options, $attributes);
        echo $this->Form->radio('キャラクター', $options, $attributes);
        echo $this->Form->radio('世界観', $options, $attributes);
        echo $this->Form->input('コメント', array('rows' => '3'));
        echo $this->Form->end('評価する');
    ?>
    </div>
</div>

<script id="script" 
    story         ='<?php echo $evaluationData[0]; ?>'
    drawSkill     ='<?php echo $evaluationData[1]; ?>'
    charaAppeal   ='<?php echo $evaluationData[2]; ?>'
    worldView     ='<?php echo $evaluationData[3]; ?>'
></script>

<script>
    function displayPieChart() {
        var $script         = $('#script');
        var story           = JSON.parse($script.attr('story'));
        var drawSkill       = JSON.parse($script.attr('drawSkill'));
        var charaAppeal     = JSON.parse($script.attr('charaAppeal'));
        var worldView       = JSON.parse($script.attr('worldView'));
        var data = {
            labels: ["ストーリー", "画力", "キャラクター", "世界観"],
            datasets: [
                {
                    label: "平均評価",
                    fillColor: "rgba(200,0,0,0.2)",
                    strokeColor: "red",
                    pointColor: "red",
                    pointStrokeColor: "red",
                    pointHighlightFill: "red",
                    pointHighlightStroke: "red",
                    data: [story, drawSkill, charaAppeal, worldView]
                }
            ]
        };
        var ctx = document.getElementById("radarChart").getContext("2d");
        var options = { 
          legendTemplate : "<% for (var i=0; i<datasets.length; i++){%><span style=\"background-color:<%=datasets[i].strokeColor%>\">&nbsp;&nbsp;&nbsp;</span>&nbsp;<%if(datasets[i].label){%><%=datasets[i].label%><%}%><br><%}%>"
        };
        var radarChart = new Chart(ctx).Radar(data, options);
        document.getElementById("legend").innerHTML = radarChart.generateLegend();
      }
</script>
