<?php

namespace OpdsBundle\Utils;

use OpdsBundle\Exception\OpdsParserLoaderException;
use OpdsBundle\Exception\OpdsParserNotFoundException;

class XmlLoaderUtils
{

    /**
     * Récupère un flux XML par dans un fichier
     *
     * @param string $file file path
     *
     * @return \SimpleXMLElement
     * @throws OpdsParserNotFoundException
     */
    public static function loadXmlByFile($file)
    {
        $handle = fopen($file, 'r');
        if (!$handle) {

            throw new OpdsParserNotFoundException();
        }

        while (!feof($handle)) {
            $content .= fread($handle, 8192); // 8192 : nombre d'octets équivalent à la taille d'un bloc
        }
        fclose($handle);

        return new \SimpleXMLElement($content);
    }

    /**
     * Récupère un flux XML par une url
     *
     * @param string $url
     * @param array $headerList
     *
     * @return \SimpleXMLElement
     * @throws OpdsParserLoaderException
     */
    public static function loadXmlByUrl($url, $headerList = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($headerList) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerList);
        }

        $content = curl_exec($ch);
        if (!$content) {

            throw new OpdsParserLoaderException('Fail to load ' . $url);
        }

        return new \SimpleXMLElement($content);
    }

}