<?php

// admin helper function to call 'auth()->guard('admin')' guard direct
if (!function_exists('admins')) {
    function admins()
    {
        return auth()->guard('admin');
    }
}



// Validate Image Extension
if (!function_exists('VImage')) {
    function VImage($extension = null)
    {
        if ($extension == null) {
            return 'image|mimes:jpg,jpeg,png,bmp,gif';
        } else {
            return 'image|mimes:' . $extension;
        }
    }
}
