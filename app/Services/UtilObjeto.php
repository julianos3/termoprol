<?php

namespace AgenciaS3\Services;

use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;

class UtilObjeto
{

    use ValidatesRequests;

    public function uploadFile($request, $data, $path, $file, $required)
    {
        if (isset($data[$file])) {
            $this->validate($request, [
                $file => 'required|' . $required . '',
            ]);

            $fileName = md5(time() . rand(1, 8)) . '.' . $data[$file]->getClientOriginalExtension();
            $request->$file->move(public_path($path), $fileName);
            $data[$file] = $fileName;

            return $data[$file];
        }

        return false;
    }

    public static function getSiteLanguage()
    {
        return app()->getLocale();
    }

    public static function language($pt, $en, $es)
    {
        $language = app()->getLocale();
        if ($language == 'en') {
            return $en;
        } elseif ($language == 'es') {
            return $es;
        } else {
            return $pt;
        }
    }

    public static function video($url, $class = "", $height = "", $size = "large", $autoPlay = "")
    {
        if ($size == "thumb") {
            $size = 1;
        } else {
            $size = 0;
        }

        if (isset($height) && !empty($height)) {
            //$height = $height;
        } else {
            $height = "515";
        }
        //?rel=0&autoplay=1
        $relAutoPlay = '';
        $image_url = parse_url($url);
        if (isset($image_url['host']) && !empty($image_url['host'])) {
            if ($image_url['host'] == 'www.youtube.com' || $image_url['host'] == 'youtube.com') {
                $array = explode("&", $image_url['query']);
                if (isset($autoPlay) && !empty($autoPlay)) {
                    $relAutoPlay = '?rel=0&autoplay=1';
                }
                return '<iframe class="' . $class . '" width="100%" height="' . $height . '" src="https://www.youtube.com/embed/' . substr($array[0], 2) . $relAutoPlay . '" frameborder="0" allowfullscreen></iframe>';

            } elseif ($image_url['host'] == 'www.vimeo.com.br' || $image_url['host'] == 'vimeo.com.br' || $image_url['host'] == 'www.vimeo.com' || $image_url['host'] == 'vimeo.com') {
                $hash = $url;
                $dividename = explode('https://vimeo.com/', $hash);
                return '<iframe class="' . $class . '" src="https://player.vimeo.com/video/' . $dividename[1] . '" width="100%" height="515" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            }
        }
    }

    public static function getLocal($address)
    {
        $googleKey = 'AIzaSyDoc8kdOuMP-uIs2URGyz5tcca0gDbTmM0';

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=' . $googleKey;
        $result = self::loadUrl($url);
        $json = json_decode($result);
        if ($json->{'status'} == 'OK') {
            return $json->{'results'}[0]->{'geometry'}->{'location'};
        } else {
            return false;
        }
    }

    public static function loadUrl($url)
    {
        $cURL = curl_init($url);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($cURL);
        curl_close($cURL);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function setLanguage($language)
    {
        app()->setLocale($language);
        return $language;
    }

    public function getLanguage()
    {
        return app()->getLocale();
    }

    public function gerarDataAdiante($qtdeDias)
    {
        $data = date('Y-m-d h:i:s', strtotime("+$qtdeDias days", strtotime(Carbon::now())));

        return $data;
    }

    public function nameUrl($str)
    {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        $str = preg_replace('/[^a-z0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '-', $str);

        return strtolower($str);
    }

    /*
    public function upload($file, $path, $validator)
    {
        $rules = array('file' => 'required|mimes:' . $validator);
        $validator = Validator::make(array('file' => $file), $rules);
        if ($validator->passes()) {

            $nameImage = md5($file->getFilename());
            $extension = $file->getClientOriginalExtension();
            $this->storage->put($path . $nameImage, $this->filesystem->get($file));
            $mime_type = $this->storage->mimeType($path . $nameImage, $this->filesystem->get($file));

            $result = [
                'name' => $file->getClientOriginalName(),
                'file' => $nameImage,
                'extension' => $extension,
                'mime_type' => $mime_type
            ];

            return $result;
        }
        return false;
    }
    */

    public function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

    public function ip()
    {
        $ipAddress = '';

        // Check for X-Forwarded-For headers and use those if found
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ('' !== trim($_SERVER['HTTP_X_FORWARDED_FOR']))) {
            $ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            if (isset($_SERVER['REMOTE_ADDR']) && ('' !== trim($_SERVER['REMOTE_ADDR']))) {
                $ipAddress = trim($_SERVER['REMOTE_ADDR']);
            }
        }

        return $ipAddress;
    }

    public function trataCampoValor($valor)
    {
        $novoValor = str_replace(".", "", $valor);
        $novoValor = str_replace(",", ".", $novoValor);

        return $novoValor;
    }

    public function paginate($dados, $limit = '')
    {
        $currentPage = Paginator::resolveCurrentPage() - 1;
        $perPage = 15;
        if ((int)$limit > 0) {
            $perPage = $limit;
        }
        $currentPageSearchResults = $dados->slice($currentPage * $perPage, $perPage)->all();
        $dados = new LengthAwarePaginator($currentPageSearchResults, count($dados), $perPage);

        return $dados;
    }

    public function valida_cnpj($cnpj)
    {
        // Deixa o CNPJ com apenas números
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Garante que o CNPJ é uma string
        $cnpj = (string)$cnpj;

        // O valor original
        $cnpj_original = $cnpj;

        // Captura os primeiros 12 números do CNPJ
        $primeiros_numeros_cnpj = substr($cnpj, 0, 12);

        /**
         * Multiplicação do CNPJ
         *
         * @param string $cnpj Os digitos do CNPJ
         * @param int $posicoes A posição que vai iniciar a regressão
         * @return int O
         *
         */
        if (!function_exists('multiplica_cnpj')) {
            function multiplica_cnpj($cnpj, $posicao = 5)
            {
                // Variável para o cálculo
                $calculo = 0;

                // Laço para percorrer os item do cnpj
                for ($i = 0; $i < strlen($cnpj); $i++) {
                    // Cálculo mais posição do CNPJ * a posição
                    $calculo = $calculo + ($cnpj[$i] * $posicao);

                    // Decrementa a posição a cada volta do laço
                    $posicao--;

                    // Se a posição for menor que 2, ela se torna 9
                    if ($posicao < 2) {
                        $posicao = 9;
                    }
                }
                // Retorna o cálculo
                return $calculo;
            }
        }

        // Faz o primeiro cálculo
        $primeiro_calculo = multiplica_cnpj($primeiros_numeros_cnpj);

        // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
        // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
        $primeiro_digito = ($primeiro_calculo % 11) < 2 ? 0 : 11 - ($primeiro_calculo % 11);

        // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
        // Agora temos 13 números aqui
        $primeiros_numeros_cnpj .= $primeiro_digito;

        // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
        $segundo_calculo = multiplica_cnpj($primeiros_numeros_cnpj, 6);
        $segundo_digito = ($segundo_calculo % 11) < 2 ? 0 : 11 - ($segundo_calculo % 11);

        // Concatena o segundo dígito ao CNPJ
        $cnpj = $primeiros_numeros_cnpj . $segundo_digito;

        // Verifica se o CNPJ gerado é idêntico ao enviado
        if ($cnpj === $cnpj_original) {
            return true;
        }
        return false;
    }

    public function destroyFile($path, $file_name)
    {
        $file = $path . $file_name;
        if (file_exists($file) && isset($file_name) && !empty($file_name)) {
            return Storage::disk('public')->delete(str_replace('uploads', '', $file));
        }

        return false;
    }

}