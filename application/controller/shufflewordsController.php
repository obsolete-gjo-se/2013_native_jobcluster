<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Gregory
 * Date: 21.03.13
 * Time: 05:54
 * To change this template use File | Settings | File Templates.
 */

namespace controller;


class ShuffleWordsController
{
    private $phraseSigns = array(
        '.', ',', '!', '?'
    );
    private $text;
    private $originalText;
    private $lines = array();
    private $wholeText;
    private $words = array();
    private $newWords = array();
    private $error_msg;

    public function __construct()
    {
        $this->error_msg = '';
    }


    public function getShuffledText()
    {
        if (isset($_POST['originalText']) and $_POST['originalText'] != '') {
            $this->text = htmlspecialchars($_POST['originalText']);

            $this->originalText = $this->text;

            $this->getLines();
            $this->getWholeText();
            $this->getWords();
            $this->shuffleWord();
            return implode(' ', $this->newWords);
        } else {
            $this->error_msg .= 'Bitte einen Text eingeben.' . '<br />';
        }

    }

    private function getLines()
    {
        $this->lines = explode("\n", $this->text);
    }

    private function getWholeText()
    {
        $this->wholeText = implode(" ", $this->lines);
    }

    private function getWords()
    {
        $this->words = explode(" ", $this->wholeText);
    }

    private function shuffleWord()
    {
        foreach ($this->words as $word) {

            $word = trim($word);

            if ($this->checkWordsRegex($word)) {

                // firstSign
                if (in_array(substr($word, 0, 1), $this->phraseSigns)) {
                    $firstSign = substr($word, 0, 2);
                } else {
                    $firstSign = substr($word, 0, 1);
                }

                // lastSign
                if (in_array(substr($word, -1, 1), $this->phraseSigns)) {
                    $lastSign = substr($word, -2);
                } else {
                    $lastSign = substr($word, -1, 1);
                }

                // middleSigns
                $middleSigns = substr($word, strlen($firstSign), strlen($word) - strlen($firstSign) - strlen($lastSign));

                // per Regex um UTF-8 darzustellen
                $tmp = preg_split("//u", $middleSigns, -1, PREG_SPLIT_NO_EMPTY);
                shuffle($tmp);
                $middleSignsShuffle = join("", $tmp);
                $this->newWords[] = $firstSign . $middleSignsShuffle . $lastSign;

            } else {
                $this->error_msg .= 'Bitte nur gültige Zeichen eingeben.' . '<br />';
            }
        }
    }

    private function checkWordsRegex($word)
    {
        if (preg_match('/[^a-zäöüß0-9\.\,\?\!\r\n ]+/i', $word)) {
            return false;
        }else{
            return true;
        }
    }

    public function getOriginalText()
    {
        return $this->originalText;
    }

    public function getErrorMsg()
    {
        if ($this->error_msg != '') {
            return $this->error_msg;
        } else {
            return false;
        }
    }

}