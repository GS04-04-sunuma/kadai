<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $this->fetch('title'); ?>
        </title>
        <?php
            echo $this->Html->meta('icon');

            echo $this->Html->css('cake.generic');
            echo $this->Html->css('slick');
            echo $this->Html->css('slick-theme');
            echo $this->Html->css('style');
            echo $this->Html->script( '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js');
            echo $this->Html->script('slick.min.js');
            echo $this->Html->script( 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js');
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
    </head>
    <body onload="displayPieChart();">
        <div id="container">
           <!--
            <div id="header">
                <h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
            </div>
            -->
            <div id="header">漫画評価サイト</div>
            <div id="content">
                <?php echo $this->Flash->render(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
            <!--
            <div id="footer">
                <?php echo $this->Html->link($this->Html->image(
                            'cake.power.gif',
                            array('alt' => $cakeDescription, 'border' => '0')),'http://www.cakephp.org/', array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
                    );
                ?>
                <p>
                    <?php echo $cakeVersion; ?>
                </p>
            </div>
            -->
        </div>
        <script>
            $(function(){
                $('.sample').slick({
                    infinite: true,
                    slidesToShow: 8,
                    slidesToScroll: 8,
                });
            }); 
            
            function displayPieChart() {
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
                            data: [5, 3, 2, 3]
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
        <!--
        <?php echo $this->element('sql_dump'); ?>
        -->
    </body>
</html>
