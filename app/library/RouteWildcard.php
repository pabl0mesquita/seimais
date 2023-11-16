<?php

namespace app\library;

use app\enums\RouteWildcard as EnumsRouteWildcard;

class RouteWildcard
{
    private string $wildcardReplaced;

    private array $paramsWildcard = [];

    public function replaceWildcardPattern(string $uriToReplace)
    {
        $this->wildcardReplaced =  $uriToReplace;

        if(str_contains($this->wildcardReplaced, '(:numeric)')){
            $this->wildcardReplaced = str_replace('(:numeric)', EnumsRouteWildcard::numeric->value, $this->wildcardReplaced
        );
        }

        if(str_contains($this->wildcardReplaced, '(:alpha)')){
            $this->wildcardReplaced = str_replace('(:alpha)', EnumsRouteWildcard::alpha->value, $this->wildcardReplaced
        );
        }

        if(str_contains($this->wildcardReplaced, '(:any)')){
            $this->wildcardReplaced = str_replace('(:any)', EnumsRouteWildcard::any->value, $this->wildcardReplaced
        );
        }
    }

    public function getParams()
    {
        return $this->paramsWildcard;
    }

    /**
     * paramsToArray
     */
    public function paramsToArray(string $uri, string $wildcard, array $aliases)
    {
        $explodeUri = explode('/', ltrim($uri, '/'));
        $explodeWildcard = explode('/', ltrim($wildcard, '/'));

        $differenceArrays = array_diff_assoc($explodeUri, $explodeWildcard);

        if(empty($aliases)){
            $aliases = array_intersect_assoc($explodeUri, $explodeWildcard);
        }

        $arrayFillKeysToParams = array_combine($aliases, $differenceArrays);

        $this->paramsWildcard = $arrayFillKeysToParams;
        //var_dump($arrayFillKeysToParams);
    
    }
    public function getWildcardReplaced(): ?string
    {
        return $this->wildcardReplaced;
    }

    public function uriEqualToPattern($currentUri, $wildcardReplaced)
    {
        $wildcard = str_replace('/','\/', ltrim($wildcardReplaced, '\/'));
        
        return preg_match("/^$wildcard$/", trim($currentUri, '/')."/");
    }
}