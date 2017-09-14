<?

class test extends ACore
{

    public function get_content()
    {
        echo "<div id='main' class='col-md-7'>";
        if (!$_GET['id_test']) {
            echo "Неправильные данные для вывода теста";
        } else {
            $id_test = (int)$_GET['id_test'];
            if (!$id_test) {
                echo "Неправильные данные для вывода статьи";
            } else {
                $queryQuestions = "SELECT q_id, q_text FROM test_questions WHERE test='$id_test'";
                $resultQuestions = mysql_query($queryQuestions);
                if (!$resultQuestions) {
                    exit(mysql_error());
                }
                for ($i = 0; $i < mysql_num_rows($resultQuestions); $i++) {
                    $question = mysql_fetch_array($resultQuestions, MYSQL_ASSOC);
                    $arQuestions[$question['q_id']]['question'] = ['text' => $question['q_text']];
                }
                if (!empty($arQuestions)) {
                    $arQuestId = array_keys($arQuestions);

                    foreach ($arQuestId as $questId) {
                        $queryAnswers = "SELECT a_id, a_text, a_correct, question FROM test_answ WHERE question='$questId'";
                        $resultAnswers = mysql_query($queryAnswers);
                        if (!$resultAnswers) {
                            exit(mysql_error());
                        }
                        for ($i = 0; $i < mysql_num_rows($resultAnswers); $i++) {
                            $answer = mysql_fetch_array($resultAnswers, MYSQL_ASSOC);
                            $arQuestions[$questId]['answers'][$answer['a_id']] = ['text' => $answer['a_text']];
                        }
                    }
                }

                /*echo '<pre>';
                var_export($arQuestions, false);
                echo '</pre>'; */?>
                <? if (!empty($arQuestions)) { ?>
                    <form method="post" class="test">
                        <ul class="nav nav-tabs">
                            <?
                            $qIterator = 1;
                            foreach (array_keys($arQuestions) as $value) { ?>
                                <li <?= $qIterator == 1 ? 'class="active"' : '' ?>>
                                    <a data-toggle="tab" href="#panel_<?= $value ?>">Вопрос <?= $qIterator ?></a>
                                </li>
                                <?
                                $qIterator += 1;
                            } ?>
                        </ul>
                        <div class="tab-content">
                            <?
                            $aIterator = 0;
                            foreach ($arQuestions as $key => $question) {
                                 ?>
                                <div id="panel_<?= $key ?>" class="tab-pane fade <?= $aIterator == 0? 'in active' : ''?>">
                                    <p class="question"><?= $question['question']['text'] ?></p>
                                    <div class="custom-controls-stacked">
                                    <?
                                    foreach ($question['answers'] as $a_key=>$answer) { ?>
                                        <label class="custom-control custom-radio">
                                            <input id="answerRadio<?= $a_key ?>" name="answerRadio<?= $aIterator ?>"
                                                   type="radio"
                                                   class="custom-control-input"
                                            value="<?=$answer['text']?>">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description"><?= $answer['text'] ?></span>
                                        </label>
                                        <?
                                    }
                                    $aIterator += 1;?>
                                        </div>
                                </div>
                                <?

                            } ?>
                        </div>
                        <input type="hidden" id="time_start" name="time_start" value="<?= time()?>">
                        <input type="hidden" id="test_id" name="test_id" value="<?= $id_test?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?= $_SESSION['userID']?>">
                        <button class="test-final">Закончить тестирование</button>
                    </form>
                <? } ?>
                <?
            }
        }
    }
}

;