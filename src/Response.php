<?php

namespace subzeta\SelaeScraper;

interface Response
{
    public function isSuccessful() : bool;

    public function errorMessage() : string;
}
