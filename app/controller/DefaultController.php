<?php

namespace App\Controller;

use App\Lib\Analyzer\Analyzer;
use ErrorException;

class DefaultController
{
    private $headers = [
        404 => 'HTTP/1.0 404 Not Found'
    ];

    /**
     *  Анализ текста
     *
     * @return mixed
     * @throws ErrorException
     */
    public function analyzeAction()
    {
        $text = trim(strip_tags($_POST['text']));

        if (!$text) {
            return $this->errorPage('Текст не должен быть пустым!');
        }

        $analyzer = new Analyzer($text);

        $data = [
            'words_count'   => $analyzer->countWords(),
            'popular_words' => $analyzer->getPopularWords(10),
            'text'          => $analyzer->filterBadText('#!*^#')
        ];

        return $this->tpl('result', $data);
    }

    /**
     * Отображение страниц
     *
     * @param string $view
     * @return mixed
     * @throws ErrorException
     */
    public function page($view)
    {
        if (!$this->tplExists($view)) {

            return $this->errorPage('Страница не найдена!', 404);
        }

        return $this->tpl($view);
    }

    /**
     * Страница ошибки
     *
     * @param string $message
     * @param int $code
     * @return mixed
     * @throws ErrorException
     */
    private function errorPage($message, $code = null)
    {
        if (!is_null($code)) {
            // установить код ошибки по умолчанию, если не поддерживается
            isset($this->headers[$code]) || $code = 404;
            header($this->headers[$code]);
        }

        return $this->tpl('error', ['message' => $message]);
    }

    /**
     * Отображение шаблона
     *
     * @param string $file
     * @param array $data
     * @return mixed
     * @throws ErrorException
     */
    private function tpl($file, $data = [])
    {
        $tpl = TPL_DIR . '/' . $file . '.php';

        // шаблон отсутствует
        if (!$this->tplExists($file)) {

            throw new ErrorException('Template not found: ' . $tpl);
        }

        return include $tpl;
    }

    /**
     * Проверка наличия шаблона
     *
     * @param string $file
     * @return bool
     */
    private function tplExists($file)
    {
        $tpl = TPL_DIR . '/' . $file . '.php';

        return is_file($tpl);
    }
}