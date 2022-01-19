<?php

namespace EvalBookCore\Installer;


final class Form
{
    /**
     * Check if given posts params are empty.
     * @param ...$fields
     * @return bool
     */
    public static function areFieldsEmpty(...$fields): bool {
        foreach($fields as $field) {
            return is_null($field) || (!is_int($field) && !strlen($field) > 0);
        }
        return false;
    }
}