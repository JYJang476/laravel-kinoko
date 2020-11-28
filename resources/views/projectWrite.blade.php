@include("layouts.master")

<!doctype html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>새 프로젝트 추가</title>

    <style>
        * {
            color: #707070
        }

        .realContentDiv {
            width: 95%;
            height: 85%;
            margin-left: 2.5%;
            display: flex;
            flex-direction: column;
        }

        .txtTitle {
            width: 100%;
            height: 50px;
        }

        .techDiv {
            width: 100%;
            height: 220px;
        }

        .headerDiv {
            width: 100%;
            height: 40px;
            line-height: 40px;
            display: flex;
            justify-content: space-between;
        }

        .headerDiv div:nth-child(2) {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .listHeaderDiv {
            width: 100%;
            height: 40px;
            line-height: 40px;
            display: flex;
            justify-content: space-between;
        }

        .listHeaderDiv div:nth-child(1),
        .itemDiv div:nth-child(1){
            width: 10%;
            padding-left: 10px;
            border-right: 1px solid #707070;
        }

        .itemDiv div:nth-child(1) {
            border:  none;
        }

        .listHeaderDiv div:nth-child(2),
        .itemDiv div:nth-child(2) {
            width: 90%;
            text-align: left;
            padding-left: 20px;
        }

        .listDiv {
            width: 100%;
            height: 180px;
            background-color: white;
            border: 1px solid #707070
        }

        .listHeaderDiv {
            width: 100%;
            height: 40px;
        }

        .listItemDiv {
            width: 100%;
            height: 140px;
        }

        .itemDiv {
            width: 100%;
            height: 40px;
            line-height: 40px;
            display: flex;
            justify-content: space-between;
        }

        .imgDiv {
            margin-top: 50px;
            width: 100%;
            height: 50%;
        }

        .imgListDiv {
            width: 100%;
            height: 82px;
            display: flex;
            justify-content: flex-start;
        }

        .imgListDiv img {
            width: 82px;
            height: 82px;
            margin-right: 10px;
        }

        .getImgDiv {
            width: 100%;
            height: 70%;
            margin-top: 3%;
            background-color: white;
            border: 1px solid #707070;
        }
    </style>
</head>
<body>
    <div class="mainDiv">
        @yield("nav")
        <div class="contentDiv">
            <div class="subContentDiv">
                <div class="categoryDiv">
                    Project > 새 프로젝트
                </div>
                <input name="txtTitle" class="txtTitle" type="text" placeholder="제목을 입력해주세요">
                <div class="techDiv">
                    <div class="headerDiv">
                        <div>사용기술</div>
                        <div>@yield("techAddButton")</div>
                    </div>
                    <div class="listDiv">
                        <div class="listHeaderDiv">
                            <div>번호</div>
                            <div>제목</div>
                        </div>
                        <div class="listItemDiv">
                            <div class="itemDiv">
                                <div>1</div>
                                <div>제목1</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="imgDiv">
                    <div class="imgListDiv">
                        <img src="http://placehold.it/82x82/efa/aae&text=image" alt="">
                        <img src="http://placehold.it/82x82/efa/aae&text=image" alt="">
                        <img src="http://placehold.it/82x82/efa/aae&text=image" alt="">
                    </div>
                    <div class="getImgDiv">

                    </div>
                </div>
                <hr>
                <div class="FootDiv">
                    <button>글쓰기</button>
                    <button>취소</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>