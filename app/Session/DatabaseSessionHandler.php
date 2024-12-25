<?php

namespace App\Session;

use Illuminate\Session\DatabaseSessionHandler as BaseDatabaseSessionHandler;

class DatabaseSessionHandler extends BaseDatabaseSessionHandler
{
    /**
     * Get the default payload for the session.
     *
     * @param  string  $data
     * @return array
     */
    protected function getDefaultPayload($data)
    {
        $payload = [
            'payload' => base64_encode($data),
            'last_activity' => $this->currentTime(),
            'reg_no' => $this->getUserId(),
        ];

        if (! $this->container->bound('request')) {
            return $payload;
        }

        $request = $this->container->make('request');

        if ($request->hasSession() && $request->session()->getId() === null) {
            return $payload;
        }

        return array_merge($payload, [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Get the current user's ID.
     *
     * @return string|null
     */
    protected function getUserId()
    {
        if (! $this->container->bound('auth')) {
            return null;
        }

        $user = $this->container->make('auth')->user();

        return $user ? $user->reg_no : null;
    }
}