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
            background: url("../../index/back.png");
        }
        h2{
            width: 200px;
            color: #3366CC;
            margin: 0 auto;
            text-align: center;
            text-shadow: 1px 1px 2px #3366CC;
        }
        .note{
            width: 450px;
            color: #3366CC;
            margin: 0 auto;
            margin-top: 50px;
        }
        .note li{
            display: inline-block;
            background: #eee;
            width: 50px;
            height: 100px;
            text-align: center;
            line-height: 100px;
            margin: 5px;
            box-shadow: 2px 2px 1px #3366CC;
        }
        .ctrl{
            width: 600px;
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
            50%{height: 0;background: #3366CC;}
            100%{height: 100px;}
        }
    </style>
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
    <script>
        window=onload=function () {
            let scores = "<?=$score?>".split("*");
            let score=[];
            score['F大调快板(Mozart)'] = scores[0];
            score['粉刷匠'] = scores[1];
            score['欢乐颂'] = scores[2];
            $("#playScore").bind("click",function () {//播放选择音谱
                scorePlay(score[selectItem(1)],selectItem(0),parseInt(selectItem(2)),parseInt(selectItem(3)));
                });

            $("#playUserMusic").bind("click",function () {//播放输入音谱
                let score=$("#userMusic").val();
                scorePlay(score,selectItem(0),parseInt(selectItem(2)),parseInt(selectItem(3)));
            });
        }

        function selectItem(item) {
            let select=document.getElementsByTagName("select")[item];
            let index = select.selectedIndex;
            return select.options[index].text;
        }

        function scorePlay(score,tune,v,d) {
            let reg=/ *\d/g;
            let notes = score.match(reg);
            console.log(notes);
            let time=0;
            for (let i=0;i<notes.length;i++) {
                time+=(v*(notes[i].length-1));
                setTimeout("playMp3(" + (parseInt(notes[i][notes[i].length-1])+d).toString() + ",'"+ tune + "')",time);
            }
        }

        function freePlay(tune) {
            let events = event.srcElement.innerText;
            playMp3(events,tune);
        }

        function playMp3(events,tune) {
            let mp3 = document.getElementsByTagName("audio")[events-1];
            mp3.src="mp3/"+tune+events+"!.mp3";
            mp3.currentTime = 0;
            mp3.play();
            let li = document.getElementsByTagName("li");
            $(li[events-1]).removeClass().addClass("animation");
                    setTimeout(function(){
                        $(li[events-1]).removeClass();
                    },1000)
        }
    </script>
</head>
<body>
<h2>7调(选)7阶 49选7键Piano2.0</h2>
<ul class="note" onmouseover="freePlay(selectItem(0));">
    <li>1<audio src="mp3/e1!.mp3"></audio></li>
    <li>2<audio src="mp3/e2!.mp3"></audio></li>
    <li>3<audio src="mp3/e3!.mp3"></audio></li>
    <li>4<audio src="mp3/e4!.mp3"></audio></li>
    <li>5<audio src="mp3/e5!.mp3"></audio></li>
    <li>6<audio src="mp3/e6!.mp3"></audio></li>
    <li>7<audio src="mp3/e7!.mp3"></audio></li>
</ul>
<ul class="ctrl">
    <label>音调:</label>
    <select>
        <option>a</option>
        <option>b</option>
        <option>c</option>
        <option>d</option>
        <option selected="selected">e</option>
        <option>f</option>
        <option>g</option>
    </select>
    <label>曲目:</label>
    <select>
        <option>F大调快板(Mozart)</option>
        <option>粉刷匠</option>
        <option>欢乐颂</option>
    </select>
    <label>速度:</label>
    <select>
        <option>150</option>
        <option>200</option>
        <option>250</option>
        <option>300</option>
    </select>
    <label>升调:</label>
    <select>
        <option>0</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
    </select>
    <li class="play">
        <span id="playScore">Play the Score</span>
    </li>
    <div>数字代表音符，空格代表间隔，例如：5 3 5 3 5 3 1</div>
    <textarea id="userMusic" class="userMusic" placeholder="你的旋律"></textarea>
    <br/>
    <div id="playUserMusic" class="play">Play your music!</div>
</ul>
</body>
</html>