<?php
/**
 * Created by PhpStorm.
 * User: Dearvee
 * Date: 2017/5/26
 * Time: 14:23
 */
include $scores.'score.php';
$score=implode("*",$scores);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Piano</title>
    <style>
        body{
            background: url("../../../index/back.png");
        }
        h2{
            width: 200px;
            color: #3366CC;
            margin: 0 auto;
            text-align: center;
            text-shadow: 1px 1px 2px #3366CC;
        }
        .note{
            width: 850px;
            color: #3366CC;
            margin: 0 auto;
        }
        .note li{
            display: inline-block;
            background: #eee;
            width: 50px;
            height: 100px;
            text-align: center;
            line-height: 100px;
            margin: 5px auto;
            box-shadow: 2px 2px 1px #3366CC;
        }
        .ctrl{
            width: 800px;
            height: 40px;
            margin: 0 auto;
            color: #3366CC;
            text-align: center;
            line-height: 40px;
        }
        .play{
            display: inline-block;
            background: #eeeeee;
            color: #3366CC;
            margin: 10px;
            border-radius: 5px;
            padding: 2px;
            border: none;
            cursor: pointer;
            box-shadow: 2px 2px 1px #3366CC;
            transition: all 0.3s;
        }
        .play:hover{
            color: #ffffff;
            background: #3366CC;
        }
        .animation{
            animation: playMp3 0.8s;
        }
        .userMusic{
            width: 300px;
            height: 100px;
            color: #3366CC;
            font-size: 1.5em;
            padding: 10px;
        }
        @keyframes playMp3 {
            0%{height: 100px;}
            50%{height: 10px;background: #3366CC;}
            100%{height: 100px;}
        }
    </style>
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
    <script>
        window=onload=function () {
            let scores = "<?=$score?>".split("*");
            let score=[];
            score['F大调快板(Mozart)'] = scores[0];
            score['费加罗婚礼选段(Mozart)'] = scores[1];
            score['乱调的调调#_#'] = scores[2];
            //score['粉刷匠'] = scores[2];
            //score['欢乐颂'] = scores[3];
            $("#playScore").bind("click",function () {
                scorePlay(score[selectItem(0)],parseInt(selectItem(1)),parseInt(selectItem(2)),parseInt(selectItem(3)));
                });

            $("#playUserMusic").bind("click",function () {//播放输入音谱
                let score=$("#userMusic").val();
                scorePlay(score,selectItem(1),parseInt(selectItem(2)),parseInt(selectItem(3)));
            });
        }

        function selectItem(item) {
            let select=document.getElementsByTagName("select")[item];
            let index = select.selectedIndex;
            return select.options[index].text;
        }

        function scorePlay(score,v,d,j) {
            let reg=/ *[a-g]\d/g;
            let notes = score.match(reg);
            let time=0;
            for (let i=0;i<notes.length;i++) {
                time+=(v*(notes[i].length-2));
                //setTimeout("playMp3(" + (parseInt(notes[i][notes[i].length-1])+d).toString() + ")",time);
                setTimeout("playMp3('" + (String.fromCharCode(notes[i][notes[i].length-2].charCodeAt(0)+d)).toString()+(parseInt(notes[i][notes[i].length-1])+j).toString() + "')",time);
            }
        }

        function freePlay() {
            let events = event.srcElement.innerText;
            playMp3(events);
        }

        function playMp3(events) {
            let mp3 = document.getElementById("audio"+events);
            mp3.currentTime = 0;
            mp3.play();
            let li = document.getElementById("li"+events);
            $(li).removeClass().addClass("animation");
                    setTimeout(function(){
                        $(li).removeClass();
                    },1000);
        }
    </script>
</head>
<body>
<h2>7调7阶 49键Piano2.1</h2>
<ul class="note" onmouseover="freePlay();">
    <?
    for($i=1;$i<8;$i++)
        for($j=1;$j<8;$j++) {
            $name=chr($i+ord('a')-1).$j;
            echo "<li id=\"li"
                . $name . "\" 
            style=\"background: rgba(51,102,204,".(0.7-$i/10).");
            color:rgba(51,102,204,".(0.3+$i/10).")\">"
                . $name . "<audio id=\"audio" . $name . "\" src=\"mp3/"
                . $name . "!.mp3\"></audio></li>";
        }
    ?>
</ul>
<ul class="ctrl">
    <label>曲目:</label>
    <select>
        <option>F大调快板(Mozart)</option>
        <option>费加罗婚礼选段(Mozart)</option>
        <option>乱调的调调#_#</option>
    </select>
    <label>速度:</label>
    <select>
        <option>150</option>
        <option>200</option>
        <option>250</option>
        <option>300</option>
    </select>
    <label>音调:</label>
    <select>
        <option>0</option>
        <option>+1</option>
        <option>+2</option>
        <option>+3</option>
        <option>+4</option>
        <option>-1</option>
        <option>-2</option>
        <option>-3</option>
        <option>-4</option>
    </select>
    <label>音阶:</label>
    <select>
        <option>0</option>
        <option>+1</option>
        <option>+2</option>
        <option>+3</option>
        <option>+4</option>
        <option>-1</option>
        <option>-2</option>
        <option>-3</option>
        <option>-4</option>
    </select>
    <li class="play">
        <span id="playScore">Play the Score</span>
    </li>
    <div>Better:【曲目:F大调快板 速度:150 音调:0 音阶:0】【曲目:费加罗的婚礼 速度:300 音调:0 音阶:0】</div>
    <div>PS:数字代表音符，空格代表间隔，例如：e5 e3 e1 d5 e3 e2 e4(如果速度过快，可通过多选框调节)</div>
    <textarea id="userMusic" class="userMusic" placeholder="你的旋律"></textarea>
    <br/>
    <div id="playUserMusic" class="play">Play your music!</div>
</ul>
</body>
</html>