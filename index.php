<?php
session_start();
include ('logic.php');
?>
<html>
<head>
    <link href="css/main.css" rel="stylesheet" />
</head>
<body>
    <form action = "logic.php" method = "post" class = "form">
            <div class="title">Здравствуйте</div>
            <div class="subtitle">Давайте введем входные данные!</div>
            <div>
                <input type = "text" name = "ClientName" class = "formInput" placeholder = "Введите имя клиента">
            </div>
            <div >
                <input type = "text" name = "PhoneNumber" class = "formInput" placeholder = "Введите телефон клиента">
            </div>
            <div >
                <input type = "submit" value = "Сохранить" name = "submit" class = "submitButton">
            </div>
            <?php
                if(isset($_SESSION['Message'])){
                    echo $_SESSION['Message'];
                    session_unset();
                }

            ?>
    </form>
    <div class = "phoneList">
        <?php load_data($file); ?>
    </div>
</body>    
</html>