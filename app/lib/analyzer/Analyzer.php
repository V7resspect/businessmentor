<?php

namespace App\Lib\Analyzer;

class Analyzer
{
    private $text = '';
    private $words = [];

    /**
     * @param string $text
     */
    function __construct($text)
    {
        $this->text = $text;
        $this->detectWords($text);
    }

    /**
     * Определить слова
     *
     * @param string $text
     * @return void
     */
    private function detectWords($text)
    {
        preg_match_all('~[a-zа-яё\']+(?:-[a-zа-яё\']+)*~iu', $text, $matches);

        $this->words = $matches[0];
    }

    /**
     * Получить часто используемые слова
     *
     * @param int $count
     * @return array
     */
    public function getPopularWords($count)
    {
        $words = array_count_values($this->words);

        arsort($words);

        return array_slice($words, 0, $count);
    }

    /**
     * Антимат-фильтр
     *
     * @param string $replacement
     * @return string
     */
    public function filterBadText($replacement)
    {
        // Матерный словарь
        $bad_words = file_get_contents(__DIR__ . '/bad_words.json');
        $bad_words = json_decode($bad_words);

        $text = $this->text;

        foreach ($bad_words as $word) {
            $text = preg_replace('/' . $word . '/iu', $replacement, $text);
        }

        return $text;
    }

    /**
     * Получить количество слов
     *
     * @return int
     */
    public function countWords()
    {
        return count($this->words);
    }
}