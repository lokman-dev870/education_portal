<?php

namespace App\Livewire;

use Livewire\Mechanisms\HandleRequests\HandleRequests;

class CustomHandleRequests extends HandleRequests
{
    function getUpdateUri()
    {
        // Check if updateRoute is set, if not return a default
        if (!$this->updateRoute) {
            return $this->getDefaultUri();
        }

        try {
            // Get the URI from the parent method
            $uri = (string) str(
                route($this->updateRoute->getName(), [], false)
            )->start('/');
            
            // If we're using a subdirectory in production, ensure it's included
            if ($this->shouldUseSubdirectory() && !str_starts_with($uri, '/education_portal')) {
                $uri = '/education_portal' . $uri;
            }
            
            return $uri;
        } catch (\Exception $e) {
            // Fallback to default path
            return $this->getDefaultUri();
        }
    }

    protected function shouldUseSubdirectory()
    {
        return config('app.env') === 'production' && str_contains(config('app.url'), '/education_portal');
    }

    protected function getDefaultUri()
    {
        return $this->shouldUseSubdirectory() 
            ? '/education_portal/livewire/update' 
            : '/2livewire/update';
    }
}
