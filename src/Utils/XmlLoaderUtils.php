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
        $content = fread($handle, filesize($file));
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
        if ($headerList) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerList);
        }

        if (!ob_start()) {
            throw new OpdsParserLoaderException('Output buffer error');
        }
        if (!curl_exec($ch)) {
            throw new OpdsParserLoaderException('Fail to load ' . $url);
        }

        curl_close($ch);
        $content = ob_get_contents();

        if (!$content) {
            throw new OpdsParserLoaderException('Cannot return output buffer');
        }

        ob_end_clean();

        return new \SimpleXMLElement($content);
    }

}