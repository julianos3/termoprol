<?php

namespace AgenciaS3\Http\Controllers\Admin\Configuration\Keyword;


use AgenciaS3\Entities\Keyword;
use AgenciaS3\Http\Controllers\Controller;

class KeywordCheckController extends Controller
{

    public function checkDescription($string, $label, $qty = null)
    {
        $dadosKeywords = Keyword::where('active', 'y')->get();
        $keywords = [];
        if ($dadosKeywords) {
            foreach ($dadosKeywords as $key) {
                $keywords[] = $key->name;
            }
        }

        $total = $this->getCheckStrings($string, $keywords);
        if ($total) {
            if ($qty > $total) {
                return '<div class="alert alert-warning">O campo <strong>' . $label . '</strong> deve conter pelo menos <strong> "' . $qty . '" Keywords</strong></div>';
            }

            return '';
        }

        return '<div class="alert alert-warning">Nenhuma <strong>Keyword</strong> encontrada no campo <strong>' . $label . '</strong></div>';
    }

    public function getCheckStrings($string, $keywords, $result = 0)
    {
        if (is_array($keywords)) {
            foreach ($keywords as $key => $value) {
                $pos = strpos($string, $value);
                if ($pos !== false) {
                    $result++;
                    //break;
                }
            }

            return $result;
        }

        return false;
    }


}