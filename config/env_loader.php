<?php
declare(strict_types=1);

/**
 * Loads environment variables from a .env file into $_ENV, $_SERVER and system env.
 *
 * Usage:
 *   require_once 'config/env_loader.php';
 *   loadEnv(__DIR__ . '/../.env');
 */

/**
 * Main loader function.
 *
 * @param string $path Absolute path to the .env file
 * @throws RuntimeException If the file does not exist
 */
function loadEnv(string $path): void
{
    if (!file_exists($path)) {
        throw new RuntimeException(sprintf('The .env file "%s" was not found.', $path));
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        if (isEnvComment($line) || isEmptyLine($line)) {
            continue;
        }

        [$key, $value] = parseEnvLine($line);

        if (!envAlreadyDefined($key)) {
            setEnvVar($key, $value);
        }
    }
}

/**
 * Checks if the line is a comment.
 */
function isEnvComment(string $line): bool
{
    return str_starts_with($line, '#');
}

/**
 * Checks if the line is empty.
 */
function isEmptyLine(string $line): bool
{
    return $line === '';
}

/**
 * Parses an environment line into key and value.
 *
 * @param string $line
 * @return array [key, value]
 */
function parseEnvLine(string $line): array
{
    [$key, $value] = explode('=', $line, 2);
    $key = trim($key);
    $value = trimQuotes(trim($value));

    return [$key, $value];
}

/**
 * Removes wrapping quotes from the value if present.
 */
function trimQuotes(string $value): string
{
    if (
        (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
        (str_starts_with($value, "'") && str_ends_with($value, "'"))
    ) {
        return substr($value, 1, -1);
    }

    return $value;
}

/**
 * Checks if the variable is already defined in the environment.
 */
function envAlreadyDefined(string $key): bool
{
    return array_key_exists($key, $_ENV) || array_key_exists($key, $_SERVER);
}

/**
 * Defines the environment variable in all relevant scopes.
 */
function setEnvVar(string $key, string $value): void
{
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}
