<?
require_once("../config.php");

$db = mysql_connect(HOST, USER, PASSWORD);
if (!$db) {
    exit("Ошибка соединения с базой данных" . mysql_error());
}
if (!mysql_select_db(DB, $db)) {
    exit("Нет такой бд" . mysql_error());
}
mysql_query("SET NAMES 'UTF8'");

$arAnswers = [];
$arResult = [];
$aNumRights = 0;
$curTime= time();

foreach ($_POST as $key => $answer){
    if($key !== 'time_result'){
        $newKey = (int)preg_replace('/[^0-9]/', '', $key);
        $arAnswers[$newKey] = $answer;
    }
}
foreach ($arAnswers as $id_answer => $text_answer){
    $queryAnswers = "SELECT a_id, a_text, a_correct, question FROM test_answ WHERE a_id='$id_answer'";
    $resultAnswers = mysql_query($queryAnswers);

    if (!$resultAnswers) {
        exit(mysql_error());
    }
    for ($i = 0; $i < mysql_num_rows($resultAnswers); $i++) {
        $answer = mysql_fetch_array($resultAnswers, MYSQL_ASSOC);
        if ($answer['a_correct'] === 'Y'){
            $aNumRights+= 1;
        }
        $arResult[] = $answer['a_correct'];
    }
}
echo '<div class="test-result-header">Количество правильных ответов: '.$aNumRights.'</div>';
echo '<table class ="table table-responsive table-bordered test-result">';
echo '<tr>';
foreach (array_keys($arResult) as $key){
    echo '<th>'.($key+1).'</td>';
}
echo '</tr>';
echo '<tr>';
foreach ($arResult as $answer){
    ;
    if($answer==='Y'){
        echo '<td class="success-answ"> &#9745;</td>';
    }
    if($answer==='N'){
        echo '<td class="error-answ"> &#9746;</td>';
    }
}
echo '</tr>';
echo '</table>';

echo '<div class="test-result-header">Затрачено: '.round((($curTime-(int)$_POST['time'])/60), 1).' с.</div>';
