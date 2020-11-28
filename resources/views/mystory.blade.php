@include("layouts.master")

<!doctype html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>나의 스토리</title>

    <style>
        .realContentDiv {
            width: 100%;
            height: 97%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .contentLeftDiv {
            width: 35%;
            height: 100%;

        }

        .schDiv {
            width: 100%;
            height: 5%;
        }

        .boardDiv {
            width: 100%;
            height: 85%;
            background-color: white;
            border: 1px solid #707070;

        }

        .headerDiv {
            width: 100%;
            height: 5%;
            border-bottom: 1px solid #707070;
            display: flex;
            justify-content: space-between;
        }

        .headerDiv div, .itemDiv div {
            text-align: center;
            line-height: 2.25;
        }

        .headerDiv div:nth-child(1),
        .itemDiv div:nth-child(1) {
            width: 25%;
            height: 100%;
        }

        .headerDiv div:nth-child(2),
        .itemDiv div:nth-child(2) {
            width: 50%;
            height: 100%;
        }

        .headerDiv div:nth-child(3),
        .itemDiv div:nth-child(3){
            width: 25%;
            height: 100%;
        }

        .contentRightDiv {
            width: 60%;
            height: 85%;
            border: 1px solid #707070;
            background-color: white;
            margin-top: 4%;
        }

        .contentHeaderDiv {
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: space-between;
        }

        .contentHeaderDiv div:nth-child(1) {
            width: 70%;
            height: 100%;
            background-color: white;
        }

        .contentHeaderDiv div:nth-child(2) {
            width: 30%;
            height: 100%;
            background-color: yellow;
        }

        .contentContentDiv {
            width: 95%;
            height: 95%;
            margin-left: 2.5%;
            margin-top: 2.5%;
        }

        .listDiv {
            width: 100%;
            height: 100%;
        }

        .itemDiv {
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: space-around;
        }

    </style>
</head>
<body>
    <div class="mainDiv">
        @yield("nav")
        <div class="contentDiv">
            <div class="subContentDiv">
                <div class="categoryDiv">
                    My Story
                </div>
                <div class="realContentDiv">
                    <div class="contentLeftDiv">
                        <div class="schDiv">
                            <div class="txtBoxDiv">
                                <input class="sch_txt" name="sch_txt" type="text" placeholder="검색어">
                                <a href="">
                                    <img src="" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="boardDiv">
                            <div class="headerDiv">
                                <div>번호</div>
                                <div>제목</div>
                                <div>날짜</div>
                            </div>
                            <div class="listDiv">
                                <div class="itemDiv">
                                    <div>1</div>
                                    <div>제목1</div>
                                    <div>2020-11-11</div>
                                </div>
                            </div>
                        </div>
                        <div class="contentFootDiv">
                            <button>글쓰기</button>
                        </div>
                    </div>
                    <div class="contentRightDiv">
                        <div class="rightContentDiv">
                            <div class="contentHeaderDiv">
                                <div>제목</div>
                                <div>2020-11-11</div>
                            </div>
                            <div class="contentContentDiv">
                                내용입니다.
                            </div>
                        </div>
                        <div class="rightFootDiv">
                            <button>삭제</button>
                            <button>수정</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
