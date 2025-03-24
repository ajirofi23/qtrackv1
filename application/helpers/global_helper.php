<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('check_login')) {
    /**
     * Memeriksa status login dan roles pengguna.
     * Jika tidak login, redirect ke AuthController.
     * Jika login tetapi roles tidak sesuai, redirect ke UserController.
     */
    function check_login() {
        $CI =& get_instance(); // Mendapatkan instance CI

        // Periksa apakah pengguna sudah login
        if (!$CI->session->userdata('is_login')) {
            redirect('AuthController'); // Redirect ke halaman login
        }

        // Periksa roles pengguna
        $roles = $CI->session->userdata('roles');
        $allowed_roles = ['admin', 'operator']; // Daftar roles yang diizinkan

        // Jika roles tidak ada dalam daftar yang diizinkan, redirect ke UserController
        if (!in_array($roles, $allowed_roles)) {
            redirect('UserController'); // Redirect ke halaman user
        }
    }

    /**
     * Memeriksa apakah pengguna adalah user biasa.
     * Jika tidak login, redirect ke AuthController.
     * Jika login tetapi bukan user, redirect ke HomeController.
     */
    function check_user() {
        $CI =& get_instance();

        // Periksa apakah pengguna sudah login
        if (!$CI->session->userdata('is_login')) {
            redirect('AuthController'); // Redirect ke halaman login
        }

        // Periksa roles pengguna
        $roles = $CI->session->userdata('roles');
        $allowed_roles = 'user'; // Role yang diizinkan

        // Jika roles bukan user, redirect ke HomeController
        if ($roles != $allowed_roles) {
            redirect('HomeController'); // Redirect ke halaman home
        }
    }

    /**
     * Memeriksa apakah pengguna adalah admin.
     * Jika tidak login, redirect ke AuthController.
     * Jika login tetapi bukan admin, redirect ke UserController.
     */
    function check_admin() {
        $CI =& get_instance();

        // Periksa apakah pengguna sudah login
        if (!$CI->session->userdata('is_login')) {
            redirect('AuthController'); // Redirect ke halaman login
        }

        // Periksa roles pengguna
        $roles = $CI->session->userdata('roles');
        $allowed_roles = 'admin'; // Role yang diizinkan

        // Jika roles bukan admin, redirect ke UserController
        if ($roles != $allowed_roles) {
            redirect('HomeController'); // Redirect ke halaman user
        }
    }

    /**
     * Memeriksa apakah pengguna adalah operator.
     * Jika tidak login, redirect ke AuthController.
     * Jika login tetapi bukan operator, redirect ke UserController.
     */
    function check_operator() {
        $CI =& get_instance();

        // Periksa apakah pengguna sudah login
        if (!$CI->session->userdata('is_login')) {
            redirect('AuthController'); // Redirect ke halaman login
        }

        // Periksa roles pengguna
        $roles = $CI->session->userdata('roles');
        $allowed_roles = 'operator'; // Role yang diizinkan

        // Jika roles bukan operator, redirect ke UserController
        if ($roles != $allowed_roles) {
            redirect('HomeController'); // Redirect ke halaman user
        }
    }
}