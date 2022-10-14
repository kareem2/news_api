<?php

namespace App\News;

interface NewsApiClientInterface
{

    public function query($parameters);
}
