<?php
$file = 'phoneBook.json';

if(isset($_POST['submit'])){
    form_submit($file);
}

if(isset($_GET['delete'])){
    delete_element($file, $_GET['delete']);
}

//Функции
function form_submit($file){
    $clientName = $_POST['ClientName'];

    $phoneNumber = $_POST['PhoneNumber'];

    //валидация номера
    $telephone = str_replace([' ', '.', '-', '(', ')'], '', $phoneNumber); 

    if(preg_match('/^[0-9]/', $telephone)){  

        $fileArray = [];
        
        $key = 0; 

        if (file_exists($_SERVER['DOCUMENT_ROOT']."/task-php-phonebook/".$file)){
            $fileArray = json_decode(file_get_contents($file), true); 
            if(!is_null($fileArray)){
                $elementLast = $fileArray[array_key_last($fileArray)];
                
                $key = $elementLast['key'] + 1;
            }
        }

        $fileArray[] = ['Name' => $clientName, 'Number' => $phoneNumber, "key" => $key]; 

        $jsonInput = json_encode($fileArray, JSON_UNESCAPED_UNICODE);

        file_put_contents('phoneBook.json', $jsonInput);

        session_start();

        $_SESSION['Message'] = "<div class = 'message'>Запись успешно сохранена!</div>";

        session_write_close();

        header("location: index.php ");
    }
    else{
        session_start();

        $_SESSION['Message'] = "<div class = 'message wrong'>Номер введен неверно! В номере должны быть лишь буквы и специальные символы</div>";

        session_write_close();

        header("location: index.php ");
    }
}

function load_data($file){
    $str = "<div class='subtitle'> На данный момент файл пуст </div>";

    if (file_exists($_SERVER['DOCUMENT_ROOT']."/task-php-phonebook/".$file)){

        $fileArray = json_decode(file_get_contents($file), true); 
        
        if(!is_null($fileArray)){
            $str = "<table class = 'phoneTable'>";
        
            $str .= "<thead> 
                        <tr>
                            <th> Имя </th>
                            <th> Номер </th>
                            <th> </th>
                        </tr>
                    </thead>";
    
            $str .= "<tbody>"; 
    
            foreach($fileArray as $key => $arr){
                $str .= "<tr> 
                            <td>".$arr['Name']."</td>
                            <td>".$arr['Number']."</td>
                            <td> <a class = 'delete' href='logic.php?delete=".$arr['key']."'> Удалить </a> </td>
                        </tr>";
            }
    
            $str .= "</tbody> ";
            
            $str .= "</table> ";
        }

    }

    echo $str;
}

function delete_element($file, $key){
    $fileArray = json_decode(file_get_contents($file), true); 

    unset($fileArray[$key]);

    $json = json_encode($fileArray, JSON_PRETTY_PRINT);

	file_put_contents($file, $json);
 
	header('location: index.php');
}