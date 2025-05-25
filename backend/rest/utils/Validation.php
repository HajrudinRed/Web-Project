<?php

class Validation {
    public static function require_fields($payload, $fields) {
        foreach ($fields as $field) {
            if (empty($payload[$field])) {
                Flight::halt(400, "$field is required.");
            }
        }
    }
}