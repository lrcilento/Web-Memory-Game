<?php
    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: config/login.php");
        exit();
    }
?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Memory Game</title>
    </head>
    <body>
        <style>
            h1{ 
                text-align: center;
            }
            p {
                text-align: center;
                font-size:larger;
            }
            button {
                margin:auto;
                display:block;
            }
            #main {
                background-color: lightgrey;
                border: 2px solid black;
                border-radius: 25px;
                padding: 20px;
                width:35%;
                margin: auto;
            }
            body {
                background-color: darkblue;
            }
            table {
                border-collapse: collapse; 
                background-color:white;
                margin: auto;
            }
            td {
                border: 1px solid black;
                font-size:larger;
                text-align: center;                
            }
        </style>

        <script src="https://unpkg.com/react@16.8.6/umd/react.development.js"></script>
        <script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.development.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

        <div id="main">

            <h1>Memory Game</h1>

            <div id="root"></div>

            <p id="scoreBoard"></p>

            <button onclick="generate()">New Game!</button>
            <br>
            <button onclick="window.location.href='config/leaderboards.php';">Leaderboards</button>
            <br>

        </div>

        <script>

            var t = setInterval(countDown,500);
            clearInterval(t)
            var arr = [1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6]
            var points = 0
            var time = 0;
            var turn = 0;
            var tempCard = 0;
            var cardOpen = "";
            var cardOpen2 = "";
            var done = [];
            var watcherStatus = 0;
            var moves = 0;

            function generate() {
                window.points = 0;
                window.turn = 0;
                window.tempCard = 0;
                window.cardOpen = "";
                window.cardOpen2 = "";
                window.done = []
                window.time = 0;
                window.moves = 0;
                window.arr = shuffle(arr)
                updateSB()
                clearInterval(window.t)
                
                t = setInterval(countDown,1000);
                var x = document.getElementsByClassName("card")
                for (i = 0; i < x.length; i++) {
                    x[i].src = "imgs/cardBack.png";
                }
                var structure = React.createElement("table", null,
                                    React.createElement("tr", null,
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card1", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card2", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card3", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card4", style: {height: "64px", width: "64px"}}, null)
                                        )
                                    ),
                                    React.createElement("tr", null,
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card5", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card6", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card7", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card8", style: {height: "64px", width: "64px"}}, null)
                                        )
                                    ),
                                    React.createElement("tr", null,
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card9", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card10", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card11", style: {height: "64px", width: "64px"}}, null)
                                        ),
                                        React.createElement("td", null,
                                            React.createElement("img", {src:"imgs/cardBack.png", className:"card", id:"card12", style: {height: "64px", width: "64px"}}, null)
                                        )
                                    )
                                )

                ReactDOM.render(structure, document.getElementById('root'))
                if(watcherStatus == 0){
                    watcherStatus++
                    watcher()
                }
            }

            function changeImg(id) {
                switch(id) {
                    case "card1":
                        var arrPos = 0
                        break;
                    case "card2":
                        var arrPos = 1
                        break;
                    case "card3":
                        var arrPos = 2
                        break;
                    case "card4":
                        var arrPos = 3
                        break;
                    case "card5":
                        var arrPos = 4
                        break;
                    case "card6":
                        var arrPos = 5
                        break;
                    case "card7":
                        var arrPos = 6
                        break;
                    case "card8":
                        var arrPos = 7
                        break;
                    case "card9":
                        var arrPos = 8
                        break;
                    case "card10":
                        var arrPos = 9
                        break;
                    case "card11":
                        var arrPos = 10
                        break;
                    case "card12":
                        var arrPos = 11
                        break;
                }
                if (!done.includes(window.arr[arrPos]) && id != cardOpen) {
                    if (turn == 0) {
                        if (cardOpen != 0) {
                            document.getElementById(cardOpen).src = "imgs/cardBack.png"
                            document.getElementById(cardOpen2).src = "imgs/cardBack.png"
                            window.cardOpen = ""
                            window.cardOpen2 = ""
                            window.tempCard = 0
                        }
                        document.getElementById(id).src = "imgs/"+window.arr[arrPos]+".png"
                        window.tempCard = window.arr[arrPos];
                        window.cardOpen = id;
                        window.turn ++;
                        window.moves ++;
                        updateSB()
                    }
                    else {
                        document.getElementById(id).src = "imgs/"+window.arr[arrPos]+".png"
                        if (window.tempCard - window.arr[arrPos] == 0) {
                            window.done[points] = window.arr[arrPos]
                            window.points++
                            window.cardOpen = ""
                            window.cardOpen2 = ""
                            window.tempCard = 0
                            updateSB()
                            if (window.points == 6) {
                                clearInterval(t)
                                end()
                            }
                        }
                        else {
                            cardOpen2 = id;
                        }
                        window.turn = 0;
                        window.moves ++;
                        updateSB()
                    }
                }

            }

            function countDown() {
                window.time++
                updateSB()
            }

            function updateSB() {
                document.getElementById("scoreBoard").innerHTML = "Moves: "+window.moves+" | Time: "+window.time+"s";
            }

            function shuffle(array) { 
                for (var i = array.length - 1; i > 0; i--) {  
                    var j = Math.floor(Math.random() * (i + 1));                     
                    var temp = array[i]; 
                    array[i] = array[j]; 
                    array[j] = temp; 
                }        
                return array; 
            } 

            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            function watcher() {
                $('.card').click(function(){
                var id = $(this).attr('id');
                changeImg(id);
                });
            }

            async function end() {
                alert('Fim de Jogo!')
                window.location.replace('config/results.php?moves=' + window.moves + '&time=' + window.time);
            }

        </script>
    </body>
</html>