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
            width: 650px;
            color: #3366CC;
            margin: 0 auto;
            margin-top: 100px;
        }
        .note li{
            display: inline-block;
            background: #eee;
            width: 50px;
            height: 100px;
            text-align: center;
            line-height: 100px;
            margin: 5px;
        }
        .ctrl{
            width: 600px;
            height: 40px;
            margin: 0 auto;
            color: #3366CC;
            text-align: center;
            line-height: 40px;
        }
        .ctrl li{
            display: inline-block;
            width: 50px;
            background: #eeeeee;
            margin: 10px;
            border-radius: 5px;
            transition: all 0.8s;
        }
        .ctrl li:hover{
            color: #ffffff;
            background: #3366CC;
        }
        .animation{
            animation: playMp3 0.8s;
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
            score['粉刷匠'] = scores[0];
            score['欢乐颂'] = scores[1];
            $("#PlayScore").bind("click",function () {
                    scorePlay(score[selectItem(0)],parseInt(selectItem(1)),parseInt(selectItem(2)));
                });
        }

        function selectItem(item) {
            let select=document.getElementsByTagName("select")[item];
            let index = select.selectedIndex;
            return select.options[index].text;

        }

        function scorePlay(score,v,d) {
            let reg=/ *\d/g;
            let notes = score.match(reg);
            console.log(notes);
            let time=0;
            for (let i=0;i<notes.length;i++) {
                time+=(v*(notes[i].length-1));
                setTimeout("playMp3(" + (parseInt(notes[i][notes[i].length-1])+d).toString() + ")",time);
            }
        }

        function freePlay() {
            let events = event.srcElement.innerText;
            playMp3(events);
        }

        function playMp3(events) {
            let mp3 = document.getElementsByTagName("audio")[events-1];
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
<h2>1阶9调Piano1.0</h2>
<ul class="note" onmouseover="freePlay();">
    <li id="btn">1<audio id="1" src="mp3/1.mp3"></audio></li>
    <li>2<audio src="mp3/2.mp3"></audio></li>
    <li>3<audio src="mp3/3.mp3"></audio></li>
    <li>4<audio src="mp3/4.mp3"></audio></li>
    <li>5<audio src="mp3/5.mp3"></audio></li>
    <li>6<audio src="mp3/6.mp3"></audio></li>
    <li>7<audio src="mp3/7.mp3"></audio></li>
    <li>8<audio src="mp3/8.mp3"></audio></li>
    <li>9<audio src="mp3/9.mp3"></audio></li>
</ul>
<ul class="ctrl">
    <label>曲目:</label>
    <select>
        <option>粉刷匠</option>
        <option>欢乐颂</option>
    </select>
    <label>速度:</label>
    <select>
        <option>150</option>
        <option selected = "selected" >200</option>
        <option>250</option>
        <option>300</option>
    </select>
    <label>音调:</label>
    <select>
        <option>0</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option selected = "selected" >4</option>
    </select>
    <li>
        <span id="PlayScore">Play</span>
    </li>
</ul>
</body>
</html>