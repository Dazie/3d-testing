<?

class add_test extends ACore_Admin
{
    public function obr()
    {
        $test_name = $_POST['test-name'];
        $test_description = $_POST['test_description'];

        if (!$test_name) {
            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Заполните все поля
                </div>';
        }

        if (!$this->try_test_name($test_name)) {
            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Тест с таким названием уже существует!
                </div>';
        }

        $this->addTest($_POST);
    }

    public function addQuestion($postArray, $testId)
    {
        $arQuestions = [];
        foreach ($postArray as $key => $item) {
            if (strpos($key, 'test-question-') !== false) {
                $arQuestions[$key] = $item;
            }
        }

        if (!empty($arQuestions)) {
            foreach ($arQuestions as $key => $question) {
                $queryTest = "INSERT INTO test_questions
                    (q_text, test)
                  VALUES ('$question', '$testId')";
                if (!mysql_query($queryTest)) {
                    exit(mysql_error());
                } else {
                    //получаем id добавленного вопроса
                    $questionID = $this->get_question_by_text($question);
                    $this->addAnswer($postArray, $questionID, $key);
                }
            }
        }
    }

    public function addAnswer($postArray, $questionID, $keyQ)
    {
        $arAnswers = [];
        $bAnswArea = false;
        $iterator=0;
        foreach ($postArray as $key => $item) {
            echo '<pre>', var_dump($key, $keyQ), '</pre>';
            if ($key === $keyQ) {
                $bAnswArea = true;
            } elseif (strpos($key, 'test-question-') !== false && $bAnswArea === true) {
                break;
            }
            if (strpos($key, 'test-answ-') !== false && $bAnswArea === true) {
                $arAnswers[] = ['text' => $item, 'correct' => 'N'];
                $iterator++;
            };
            if (strpos($key, 'right-answ-') !== false && $bAnswArea === true){
                $arAnswers[$iterator-1]['correct'] = 'Y';
            }

        }
        var_dump($arAnswers);

        if (!empty($arAnswers)) {
            foreach ($arAnswers as $answer) {
                $answerText = $answer['text'];
                $answerCorrect = $answer['correct'];
                $queryAnsw = "INSERT INTO test_answ
                    (a_text, a_correct, question)
                  VALUES ('$answerText', '$answerCorrect', '$questionID')";
                if (!mysql_query($queryAnsw)) {
                    exit(mysql_error());
                }
            }
        }
    }

    public function addTest($postArray)
    {

        $testName = $postArray['test-name'];
        $testDescription = $postArray['test_descr'];

        $queryTest = "INSERT INTO tests
                    (test_name, test_descr)
                  VALUES ('$testName', '$testDescription')";
        if (!mysql_query($queryTest)) {
            exit(mysql_error());
        } else {
            $testId = $this->get_test_by_name($testName);
            $this->addQuestion($postArray, $testId);
            $_SESSION['res'] = 'Добавлено';
            header("Location:?option=add_test");
            exit();
        }
    }

    public function get_content()
    {
        echo '<div id="main" class="col-md-9">';
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }

        echo '<form class="add_test form-horizontal"  action="" method="post">
        <div class = "group-test">
            <div class = "form-group">
                <label for="test-name" class="col-md-3 control-label">Название теста:</label>
                <div class = "col-md-9">
                    <input id="test-name" type="text" name="test-name" class="form-control">
                </div>
            </div>
            <div class = "form-group">
                <label for="test_descr" class="col-md-3 control-label">Описание теста:</label>
                <div class = "col-md-9">
                    <input id="test-descr" type="text" name="test_descr" class="form-control">
                </div>
            </div>
        </div>
        <div class = "question-group">
            <div class="form-group">
                <label for="test-question-1" class="col-md-3 control-label">Вопрос 1:</label>
                <div class = "col-md-9">
                    <input id="test-question-1" type="text" name="test-question-1" class="form-control">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="answer-group">
                <div class="form-group">
                    <label for="test-answ-1" class="col-md-3 control-label">Ответ 1:</label>
                    <div class = "col-md-9">
                        <input id="test-answ-1" type="text" name="test-answ-1" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                        <label class="form-check-label">
                <input class="form-check-input right-answ-1" type="checkbox" name="right-answ-1" id="right-answ-1" value="option1" checked>
                Правильный ответ
                </label></div>
                <button type="button" class="btn btn-add-answ add-answ-1">Добавить ответ</button>
            </div>
        </div>
        <button type="button" class="btn btn-add-question">Добавить вопрос</button>
        <div class="clearfix"></div>
        </div>
        <input type="submit" class="btn btn-primary" name="button" value="Сохранить">
    </form>
            </div></div>
    ';
    }
}