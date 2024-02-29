<?php

require __DIR__.'/vendor/autoload.php';

use League\Csv\Reader;

function getRecords(string $file): Iterator
{
    $csv = Reader::createFromPath($file, 'r');
    $csv->setHeaderOffset(0);

    return $csv->getRecords();
}

function usage(int $exitCode = 0, ?string $error = null): void
{
    $usage = [];

    if (null !== $error) {
        $usage[] = $error;
        $usage[] = '';
    }

    $file = __FILE__;

    $usage[] = 'Usage';
    $usage[] = "  php {$file} -h|--help";
    $usage[] = "  php {$file} /path/to/Folders.csv /path/to/Passwords.csv";

    file_put_contents('php://stderr', implode("\n", $usage));

    exit($exitCode);
}

function checkFile(?string $file): void
{
    if (null === $file) {
        usage(1, 'File not defined');
    }

    if (!is_file($file) || !is_readable($file)) {
        usage(1, 'File not found or not readable: '.$file);
    }
}

foreach ($argv as $value) {
    if (in_array($value, ['-h', '--help'])) {
        usage();
    }
}

$folders = $argv[1] ?? null;
$passwords = $argv[2] ?? null;

checkFile($folders);
checkFile($passwords);

$datas = [
    'encrypted' => false,
    'folders' => [],
    'items' => [],
];

foreach (getRecords($folders) as $item) {
    $datas['folders'][] = [
        'id' => $item['Id'],
        'name' => $item['Label'],
    ];
}

foreach (getRecords($passwords) as $item) {
    $fields = [];

    if (!empty($item['Custom Fields'])) {
        $elements = explode("\n", trim($item['Custom Fields']));

        if (!empty($elements)) {
            foreach ($elements as $element) {
                preg_match('/^(.*), (.*): (.*)$/iU', $element, $match);

                $fields[] = [
                    'name' => $match[1],
                    'value' => $match[3],
                    'linkedId' => null,
                    'type' => match ($match[2]) {
                        'secret' => 1,
                        default => 0,
                    },
                ];
            }
        }
    }

    $datas['items'][] = [
        'passwordHistory' => null,
        'revisionDate' => null,
        'creationDate' => null,
        'deletedDate' => null,
        'id' => $item['Id'],
        'organizationId' => null,
        'folderId' => $item['Folder Id'],
        'type' => 1,
        'reprompt' => 0,
        'name' => $item['Label'],
        'notes' => $item['Notes'],
        'favorite' => 'true' === $item['Favorite'],
        'fields' => $fields,
        'login' => [
            'fido2Credentials' => [],
            'uris' => [[
                'match' => null,
                'uri' => $item['Url'],
            ]],
            'username' => $item['Username'],
            'password' => $item['Password'],
            'topt' => null,
        ],
    ];
}

echo json_encode($datas);
