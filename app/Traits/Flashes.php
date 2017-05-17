<?php

namespace App\Traits;

trait Flashes {

    public function goodFlash($message)
    {
        return $this->writeFlash($message, 'success');
    }

    public function infoFlash($message)
    {
        return $this->writeFlash($message, 'info');
    }

    public function warningFlash($message)
    {
        return $this->writeFlash($message, 'warning');
    }

    public function badFlash($message)
    {
        return $this->writeFlash($message, 'danger');
    }

    public function writeFlash($message, $key)
    {
        session()->flash('flash', ['message' => $message, 'type' => $key]);
    }
}