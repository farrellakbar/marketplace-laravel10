<?php

    if (!function_exists('active_role')) {
        function active_role(){
            return session('active_role');
        }
    }
    if (!function_exists('user_menus')) {
        function user_menus(){
            return session('user_menus');
        }
    }
