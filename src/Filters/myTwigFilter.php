<?php

namespace App\Filters;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class myTwigFilter extends AbstractExtension
{
    public function getFilters()
    {
        return [
          new TwigFilter('defaultimage',[$this,'defaultImage'])
        ];
    }
    public function defaultImage(string $path):string{
           if(strlen(trim($path))==0){
               return 'safa.jpg';
           }
           else return $path;
    }
}